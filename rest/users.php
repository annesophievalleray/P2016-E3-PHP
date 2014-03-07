<?php
namespace REST;

class users extends \REST\api{
	
	public function get($f3){
		$db= new \DB\SQL('mysql:host='.$f3->get('db_host').';port=3306;dbname='.$f3->get('db_server'),$f3->get('db_login'),$f3->get('db_password'));
		
		$mapper= new \DB\SQL\Mapper($db,'user');
		if(!$f3->get('PARAMS.id'))
			$f3->set('users',$mapper->find(array(),array('order'=>'login')));
		else
			$f3->set('users',$mapper->find(array("user_id=?",$f3->get('PARAMS.id'))));
		
	}

	public function getPosts($f3){
		$db= new \DB\SQL('mysql:host='.$f3->get('db_host').';port=3306;dbname='.$f3->get('db_server'),$f3->get('db_login'),$f3->get('db_password'));
		
		$mapper= new \DB\SQL\Mapper($db,'post_view');
		if(!$f3->get('PARAMS.id'))
			$f3->set('usersPosts',$mapper->find(array(),array('order'=>'login')));
		else
			$f3->set('usersPosts',$mapper->find(array("user_id=?",$f3->get('PARAMS.id'))));
		
	}
	
	public function post($f3){
	}
	
	public function put($f3){
	}
	
	public function delete($f3){
	}
	
	
}



?>