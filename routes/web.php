<?php

$router->get('users',  ['uses' => 'UserController@getAll']);

$router->post('auth/register',  ['uses' => 'AuthController@register']);

