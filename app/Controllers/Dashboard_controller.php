<?php
class Dashboard_controller extends Controller{
	
  function __construct(){
    $this->tpl=array('sync'=>'main.html');
  }
  
    function getFeed($f3){
    $f3->set('getFeed',$this->model->getFeed());
	
	$this->tpl['sync']='profil.html';
	
	}
	
}

?>