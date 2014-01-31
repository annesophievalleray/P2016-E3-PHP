<?php
class Profile_controller extends Controller{
	
  function __construct(){
    //$this->tpl=array('sync'=>'profil.html');
  }
  
   function getProfil($f3){
    $f3->set('getProfil',$this->model->getProfil(array('id'=>$f3->get('PARAMS.id'))));
	
	$this->tpl['async']='profil.html';
  }
  
    function searchUsers($f3){
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	$this->tpl['async']='partials/users.html';
  }
	
}
?>