<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    
    return view('home', [
        'dokumens' => \App\Models\DokumenWarga::get()
    ]);
});
