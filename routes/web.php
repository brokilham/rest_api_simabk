<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->post('login','app_credential\LoginAppController@LoginAppController');

$router->group(['prefix' => 'transaksi_bimbingan'], function () use ($router) {
  
    //http://localhost/rest_api_simabk/public/transaksi_bimbingan/create
    // $router->get('create','transaksi_bimbingan\TransaksiBimbinganController@create');

   //http://localhost/rest_api_simabk/public/transaksi_bimbingan/create?tes=halo&tes2=kamu
   $router->post('create','transaksi_bimbingan\TransaksiBimbinganController@create');
  
});





/*use Illuminate\Http\Request;

$router->get('/post/{id}', ['middleware' => 'auth', function (Request $request, $id) {
    $user = Auth::user();
    $user = $request->user();

    //
}]);*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


