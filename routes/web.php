<?php

Route::get('', 'HomeController@index')->name('index');

Route::get('auth/login','LoginController@authSchCallback')->name('auth_sch_callback');
Route::get('auth/redirect','LoginController@authSchRedirect')->name('login');

Route::get('logout', 'LoginController@logout')->name('logout');

Route::group(['prefix' => 'orders', 'as' => 'orders.'], function(){
    Route::get('new','OrdersController@new')->name('new');
});
