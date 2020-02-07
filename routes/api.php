<?php

use Illuminate\Http\Request;


Route::group([

    'middleware' => ['api', 'cors'], #jwt.auth
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    Route::post('refresh', 'Auth\AuthController@refresh');
    Route::post('me', 'Auth\AuthController@me');
    Route::get('produtos','ProdutosController@index');
});
