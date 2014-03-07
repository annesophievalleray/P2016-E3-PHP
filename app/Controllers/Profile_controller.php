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

 //-----Profil----- 
  	function updateProfile($f3){
		
	    $this->tpl['sync']='profile_update.html';
	    	switch($f3->get('VERB')){
	     	   case 'POST':
	              print_r($f3->get('POST'));
	              print_r($_FILES);
	     	   break;
		   }
		
		$error = array();
		
		foreach($f3->get('POST') as $key => $value){
			if($f3->exists('POST'.$key))
				$f3->clean($f3->get('POST'.$key));
			else
				array_push($error, 'Vous n\'avez pas renseigné le champ : '.$key);
		} // end foreach
		
		if(count($error)==0){
					
			/*if (isset($_FILES["file"])) {
			    $tmpFile = $_FILES["file"]["tmp_name"];
			    $fileName = ... // determine secure name for uploaded file
 
		        list($width, $height) = getimagesize($tmpFile);
			    // check if the file is really an image
				if ($width == null && $height == null) {
		        header("Location: index.php");
		        return;
			    }
			    
				// resize if necessary
				if ($width >= 400 && $height >= 400) {
					$image = new Imagick($tmpFile);
				    $image->thumbnailImage(400, 400);
					$image->writeImage($fileName);
				} else { move_uploaded_file($tmpFile, $fileName); }
			
			================  differentes methodes ===================
			
			$tmpFile = $_FILES['file']['tmp_name'];
				$fileName = "newAvatar.jpg";
				
				$width = width($tmpFile);
				$height = height($tmpFile);
				
				if($width >= 115 && $height >=115){
					$image = new Image($tmpFile);
					$image->crop()
				}*/
			
			if($f3->get('password')==$f3->get('password2')){
				$params=array(
					'user_id'=>$f3->get('SESSION.user_id'),
					'password'=>$f3->get('POST.password'),
					'email'=>$f3->get('POST.email'),
					'avatar'=>$f3->get($f3->get('UPLOADS').$_FILES['file']['name']),
					'location'=>$f3->get('POST.location'),
					'date_birth'=>$f3->get('POST.date_birth')
				);
				
				if($_FILES['file']['error']==0){
					$avatar = \Web::instance()->receive(function($file){
						$f3 = \Base::instance();
						$params['avatar']=$f3->get($f3->get('UPLOADS').$_FILES['file']['name']);
					}, true, true);
				}
				
				$this->model->profileUpdate($params);
				$f3->reroute("/");
			}
		}
	}
//----Follow----
	function getStateFollow($f3){
	$getStateFollow_=$f3->set('getStateFollow',$this->model->getStateFollow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following_id'))));
	
	$this->tpl['async']='json/followState.json';
		
	}
	
  	function follow($f3){
		$follow_=$f3->set('follow',$this->model->follow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following'))));
		
		
		$this->tpl['async']='partials/users.html';
		
	}

  	function followSuggest($f3){
		$followSuggest_=$f3->set('followSuggest',$this->model->followSuggest(array('user_id'=>$f3->get('SESSION.id'))));
		echo $followSuggest_->count();
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
  }
 
function _displayBadges($f3){
	 $bdg_str=$this->_getBadges($f3);
	 
	if($bdg_str!=""){
	 
	if(substr_count($bdg_str, ',')<=2){
		$f3->set('nb_badges',(substr_count($bdg_str, ',')));
	} else {
		$f3->set('nb_badges',3);
		
	  $f3->set('badges_array',explode(',',$bdg_str));
	  $badges_array=$f3->get('badges_array');
	  
	  $f3->set('all',$f3->get('GET.all'));
	  
	  for ($i=0; $i<=count($f3->get('badges_array'))-2; $i++) { 
       		$badges_name[]=$this->getBadgesName($badges_array[$i],$f3);
		}}
	  $f3->set('badges_name',$badges_name);
	  $this->tpl['async']='partials/apercuBadges.html';

    }
	}
  }

  function getBadgesName($badge_id,$f3){
    $getBadgesName_=$f3->set('getBadgesName',$this->model->getBadgesName(array('badge_id'=>$badge_id)));
    if($getBadgesName_){
      $bdg_name=$getBadgesName_->bdg_name;
      return $bdg_name;
    }
  }

  function addVisit($f3){
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

/*===========================
		OBJECTIVES
============================*/

	
function _displayObjectives($f3){
    $displayObjectives_=$f3->set('displayObjectives',$this->model->displayObjectives(array('objective_user_id'=>$f3->get('SESSION.id'))));
	
    if($displayObjectives_) {

      echo 'Les objectifs : '.$obj_str=$displayObjectives_->obj_id.'<br>';

      $nb_obj=substr_count($obj_str, ',');
      echo "Nombre d'objectifs : ".$nb_obj.'<br>';

      $objectives_array = explode(',',$obj_str);

      $f3->set('objectives_array',$objectives_array);
	  
      for ($i=0; $i < count($objectives_array)-1; $i++) { 
        echo 'Objectif '.($i+1).' : '.$objectives_array[$i].' - ';
        
        echo $this->getObjectivesName($objectives_array[$i],$f3);
      }
    }
}

  function _getObjCatId($f3){
    $getObjCatId_=$f3->set('getObjCatId',$this->model->getObjCatId(array('keyword'=>$f3->get('category'))));
    if($getObjCatId_){
      $cat_id=$getObjCatId_->cat_id;
      $this->_checkObjectives($f3,$cat_id);
    }
  }

  function _getObjectives($f3){
    $getObjectives_=$f3->set('getObjectives',$this->model->getObjectives(array('id'=>$f3->get('SESSION.id'))));
      
      $obj_str=$getObjectives_->obj_id;
      return $objectives_array = explode(',',$obj_str);
      
  }

  function _checkObjectives($f3,$obj_id){
    $checkObjectives_=$f3->set('checkObjectives',$this->model->checkObjectives(array('obj_user_id'=>$obj_id,'obj_state'=>$f3->get('obj_state'))));

    if(!$checkObjectives_){

      echo "<br><br>Pas d'objectifs";

    } else {

        $obj_user_id=$checkObjectives_->obj_user_id;

        $hasObjective=false;
        $objectives_array=$this->_getObjectives($f3);

        for ($i=0; $i < count($objectives_array); $i++) { 
         if($objectives_array[$i]==$obj_user_id){
          $hasObjective=true;
         }
        }

        if (!$hasObjective) {

          $this->_addObjective($f3,$obj_user_id);

        } 
        
      }

  }

  function _addObjective($f3,$obj_id){
    $checkObjectives_=$f3->set('addObjective',$this->model->addObjective(array('user_id'=>$f3->get('SESSION.id'),'obj_id'=>$obj_id)));
  }

?>