<?php
namespace imden\test;
class Test {
	public function test(TestInterface $inter,$str){
		echo $str.'<br/>';
		$inter->inter();
	}
}