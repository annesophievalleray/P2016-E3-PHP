<?php
class Dashboard_controller extends Controller{
	
  function __construct(){
	  parent::__construct();
    $this->tpl=array('sync'=>'dashboard.html');
  }
  
    function getDashboard($f3){
		//$login=$f3->get('SESSION.login');
		$this->getFeed($f3);
		$this->followSuggest($f3);
		
	}
	
	function searchUsers($f3){
		 //$this->redirection=false;
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	//echo $f3->get('users');
	$this->tpl['async']='partials/users.html';
  }
  
  	function followSuggest($f3){
		$followSuggest_=$f3->set('followSuggest',$this->model->followSuggest(array('user_id'=>$f3->get('SESSION.id'))));
		echo 'nombre follow :'.count($followSuggest_).'</br>';
		
		$id1=rand(1,count($followSuggest_));
		// do{
		// $id2=rand(1,count($followSuggest_));
		// }while($id1==$id2);
		
		echo 'nombre 1 :'.$id1.'</br>';
		// echo 'nombre 2 :'.$id2.'</br>';
		
		foreach($followSuggest_ as $follow){
			
			//if($follow->
			
		}
		
		
		//$this->tpl['async']='partials/suggestions.json';
		
	}
  
	
	
	function getFeed($f3){
    $f3->set('getFeed',$this->model->getFeed());
	
	//$this->tpl['sync']='profil.html';
	
	}
	
}

?>