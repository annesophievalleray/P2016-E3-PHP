<?php



class Dashboard_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
   function getFeed($params){
   return $this->getMapper('post_follow')->find(array('follower_id=? AND state=1',$params['user_id']),array('order'=>'post_date DESC'));
  } 
  
  
  function getNewPosts($params){
	return $this->getMapper('post_follow')->find(array('(follower_id=? AND state=1) AND post_id>?',$params['user_id'],$params['recentId']),array('order'=>'post_date DESC'));  
  }
  
  function getSuggestArticles($params){
	  //return $dB->exec(array('SELECT * FROM post_view WHERE user_id !=? ORDER BY RAND() LIMIT 2'),$params['user_id']);
	  
	  return $this->getMapper('post_view')->find(array('user_id !=?',$params['user_id'])); 
	  
  }
  
  function searchUsers($params){
    return $this->getMapper('user')->find('login like "%'.$params['keywords'].'%"');
  }
  
  function getCategories(){
	  return $this->getMapper('category')->find(array(),array('order'=>'cat_name')); 
  }
  
  
  	function followSuggest($params){
		
		return $this->getMapper('follow')->find(array('follower_id = ? AND state=1',$params['user_id']));
		
	}

}

?>