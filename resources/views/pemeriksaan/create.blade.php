@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>Tambah Pemeriksaan</h3>

        <a href="{{ route('pemeriksaan.index') }}"
           class="btn btn-secondary">
            Kembali
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <strong>Terdapat kesalahan:</strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="card">

        <div class="card-body">

            <form action="{{ route('pemeriksaan.store') }}"
                  method="POST">

                @csrf

                @include('pemeriksaan._form')

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('pemeriksaan.index') }}"
                       class="btn btn-secondary">
                        Batal
                    </a>

                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Pemeriksaan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection