<?php
require './vendor/autoload.php';
require './Container.php';
require './route/config.php';
$container = new \Container();
$container->bind('route','route\Route');
$route = $container->make('route');
$pathInfo = trim($_SERVER['REQUEST_URI'],'/');
list($controller,$method) = getControllerMethod($route,$pathInfo);
if(empty($controller) || empty($method))
	exit('找不到路由！');
$container->bind('controller','controller\\'.$controller);
$contoller = $container->make('controller');
$contoller->$method();


















function getControllerMethod($route, $pathInfo){
	$controller = $method = '';
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$pathArr = $route::$POST;
	}else{
		$pathArr = $route::$GET;
	}
	foreach ($pathArr as $path=>$config) {
		if($path == $pathInfo){
			list($controller,$method) = $route::getControllerMethod($config);
			break;
		}
	}
	return [$controller,$method];
}
// $container = new \Container();
// $container->bind('inter\secondary\Secondary','operation\secondary\Secondary');
// $container->bind('main','operation\main\Main');
// $main = $container->make('main');
// $main->start('success');