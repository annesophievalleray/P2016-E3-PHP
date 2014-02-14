<?php
class Profile_model extends Model{
  
  
  function __construct(){
    parent::__construct();
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
  	function follow($f3){
	return $db->exec(array('INSERT INTO follow (id_demandeur, id_accepteur) VALUES (?,?)',$params['id_demandeur'], $params['id_accepteur']));
		
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