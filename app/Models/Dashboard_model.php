<?php



class Dashboard_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
   function getFeed(){
    return $this->getMapper('feed')->find(array());
  } 

}

?>