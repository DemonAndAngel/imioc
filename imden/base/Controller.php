<?php 
namespace imden\base;
class Controller {
	public static function init(){
		$controllerPath = APP_PATH.'/controller';
	    Imden::getFiles($controllerPath,function ($file){
	    	include $file;
	    });
	}
}