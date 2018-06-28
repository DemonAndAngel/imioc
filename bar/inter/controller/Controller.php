<?php 
namespace inter\controller;
interface Controller {
	public function before($arg);
	public function after($arg);
}