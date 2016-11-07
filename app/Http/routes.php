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
    Route::get("sharedfolder", "FolderController@sharedFolder");
    Route::get("shareduser/{id}", "FolderController@sharedUser");
    Route::resource("folder", "FolderController");

    Route::get("folder/{folder_id}/file/{id}/content", "FileController@content");
    Route::get("folder/{folder_id}/file/{id}/download", "FileController@download");
    Route::resource("folder.file", "FileController");
    Route::get("/", "AdminController@index");
    route::post('getuserfolders', 'FolderController@getuserfolders');
    Route::get("delete/{id}/{type}", "FileController@deleteFileFolder");
});

Route::group(["middleware"=>"auth"], function()
{
    Route::resource("user", "UserController");
    Route::resource("permission", "PermissionController");
    Route::get("/user/{user_id}/folder/{folder_id}", "UserController@userFolderDocument");
    Route::get("user/{user_id}/home","UserController@userHome");
	Route::get("user/{user_id}/history","UserController@userHistory");
	Route::get("user/{user_id}/usermanage","UserController@userManage");
    Route::post("document_permissions","PermissionController@documentPermission");
    Route::get("/user/{id}/select", "UserController@selectUser");
});

Route::group(["middleware"=>"auth"],function(){
  Route::resource("usermanage", "UserManageController");
});

Route::group(["middleware"=>"auth"], function()
{
    Route::resource("setting", "SettingController");
});

Route::get("test", function () {
    echo \App\User::authUserType();
});

?>
