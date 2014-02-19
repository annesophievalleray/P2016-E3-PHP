<?php
class Dashboard_controller extends Controller{
	
  function __construct(){
    $this->tpl=array('sync'=>'dashboard.html');
  }
  
    function getDashboard($f3){
		//$login=$f3->get('SESSION.login');
		$this->getFeed($f3);
		
	}
	
	function searchUsers($f3){
		 //$this->redirection=false;
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	//echo $f3->get('users');
	$this->tpl['async']='partials/users.html';
  }
  
	
	
	function getFeed($f3){
    $f3->set('getFeed',$this->model->getFeed());
	
	//$this->tpl['sync']='profil.html';
	
	}
	
}

?>