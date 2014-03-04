<?php
class Profile_controller extends Controller{
	
  function __construct(){
    $this->tpl=array('sync'=>'profile.html');
	/*$this->redirection=false;
	session_start();*/
  }
  
   function getProfil($f3){
    $getProfil_=$f3->set('getProfil',$this->model->getProfil(array('id'=>$f3->get('PARAMS.id'))));
		if($getProfil_){
			$userLogin=$getProfil_->login;
		}
			$f3->set('userLogin',$userLogin);
			

	$this->_getFeedUser($f3);
	$this->_getFollowers($f3);
	$this->_getFollowing($f3);
	//$this->displayBadges($f3);
	//$this->_dmd_follow($f3);
	$this->tpl['async']='profile.html';
  }
//------UserDatas----
  function getUserData($f3){
	      $f3->set('getUserData',$this->model->getUserData(array('id'=>$f3->get('PARAMS.id'))));
	  //$this->redirection=true;
		//echo $f3->get('SESSION.login');
		$this->tpl['async']='json/dataUser.json';
	  
  }
  
  function getUserVisitData($f3){
	      $f3->set('getUserData',$this->model->getUserData(array('id'=>$f3->get('PARAMS.id'))));
	  //$this->redirection=true;
		//echo $f3->get('SESSION.login');
		$this->tpl['async']='json/dataUser.json';
	  
  }
  
  	function _getFollowers($f3){
	
		$f3->set('getFollowers',$this->model->getFollowers(array('user_id'=>$f3->get('PARAMS.id'))));
	
		}
		
	function _getFollowing($f3){
	
		$f3->set('getFollowing',$this->model->getFollowing(array('user_id'=>$f3->get('PARAMS.id'))));
	
		}
		
 //------FEED----   
  	 function _getFeedUser($f3){
		 	$f3->set('getFeedUser',$this->model->getFeedUser(array('user_id'=>$f3->get('PARAMS.id'))));
		
	}
  
