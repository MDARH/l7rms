<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});





// TEST
Route::get('/addseed', 'DbseedController@seed')->name('seed');
Route::get('/new', 'DbseedController@newuser')->name('seed-new-stu');
Route::get('/stu/{id}', 'DbseedController@getuser')->name('getUser');
Route::get('/student/{roll}', 'DbseedController@roll')->name('getUserByRoll');
Route::get('/dep/{user}', 'DbseedController@dep')->name('dep');
Route::get('/cls/{user}', 'DbseedController@cls')->name('cls');

Route::get('/newdepcls', 'DbseedController@newdepcls')->name('newdepcls');

Route::get('/department/{dep_slug}', 'DbseedController@deptocls')->name('deptocls');
Route::get('/class/{class}', 'DbseedController@clstodep')->name('clstodep');
