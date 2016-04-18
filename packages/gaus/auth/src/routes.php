<?php

Route::any('auth', ['uses' => 'Gaus\Auth\Controllers\AuthController@index', 'as' => 'auth']);
