<?php
class Profile_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
  
  function getProfil($params){
    return $this->getMapper('users')->find(array('id = ?',$params['id']));
  }
  
  
  function searchUsers($params){
    return $this->getMapper('users')->find('login like "%'.$params['keywords'].'%"');
  }
  

}

?>