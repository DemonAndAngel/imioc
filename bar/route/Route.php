<?php
namespace route;
class Route{
	public static $GET = [];
	public static $POST = [];
	public static function get($pathInfo,$config){
		self::addRoute($pathInfo,$config,'GET');
	}
	public static function post($pathInfo,$config){
		self::addRoute($pathInfo,$config,'POST');
	}
	public static function any($pathInfo,$config){
		self::addRoute($pathInfo,$config,'GET');
		self::addRoute($pathInfo,$config,'POST');
	}
	private static function addRoute($pathInfo,$config,$method){
		$pathInfo = trim($pathInfo,'/');
		if($method == 'POST'){
			self::$POST[$pathInfo] = $config;
		}else{
			self::$GET[$pathInfo] = $config;
		}
	}
	public static function getControllerMethod($config){
		return explode('@',$config['uses']);
	}
}