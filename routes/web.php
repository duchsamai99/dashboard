<?php
use App\Models\SiteDescription;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

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
        Route::get('/', function (Request $request) {   
            $site_description_last = SiteDescription::all()->last();
            if($site_description_last !=null){
		        session(['logo_image' => $site_description_last->sitImage1]);

                //$request->session()->flash("logo_image", $site_description_last->sitImage1);
            }else{
		        session(['logo_image' => 'amatak_logo.jpg']);

                //$request->session()->flash("logo_image", 'amatak_logo.jpg');

            }        
            return view('dashboard.homepage'); 
        });
        // users route
        Route::resource('users',        'UsersController');
        Route::post('/users/crop',   'UsersController@cropProfile')->name('users.crop');
        // social route
        Route::resource('socials',        'SocialController');
        Route::post('/socials/crop',   'SocialController@cropImage')->name('socials.crop');

        // // social route
        // Route::resource('slides',        'SlideController');
        // Route::post('/slides/crop',   'SlideController@cropImage')->name('socials.crop');
        // title route
        Route::resource('titles',        'TitleController');
        // roles route
        Route::resource('roles',        'RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
        // site description route
        Route::resource('site-descriptions', 'SiteDescriptionController');
        Route::post('/site-descriptions/crop',   'SiteDescriptionController@crop')->name('site-descriptions.crop');

        // switch language
        Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'LanguageController@switchLang']);
        // admin menu route
        Route::prefix('menu/')->group(function () { 
            Route::get('/',             'AdminMenuRoleController@index')->name('menu.index');
            Route::get('/move-up',      'AdminMenuRoleController@moveUp')->name('menu.up');
            Route::get('/move-down',    'AdminMenuRoleController@moveDown')->name('menu.down');
            Route::get('/create',       'AdminMenuRoleController@create')->name('menu.create');
            Route::post('/store',       'AdminMenuRoleController@store')->name('menu.store');
            Route::get('/get-parents',  'AdminMenuRoleController@getParents');
            Route::get('/edit',         'AdminMenuRoleController@edit')->name('menu.edit');
            Route::post('/update',      'AdminMenuRoleController@update')->name('menu.update');
            Route::get('/show',         'AdminMenuRoleController@show')->name('menu.show');
            Route::delete('/delete',       'AdminMenuRoleController@delete')->name('menu.delete');
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
            Route::delete('/delete',    'SiteMenuController@delete')->name('site.menu.delete');
        });
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
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
