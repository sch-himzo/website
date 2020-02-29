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
Route::get('newActivate', 'LoginController@newCode')->name('new_activate');
Route::get('email_sent', 'LoginController@activate2')->name('activate2');

Route::group(['prefix' => 'orders', 'as' => 'orders.', 'middleware' => ['auth','activate']],
    function(){
        Route::group(['prefix' => 'new', 'as' => 'new.'],
            function(){
                Route::get('create', 'NewOrderController@create')->name('create');
                Route::get('fake', 'NewOrderController@fake')->name('fake');

                Route::post('{order}/delete', 'NewOrderController@deleteOrder')->name('delete.order');
                Route::get('{group}/delete', 'NewOrderController@deleteGroup')->name('delete.group');

                Route::post('{group}/save', 'NewOrderController@save')->name('save');
                Route::get('{group}/finished', 'NewOrderController@finished')->name('finished');

                Route::post('step/2/{group?}','NewOrderController@step2')->name('step2');
                Route::get('step/new/2/{group}', 'NewOrderController@newStep2')->name('new_step_2');
                Route::get('step/new/2/delete/{order}', 'NewOrderController@deleteStep2')->name('step2.delete');

            });

        Route::group(['prefix' => 'groups', 'as' => 'groups.'],
            function(){
                Route::get('{group}', 'OrderGroupController@view')->name('view');

                Route::get('{group}/joint','OrderGroupController@joint')->name('joint');
                Route::get('{group}/archive', 'OrderGroupController@archive')->name('archive');
                Route::get('{group}/unarchive','OrderGroupController@unarchive')->name('unarchive');
                Route::get('{group}/assign', 'OrderGroupController@assign')->name('assign');
                Route::get('{group}/approve/{internal}', 'OrderGroupController@approve')->name('approve');
                Route::get('{group}/done', 'OrderGroupController@done')->name('done');
                Route::get('{group}/help', 'OrderGroupController@help')->name('help');
                Route::post('{group}/ETA', 'OrderGroupController@ETA')->name('ETA')->middleware('rookie');
                Route::post('{group}/comment', 'OrderGroupController@comment')->name('comment');
                Route::post('{group}/status', 'OrderGroupController@status')->name('status');
                Route::post('{group}/add', 'OrderGroupController@add')->name('add');
                Route::post('{group}/delete', 'OrderGroupController@delete')->name('delete');

                Route::get('{group}/spam', 'OrderGroupController@spam')->name('spam');
                Route::get('{group}/spam/delete', 'OrderGroupController@deleteSpam')->name('spam.delete');
                Route::get('{group}/spam/unset', 'OrderGroupController@notSpam')->name('spam.unset');

            });

        Route::get('{group}/order/{order}', 'OrderController@view')->name('view');

        Route::get('{order}/albums', 'OrderController@albums')->name('albums');
        Route::post('{order}/status', 'OrderController@status')->name('status')->middleware('rookie');
        Route::get('{order}/existing', 'OrderController@existing')->name('existing');
        Route::post('{order}/testImage', 'OrderController@testImage')->name('testImage');

        Route::get('image/{image}', 'OrderController@image')->name('image');
        Route::get('{order}/font', 'OrderController@font')->name('font');
    });

Route::group([
    'prefix' => 'projects',
    'as' => 'projects.',
    'middleware' => 'rookie'
], function(){
    Route::get('', 'ProjectController@index')->name('index');

    Route::match(['get','post'], 'create/{step?}', 'ProjectController@create')->name('create');
    Route::post('save', 'ProjectController@save')->name('save');
});


Route::group(['prefix' => 'designs', 'as' => 'designs.', 'middleware' => ['auth','activate']], function(){

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

Route::group(['prefix' => 'transactions', 'as' => 'transactions.', 'middleware' => ['jew','activate']], function(){
    Route::post('teddy-bears/new','TransactionController@newTeddy')->name('teddy_bear.new');
    Route::post('teddy-bears/{teddy_bear}/balance/add', 'TransactionController@addBalance')->name('teddy_bear.balance.add');

    Route::post('transaction/{transaction}/edit','TransactionController@editTransaction')->name('edit');
    Route::post('transaction/{transaction}/delete','TransactionController@deleteTransaction')->name('delete');

    Route::get('teddy-bears/{teddy_bear}','TransactionController@teddyBear')->name('teddy_bear');

    Route::get('teddy-bears','TransactionController@teddyBears')->name('teddy_bears');
});

Route::group(['prefix' => 'members','as' => 'members.', 'middleware' => ['rookie','activate']], function(){
    Route::get('','MembersController@index')->name('index');
    Route::get('unassigned','MembersController@unassigned')->name('unassigned');
    Route::get('mine','MembersController@mine')->name('mine');
    Route::get('unapproved','MembersController@unapproved')->name('unapproved');

    Route::get('joint','MembersController@joint')->name('joint');
    Route::get('archived','MembersController@archived')->name('archived');

    Route::get('active','MembersController@active')->name('active');

});

Route::group(['prefix' => 'gallery','as' => 'gallery.'], function(){
    Route::get('','Gallery\GalleryController@images')->name('index');
});

Route::group(['prefix' => 'images', 'as' => 'images.'], function(){
    Route::get('{image}/get', 'Gallery\ImageController@get')->name('get');
});

Route::group(['prefix' => 'albums', 'as' => 'albums.'], function(){
    Route::group(['middleware' => ['auth','activate']], function(){
        Route::get('new/order/{order}','Gallery\AlbumController@create')->name('new');
        Route::post('new/step/2/order/{order}','Gallery\AlbumController@editUploadedImages')->name('new.step2');
        Route::post('save/order/{order}/album/{album}','Gallery\AlbumController@save')->name('save');
    });

    Route::get('view/{album}','Gallery\AlbumController@view')->name('view');
});


Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth','activate']], function(){
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

Route::group(['prefix' => 'admin','as' => 'admin.', 'middleware' => ['leader','activate']], function(){
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
        'prefix' => 'emails',
        'as' => 'emails.'
    ], function(){
        Route::get('', 'Admin\EmailController@index')->name('index');

        Route::get('unsent', 'Admin\EmailController@unsent')->name('unsent');
        Route::get('sent', 'Admin\EmailController@sent')->name('sent');

        Route::get('{email}/delete', 'Admin\EmailController@delete')->name('delete');
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
        Route::post('min_time','Admin\AdminController@setCurrentMinTime')->name('min_time');
        Route::post('projects_group', 'Admin\AdminController@setProjectsGroup')->name('projects_group');
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

        Route::get('new', 'Admin\NewsController@create')->name('new');
        Route::post('save', 'Admin\NewsController@save')->name('save');
        Route::get('edit/{news}', 'Admin\NewsController@edit')->name('edit');
        Route::post('push/{news}', 'Admin\NewsController@push')->name('push');
        Route::get('delete/{news}', 'Admin\NewsController@delete')->name('delete');
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
