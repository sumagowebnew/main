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

//$router->post('/login', 'AuthController@login');
//$router->post('/login', 'LoginController@user_login');

// Route::group([
//     'prefix' => 'api'
// ],
// function ($router) {
// });

Route::post('/login', 'AuthController@login');
$router->post('/refresh_token', 'AuthController@refresh_token');
$router->get('/clientLogo/get-all-record', 'ClientLogoController@index');
$router->get('/contact/get-all-record', 'ContactEnquiriesController@getAllRecord');
$router->get('/get-all-record', 'ContactEnquiriesController@getAllRecord');
$router->get('/questions/get-all-record', 'questionController@getAllRecord');
$router->get('/get-all-record', 'questionController@getAllRecord');
$router->get('/freeConsultaion/get-all-record', 'freeConsultationController@getAllRecord');
$router->get('/get-all-record', 'freeConsultationController@getAllRecord');
$router->get('/getAquote/get-all-record', 'GetAQuoteController@getAllRecord');
$router->get('/get-all-record', 'GetAQuoteController@getAllRecord');
$router->get('/count/get-all-record', 'CountController@getAllRecord');
$router->get('/get-all-record', 'CountController@getAllRecord');
$router->get('/portfolio/get-all-record', 'PortfolioController@index');
$router->get('/appreciation/get-all-record', 'AppreciationController@index');
$router->get('/birthday/get-all-record', 'BirthdayController@index');
$router->get('/events/get-all-record', 'EventsController@index');
$router->get('/award/get-all-record', 'AwardController@index');
$router->get('/training/get-all-record', 'TrainingController@index');
$router->get('/designation/get-all-record', 'DesignationController@getAllRecord');
$router->get('/news/get-all-record', 'NewsController@index');
$router->get('/certificate/get-all-record', 'CertificateController@index');
$router->get('/mou/get-all-record', 'MouController@index');
$router->get('/recognisation/get-all-record', 'RecognisationController@index');
$router->get('/funatwork/get-all-record', 'FunatworkController@index');
$router->get('/achievement/get-all-record', 'AchievementsController@index');
$router->get('/admin_team/get-all-record', 'AdminTeamController@index');
$router->get('/trainee_team/get-all-record', 'TraineeTeamController@index');
$router->get('/career_enquirires/get-all-record', 'CareerEnquiriesController@show');
$router->get('/dashboard/get_dashboard_count', 'DashboardController@get_dashboard_count');
$router->get('/contact_details/get-all-record', 'ContactDetailsController@getAllRecord');
$router->get('/vacancy/get-all-record', 'VacancyController@getAllRecord');
$router->get('/service/get-all-record', 'ServiceController@index');
$router->get('/developement_team/get-all-record', 'DevelopementTeamController@index');
$router->get('/design_team/get-all-record', 'DesignTeamController@index');
$router->get('/career_enquirires/{id}/download/cv', 'CareerEnquiriesController@downloadCV');
$router->get('/career_enquirires/{id}/download/cover_letter', 'CareerEnquiriesController@downloadCoverLetter');
$router->post('/contact/add', 'ContactEnquiriesController@getAdd');
$router->post('/career_enquirires/add', 'CareerEnquiriesController@add');
$router->post('/getAquote/add', 'GetAQuoteController@add');
$router->get('/slider/get_all_records', 'SliderController@index');



