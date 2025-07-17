<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api-test', function () {
    return view('api-test');
});

Route::get('/dashboard', function () {
    return view('api-test');
});
