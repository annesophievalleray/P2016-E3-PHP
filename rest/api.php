<?php
namespace REST;

abstract class api{
	
	protected $tpl;
	
	abstract function get($f3);
	
	abstract function post($f3);
	
	abstract function put($f3);
	
	abstract function delete($f3);
	
	function beforeroute(){
		
	}
	
	function afterroute(){
	echo \View::instance()->render($this->tpl,'application/json');
		
	}
	
	
}



?>