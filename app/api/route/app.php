<?php

use think\facade\Route;

/*Route::get('test','api/test/index');
Route::put('test/:id','api/test/update');
Route::delete('test/:id','api/test/delete');*/


Route::get('test/token','api/test/token');
Route::get('test/sendSms','api/test/sendSms');
Route::resource('test','api/test');


Route::get(':ver/cat','api/:ver.cat/read');

Route::get(':ver/index','api/:ver.index/index');

Route::resource(':ver/news','api/:ver.news');

Route::get(':ver/rank','api/:ver.rank/index');

Route::get(':ver/init','api/:ver.index/init');

Route::resource(':ver/identify','api/:ver.identify');

Route::resource(':ver/login','api/:ver.login');

Route::resource(':ver/user','api/:ver.user');

Route::resource(':ver/image','api/:ver.image');

// 点赞
Route::post(':ver/upvote','api/:ver.upvote/save');

// 取消点赞
Route::delete(':ver/upvote','api/:ver.upvote/delete');

// 查询文章是否被点赞
Route::get(':ver/upvote/:id','api/:ver.upvote/read');