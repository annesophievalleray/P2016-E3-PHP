<?php
class Dashboard_controller extends Controller{
	
  function __construct(){
	  parent::__construct();
	  date_default_timezone_set('CET');
    $this->tpl=array('sync'=>'dashboard.html');
  }
 //----Extension Chrome--------- 
  function getExtension($f3){
	  $this->tpl['sync']='extension.html';
	  $this->_getCategories($f3);
  }
  
 //----Obtenir une première fois des données du Dashboard----- 
    function getDashboard($f3){
		$this->_getFollowList($f3);
		$this->_getCategories($f3);
		$this->_getSuggestArticles($f3);
		$this->_graphDashboard($f3);


		
	}
//-----Obtenir catégories du select du formulaire de post------	
	function _getCategories($f3){
		$getCategories_=$f3->set('getCategories',$this->model->getCategories());
		
	}
//------Rehcerche Utilisateurs---------	
	function searchUsers($f3){
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	$this->tpl['async']='partials/users.html';
  }
 
 //-----Obtenir liste des following d'un user sous forme d'un String puis lancer followSuggest----- 
  function _getFollowList($f3){
	  $getFollowList_=$f3->set('getFollowList',$this->model->getFollowList(array('user_id'=>$f3->get('SESSION.id'))));
	 if($getFollowList_){ 
	  foreach($getFollowList_ as $follow){
		 $followTabId[]=$follow->following_id;
	  }
	 $followStringId=implode(",", $followTabId);

		$this->_followSuggest($f3,$followStringId);
	 }	  
  }

//----Obtenir une suggestion de following que l'user ne suit pas déjà-----------  
  	function _followSuggest($f3,$followStringId){
		$followSuggest_=$f3->set('followSuggest',$this->model->followSuggest(array('followString'=>$f3->get('SESSION.id'),'followStringId'=>$followStringId)));
		
		$map_follow_ok=array();
		
		$followTab=explode(",",$followStringId);
		
		foreach($followSuggest_ as $follow){
				if(in_array($follow->following_id, $followTab)==false){
					$map_follow_ok[]=$follow;
				}
		}
		
	if(count($map_follow_ok)<1){
		$f3->set('noSuggest',"Pas de suggestions");
		}	
	else{
		//Mélange du tableau de manière aléatoire
		shuffle($map_follow_ok);
		$f3->set('followSuggestRand',$map_follow_ok);
	}

		$this->tpl['async']='partials/followSuggest.html';
		
	}
	
//------Obtenir les (10 premiers :au chargement de la page) posts de l'user et de ses following-------
	
	function _getNewPosts($f3){
		$f3->set('getNewPosts',$this->model->getNewPosts(array('user_id'=>$f3->get('SESSION.id'),'recentId'=>$f3->get('GET.recentId'),'limit'=>$f3->get('GET.limit'))));
		
		
		$this->tpl['async']='partials/feed_new.html';
		
	}
//-----Obtenir des post plus anciens que ceux afficher: SCROLL INFINI-------
	function _getOldPosts($f3){
		$f3->set('getOldPosts',$this->model->getOldPosts(array('user_id'=>$f3->get('SESSION.id'),'oldId'=>$f3->get('GET.oldId'))));
		
		$this->tpl['async']='partials/feed_old.html';
		
	}
//-------Suggestion d'articles non postés par l'user---------	
	function _getSuggestArticles($f3){
	
	$getSuggestArticles_=$f3->set('getSuggestArticles',$this->model->getSuggestArticles(array('user_id'=>$f3->get('SESSION.id'))));
	$map_art=array();
	
	foreach ($getSuggestArticles_ as $article){
		$map_art[]=$article;
	}
	if(count($map_art)<1){
		$f3->set('noSuggest',"Pas de suggestions");
		}	
	else{
		//Mélange du tableau
		shuffle($map_art);
		$f3->set('articlesSuggestRand',$map_art);
	}
	
	$this->tpl['async']='partials/articles.html';
		
	}
	
	//STATS
//--------Obtenir la navigation de l'user pendant le mois courant et par catégories------	
function _graphDashboard($f3){
		
	$graphDashboard_=$f3->set('graphDashboard',$this->model->graphDashboard(array('user_id'=>$f3->get('PARAMS.id'))));
	
	$count=0;
		foreach ($graphDashboard_ as $post){
			$count+=$post->sum_cat;
		}
	$f3->set('count',$count);
	$this->tpl['async']='partials/count.html';

		}
	
}

?>