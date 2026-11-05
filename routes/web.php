<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('mobil-cinta.login');
});

require __DIR__.'/mobil_cinta.php';