$router->group(['middleware' => 'auth'], function () use ($router)
{
    $router->get('/clientLogo/show/{id}', 'ClientLogoController@show');
    $router->post('/clientLogo/add', 'ClientLogoController@store');
    $router->post('/clientLogo/update/{id}', 'ClientLogoController@update');
    $router->delete('/clientLogo/delete/{id}', 'ClientLogoController@destroy');
    $router->delete('/contact/delete/{id}', 'ContactEnquiriesController@destroy');
    $router->post('/questions/add', 'questionController@add');
    $router->delete('/questions/delete/{id}', 'questionController@destroy');
    $router->post('/freeConsultaion/add', 'freeConsultationController@add');
    $router->delete('/freeConsultaion/delete/{id}', 'freeConsultationController@destroy');
    $router->delete('/getAquote/delete/{id}', 'GetAQuoteController@destroy');
    $router->post('/count/add', 'CountController@add');
    $router->post('/count/update/{id}', 'CountController@update');
    $router->delete('/count/delete/{id}', 'CountController@destroy');
    $router->post('/portfolio/add', 'PortfolioController@add');
    $router->post('/portfolio/update/{id}', 'PortfolioController@update');
    $router->delete('/portfolio/delete/{id}', 'PortfolioController@destroy');
    $router->get('/appreciation/show/{id}', 'AppreciationController@show');
    $router->post('/appreciation/add', 'AppreciationController@store');
    $router->post('/appreciation/update/{id}', 'AppreciationController@update');
    $router->delete('/appreciation/delete/{id}', 'AppreciationController@destroy');
    $router->get('/birthday/show/{id}', 'BirthdayController@show');
    $router->post('/birthday/add', 'BirthdayController@store');
    $router->post('/birthday/update/{id}', 'BirthdayController@update');
    $router->delete('/birthday/delete/{id}', 'BirthdayController@destroy');
    $router->get('/events/show/{id}', 'EventsController@show');
    $router->post('/events/add', 'EventsController@store');
    $router->post('/events/update/{id}', 'EventsController@update');
    $router->delete('/events/delete/{id}', 'EventsController@destroy');
    $router->get('/award/show/{id}', 'AwardController@show');
    $router->post('/award/add', 'AwardController@store');
    $router->post('/award/update/{id}', 'AwardController@update');
    $router->delete('/award/delete/{id}', 'AwardController@destroy');
    $router->get('/training/show/{id}', 'TrainingController@show');
    $router->post('/training/add', 'TrainingController@store');
    $router->post('/training/update/{id}', 'TrainingController@update');
    $router->delete('/training/delete/{id}', 'TrainingController@destroy');
    $router->post('/designation/add', 'DesignationController@add');
    $router->post('/designation/update/{id}', 'DesignationController@update');
    $router->delete('/designation/delete/{id}', 'DesignationController@destroy');
    $router->post('/news/add', 'NewsController@add');
    $router->post('/news/update/{id}', 'NewsController@update');
    $router->delete('/news/delete/{id}', 'NewsController@destroy');
    $router->post('/certificate/add', 'CertificateController@add');
    $router->delete('/certificate/delete/{id}', 'CertificateController@destroy');
    $router->post('/mou/add', 'MouController@add');
    $router->post('/mou/update/{id}', 'MouController@update');
    $router->delete('/mou/delete/{id}', 'MouController@destroy');
    $router->post('/recognisation/add', 'RecognisationController@add');
    $router->post('/recognisation/update/{id}', 'RecognisationController@update');
    $router->delete('/recognisation/delete/{id}', 'RecognisationController@destroy');
    $router->post('/funatwork/add', 'FunatworkController@add');
    $router->post('/funatwork/update/{id}', 'FunatworkController@update');
    $router->delete('/funatwork/delete/{id}', 'FunatworkController@destroy');
    $router->post('/achievement/add', 'AchievementsController@add');
    $router->delete('/achievement/delete/{id}', 'AchievementsController@destroy');
    $router->post('/developement_team/add', 'DevelopementTeamController@add');
    $router->delete('/developement_team/delete/{id}', 'DevelopementTeamController@destroy');
    $router->post('/admin_team/add', 'AdminTeamController@add');
    $router->delete('/admin_team/delete/{id}', 'AdminTeamController@destroy');
    $router->post('/trainee_team/add', 'TraineeTeamController@add');
    $router->delete('/trainee_team/delete/{id}', 'TraineeTeamController@destroy');
    $router->delete('/career_enquirires/delete/{id}', 'CareerEnquiriesController@destroy');
    $router->post('/contact_details/add', 'ContactDetailsController@getAdd');
    $router->post('/contact_details/update/{id}', 'ContactDetailsController@update');
    $router->delete('/contact_details/delete/{id}', 'ContactDetailsController@destroy');
    $router->post('/vacancy/add', 'VacancyController@getAdd');
    $router->post('/vacancy/update/{id}', 'VacancyController@update');
    $router->delete('/vacancy/delete/{id}', 'VacancyController@destroy');
    $router->post('/service/add', 'ServiceController@add');
    $router->post('/service/update/{id}', 'ServiceController@update');
    $router->delete('/service/delete/{id}', 'ServiceController@destroy');
    $router->post('/logout', 'AuthController@logout');
    $router->post('/design_team/add', 'DesignTeamController@add');
    $router->post('/design_team/update/{id}', 'DesignTeamController@update');
    $router->delete('/design_team/delete/{id}', 'DesignTeamController@destroy');
    $router->post('/slider/add', 'SliderController@add');
    $router->post('/slider/update/{id}', 'SliderController@update');
    $router->delete('/slider/delete/{id}', 'SliderController@destroy');

});
