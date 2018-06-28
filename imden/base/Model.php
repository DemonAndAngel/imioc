<?php 
namespace imden\base;
class Model {
	public static function init(){
		$modelPath = APP_PATH.'/model';
	    Imden::getFiles($modelPath,function ($file){
	    	include $file;
	    });
	}
}