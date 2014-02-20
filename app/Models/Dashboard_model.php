<?php



class Dashboard_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
   function getFeed(){
   return $this->getMapper('posts')->find(array(),array('order'=>'post_date DESC'));
  } 
  
  function searchUsers($params){
    return $this->getMapper('user')->find('login like "%'.$params['keywords'].'%"');
  }
  
  	function followSuggest($params){
		
		return $this->getMapper('follow')->find(array('follower_id = ? AND state=1',$params['user_id']));
		
	}

}

?>