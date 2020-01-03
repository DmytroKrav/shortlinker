<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('/create-short-url', 'Links\LinkController@createLink')->name('create-short-url');
Route::get('/r/{code}', 'Links\LinkController@performRedirect')->name('perform-redirect');
