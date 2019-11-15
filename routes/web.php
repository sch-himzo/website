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


Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => 'auth'],
    function () {
        Route::get('new', 'OrdersController@create')->name('new');
        Route::post('delete/order/{order}', 'OrdersController@delete')->name('delete');
        Route::get('fake', 'OrdersController@fake')->name('fake');
        Route::post('save/fake', 'OrdersController@saveFake')->name('saveFake');
        Route::post('save', 'OrdersController@save')->name('save');
        Route::get('image/order/{order}', 'OrdersController@getImage')->name('getImage');

        Route::post('email/{order}','OrdersController@email')->name('email');

        Route::post('setUser/{order}','OrdersController@setUser')->name('setUser');

        Route::get('unapproved', 'OrdersController@unapproved')->name('unapproved');
        Route::get('approve/order/{order}', 'OrdersController@approve')->name('approve');

        Route::get('active', 'OrdersController@active')->name('active');
    });

Route::group(['prefix' => 'transactions', 'as' => 'transactions.', 'middleware' => 'jew'], function(){
    Route::post('teddy-bears/new','TransactionController@newTeddy')->name('teddy_bear.new');
    Route::post('teddy-bears/{teddy_bear}/balance/add', 'TransactionController@addBalance')->name('teddy_bear.balance.add');

    Route::get('teddy-bears/{teddy_bear}','TransactionController@teddyBear')->name('teddy_bear');

    Route::get('teddy-bears','TransactionController@teddyBears')->name('teddy_bears');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'auth'], function(){
    Route::get('orders','UserController@orders')->name('orders');


    Route::get('in', 'UserController@in')->name('in');
    Route::get('out','UserController@out')->name('out');
});

Route::group(['prefix' => 'admin','as' => 'admin.', 'middleware' => 'admin'], function(){
    Route::group(['prefix' => 'trello','as' => 'trello.'], function(){
        Route::get('lists','Admin\TrelloController@lists')->name('lists');
        Route::get('lists/{trello_list}/cards','Admin\TrelloController@cards')->name('cards');
    });
});

Route::post('get/users','HomeController@getUsers')->name('getUsers');
