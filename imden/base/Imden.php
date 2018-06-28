<?php
namespace imden\base;
class Imden {
	public static function init(){
		// 初始化路由
		Route::init();
		// 初始化控制器
		Controller::init();
		// 初始化模型
		Model::init();

		// 实例化控制器
		$pathInfo = trim($_SERVER['REQUEST_URI'],'/');
		$route = self::getControllerMethod($pathInfo);
		$controller = $route['controller'];
		$method = $route['method'];
		$container = new Container();
		$container->bind('controller',str_replace('/','\\',trim(str_replace(ROOT_PATH, '', APP_PATH),'/')).'\\controller\\'.$controller);
		$controller = $container->make('controller');
		// 调用控制器方法
		$container->method($controller,$method);
	}

	// 根据链接找到指定控制器名和方法名和路由别名
	public static function getControllerMethod($pathInfo){
		$httpMethod = strtolower($_SERVER['REQUEST_METHOD']);
		$httpMethod = 'post';
		$route = Route::$ROUTE[$httpMethod]['uri'][$pathInfo]??null;
		if(empty($route))
			exit('找不到路由！');
		return $route;
	}
	// 获取文件夹下的所有文件，不含子文件夹
	public static function getFiles($dir,$callback = null){
		$files = [];
		if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
	        while(($file = readdir($handle)) !== false) {
	        	if(!is_dir($dir."/".$file)) { //将文件的名字存入数组
	        		$fileStrArr = explode('.', $file);
	            	if($fileStrArr[count($fileStrArr)-1] == 'php'){
	            		if(!empty($callback)&&$callback instanceof \Closure){
	            			$callback($dir."/".$file);
	            		}
                    	$files[] = $dir."/".$file;
	                }
                }
	        }
	        closedir($handle);
	    }
	    return $files;
	}
}