<?php

Route::get('', 'HomeController@index')->name('index');
Route::get('login','HomeController@indexLogin')->name('index.login');
Route::get('sitemap', 'HomeController@sitemap')->name('sitemap');

Route::get('party','HomeController@party')->name('party');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
    Route::get('', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');

    Route::group(['prefix' => 'sch', 'as' => 'sch.'], function(){
        Route::get('login','LoginController@authSchCallback')->name('callback');
        Route::get('redirect','LoginController@authSchRedirect')->name('redirect');
    });

    Route::post('login','LoginController@login')->name('login');

    Route::post('register', 'LoginController@register')->name('register');

    Route::post('email', 'LoginController@email')->name('email');
    Route::post('password', 'LoginController@password')->name('password');
});

Route::group(['prefix' => 'faku', 'as' => 'faq.'], function(){

    Route::get('','FAQController@index')->name('index');

    Route::group(['middleware' => 'admin'], function(){
        Route::post('{faq}/edit','FAQController@edit')->name('edit');
        Route::post('create', 'FAQController@create')->name('create');

        Route::get('{faq}/delete','FAQController@delete')->name('delete');
    });
});

Route::get('logout', 'LoginController@logout')->name('logout');

Route::get('activate/{token}','LoginController@activate')->name('user.activate');
Route::get('user/disable_email/{token}','UserController@disableEmail')->name('user.disable_email');

Route::get('activate','LoginController@emailSent')->name('activate');

Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => 'auth'],
    function () {
        Route::get('new', 'OrdersController@create')->name('new');
        Route::post('delete/order/{order}', 'OrdersController@delete')->name('delete');
        Route::get('fake', 'OrdersController@fake')->name('fake');
        Route::post('save/fake', 'OrdersController@saveFake')->name('saveFake');
        Route::post('save/{group}', 'OrdersController@save')->name('save');
        Route::get('finished/{group}', 'OrdersController@finished')->name('finished');
        Route::get('image/{image}', 'OrdersController@getImage')->name('getImage');
        Route::get('font/order/{order}', 'OrdersController@getFont')->name('getFont');

        Route::post('new/step/2/{group?}', 'OrdersController@step2')->name('step2');
        Route::get('new/2/{group}', 'OrdersController@newStep2')->name('new.step2');
        Route::get('new/step/2/delete/{order}', 'OrdersController@deleteStep2')->name('step2.delete');

        Route::get('{group}/joint','OrdersController@joint')->name('joint');

        Route::get('{order}/archive', 'OrdersController@archive')->name('archive');

        Route::post('{order}/edit','OrdersController@edit')->name('edit');

        Route::get('{group}/view','OrdersController@group')->name('view');
        Route::get('{group}/order/{order}', 'OrdersController@order')->name('order');

        Route::post('email/{order}','OrdersController@email')->name('email');

        Route::post('setUser/{order}','OrdersController@setUser')->name('setUser');

        Route::post('{group}/comment','OrdersController@comment')->name('comment');
        Route::get('{group}/assign', 'OrdersController@assign')->name('assign');
        Route::post('{group}/status', 'OrdersController@changeStatus')->name('changeStatus');

        Route::get('unapproved', 'OrdersController@unapproved')->name('unapproved');
        Route::get('approve/order/{order}/{internal}', 'OrdersController@approve')->name('approve');

        Route::get('active', 'OrdersController@active')->name('active');

        Route::get('update','OrdersController@updateTrello')->name('update');

        Route::get('{order}/albums','OrdersController@albums')->name('albums');

        Route::get('{order}/unarchive', 'OrdersController@unarchive')->name('unarchive');
        Route::get('{order}/done', 'OrdersController@done')->name('done');
        Route::get('{order}/help', 'OrdersController@help')->name('help');

        Route::post('{order}/edit/status', 'OrdersController@editStatus')->name('editStatus')->middleware('rookie');

        Route::get('{group}/delete','OrdersController@deleteGroup')->name('deleteGroup');

        Route::post('{group}/changeETA','OrdersController@changeETA')->name('changeETA')->middleware('rookie');

        Route::get('{order}/existing', 'OrdersController@existing')->name('existing');

        Route::post('{order}/testImage', 'OrdersController@testImage')->name('testImage');

        Route::post('{group}/add', 'OrdersController@addOrder')->name('group.add');

        Route::get('{group}/spam', 'OrdersController@spam')->name('group.spam');
        Route::get('{group}/spam/delete', 'OrdersController@deleteSpam')->name('group.spam.delete');
        Route::get('{group}/spam/unmark', 'OrdersController@notSpam')->name('group.notSpam');
    });

