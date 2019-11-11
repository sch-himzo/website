<?php

Route::get('', 'HomeController@index')->name('index');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
    Route::get('', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::group(['prefix' => 'sch', 'as' => 'sch.'], function(){
        Route::get('login','LoginController@authSchCallback')->name('callback');
        Route::get('redirect','LoginController@authSchRedirect')->name('redirect');
    });

    Route::group(['prefix' => 'facebook', 'as' => 'google.'], function(){
        Route::get('login', 'LoginController@facebookCallback')->name('callback');
        Route::get('redirect', 'LoginController@facebookRedirect')->name('redirect');
    });

    Route::post('login','LoginController@login')->name('login');

    Route::post('register', 'LoginController@register')->name('register');

    Route::post('email', 'LoginController@email')->name('email');
    Route::post('password', 'LoginController@password')->name('password');
});

Route::get('logout', 'LoginController@logout')->name('logout');


Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => 'auth'], function(){
    Route::get('new','OrdersController@create')->name('new');
    Route::post('save', 'OrdersController@save')->name('save');
    Route::get('image/order/{order}','OrdersController@getImage')->name('getImage');

    Route::get('unapproved','OrdersController@unapproved')->name('unapproved');
    Route::get('approve/order/{order}', 'OrdersController@approve')->name('approve');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function(){
    Route::get('orders','UserController@orders')->name('orders');
});

Route::get('trello', 'OrdersController@testTrello')->name('trello');
