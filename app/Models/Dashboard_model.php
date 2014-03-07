<?php



class Dashboard_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
 //Les mapper nom_view sont des views en BDD

//Obtenir 20 posts la première fois puis tous les nouveaux posts    
  function getNewPosts($params){
	if($params['limit']==0)
		return $this->getMapper('post_follow')->find(array('(follower_id=? AND state=1) AND post_id>?',$params['user_id'],$params['recentId']),array('order'=>'post_date DESC'));  
	else
		return $this->getMapper('post_follow')->find(array('(follower_id=? AND state=1) AND post_id>?',$params['user_id'],$params['recentId']),array('order'=>'post_date DESC','limit'=>20));
  }
//Obtenir 5 anciens posts (scroll infini)  
    function getOldPosts($params){
	return $this->getMapper('post_follow')->find(array('(follower_id=? AND state=1) AND post_id<?',$params['user_id'],$params['oldId']),array('order'=>'post_date DESC','limit'=>5));  
  }
  
  function getSuggestArticles($params){
	  return $this->getMapper('post_view')->find(array('user_id !=?',$params['user_id'])); 
	  
  }
  
  function followSuggest($params){
		
		return $this->getMapper('following_view')->find(array('follower_id != ? AND following_id != ?',$params['followString'], $params['followString']),array('group'=>'following_id'));
		
	}
  
  function searchUsers($params){
    return $this->getMapper('user')->find('login like "%'.$params['keywords'].'%"');
  }
  
  function getCategories(){
	  return $this->getMapper('category')->find(array(),array('order'=>'cat_name')); 
  }

function getFollowList($params){
	return $this->getMapper('follow')->find(array('follower_id = ? AND state=1',$params['user_id']));
		
	}  
  

	
//STATS
	//Utilisation de VIRTUALS FIELD
function graphDashboard($params){
	
	$postStat=$this->getMapper('post_cat');
	$postStat->sum_cat = 'count(post_cat)';
	$postStat->name_cat = 'cat_name';
	$postStat->id_cat = 'cat_id';
	return $postStat->find((array('post_user_id = ? AND MONTH(post_date)= MONTH(NOW())',$params['user_id'])),array('group'=>'post_cat'));

	
		}

}



?>