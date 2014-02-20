<?php
class Home_controller extends Controller{


  function __construct(){
	  parent::__construct();
    $this->tpl=array('sync'=>'main.html');
  }
  
  function home(){
  }
  
  function signIn($f3){
	 switch($f3->get('VERB')){
	  case 'GET':
         $this->tpl['sync']='main.html';
      break;
      case 'POST':
    $auth=$f3->set('signIn',$this->model->signIn(array('login'=>$f3->get('POST.login'),'password'=>$f3->get('POST.password'))));
	
	if(!$auth){
		//$f3->set('error','Oops!'); 
		//$this->redirection=false;
		echo" essaye encore";
		$this->tpl['sync']='main.html';
		}
		
	else{
		/*$this->redirection=true;
            foreach($f3->get('signIn') as $user): 
				$id=$user->id;
				$login=$user->login;
            endforeach;*/
			// Session f3
			$user=array(
				'id'=>$auth->user_id,
				'login'=>$auth->login);
			$f3->set('SESSION',$user);
			$id=$f3->get('SESSION.id');
			$f3->reroute('/dashboard/'.$id);
			
			
		/*session_start();
		$_SESSION['login']=$login;
		echo $_SESSION['id']=$id;*/
			
		//$this->tpl['async']='profile.htm';
		//header("Location: /$id");
		 //$f3->reroute('/user/'.$id, true);

	}
		break;
		
	 }
			  
  }
  
  public function signOut($f3){
	    session_destroy();
	    $f3->reroute('/');
	  }

  
  //test
  
    function session(){

		//$f3->set('CACHE',TRUE);
		//$cache = \Cache::instance();
		//$cache->set('foo','bar',5);
		//echo var_dump($cache->exists('foo'));
		//new Session();
		//$f3->set('SESSION.id',"moi");
		//print_r($f3->get('SESSION.id'));
		session_start();
		$_SESSION['id']="moi";
		echo $_SESSION['id'];
		$this->tpl['sync']='profile.htm';

  }
  
  
    function testUpdate($f3){
    $test=$f3->set('testUpdate',$this->model->testUpdate());
	
	if($test)
		echo $test;
	
	}
  
 
  
  


  

  
}
?>