```php
<?php

use App\Http\Controllers\PemeriksaanController;
use Illuminate\Support\Facades\Route;

Route::resource('pemeriksaan', PemeriksaanController::class);