Route::group(['prefix' => 'designs', 'as' => 'designs.', 'middleware' => 'auth'], function(){

    Route::post('find','DesignController@find')->name('find');
    Route::get('{design}/order/{order}','DesignController@attachGroupToOrder')->name('attach')->middleware('rookie');

    Route::group(['middleware' => 'member'], function(){
        Route::get('{design}/svg', 'DesignController@getSVGFile')->name('getSVG');

        Route::post('{group}/save','DesignController@save')->name('save');

        Route::get('{order}/redraw','DSTController@redraw')->name('redraw');
    });

    Route::post('{design}/colors', 'DesignController@colors')->name('colors');
    Route::get('{design}/parse/{order?}','DSTController@parse')->name('parse');
    Route::get('{design}/get','DesignController@get')->name('get');

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function(){
        Route::get('{order}/view','DesignController@order')->name('view');
        Route::post('{order}/add','DesignController@addToOrder')->name('add');
        Route::post('{order}/update/{design}','DesignController@updateOrder')->name('update');
        Route::post('{order}/update','DesignController@updateSingle')->name('updateSingle');
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
    Route::get('archived','MembersController@archived')->name('archived');

    Route::group(['middleware' => 'leader'], function(){
        Route::get('active','MembersController@active')->name('active');
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

    Route::group(['middleware' => 'rookie'], function(){
        Route::post('find','UserController@find')->name('find');
    });

    Route::get('profile','UserController@profile')->name('profile');
    Route::get('emails/enable','UserController@enableEmails')->name('emails.enable');
    Route::get('emails/disable','UserController@disableEmails')->name('emails.disable');

    Route::get('in', 'UserController@in')->name('in');
    Route::get('out','UserController@out')->name('out');

    Route::get('notifications/disable','UserController@disableNotifications')->name('disable_notifications');
});

Route::group(['prefix' => 'admin','as' => 'admin.', 'middleware' => 'leader'], function(){
    Route::get('', 'Admin\AdminController@index')->name('index');

    Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
        Route::get('', 'Admin\UsersController@index')->name('index');

        Route::get('{user}', 'Admin\UsersController@user')->name('user');
        Route::post('{user}/edit', 'Admin\UsersController@edit')->name('edit');
    });

    Route::group(['prefix' => 'galleries', 'as' => 'galleries.'], function(){
        Route::get('', 'Admin\GalleryController@index')->name('index');

        Route::get('{gallery}', 'Admin\GalleryController@gallery')->name('gallery');
        Route::get('{gallery}/delete', 'Admin\GalleryController@delete')->name('delete');

        Route::post('new', 'Admin\GalleryController@new')->name('new');
    });

    Route::group(['prefix' => 'albums', 'as' => 'albums.'], function() {
        Route::get('{album}', 'Admin\AlbumController@album')->name('album');

        Route::post('new', 'Admin\AlbumController@new')->name('new');
    });

    Route::group(['prefix' => 'designs', 'as' => 'designs.'], function(){
        Route::get('', 'Admin\DesignsController@index')->name('index');

        Route::get('{design_group}', 'Admin\DesignsController@group')->name('group');
        Route::post('new', 'Admin\DesignsController@newGroup')->name('new');
        Route::post('{design_group}/edit', 'Admin\DesignsController@editGroup')->name('edit');
        Route::get('{design_group}/delete', 'Admin\DesignsController@deleteGroup')->name('delete');
        Route::post('{design_group}/save', 'Admin\DesignsController@upload')->name('save');

        Route::get('design/{design}/delete', 'Admin\DesignsController@deleteDesign')->name('deleteDesign');
    });

    Route::group(['prefix' => 'slides', 'as' => 'slides.'], function(){
        Route::get('','Admin\SlidesController@index')->name('index');

        Route::get('{slide}/edit', 'Admin\SlidesController@edit')->name('edit');
        Route::post('{slide}/save', 'Admin\SlidesController@save')->name('save');
        Route::get('{slide}/up', 'Admin\SlidesController@up')->name('up');
        Route::get('{slide}/down', 'Admin\SlidesController@down')->name('down');
        Route::get('{slide}/delete', 'Admin\SlidesController@delete')->name('delete');
        Route::post('new', 'Admin\SlidesController@create')->name('new');
    });

    Route::group([
        'prefix' => 'misc',
        'as' => 'misc.'
    ], function(){

        Route::get('', 'Admin\AdminController@misc')->name('index');

        Route::post('public_gallery','Admin\AdminController@setPublicGallery')->name('set_public_gallery');
        Route::post('orders_gallery', 'Admin\AdminController@setOrdersGallery')->name('set_orders_gallery');
        Route::post('orders_folder','Admin\AdminController@setOrdersFolder')->name('set_orders_folder');
        Route::post('machine_role','Admin\AdminController@setMachineRole')->name('set_machine_role');
    });

    Route::group([
        'prefix' => 'backgrounds',
        'as' => 'backgrounds.'
    ], function(){
        Route::get('', 'Admin\BackgroundsController@index')->name('index');

        Route::post('create', 'Admin\BackgroundsController@create')->name('create');
        Route::post('{background}/edit', 'Admin\BackgroundsController@edit')->name('edit');
        Route::get('{background}/delete', 'Admin\BackgroundsController@delete')->name('delete');
    });

    Route::group([
        'prefix' => 'news',
        'as' => 'news.'
    ], function(){
        Route::get('','Admin\NewsController@index')->name('index');
    });
});

Route::group(['prefix' => 'api','as' => 'api.', 'middleware' => 'machine'], function(){
    Route::group(['prefix' => 'machine', 'as' => 'machine.'], function(){
        Route::post('status','API\MachineController@updateStatus')->name('status');
        Route::post('dst', 'API\MachineController@updateDST')->name('dst');
    });
});


Route::get('api/machine/status/get/{machine_key}','API\MachineController@getStatus')->name('getStatus');

Route::group(['prefix' => 'machines', 'as' => 'machines.', 'middleware' => 'rookie'], function(){
    Route::get('status', 'HomeController@machineStatus')->name('status')->middleware('view-machine');
    Route::post('getStatus','HomeController@getMachineStatus')->name('getStatus');
    Route::post('getProgressBar', 'HomeController@getProgressBar')->name('getProgressBar');
});

Route::post('get/users','HomeController@getUsers')->name('getUsers');

Route::group(['prefix' => 'jumpers', 'as' => 'jumpers.'], function(){
    Route::get('','JumperController@index')->name('index');

    Route::get('edit','JumperController@edit')->name('edit');
    Route::post('save','JumperController@save')->name('save');
});
