<?php


$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register',  ['uses' => 'AuthController@register']);
    $router->post('login',     ['uses' => 'AuthController@login']);
});



$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('',  ['uses' => 'UserController@getAll']);
    $router->group(['prefix' => 'check'], function () use ($router) {
        $router->post('email',   ['uses' => 'UserController@checkIfEmailExists']);
    });
});