<?php
class Profile_controller extends Controller{
	
  function __construct(){
	parent::__construct();
    $this->tpl=array('sync'=>'profile.html');
  }
//------Obtenir des données du profil une 1ère fois------  
   function getProfil($f3){
    $getProfil_=$f3->set('getProfil',$this->model->getProfil(array('id'=>$f3->get('PARAMS.id'))));
		if($getProfil_){
			$userLogin=$getProfil_->login;
			$f3->set('userLogin',$userLogin);
		}
//-----REROUTE vers le dashboard si l'id du user n'existe pas
		else
			$f3->reroute('/dashboard/'.$f3->get('SESSION.id'));

	$this->_getFeedUser($f3);
	$this->_getFollowers($f3);
	$this->_getFollowing($f3);

	$this->tpl['async']='profile.html';
  }
//------UserDatas----
  function getUserData($f3){
	  	 $this->_getCountBadges($f3);
	      $f3->set('getUserData',$this->model->getUserData(array('id'=>$f3->get('PARAMS.id'))));
		$this->tpl['async']='json/dataUser.json';
	  
  }
		
 //------FEED de l'user----   
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
		
		================  autre methode ===================
		
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
				'avatar'=>$f3->get($f3->get('UPLOADS').$f3->get('SESSION.user_id').$_FILES['file']['name']),
				'location'=>$f3->get('POST.location'),
				'date_birth'=>$f3->get('POST.date_birth')
			);
			
			if($_FILES['file']['error']==0){
				$avatar = \Web::instance()->receive(function($file){
					$f3 = \Base::instance();
					$params['avatar']=$f3->get($f3->get('UPLOADS').$f3->get('SESSION.user_id').$_FILES['file']['name']);
				}, true, true);
			}
			
			$this->model->profileUpdate($params);
			$f3->reroute("/");
		}
	}
}
//----Follow----
//---Obtenir les followers de l'user du profil visité-----
	function _getFollowers($f3){
	
		$f3->set('getFollowers',$this->model->getFollowers(array('user_id'=>$f3->get('PARAMS.id'))));
	
		}
//---Obtenir les following de l'user du profil visité-----		
	function _getFollowing($f3){
	
		$f3->set('getFollowing',$this->model->getFollowing(array('user_id'=>$f3->get('PARAMS.id'))));
	
		}
//---Savoir si l'user du profil visité est ami avec l'user en session-----		
	function getStateFollow($f3){
	$getStateFollow_=$f3->set('getStateFollow',$this->model->getStateFollow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following_id'))));
	
	$this->tpl['async']='json/followState.json';
		
	}
//-----Gestion du follow/unfollow et lancer l'update des compteurs des follow---------	
  	function follow($f3){
		$follow_=$f3->set('follow',$this->model->follow(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$f3->get('PARAMS.following'))));
		
		$this->_updateFollowNumbers($f3,$f3->get('PARAMS.following'),$f3->get('PARAMS.state'));
		
		//n'est pas servi
		$this->tpl['async']='partials/users.html';
		
	}
//----Update des compteurs lors d'un follow/unfollow------	
	function _updateFollowNumbers($f3,$following_id,$state){
		$f3->set('updateFollowNumbers',$this->model->updateFollowNumbers(array('follower_id'=>$f3->get('SESSION.id'),'following_id'=>$following_id,'state'=>$state)));
		
		
	}

//-----POSTER-----

	function insertPost($f3){
		$f3->set('insertPost',$this->model->insertPost());
		$this->_addVisit($f3);
		$this->tpl['async']='json/checkBadges.json';
	}
	

//-----BADGES----
//Obtenir la liste des badges de l'user du profil connecté ou de l'user en session
  function _getBadges($f3){
	  
	  if($f3->get('PARAMS.id'))
	  	$id=$f3->get('PARAMS.id');
	else
		$id=$f3->get('SESSION.id');
	  
    $getBadges_=$f3->set('getBadges',$this->model->getBadges(array('id'=>$id)));
     
	 if($getBadges_) { 
      return $bdg_str=$getBadges_->bdg_id;
	  
	 }
      
  }
//------Obtenir le nombre de badges------ 
  function _getCountBadges($f3){
	  $bdg_str=$this->_getBadges($f3);
	  $f3->set('count',substr_count($bdg_str, ','));	  
  }
//----Afficher les badges: on va les chercher et chercher leur nom---- 	Format des badges dans la BDD: 'bdg1,bdg2,'
function _displayBadges($f3){
	
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
      }
	  
	  $f3->set('badges_name',$badges_name);

	   }
	   
	   $this->tpl['async']='partials/apercuBadges.html'; 
  }

  function getBadgesName($badge_id,$f3){
    $getBadgesName_=$f3->set('getBadgesName',$this->model->getBadgesName(array('badge_id'=>$badge_id)));
    if($getBadgesName_){
      $bdg_name=$getBadgesName_->bdg_name;
      return $bdg_name;
    }
  }
