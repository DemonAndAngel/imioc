<?php 
namespace factory;
class ControllerFactory extends FactoryBase {
	public $controller;
	public $controllerArg;
	public function __call ($name, $arg){
		$this->controller->$name($arg[0]);
	}
	public static function createController($className,$arg = null){
		$controllerFactory = new ControllerFactory();
		$className = 'controller\\'.$className.'Controller';
		$controllerFactory->controller = new $className($arg);
		$controllerFactory->controllerArg = $arg;
		return $controllerFactory;
	}
}