<?php
class Home_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
  
  function home(){
    
  }
  
  function signIn($params){
    return $this->getMapper('user')->load(array('login = ? AND password = ?',$params['login'],$params['password']));
  }
  
  function verifForm($params){
	  return $this->getMapper('user')->load(array('login = ?',$params['login'])); 
  }
  
  function signUp($params){
	
	  		$insertUser_=$this->getMapper('user');
			$insertUser_->copyfrom('POST');
			$insertUser_->save();
	if(isset($params['password']))
	return $this->getMapper('user')->load(array('login = ? AND password = ?',$params['login'],$params['password']));
			
			
  }
  


  


}
?>