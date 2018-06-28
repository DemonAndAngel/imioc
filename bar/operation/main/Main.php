<?php 
namespace operation\main;
class Main implements \inter\main\Main {
	public $secondary;
	public function __construct(\inter\secondary\Secondary $secondary){
		$this->secondary = $secondary;
	}
	public function start($arg){
		$this->secondary->before($arg);
		echo $arg.'<br/>';
		$this->secondary->after($arg);
	}
}