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

$router->get('/clientLogo/get-all-record', 'ClientLogoController@index');
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

$router->get('/appreciation/get-all-record', 'AppreciationController@index');
$router->get('/appreciation/show/{id}', 'AppreciationController@show');
$router->post('/appreciation/add', 'AppreciationController@store');
$router->post('/appreciation/update/{id}', 'AppreciationController@update');
$router->delete('/appreciation/delete/{id}', 'AppreciationController@destroy');

$router->get('/birthday/get-all-record', 'BirthdayController@index');
$router->get('/birthday/show/{id}', 'BirthdayController@show');
$router->post('/birthday/add', 'BirthdayController@store');
$router->post('/birthday/update/{id}', 'BirthdayController@update');
$router->delete('/birthday/delete/{id}', 'BirthdayController@destroy');

$router->get('/events/get-all-record', 'EventsController@index');
$router->get('/events/show/{id}', 'EventsController@show');
$router->post('/events/add', 'EventsController@store');
$router->post('/events/update/{id}', 'EventsController@update');
$router->delete('/events/delete/{id}', 'EventsController@destroy');

$router->get('/award/get-all-record', 'AwardController@index');
$router->get('/award/show/{id}', 'AwardController@show');
$router->post('/award/add', 'AwardController@store');
$router->post('/award/update/{id}', 'AwardController@update');
$router->delete('/award/delete/{id}', 'AwardController@destroy');

$router->get('/training/get-all-record', 'TrainingController@index');
$router->get('/training/show/{id}', 'TrainingController@show');
$router->post('/training/add', 'TrainingController@store');
$router->post('/training/update/{id}', 'TrainingController@update');
$router->delete('/training/delete/{id}', 'TrainingController@destroy');

$router->get('/designation/get-all-record', 'DesignationController@getAllRecord');
$router->post('/designation/add', 'DesignationController@add');
$router->post('/designation/update/{id}', 'DesignationController@update');
$router->delete('/designation/delete/{id}', 'DesignationController@destroy');

$router->get('/news/get-all-record', 'NewsController@index');
$router->post('/news/add', 'NewsController@add');
$router->delete('/news/delete/{id}', 'NewsController@destroy');

$router->get('/certificate/get-all-record', 'CertificateController@index');
$router->post('/certificate/add', 'CertificateController@add');
$router->delete('/certificate/delete/{id}', 'CertificateController@destroy');

$router->get('/mou/get-all-record', 'MouController@index');
$router->post('/mou/add', 'MouController@add');
$router->delete('/mou/delete/{id}', 'MouController@destroy');

$router->get('/achievement/get-all-record', 'AchievementsController@index');
$router->post('/achievement/add', 'AchievementsController@add');
$router->delete('/achievement/delete/{id}', 'AchievementsController@destroy');

$router->get('/developement_team/get-all-record', 'DevelopementTeamController@index');
$router->post('/developement_team/add', 'DevelopementTeamController@add');
$router->delete('/developement_team/delete/{id}', 'DevelopementTeamController@destroy');

$router->get('/admin_team/get-all-record', 'AdminTeamController@index');
$router->post('/admin_team/add', 'AdminTeamController@add');
$router->delete('/admin_team/delete/{id}', 'AdminTeamController@destroy');

$router->get('/trainee_team/get-all-record', 'TraineeTeamController@index');
$router->post('/trainee_team/add', 'TraineeTeamController@add');
$router->delete('/trainee_team/delete/{id}', 'TraineeTeamController@destroy');

$router->get('/career_enquirires/get-all-record', 'CareerEnquiriesController@show');
$router->get('/career_enquirires/{id}/download/cv', 'CareerEnquiriesController@downloadCV');
$router->get('/career_enquirires/{id}/download/cover_letter', 'CareerEnquiriesController@downloadCoverLetter');
$router->post('/career_enquirires/add', 'CareerEnquiriesController@add');
$router->delete('/career_enquirires/delete/{id}', 'CareerEnquiriesController@destroy');

$router->group(['middleware' => 'auth'], function () use ($router) {

$router->post('/logout', 'AuthController@logout');

});
