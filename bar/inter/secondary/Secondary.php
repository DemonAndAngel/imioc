<?php 
namespace inter\secondary;
interface Secondary{
	public function before($mainArg);
	public function after($mainArg);
}