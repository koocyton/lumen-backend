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

// 更路径
$app->get('/', function () {
	return redirect()->route('login');
});

/*
|-----------------------------------------------------
| 登录接口处理
|-----------------------------------------------------
*/
// 页面 - 显示登录的界面
$app->get('/login', ['as' => 'login', 'uses' => 'LoginController@index']);

// 登录校验的接口
$app->group(['prefix' => '/login', 'namespace'=>'App\Http\Controllers'], function () use ($app) {
	// 用户登录
	$app->post('signin', 'LoginController@signIn');
	// 用户登出
	$app->get('signout', 'LoginController@signOut');
});


/*
|--------------------------------------------------
|管理员的页面和接口 Route 设置
|--------------------------------------------------
*/
// 操作日志
$app->get('/operation/list', 'ManagerController@operationList');

// 管理员的接口
$app->group(['prefix'=>'/manager', 'namespace'=>'App\Http\Controllers'], function() use ($app) {
	// 管理员列表
	$app->get('list', 'ManagerController@list');
	// 管理员
	$app->get('{id}', 'ManagerController@get');
	// 删除管理员
	$app->delete('{id}', 'ManagerController@delete');
	// 管理员开关
	$app->get('{id}/switch', 'ManagerController@switch');
});

/*
|--------------------------------------------------
| 项目操作
|--------------------------------------------------
*/
// 管理员的接口
$app->group(['prefix'=>'/project', 'namespace'=>'App\Http\Controllers'], function() use ($app) {
	// 接口文档
	$app->get('api-debug/{key}', 'ProjectController@apiDebug');
});


/*
|--------------------------------------------------
| API 接口
|--------------------------------------------------
*/
$app->post('/access-token', 'UserController@accessToken');

