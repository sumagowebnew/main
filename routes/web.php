<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/register', 'AuthController@register');

$router->post('/login', 'AuthController@login');

$router->post('/refresh_token', 'AuthController@refresh_token');

$router->get('/clientLogo', 'ClientLogoController@index');
$router->get('/clientLogo/show/{id}', 'ClientLogoController@show');
$router->post('/clientLogo/add', 'ClientLogoController@store');
$router->post('/clientLogo/update/{id}', 'ClientLogoController@update');
$router->delete('/clientLogo/delete/{id}', 'ClientLogoController@destroy');

$router->get('/contact/get-all-record', 'ContactEnquiriesController@getAllRecord');
$router->post('/contact/add', 'ContactEnquiriesController@getAdd');
$router->get('/get-all-record', 'ContactEnquiriesController@getAllRecord');
$router->delete('/contact/delete/{id}', 'ContactEnquiriesController@destroy');

$router->get('/questions/get-all-record', 'questionController@getAllRecord');
$router->post('/questions/add', 'questionController@add');
$router->get('/get-all-record', 'questionController@getAllRecord');
$router->delete('/questions/delete/{id}', 'questionController@destroy');

$router->get('/freeConsultaion/get-all-record', 'freeConsultationController@getAllRecord');
$router->post('/freeConsultaion/add', 'freeConsultationController@add');
$router->get('/get-all-record', 'freeConsultationController@getAllRecord');
$router->delete('/freeConsultaion/delete/{id}', 'freeConsultationController@destroy');

$router->get('/getAquote/get-all-record', 'GetAQuoteController@getAllRecord');
$router->post('/getAquote/add', 'GetAQuoteController@add');
$router->get('/get-all-record', 'GetAQuoteController@getAllRecord');
$router->delete('/getAquote/delete/{id}', 'GetAQuoteController@destroy');

$router->get('/count/get-all-record', 'CountController@getAllRecord');
$router->post('/count/add', 'CountController@add');
$router->post('/count/update/{id}', 'CountController@update');
$router->get('/get-all-record', 'CountController@getAllRecord');
$router->delete('/count/delete/{id}', 'CountController@destroy');

$router->get('/portfolio/get-all-record', 'PortfolioController@getAllRecord');
$router->post('/portfolio/add', 'PortfolioController@add');
$router->post('/portfolio/update/{id}', 'PortfolioController@update');
$router->delete('/portfolio/delete/{id}', 'PortfolioController@destroy');

$router->get('/appreciation', 'ClientLogoController@index');
$router->get('/appreciation/show/{id}', 'AppreciationController@show');
$router->post('/appreciation/add', 'AppreciationController@store');
$router->post('/appreciation/update/{id}', 'AppreciationController@update');
$router->delete('/appreciation/delete/{id}', 'AppreciationController@destroy');

$router->group(['middleware' => 'auth'], function () use ($router) {

$router->post('/logout', 'AuthController@logout');


});
