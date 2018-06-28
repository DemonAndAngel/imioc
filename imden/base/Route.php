<?php
namespace imden\base;
class Route {
	public static $ROUTE = [];
	public static function init(){
		$routePath = CONF_PATH.'/route';
	    Imden::getFiles($routePath,function ($file){
	    	include $file;
	    });
	}
    public static function __callStatic($httpMethod, $args)
    {
        $type = ['get', 'post'];
        if (in_array($httpMethod, $type)) {
        	$uri = $args[0];
        	$arr = $args[1];
            $as = $arr['as']??$uri;
			$uses = $arr['uses'];
			list($controller,$method) = explode('@', $uses);
			self::$ROUTE[$httpMethod]['as'][$as] = compact('uri','controller','as','method');
			self::$ROUTE[$httpMethod]['uri'][$uri] = compact('uri','controller','as','method');
        }
    }
}