//ajout d'une visite à user
  function _addVisit($f3){
	$f3->set('category',$f3->get('POST.post_cat'));
	
    $f3->set('addVisit',$this->model->addVisit(array('keyword'=>$f3->get('category'),'user_id'=>$f3->get('SESSION.id'))));
    $this->_getVisits($f3);
	//n'est pas servi
    $this->tpl['async']='partials/users.html';
  }
//----Obtenir le nombre de visite de la catégorie du post pour CheckBadges-----
  function _getVisits($f3){
    $getVisits_=$f3->set('getVisits',$this->model->getVisits(array('user_id'=>$f3->get('SESSION.id'),'keyword'=>$f3->get('category'))));
    if($getVisits_){
      $cat_id=$f3->get('category');
      $cat_count=$getVisits_->$cat_id;
      $f3->set('cat_count',$cat_count);
	  $this->_checkBadges($f3,$cat_id);
    }
  }

//-----Savoir si l'user à droit à un badge grâce à sa nouvelle visite-------
  function _checkBadges($f3,$cat_id){
    $checkBadges_=$f3->set('checkBadges',$this->model->checkBadges(array('cat_id'=>$cat_id,'cat_count'=>$f3->get('cat_count'))));

if($checkBadges_){

        $bdg_id=$checkBadges_->bdg_id;
//On recherche si il a déjà le badge auquel il aurait droit...
        $hasBadge=false;
		$bdg_str=$this->_getBadges($f3);
		$badges_array = explode(',',$bdg_str);

        for ($i=0; $i < count($badges_array); $i++) { 
         if($badges_array[$i]==$bdg_id){
          $hasBadge=true;
         }
        }

        if (!$hasBadge) {
//...Si il ne l'a pas on l'ajoute dans ses badges
          $this->_addBadge($f3,$bdg_id);
        } 
        
      }

  }
//Ajout du badge dans les badges de l'user
  function _addBadge($f3,$bdg_id){
    $f3->set('addBadge',$this->model->addBadge(array('user_id'=>$f3->get('SESSION.id'),'bdg_id'=>$bdg_id)));
	$this->_newBadgeData($f3, $bdg_id);
	
  }
//Obtenir les données des badges pour les afficher  
 function _newBadgeData($f3, $bdg_id){
	 $f3->set('newBadgeData',$this->model->newBadgeData(array('bdg_id'=>$bdg_id))); 
 }
 
 /*===========================
 		OBJECTIVES
 ============================*/

	
 function _displayObjectives($f3){
	  
	 $obj_str=$this->_getObjectives($f3);
	 
	if($obj_str!=""){ 
	 
		if(substr_count($obj_str, ',')<=2)
			$f3->set('nb_obj',(substr_count($obj_str, ',')));
		else
			$f3->set('nb_obj',3);
			
	$f3->set('objectives_array',explode(',',$obj_str));
	$objectives_array=$f3->get('objectives_array');
		  
	$f3->set('all',$f3->get('GET.all'));
		  
	for ($i=0; $i<=count($f3->get('objectives_array'))-2; $i++) { 
				$objectives_name[]=$this->getObjectivesName($objectives_array[$i],$f3);
      }
	  
	  $f3->set('objectives_name',$objectives_name);

	   }
	   
	   $this->tpl['async']='partials/objectifs.html'; 
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

     if($checkObjectives_){
         $obj_user_id=$checkObjectives_->obj_user_id;
         $hasObjective=false;
         $objectives_array=$this->_getObjectives($f3);

         for ($i=0; $i < count($objectives_array); $i++) { 
          if($objectives_array[$i]==$obj_user_id){
           $hasObjective=true;
          }
     }
         if (!$hasObjective) {
           $this->_addObjective($f3,$obj_user_id); } 
       }
   }
   
   function _addObjective($f3,$obj_id){
     $checkObjectives_=$f3->set('addObjective',$this->model->addObjective(array('user_id'=>$f3->get('SESSION.id'),'obj_id'=>$obj_id)));
   }
 
 
 //STATS GRAPH
//Obtenir le nom des catégories dans lesquelles l'user à poster dans la semaine courante
   function _catWeek($f3){
    $catWeek_=$f3->set('catWeek',$this->model->catWeek(array('user_id'=>$f3->get('PARAMS.id'))));
 
	$this->tpl['async']='partials/categories.html';
	
  } 
//Obtenir la navigation d'un user dans la semaine courante et par catégories
  function _graphProfile($f3){
    $graphProfile_=$f3->set('graphProfile',$this->model->graphProfile(array('user_id'=>$f3->get('PARAMS.id'),'cat_id'=>$f3->get('POST.categorie'))));

	$this->tpl['async']='partials/statsWeek.html';
	
  } 
	
}
	

?>