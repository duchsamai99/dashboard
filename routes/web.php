<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('login', function () {           return view('auth.login'); });
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['get.menu']], function () {
        Route::get('/', function () {           return view('dashboard.homepage'); });
        Route::group(['middleware' => ['role:admin']], function () {
            // users route
            Route::resource('users',        'UsersController');
            Route::post('/users/crop',   'UsersController@cropProfile')->name('users.crop');
            // roles route
            Route::resource('roles',        'RolesController');
            Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
            Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
            // site description route
            Route::resource('site-descriptions', 'SiteDescriptionController');
            Route::post('/site-descriptions/crop',   'SiteDescriptionController@crop')->name('site-descriptions.crop');

            // admin menu route
            Route::prefix('menu/element')->group(function () { 
                Route::get('/',             'MenuElementController@index')->name('menu.index');
                Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
                Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
                Route::get('/create',       'MenuElementController@create')->name('menu.create');
                Route::post('/store',       'MenuElementController@store')->name('menu.store');
                Route::get('/get-parents',  'MenuElementController@getParents');
                Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
                Route::post('/update',      'MenuElementController@update')->name('menu.update');
                Route::get('/show',         'MenuElementController@show')->name('menu.show');
                Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
            });
            // admin menu route
            Route::prefix('site/menu')->group(function () { 
                Route::get('/',             'SiteMenuController@index')->name('site.menu.index');
                Route::get('/move-up',      'SiteMenuController@moveUp')->name('site.menu.up');
                Route::get('/move-down',    'SiteMenuController@moveDown')->name('site.menu.down');
                Route::get('/create',       'SiteMenuController@create')->name('site.menu.create');
                Route::post('/store',       'SiteMenuController@store')->name('site.menu.store');
                Route::get('/get-parents',  'SiteMenuController@getParents');
                Route::get('/edit',         'SiteMenuController@edit')->name('site.menu.edit');
                Route::post('/update',      'SiteMenuController@update')->name('site.menu.update');
                Route::get('/show',         'SiteMenuController@show')->name('site.menu.show');
                Route::get('/delete',       'SiteMenuController@delete')->name('site.menu.delete');
            });
            // Route::prefix('menu/menu')->group(function () { 
            //     Route::get('/',         'MenuController@index')->name('menu.menu.index');
            //     Route::get('/create',   'MenuController@create')->name('menu.menu.create');
            //     Route::post('/store',   'MenuController@store')->name('menu.menu.store');
            //     Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
            //     Route::post('/update',  'MenuController@update')->name('menu.menu.update');
            //     Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
            // });

            /**
             * project route
             */
            //slide routes
            Route::prefix('slides')->group(function () { 
                Route::get('/',         'SlideController@index')->name('slides.index');
                Route::get('/create',   'SlideController@create')->name('slides.create');
                Route::post('/crop',   'SlideController@crop')->name('slides.crop');
                Route::post('/store',   'SlideController@store')->name('slides.store');
                Route::get('/edit',     'SlideController@edit')->name('slides.edit');
                Route::get('/show',     'SlideController@show')->name('slides.show');
                Route::post('/update',  'SlideController@update')->name('slides.update');
                Route::delete('/delete',   'SlideController@delete')->name('slides.delete');
            });
        });
        // Route::group(['middleware' => ['role:user']], function () {
        //     Route::resource('users',        'UsersController');
        //     Route::get('/colors', function () {     return view('dashboard.colors'); });
        //     Route::get('/typography', function () { return view('dashboard.typography'); });
        //     Route::get('/charts', function () {     return view('dashboard.charts'); });
        //     Route::get('/widgets', function () {    return view('dashboard.widgets'); });
        //     Route::get('/404', function () {        return view('dashboard.404'); });
        //     Route::get('/500', function () {        return view('dashboard.500'); });
        //     Route::prefix('base')->group(function () {  
        //         Route::get('/breadcrumb', function(){   return view('dashboard.base.breadcrumb'); });
        //         Route::get('/cards', function(){        return view('dashboard.base.cards'); });
        //         Route::get('/carousel', function(){     return view('dashboard.base.carousel'); });
        //         Route::get('/collapse', function(){     return view('dashboard.base.collapse'); });

        //         Route::get('/forms', function(){        return view('dashboard.base.forms'); });
        //         Route::get('/jumbotron', function(){    return view('dashboard.base.jumbotron'); });
        //         Route::get('/list-group', function(){   return view('dashboard.base.list-group'); });
        //         Route::get('/navs', function(){         return view('dashboard.base.navs'); });

        //         Route::get('/pagination', function(){   return view('dashboard.base.pagination'); });
        //         Route::get('/popovers', function(){     return view('dashboard.base.popovers'); });
        //         Route::get('/progress', function(){     return view('dashboard.base.progress'); });
        //         Route::get('/scrollspy', function(){    return view('dashboard.base.scrollspy'); });

        //         Route::get('/switches', function(){     return view('dashboard.base.switches'); });
        //         Route::get('/tables', function () {     return view('dashboard.base.tables'); });
        //         Route::get('/tabs', function () {       return view('dashboard.base.tabs'); });
        //         Route::get('/tooltips', function () {   return view('dashboard.base.tooltips'); });
        //     });
        //     Route::prefix('buttons')->group(function () {  
        //         Route::get('/buttons', function(){          return view('dashboard.buttons.buttons'); });
        //         Route::get('/button-group', function(){     return view('dashboard.buttons.button-group'); });
        //         Route::get('/dropdowns', function(){        return view('dashboard.buttons.dropdowns'); });
        //         Route::get('/brand-buttons', function(){    return view('dashboard.buttons.brand-buttons'); });
        //     });
        //     Route::prefix('icon')->group(function () {  // word: "icons" - not working as part of adress
        //         Route::get('/coreui-icons', function(){         return view('dashboard.icons.coreui-icons'); });
        //         Route::get('/flags', function(){                return view('dashboard.icons.flags'); });
        //         Route::get('/brands', function(){               return view('dashboard.icons.brands'); });
        //     });
        //     Route::prefix('notifications')->group(function () {  
        //         Route::get('/alerts', function(){   return view('dashboard.notifications.alerts'); });
        //         Route::get('/badge', function(){    return view('dashboard.notifications.badge'); });
        //         Route::get('/modals', function(){   return view('dashboard.notifications.modals'); });
        //     });
        //     Route::resource('notes', 'NotesController');
        // });
        Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
