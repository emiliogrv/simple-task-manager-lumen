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

$app->group(['prefix' => 'authenticate', 'as' => 'api.v1.authenticate'], function ($app) {
	$app->post('/', ['as' => 'login', 'uses' => 'AuthController@login']);

	$app->group(['middleware' => 'auth:api'], function ($app) {
		$app->get('/', ['as' => 'logged', 'uses' => 'AuthController@logged']);
		$app->delete('/', ['as' => 'logout', 'uses' => 'AuthController@logout']);
	});
});

$app->group(['middleware' => 'auth:api', 'as' => 'api.v1'], function ($app) {
	$app->group(['prefix' => 'priorities', 'as' => 'priorities'], function ($app) {
		$app->get('/', ['as' => 'index', 'uses' => 'PriorityController@index']);
		$app->get('{id}', ['as' => 'show', 'uses' => 'PriorityController@show']);
		$app->post('/', ['as' => 'store', 'uses' => 'PriorityController@store']);
		$app->put('{id}', ['as' => 'update', 'uses' => 'PriorityController@update']);
		$app->put('{id}/restore', ['as' => 'restore', 'uses' => 'PriorityController@restore']);
		$app->delete('{id}', ['as' => 'destroy', 'uses' => 'PriorityController@destroy']);
	});

	$app->group(['prefix' => 'users', 'as' => 'users'], function ($app) {
		$app->get('/', ['as' => 'index', 'uses' => 'UserController@index']);
		$app->get('{id}', ['as' => 'show', 'uses' => 'UserController@show']);
		$app->post('/', ['as' => 'store', 'uses' => 'UserController@store']);
		$app->put('{id}', ['as' => 'update', 'uses' => 'UserController@update']);
		$app->put('{id}/restore', ['as' => 'restore', 'uses' => 'UserController@restore']);
		$app->delete('{id}', ['as' => 'destroy', 'uses' => 'UserController@destroy']);
	});

	$app->group(['prefix' => 'tasks', 'as' => 'tasks'], function ($app) {
		$app->get('/', ['as' => 'index', 'uses' => 'TaskController@index']);
		$app->get('{id}', ['as' => 'show', 'uses' => 'TaskController@show']);
		$app->post('/', ['as' => 'store', 'uses' => 'TaskController@store']);
		$app->put('{id}', ['as' => 'update', 'uses' => 'TaskController@update']);
		$app->put('{id}/restore', ['as' => 'restore', 'uses' => 'TaskController@restore']);
		$app->delete('{id}', ['as' => 'destroy', 'uses' => 'TaskController@destroy']);
	});
});