<?php
class Home_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
  
  function home(){
    
  }
  function signIn($params){
    return $this->getMapper('user')->load(array('login = ? and password = ?',$params['login'],$params['password']));
  }
  
  
  //test
  
  function testUpdate(){
	  $table=$this->getMapper('test');
	  
	  $result=$table->load(array('id_users = ?', 1));
	  $result->art++;
	 $result->update();
	 
	 return "ok";
	  
	  
  }


  
}
?>