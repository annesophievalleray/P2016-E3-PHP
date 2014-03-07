<?php
class Profile_model extends Model{
  
  
  function __construct(){
    parent::__construct();
  }
 
  //Les mapper nom_view sont des views en BDD
  
   function getUserData($params){
    return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
	
  }
  
  function getProfil($params){
    return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
	
  }
  
    function getFollowers($params){
	  
	  return $this->getMapper('followers_view')->find(array('following_id =? AND state=1 AND follower_id!=?',$params['user_id'],$params['user_id'])); 
	  
  }
  
    function getFollowing($params){
	  
	  return $this->getMapper('following_view')->find(array('follower_id =? AND state=1 AND following_id!=?',$params['user_id'],$params['user_id'])); 
	  
  }


   function getFeedUser($params){
    return $this->getMapper('posts')->find(array('post_user_id = ?',$params['user_id']),array('order'=>'post_date DESC'));
  } 
  
  
  function searchUsers($params){
    return $this->getMapper('user')->find('login like "%'.$params['keywords'].'%"');
  }
  
  // Édition / MÀJ du profil de l'utilisateur (html : profile_update.html)
  function updateProfile($params){
	  $map = $this->getMapper('user')->load(array('user_id=?',$params['user_id']));
	  foreach($params as $key => $param){
		  $map->$key=$param;
	  }
	  $map->save();
  }


//FOLLOW
// Suivre si on ne suit pas et inversement si le follow n'est pas dans la table follow on l'insert sinon on update
  	function follow($params){
		$follower_id=$params['follower_id'];
		$following_id=$params['following_id'];
	
	  	$followed=$this->getMapper('follow');
	$result=$followed->load(array('follower_id = ? AND following_id=?',$follower_id, $following_id));
	if(!$result){
		$result=$followed->load();
		$result->follower_id=$follower_id;
		$result->following_id=$following_id;
  		$result->insert();
	}
	else{
		if($result->state==0)
			$result->state=1;
		else
			$result->state=0;
			
		$result->update();
		
		}	
	}
//Incrémenter ou décrémenter selon si on follow/unfollow pour le follower et le following	
	 function updateFollowNumbers($params){
		$follower_id=$params['follower_id'];
		$following_id=$params['following_id'];
		$state=$params['state'];
		
	 $follower=$this->getMapper('user');
	$result=$follower->load(array('user_id = ?',$following_id));
	if($state==1)
		$result->nb_followers++;
	else
		$result->nb_followers--;
	$result->update();

	$following=$this->getMapper('user');
	$result2=$following->load(array('user_id = ?',$follower_id));
	if($state==1)
		$result2->nb_following++;
	else
		$result2->nb_following--;
	$result2->update();
			

		
	}
//Obtenir le statut du follow entre l'user en session et l'user du profil visité	
  	function getStateFollow($params){
		$follower_id=$params['follower_id'];
		$following_id=$params['following_id'];
		
	return $this->getMapper('follow')->load(array('follower_id = ? AND following_id=? AND state=1',$follower_id, $following_id));

		
		
	}
	
function followSuggest($f3){
	return $this->getMapper('follow')->find(array('follower_id = ? AND state=1',$params['user_id']));
		
	}

function insertPost(){
		$insertPost_=$this->getMapper('posts');
			$insertPost_->copyfrom('POST');
			$insertPost_->save();
			
			return 1;
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
	
	$stats=$this->getMapper('user');
  	$resultload=$stats->load(array('user_id = ?',$user_id));
	$resultload->nb_posts++;
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
  
   function newBadgeData($params){
  	return $this->getMapper('badges')->load(array('bdg_id = ?',$params['bdg_id']));
  }
  
 // STATS GRAPH
  //Utilisation de VIRTUALS FIELD
  function graphProfile($params){
	
	$postStat=$this->getMapper('post_cat');
	$postStat->sum_cat = 'SUM(post_cat)/post_cat';
	$postStat->name_cat = 'cat_name';
	$postStat->id_cat = 'cat_id';
	$postStat->day_cat = 'WEEKDAY(post_date)';
	return $postStat->find(array('post_user_id = ? AND WEEK(post_date,1)= WEEK(NOW(),1) AND cat_id=?',$params['user_id'],$params['cat_id']),array('group'=>'day_cat'),array('order'=>'day_cat'));

	
		}
		
	function catWeek($params){
		return $this->getMapper('post_cat')->find(array('post_user_id = ? AND WEEK(post_date,1)= WEEK(NOW(),1)',$params['user_id']),array('group'=>'cat_name'));
	}
	
    function displayObjectives($params){
    	return $this->getMapper('objectives_user')->load(array('obj_user_id = ?',$params['obj_user_id']));
    }
  
    function getObjectives($params){
    	return $this->getMapper('user')->load(array('user_id = ?',$params['id']));
    }
  
    function checkObjectives($params){
    	return $this->getMapper('objectives_user')->load(array('obj_user_id = ? and obj_state = ?',$params['obj_user_id'],$params['obj_state']));
    }
  
    function addObjective($params){
  	  $user=$this->getMapper('user');
    }
  
    function getObjectivesName($params){
    	return $this->getMapper('objectives_user')->load(array('obj_id = ?',$params['objective_id']));
    }
  
    function getObjCatId($params){
    	return $category=$this->getMapper('objective')->load(array('obj_cat = ?',$params['keyword']));
     }

}

?>