<?php

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

Route::group(["prefix" => "auth"], function ()
{
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');

    Route::get('register', 'Auth\AuthController@getRegister');
    Route::post('register', 'Auth\AuthController@postRegister');

    Route::group(['prefix' => 'google'], function ()
    {
        Route::get('/', 'SocialAuthController@googleLogin');
        Route::get('/redirect', 'SocialAuthController@googleRedirectHandler');
    });

});

Route::group(["middleware" => "auth"], function ()
{
    Route::resource("home", "HomeController", ["only" => ["index"]]);

    Route::delete("folder", "FolderController@bulkDestroy");
    Route::resource("folder", "FolderController");

    Route::get("folder/{folder_id}/file/{id}/content", "FileController@content");
    Route::get("folder/{folder_id}/file/{id}/download", "FileController@download");
    Route::resource("folder.file", "FileController");

    Route::get("/", "AdminController@index");
});

?>
