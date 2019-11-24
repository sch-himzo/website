<?php

Route::get('', 'HomeController@index')->name('index');
Route::get('login','HomeController@indexLogin')->name('index.login');

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

Route::get('activate/{token}','LoginController@activate')->name('user.activate');

Route::get('activate','LoginController@emailSent')->name('activate');

Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => 'auth'],
    function () {
        Route::get('new', 'OrdersController@create')->name('new');
        Route::post('delete/order/{order}', 'OrdersController@delete')->name('delete');
        Route::get('fake', 'OrdersController@fake')->name('fake');
        Route::post('save/fake', 'OrdersController@saveFake')->name('saveFake');
        Route::post('save', 'OrdersController@save')->name('save');
        Route::get('image/order/{order}', 'OrdersController@getImage')->name('getImage');
        Route::get('font/order/{order}', 'OrdersController@getFont')->name('getFont');

        Route::get('{order}/joint','OrdersController@joint')->name('joint');

        Route::get('{order}/archive', 'OrdersController@archive')->name('archive');

        Route::post('{order}/edit','OrdersController@edit')->name('edit');

        Route::get('{order}/view','OrdersController@order')->name('view');

        Route::post('email/{order}','OrdersController@email')->name('email');

        Route::post('setUser/{order}','OrdersController@setUser')->name('setUser');

        Route::post('{order}/comment','OrdersController@comment')->name('comment');
        Route::get('{order}/assign', 'OrdersController@assign')->name('assign');

        Route::get('unapproved', 'OrdersController@unapproved')->name('unapproved');
        Route::get('approve/order/{order}/{internal}', 'OrdersController@approve')->name('approve');

        Route::get('active', 'OrdersController@active')->name('active');

        Route::get('update','OrdersController@updateTrello')->name('update');

        Route::get('{order}/albums','OrdersController@albums')->name('albums');
    });

Route::group(['prefix' => 'designs', 'as' => 'designs.', 'middleware' => 'auth'], function(){

    Route::group(['middleware' => 'member'], function(){
        Route::get('','DesignController@index')->name('index');

        Route::get('{design}/order/{order}','DesignController@attachGroupToOrder')->name('attach');

        Route::get('{design}/svg', 'DesignController@getSVGFile')->name('getSVG');

        Route::post('{group}/save','DesignController@save')->name('save');
        Route::group(['prefix' => 'groups', 'as' => 'groups.'], function(){
            Route::post('new','DesignController@newGroup')->name('new');

            Route::get('{group}/view','DesignController@viewGroup')->name('view');
            Route::get('{group}/delete','DesignController@deleteGroup')->name('delete');
            Route::post('{group}/edit','DesignController@editGroup')->name('edit');
        });
    });

    Route::post('{design}/colors', 'DesignController@colors')->name('colors');
    Route::get('{design}/parse/{order?}','DSTController@parse')->name('parse');
    Route::get('{design}/get','DesignController@get')->name('get');

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function(){
        Route::get('{order}/view','DesignController@order')->name('view');
        Route::post('{order}/add','DesignController@addToOrder')->name('add');
        Route::post('{order}/update/{design}','DesignController@updateOrder')->name('update');
    });

});

Route::group(['prefix' => 'transactions', 'as' => 'transactions.', 'middleware' => 'jew'], function(){
    Route::post('teddy-bears/new','TransactionController@newTeddy')->name('teddy_bear.new');
    Route::post('teddy-bears/{teddy_bear}/balance/add', 'TransactionController@addBalance')->name('teddy_bear.balance.add');

    Route::post('transaction/{transaction}/edit','TransactionController@editTransaction')->name('edit');
    Route::post('transaction/{transaction}/delete','TransactionController@deleteTransaction')->name('delete');

    Route::get('teddy-bears/{teddy_bear}','TransactionController@teddyBear')->name('teddy_bear');

    Route::get('teddy-bears','TransactionController@teddyBears')->name('teddy_bears');
});

Route::group(['prefix' => 'members','as' => 'members.', 'middleware' => 'rookie'], function(){
    Route::get('','MembersController@index')->name('index');
    Route::get('unassigned','MembersController@unassigned')->name('unassigned');
    Route::get('mine','MembersController@mine')->name('mine');
    Route::get('unapproved','MembersController@unapproved')->name('unapproved');

    Route::get('joint','MembersController@joint')->name('joint');

    Route::group(['middleware' => 'leader'], function(){
        Route::get('active','MembersController@active')->name('active');
        Route::get('archived','MembersController@archived')->name('archived');
    });

});

Route::group(['prefix' => 'settings', 'as' => 'settings.', 'middleware' => 'leader'], function(){
    Route::get('gallery','Admin\SettingsController@gallery')->name('gallery');
    Route::get('index','Admin\SettingsController@index')->name('index');

    Route::get('backgrounds','Admin\SettingsController@backgrounds')->name('backgrounds');
    Route::post('backgrounds/new','Admin\SettingsController@newBackground')->name('backgrounds.new');
    Route::post('backgrounds/{background}/edit','Admin\SettingsController@editBackground')->name('backgrounds.edit');
    Route::get('backgrounds/{background}/delete', 'Admin\SettingsController@deleteBackground')->name('backgrounds.delete');

    Route::post('index/slides/new','Admin\SettingsController@newSlide')->name('index.slides.new');
    Route::get('index/slides/{slide}/edit','Admin\SettingsController@editSlide')->name('index.slide.edit');
    Route::get('index/slides/{slide}/delete','Admin\SettingsController@deleteSlide')->name('index.slide.delete');
    Route::get('index/slides/{slide}/up','Admin\SettingsController@slideUp')->name('index.slide.up');
    Route::get('index/slides/{slide}/down','Admin\SettingsController@slideDown')->name('index.slide.down');
    Route::post('index/slides/{slide}/save','Admin\SettingsController@saveSlide')->name('index.slides.save');

    Route::post('index/orders/folder/set', 'Admin\SettingsController@setFolder')->name('orders.group.set');

    Route::group(['prefix' => 'galleries', 'as' => 'galleries.'], function(){
        Route::post('new', 'Admin\GalleryController@new')->name('new');

        Route::post('set','Admin\GalleryController@set')->name('set');
        Route::post('orders/set','Admin\GalleryController@setOrderGallery')->name('orders.set');
    });

});

Route::group(['prefix' => 'gallery','as' => 'gallery.'], function(){
    Route::get('','Gallery\GalleryController@images')->name('index');
});

Route::group(['prefix' => 'images', 'as' => 'images.'], function(){
    Route::get('{image}/get', 'Gallery\ImageController@get')->name('get');
});

Route::group(['prefix' => 'albums', 'as' => 'albums.'], function(){
    Route::group(['middleware' => 'auth'], function(){
        Route::get('new/order/{order}','Gallery\AlbumController@create')->name('new');
        Route::post('new/step/2/order/{order}','Gallery\AlbumController@editUploadedImages')->name('new.step2');
        Route::post('save/order/{order}/album/{album}','Gallery\AlbumController@save')->name('save');
    });

    Route::get('view/{album}','Gallery\AlbumController@view')->name('view');
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
