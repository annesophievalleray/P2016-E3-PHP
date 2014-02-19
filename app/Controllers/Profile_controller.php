<?php
class Profile_controller extends Controller{
	
  function __construct(){
    $this->tpl=array('sync'=>'profile.html');
	/*$this->redirection=false;
	session_start();*/
  }
  
   function getProfil($f3){
    $f3->set('getProfil',$this->model->getProfil(array('id'=>$f3->get('PARAMS.id'))));

	$this->_getFeed($f3);
	$this->_displayBadges($f3);
	$this->_dmd_follow($f3);
	$this->tpl['async']='profile.html';
  }
  
  function getUserData($f3){
	      $f3->set('getUserData',$this->model->getUserData(array('id'=>$f3->get('SESSION.id'))));
	  //$this->redirection=true;
		//echo $f3->get('SESSION.login');
		$this->tpl['async']='json/dataUser.json';
	  
  }
  
    function searchUsers($f3){
		 //$this->redirection=false;
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	//echo $f3->get('users');
	$this->tpl['async']='partials/users.html';
  }
  
  	function editProfil($f3){
		
	}
	function _dmd_follow($f3){
		$dmd_follow_=$f3->set('dmd_follow',$this->model->dmd_follow(array('user_id'=>$f3->get('SESSION.id'))));
		
		//echo $dmd_follow_;
		
	}
  	function follow($f3){
		$follow_=$f3->set('follow',$this->model->follow(array('follower_id'=>$f3->get('PARAMS.follower'),'following_id'=>$f3->get('PARAMS.following'))));
		
		
		$this->tpl['async']='partials/users.html';
		
	}
	
  	function unfollow($f3){
		$unfollow_=$f3->set('unfollow',$this->model->unfollow(array('follower_id'=>$f3->get('PARAMS.follower'),'following_id'=>$f3->get('PARAMS.following'))));
		
		
		$this->tpl['async']='partials/users.html';
		
	}

//SERT A RIEN	
	function back_follow($f3){
		$back_follow_=$f3->set('back_follow',$this->model->back_follow(array('state'=>$f3->get('PARAMS.state'),'follow_id'=>$f3->get('PARAMS.follow_id'))));
		
	}
//___________
	
	 function _getFeed($f3){
		 	$f3->set('getFeedUser',$this->model->getFeedUser());
		
	}
  	function addArticle($f3){
		
	}
	
	
	//BADGES
	
function _displayBadges($f3){
    $displayBadges_=$f3->set('displayBadges',$this->model->displayBadges(array('id'=>$f3->get('SESSION.id'))));
	
    if($displayBadges_) {

      echo 'Chaine des badges : '.$bdg_str=$displayBadges_->bdg_id.'<br>';

      $nb_badges=substr_count($bdg_str, ',');
      echo 'Nb de badges : '.$nb_badges.'<br>';

      $badges_array = explode(',',$bdg_str);
      $f3->set('badges_array',$badges_array);

      for ($i=0; $i < count($badges_array)-1; $i++) { 
        echo 'Badge '.($i+1).' : '.$badges_array[$i].' - ';
        
        
        echo $this->getBadgesName($badges_array[$i],$f3);
      }

    }

  //$this->tpl['async']='partials/users.html';
  }

  function getBadgesName($badge_id,$f3){
    $getBadgesName_=$f3->set('getBadgesName',$this->model->getBadgesName(array('badge_id'=>$badge_id)));
    if($getBadgesName_){
      $bdg_name=$getBadgesName_->bdg_name;
      return $bdg_name;
    }
  }

  function addVisit($f3){
    //$f3->set('user_id',$f3->get('PARAMS.id'));
    $f3->set('category',$f3->get('PARAMS.keyword'));
	
    $f3->set('addVisit',$this->model->addVisit(array('keyword'=>$f3->get('category'),'user_id'=>$f3->get('user_id'))));
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

  function _getBadges($f3){
    $getBadges_=$f3->set('getBadges',$this->model->getBadges(array('id'=>$f3->get('SESSION.id'))));
      
      $bdg_str=$getBadges_->bdg_id;
      return $badges_array = explode(',',$bdg_str);
      
  }

  function _checkBadges($f3,$cat_id){
    $checkBadges_=$f3->set('checkBadges',$this->model->checkBadges(array('cat_id'=>$cat_id,'cat_count'=>$f3->get('cat_count'))));

    if(!$checkBadges_){
      echo "<br><br>pas de badge";
	  //return quelque chose
    } else {

        $bdg_id=$checkBadges_->bdg_id;

        $hasBadge=false;
        $badges_array=$this->_getBadges($f3);

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
	

?>