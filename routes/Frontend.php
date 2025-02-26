<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return view('Frontend.Pages.Home.Home');
});
