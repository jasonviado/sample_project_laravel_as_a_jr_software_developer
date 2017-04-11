<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Clo ure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', 'Home\LoginController@login');
//Route::get('/register','Home\RegisterController@register');
Route::post('registerAccount','Home\RegisterController@registerAccount');



Route::match(array('GET','POST'),'loginUser','Home\LoginController@loginUser');

Route::group(['middleware'=>['afterAuth']],function(){
    Route::match(array('GET','POST'),'/login','Home\LoginController@loginAccess')->name('login');
});


Route::group(['middleware'=>['auth']],function(){
    Route::group(['middleware'=>['clearCache']],function(){
        // HOME
        Route::get('/home', 'User\HomeController@home');
        Route::get('get_home_post', 'User\HomeController@get_home_post');
        Route::post('home_post', 'User\HomeController@home_post');
        Route::get('get_friend_list','User\HomeController@get_friend_list');
        Route::get('not_friends','User\HomeController@not_friends');
        Route::get('get_friend_request','User\HomeController@get_friend_request');
        Route::get('get_find_friends','User\HomeController@get_find_friends');
        Route::get('accept_friend_request','User\HomeController@accept_friend_request');
        Route::get('addFriend','User\HomeController@addFriend');
        Route::get('sendMessage','User\HomeController@sendMessage');
        Route::get('getChatMessage','User\HomeController@getChatMessage');
        Route::post('addGroup','User\HomeController@addGroup');
        Route::get('get_group_list','User\HomeController@get_group_list');
        Route::get('get_group_message','User\HomeController@get_group_message');
        Route::post('send_group_message','User\HomeController@send_group_message');
        Route::get('view_group_members','User\HomeController@view_group_members');
        Route::get('view_not_group_member_list','User\HomeController@view_not_group_member_list');

        // Profile Page
        Route::get('/profile', 'User\ProfileController@profile');
        Route::get('/profile_post', 'User\ProfileController@profile_post');
        Route::post('post', 'User\ProfileController@post');
        // Messages Page

        Route::get('/messages', 'User\MessagesController@messages');
//        Route::get('get_friend_list','User\MessagesController@get_friend_list');
    });
});

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('/login');
});