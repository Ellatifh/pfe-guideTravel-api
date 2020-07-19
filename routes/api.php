<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('login', function () {
   return response(['status'=>false,"message"=>"Unauthorized ! You're not authenticated"],401)
                  ->header('Content-Type', 'application/json');
})->name('login');
Route::prefix('v1')->group(function(){
    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@signup');

    /****** AUTHENTICATION */
    Route::post('logout', 'Api\AuthController@logout');
    Route::get('user', 'Api\AuthController@user');
    Route::put('user/changePwd', 'Api\AuthController@changePassword');
    Route::post('user/password/reset', 'Api\AuthController@forgot_password');
    /****** END AUTHENTICATION */

    Route::apiresource('users', 'Api\AuthController');
    Route::apiresource('cities', 'Api\CitieController');
    Route::apiresource('categories', 'Api\CategorieController');
    Route::apiresource('events', 'Api\EventController');
    Route::apiresource('hebergements', 'Api\HebergementController');
    Route::apiresource('cultures', 'Api\CultureController');
    //Route::apiresource('medias', 'Api\MediaController');
    Route::apiresource('infos', 'Api\InfosController');
    Route::apiresource('loisirs', 'Api\LoisirController');
    Route::apiresource('restaurants', 'Api\RestaurantController');
    Route::apiresource('shoppings', 'Api\ShoppingController');

    Route::get('medias', 'Api\MediaController@index');
    Route::get('cities/{id}/events', 'Api\CitieController@events');
    Route::get('cities/{id}/hebergements', 'Api\CitieController@hebergements');
    Route::get('cities/{id}/cultures', 'Api\CitieController@cultures');
    Route::get('cities/{id}/infos', 'Api\CitieController@infos');
    Route::get('cities/{id}/loisirs', 'Api\CitieController@loisirs');
    Route::get('cities/{id}/restaurants', 'Api\CitieController@restaurants');
    Route::get('cities/{id}/shoppings', 'Api\CitieController@shoppings');
    Route::get('endroits/sync/{date}', 'Api\EventController@synchronise');
});
