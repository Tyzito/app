<?php

use think\facade\Route;

/*Route::get('test','api/test/index');
Route::put('test/:id','api/test/update');
Route::delete('test/:id','api/test/delete');*/

Route::resource('test','api/test');

Route::get(':ver/cat','api/:ver.cat/read');

Route::get(':ver/index','api/:ver.index/index');

Route::resource(':ver/news','api/:ver.news');

Route::get(':ver/rank','api/:ver.rank/index');

Route::get(':ver/init','api/:ver.index/init');