    /*function searchUsers($f3){
		 //$this->redirection=false;
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	//echo $f3->get('users');
	$this->tpl['async']='partials/users.html';
  }*/
 //-----Profil----- 
  	function profileUpdate($f3){
		$profileUpdate_=$f3->set();
		$this->tpl['async']='profile_update.html';
	}
//----Follow----
	/*function _dmd_follow($f3){
		$dmd_follow_=$f3->set('dmd_follow',$this->model->dmd_follow(array('user_id'=>$f3->get('SESSION.id'))));
		
		//echo $dmd_follow_;
		
	}*/
	function getStateFollow($f3){
	$getStateFollow_=$f3->set('getStateFollow',$this->model->getStateFollow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following_id'))));
	
	$this->tpl['async']='json/followState.json';
		
	}
	
  	function follow($f3){
		$follow_=$f3->set('follow',$this->model->follow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following'))));
		
		
		$this->tpl['async']='partials/users.html';
		
	}
	
  	/*function unfollow($f3){
		$unfollow_=$f3->set('unfollow',$this->model->unfollow(array('follower_id'=>$f3->get('PARAMS.follower'),'following_id'=>$f3->get('PARAMS.following'))));
		
		
		$this->tpl['async']='partials/users.html';
		
	}*/

  	function followSuggest($f3){
		$followSuggest_=$f3->set('followSuggest',$this->model->followSuggest(array('user_id'=>$f3->get('SESSION.id'))));
		echo $followSuggest_->count();
		
		
		//$this->tpl['async']='partials/suggestions.json';
		
	}

//SERT A RIEN	
	function back_follow($f3){
		$back_follow_=$f3->set('back_follow',$this->model->back_follow(array('state'=>$f3->get('PARAMS.state'),'follow_id'=>$f3->get('PARAMS.follow_id'))));
		
	}
//___________
	
//----Articles----
  	function addArticle($f3){
		
	}
//POSTER

	function insertPost($f3){
		$f3->set('insertPost',$this->model->insertPost());
		$this->addVisit($f3);
		$this->tpl['async']='partials/users.html';
	}
	

//-----BADGES----
  function _getBadges($f3){
    $getBadges_=$f3->set('getBadges',$this->model->getBadges(array('id'=>$f3->get('PARAMS.id'))));
     
	 if($getBadges_) { 
      return $bdg_str=$getBadges_->bdg_id;
	  
	 }
	 
      //return $badges_array = explode(',',$bdg_str);
      
  }
  	
function _displayBadges($f3){
   // $displayBadges_=$f3->set('displayBadges',$this->model->displayBadges(array('id'=>$f3->get('PARAMS.id'))));
	
    //if($displayBadges_) {

      /*echo 'Chaine des badges : '.$bdg_str=$displayBadges_->bdg_id.'<br>';

      $nb_badges=substr_count($bdg_str, ',');
      echo 'Nb de badges : '.$nb_badges.'<br>';

      $badges_array = explode(',',$bdg_str);
      $f3->set('badges_array',$badges_array);

      for ($i=0; $i < count($badges_array)-1; $i++) { 
        echo 'Badge '.($i+1).' : '.$badges_array[$i].' - ';
        
        
        echo $this->getBadgesName($badges_array[$i],$f3);
      }*/
	
	 $bdg_str=$this->_getBadges($f3);
	 
	if($bdg_str!=""){ 
	 
	if(substr_count($bdg_str, ',')<=2)
	  	$f3->set('nb_badges',(substr_count($bdg_str, ',')));
	else
		$f3->set('nb_badges',3);
		
	  $f3->set('badges_array',explode(',',$bdg_str));
	  $badges_array=$f3->get('badges_array');
	  
	  $f3->set('all',$f3->get('GET.all'));
	  
	  for ($i=0; $i<=count($f3->get('badges_array'))-2; $i++) { 
       		$badges_name[]=$this->getBadgesName($badges_array[$i],$f3);
			//echo $badges_name[$i];
      }
	  
	  $f3->set('badges_name',$badges_name);
	  
	  //echo"daccc!!";
	  
	   $this->tpl['async']='partials/apercuBadges.html';

    }
	
	

 
  }

  function getBadgesName($badge_id,$f3){
    $getBadgesName_=$f3->set('getBadgesName',$this->model->getBadgesName(array('badge_id'=>$badge_id)));
    if($getBadgesName_){
      $bdg_name=$getBadgesName_->bdg_name;
      return $bdg_name;
    }
  }
//ajout d'une visite au post
  function addVisit($f3){
    //$f3->set('user_id',$f3->get('PARAMS.id'));
    //$f3->set('category',$f3->get('PARAMS.keyword'));
	$f3->set('category',$f3->get('POST.post_cat'));
	
    $f3->set('addVisit',$this->model->addVisit(array('keyword'=>$f3->get('category'),'user_id'=>$f3->get('SESSION.id'))));
    $this->_getVisits($f3);
    $this->tpl['async']='partials/users.html';
  }

  function _getVisits($f3){
    $getVisits_=$f3->set('getVisits',$this->model->getVisits(array('user_id'=>$f3->get('SESSION.id'),'keyword'=>$f3->get('category'))));
    if($getVisits_){
      $cat_name=$f3->get('category');
      $cat_count=$getVisits_->$cat_name;
      $f3->set('cat_count',$cat_count);
      $this->_getCatId($f3);
    }
  }

  function _getCatId($f3){
    $getCatId_=$f3->set('getCatId',$this->model->getCatId(array('keyword'=>$f3->get('category'))));
    if($getCatId_){
      $cat_id=$getCatId_->cat_id;
      $this->_checkBadges($f3,$cat_id);
    }
  }


  function _checkBadges($f3,$cat_id){
    $checkBadges_=$f3->set('checkBadges',$this->model->checkBadges(array('cat_id'=>$cat_id,'cat_count'=>$f3->get('cat_count'))));

    if(!$checkBadges_){
      echo "<br><br>pas de badge";
	  //return quelque chose
    } else {

        $bdg_id=$checkBadges_->bdg_id;

        $hasBadge=false;
        $badges_array=$f3->get('badges_array');

        for ($i=0; $i < count($badges_array); $i++) { 
         if($badges_array[$i]==$bdg_id){
          $hasBadge=true;
         }
        }

        if (!$hasBadge) {
          $this->_addBadge($f3,$bdg_id);
        } 
        
      }

  }

  function _addBadge($f3,$bdg_id){
    $checkBadges_=$f3->set('addBadge',$this->model->addBadge(array('user_id'=>$f3->get('SESSION.id'),'bdg_id'=>$bdg_id)));
    //echo "update";
	
  }
	
}

/*===========================
		OBJECTIVES
============================*/

	
function _displayObjectives($f3){
    $displayObjectives_=$f3->set('displayObjectives',$this->model->displayObjectives(array('id'=>$f3->get('SESSION.id'))));
	
    if($displayObjectives_) {

      echo 'Les objectifs : '.$obj_str=$displayObjectives_->obj_id.'<br>';

      $nb_badges=substr_count($obj_str, ',');
      echo "Nombre d'objectifs : ".$nb_objectives.'<br>';

      $objectives_array = explode(',',$obj_str);
      $f3->set('objectives_array',$objectivs_array);

      for ($i=0; $i < count($objectives_array)-1; $i++) { 
        echo 'Objectif '.($i+1).' : '.$objectives_array[$i].' - ';
        
        
        echo $this->getObjectivesName($objectives_array[$i],$f3);
      }
    }
}

  function _getCatId($f3){
    $getCatId_=$f3->set('getCatId',$this->model->getCatId(array('keyword'=>$f3->get('category'))));
    if($getCatId_){
      $cat_id=$getCatId_->cat_id;
      $this->_checkObjectives($f3,$cat_id);
    }
  }

  function _getObjectives($f3){
    $getObjectives_=$f3->set('getObjectives',$this->model->getObjectives(array('id'=>$f3->get('SESSION.id'))));
      
      $obj_str=$getObjectives_->obj_id;
      return $objectives_array = explode(',',$obj_str);
      
  }

  function _checkObjectives($f3,$obj_id){
    $checkObjectives_=$f3->set('checkObjectives',$this->model->checkObjectives(array('cat_id'=>$cat_id,'cat_count'=>$f3->get('cat_count'))));
	//À modifier, URGENT..
    if(!$checkObjectives_){
      echo "<br><br>pas d'objectifs";
	  //return quelque chose
    } else {

        $obj_id=$checkObjectives_->obj_id;

        $hasObjective=false;
        $objectives_array=$this->_getObjectives($f3);

        for ($i=0; $i < count($objectives_array); $i++) { 
         if($objectives_array[$i]==$obj_id){
          $hasObjective=true;
         }
        }

        if (!$hasObjective) {
          $this->_addObjective($f3,$obj_id);
        } 
        
      }

  }

  function _addObjective($f3,$obj_id){
    $checkObjectives_=$f3->set('addObjective',$this->model->addObjective(array('user_id'=>$f3->get('SESSION.id'),'obj_id'=>$obj_id)));
  }
  
	

?>