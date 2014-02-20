<?php
class Profile_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
  
   function getUserData($params){
    return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
	
  }
  
  function getProfil($params){
    return $this->getMapper('user')->find(array('user_id = ?',$params['id']));
	
  }


   function getFeedUser(){
    return $this->getMapper('feed')->find(array(),array('order'=>'date_feed DESC'));
  } 
  
  
  function searchUsers($params){
    return $this->getMapper('user')->find('login like "%'.$params['keywords'].'%"');
  }
  
  	function editProfil($f3){
		
		
		
	}
  	function follow($params){
		$follower_id=$params['follower_id'];
		$following_id=$params['following_id'];
	//return $db->exec(array('INSERT INTO follow (follower_id, following_id) VALUES (?,?)',$params['follower_id'], $params['following_id']));
	
	  	$followed=$this->getMapper('follow');
	$result=$followed->load(array('follower_id = ? AND following_id=?',$follower_id, $following_id));
	if(!$result){
		$result=$followed->load();
		$result->follower_id=$follower_id;
		$result->following_id=$following_id;
  		$result->insert();
	}
	else{
		$result->state=4;
		$result->update();
		
		}
		
		
	}
	 function unfollow($f3){
	return $db->exec(array('DELETE FROM follow WHERE following_id=? AND follower_id=?',$params['follower_id'], $params['following_id']));
		
	}
	
	function dmd_follow($params){
		//return $db->exec(array('SELECT * FROM user INNER JOIN follow ON user_id=follower_id WHERE following_id=? AND state=0',$params['user_id']));
		
		return $this->getMapper('follow_view')->find(array('following_id = ? AND state=0',$params['user_id']));
	
		}
	function back_follow($params){
		$follow=$this->getMapper('follow');
		$resultload=$follow->load(array('id = ?',$params['follow_id']));
		$resultload->state=$params['state'];
		$resultload->update();
		
	}
	
	function followSuggest($f3){
		
		return $this->getMapper('follow')->find(array('follower_id = ? AND state=1',$params['user_id']));
		
	}
	
	 function getFeed($f3){
		
	}
	
  	function addArticle($f3){
		
	}
	
	//BADGES
	
	 function displayBadges($params){
    return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
  }

  function getBadgesName($params){
  	return $this->getMapper('badges')->load(array('bdg_id = ?',$params['badge_id']));
  }

  function addVisit($params){
  	$keyword=$params['keyword'];
  	$user_id=$params['user_id'];

  	$stats=$this->getMapper('stats');
  	$resultload=$stats->load(array('stats_user_id = ?',$user_id));
	$resultload->$keyword++;
  	$resultload->update();
  }


  function getVisits($params){
  	// récupération du nombre de visites
  	return $stats2=$this->getMapper('stats')->load(array('stats_user_id = ?',$params['user_id']));
  }

  function getCatId($params){
  	//CHERCHER L'ID DE LA CATEGORIE
  	return $category=$this->getMapper('category')->load(array('cat_name = ?',$params['keyword']));
   }

   function getBadges($params){
    return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
  }

  function checkBadges($params){ // VERIFIER SI CORRESPOND BADGE
  	return $this->getMapper('badges')->load(array('cat_id = ? and nb_visites <= ?',$params['cat_id'],$params['cat_count']));
  }

  //AJOUTER NOUVEAU BADGE DANS USER->bdge_id
  //UPDATE HERE
  function addBadge($params){
  	$user=$this->getMapper('user');
  	$resultload=$user->load(array('user_id = ?',$params['user_id']));
	$resultload->bdg_id.=$params['bdg_id'].',';
  	$resultload->update();
  }

  

}

?>