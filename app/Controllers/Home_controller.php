<?php
class Home_controller extends Controller{


  function __construct(){
    $this->tpl=array('sync'=>'main.html');
  }
  
  function home(){
  }
  
  function signIn($f3){
    $f3->set('signIn',$this->model->signIn(array('login'=>$f3->get('POST.login'),'password'=>$f3->get('POST.password'))));
	
	if($f3->get('signIn')==null):echo "erreur d'authentification"; 
	else:$this->tpl['async']='profil.html';endif;

	  
  }
  
  


  

  
}
?>