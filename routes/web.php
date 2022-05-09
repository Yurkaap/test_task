<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('user/register', '\App\Http\Controllers\Api\ApiUserController@register');
    $router->post('user/sign-in', '\App\Http\Controllers\Api\ApiUserController@login');
    $router->post('user/recover-password', '\App\Http\Controllers\Api\ApiUserController@recoverPassword');
    $router->get('user/companies/{user_id}', '\App\Http\Controllers\Api\ApiUserController@showUserCompanies');
    $router->post('user/companies', '\App\Http\Controllers\Api\ApiUserController@addUserCompany');
});
