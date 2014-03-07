<?php
class Home_controller extends Controller{


  function __construct(){
	  parent::__construct();
    $this->tpl=array('sync'=>'home.html');
  }
  
  function home(){
  }
  
  function signIn($f3){
    $auth=$f3->set('signIn',$this->model->signIn(array('login'=>$f3->get('POST.login'),'password'=>$f3->get('POST.password'))));
	
	
	if(!$auth){
		$this->tpl['async']='json/erreurAuth.json';
		}
		
	else{
			$user=array(
				'id'=>$auth->user_id,
				'login'=>$auth->login);
			$f3->set('SESSION',$user);
			$id=$f3->get('SESSION.id');
			$f3->reroute('/dashboard/'.$id);
	
	 }
			  
  }

//Verification du formulaire (mots de passe match et login disponible) de signUp avant de créer un nouvel utilisateur  
  function verifForm($f3){
	  $verifForm_=$f3->set('verifForm',$this->model->verifForm(array('login'=>$f3->get('POST.login'))));
	  
	  if(!$verifForm_ && ($f3->get('POST.password')==$f3->get('POST.password_confirm'))){
		 $this->signUp($f3);
		 //$this->tpl['async']=''; 
	  }
	  else{
			 $this->tpl['async']='json/verifForm.json';
	  }
 		
			
	  	
  }
  
  function signUp($f3){
    $auth=$f3->set('signUp',$this->model->signUp(array('login'=>$f3->get('POST.login'),'password'=>$f3->get('POST.password'))));
	
	if($auth){
			$user=array(
				'id'=>$auth->user_id,
				'login'=>$auth->login);
			$f3->set('SESSION',$user);
			$id=$f3->get('SESSION.id');
			$f3->reroute('/dashboard/'.$id);
			
	}
			  
  }
  
  public function signOut($f3){
	    session_destroy();
	    $f3->reroute('/');
	  }

  

  
 
}
?>