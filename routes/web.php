<?php



$router->post('auth/register',  ['uses' => 'AuthController@register']);

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('',  ['uses' => 'UserController@getAll']);


    $router->group(['prefix' => 'check'], function () use ($router) {
        $router->post('email',   ['uses' => 'UserController@checkIfEmailExists']);
    });
});