<?php 
namespace operation\secondary;
class Secondary implements \inter\secondary\Secondary{
	public function before($mainArg){
		if($mainArg == 'fuck')
			exit('no');
	}
	public function after($mainArg){
		if($mainArg == 'success')
			exit('yes');
	}
}