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
});

Route::get('logout', 'LoginController@logout')->name('logout');


Route::group(['prefix' => 'orders', 'as' => 'orders.'], function(){
    Route::get('new','OrdersController@create')->name('new');
    Route::post('save', 'OrdersController@save')->name('save');
});
