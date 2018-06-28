<?php 
namespace factory;
class MyFactory extends FactoryBase {
	public $extArr = [];
	public $main;
	public $mainArg;
	public static function createOperationMain($className,$arg = null){
		$myFactory = new MyFactory();
		$className = 'operation\\main\\'.$className;
		$myFactory->main = new $className();
		$myFactory->mainArg = $arg;
		return $myFactory;
	}
	public function addOperationSecondary($className,$arg){
		$className = 'operation\\secondary\\'.$className;
		$secondary = new $className();
		$this->_addExt($secondary,$arg);
	}
	public function startMain(){
		$extArr = $this->_getExt();
		foreach ($extArr as $ext) {
			$ext[0]->before($this->mainArg,$ext[1]);
		}
		$this->main->start($this->mainArg);

		foreach ($extArr as $ext) {
			$ext[0]->after($this->mainArg,$ext[1]);
		}
	}
	private function _addExt($secondary, $arg){
		$this->extArr[] = [ $secondary , $arg ];
	}
	private function _getExt(){
		return $this->extArr;
	}
}