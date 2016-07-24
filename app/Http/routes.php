<?php
/*
use \piwidict\Piwidict;

$wikt_lang = 'ru';
Piwidict::setWiktLang ($wikt_lang);
Piwidict::setDatabaseConnection(env('DB_WIKT_HOST'), 
                                env('DB_WIKT_USERNAME'), 
                                env('DB_WIKT_USERPASS'), 
                                env('DB_WIKT_DATABASE_'.strtoupper($wikt_lang)));
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('', 'IndexController@index');

Route::get('setlocale/{locale}', function ($locale) {
    
    if (in_array($locale, Config::get('app.locales'))) {   # Проверяем, что у пользователя выбран доступный язык 
        Session::put('locale', $locale);                    # И устанавливаем его в сессии под именем locale
    }

    return redirect()->back();                              # Редиректим его <s>взад</s> на ту же страницу
});

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/confirm/{token?}', 'Auth\AuthController@getConfirm');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::group([
    'prefix'=>'admin', 
    'namespace'=>'Admin', 
    'middleware'=>'admin'
    ], function() {

    Route::get('', function() {
        return view('admin.index');
    });
    Route::post('user/find','UserController@postFind');
    Route::resource('user','UserController');

});

Route::get(
    '/socialite/{provider}',
    [ 
        'as' => 'socialite.auth',
        function ( $provider ) {
            return \Socialite::driver( $provider )->redirect();
        }
    ]
);

Route::get('/socialite/{provider}/callback', function ($provider) {
    $user = \Socialite::driver($provider)->user();
    dd($user);
});

Route::get('lab/word', 'Lab\WordController@index');
Route::get('lab/stats/languages', 'Lab\LanguagesController@index');
Route::get('lab/stats', function() {
    return view('lab.stats.index');
});
Route::get('lab',  function() {
    return view('lab.index');
});

