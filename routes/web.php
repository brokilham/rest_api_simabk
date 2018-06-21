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

$router->group(['prefix' => 'siswa'], function () use ($router) {
    $router->post('Index','siswa\SiswaController@index');
    $router->post('GetAllPelanggaran','siswa\SiswaController@GetAllPelanggaran');
    $router->post('GetAllBimbingan','siswa\SiswaController@GetAllBimbingan');
    $router->get('GetAllGuruBk','siswa\SiswaController@GetAllGuruBk');
    $router->post('GetJadwalBimbingan','siswa\SiswaController@GetJadwalBimbingan');
    $router->post('CreateBimbingan','siswa\SiswaController@CreateBimbingan');  
    $router->post('GetDataTimeLine','siswa\SiswaController@GetDataTimeLine');  
});

$router->group(['prefix' => 'walimurid'], function () use ($router) {
    $router->post('GetDataCharts','walimurid\WalimuridController@GetDataCharts');
    $router->post('GetAllPelanggaran','walimurid\WalimuridController@GetAllPelanggaran');
    $router->post('GetAllBimbingan','walimurid\WalimuridController@GetAllBimbingan'); 
});

$router->group(['prefix' => 'walikelas'], function () use ($router) {
    $router->post('GetDataCharts','walikelas\WalikelasController@GetDataCharts');
    $router->post('GetDataSiswaSekelas','walikelas\WalikelasController@GetDataSiswaSekelas');
    $router->post('GetPelanggaranByIdSiswa','walikelas\WalikelasController@GetPelanggaranByIdSiswa');
    $router->post('GetActivitySiswaById','walikelas\WalikelasController@GetActivitySiswaById');
    $router->post('GetHistoryKelas','walikelas\WalikelasController@GetHistoryKelas');
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});


