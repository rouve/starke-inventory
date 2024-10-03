<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/app/{any}', function () {
    return view('app');
})->where('any', '.*')->middleware('auth');

Route::redirect('/', '/app/batches');
Route::redirect('/home', '/app/batches')->name('home');

