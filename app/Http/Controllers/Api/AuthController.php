<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $warga = Warga::where('nik', $request->nik)->first();

        if (! $warga) {
            throw ValidationException::withMessages([
                'nik' => ['NIK belum terdaftar di Posyandu. Silakan hubungi kader.'],
            ]);
        }

        if ($warga->user()->exists()) {
            throw ValidationException::withMessages([
                'nik' => ['NIK ini sudah terhubung dengan akun lain.'],
            ]);
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'warga',
            'warga_id' => $warga->id,
        ]);

        // Buat web session sekaligus agar halaman server-side bisa diakses
        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil.',
            'data'    => [
                'user'       => new UserResource($user->load('warga')),
                'token'      => $user->createToken('api-token')->plainTextToken,
                'token_type' => 'Bearer',
            ],
        ], 201);
    }
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Buat web session agar halaman server-side (warga, kegiatan, dll) bisa diakses
        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'user'       => new UserResource($user->load('warga')),
                'token'      => $user->createToken('api-token')->plainTextToken,
                'token_type' => 'Bearer',
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => new UserResource($request->user()->load('warga')),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
    // Hapus token Sanctum jika ada
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

    // Logout session web
    Auth::guard('web')->logout();

    // Hapus session
        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ]);
    }
}