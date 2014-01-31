<?php
class Home_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
  
  function home(){
    
  }
  function signIn($params){
    return $this->getMapper('users')->find(array('login = ? and password = ?',$params['login'],$params['password']));
  }


  
}
?>