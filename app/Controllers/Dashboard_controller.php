<?php
class Dashboard_controller extends Controller{
	
  function __construct(){
	  parent::__construct();
	  date_default_timezone_set('CET');
    $this->tpl=array('sync'=>'dashboard.html');
  }
  
  function unix_timestamp($date){
	$date = str_replace(array(' ', ':'), '-', $date);
	$c    = explode('-', $date);
	$c    = array_pad($c, 6, 0);
	array_walk($c, 'intval');
	
	return mktime($c[3], $c[4], $c[5], $c[1], $c[2], $c[0]);
}
  
    function getDashboard($f3){
		$f3->set('SESSION.postid', 0);
		//echo $f3->get('post_id');
		//$login=$f3->get('SESSION.login');
		$this->_getFeed($f3);
		$this->_followSuggest($f3);
		$this->_getCategories($f3);
		$this->_getSuggestArticles($f3);

		
	}
	
	function _getCategories($f3){
		$getCategories_=$f3->set('getCategories',$this->model->getCategories());
		
	}
	
	function searchUsers($f3){
		 //$this->redirection=false;
    $f3->set('users',$this->model->searchUsers(array('keywords'=>$f3->get('POST.name'))));
	//echo $f3->get('users');
	$this->tpl['async']='partials/users.html';
  }
  
  	function _followSuggest($f3){
		$followSuggest_=$f3->set('followSuggest',$this->model->followSuggest(array('user_id'=>$f3->get('SESSION.id'))));
		echo 'nombre follow :'.count($followSuggest_).'</br>';
		
		$id1=rand(1,count($followSuggest_));
		/*do{
		$id2=rand(1,count($followSuggest_));
		}while($id1==$id2);*/
		
		echo 'nombre 1 :'.$id1.'</br>';
		//echo 'nombre 2 :'.$id2.'</br>';
		
		foreach($followSuggest_ as $follow){
			
			//if($follow->
			
		}
		
		
		//$this->tpl['async']='partials/suggestions.json';
		
	}
  
	
	
	function _getFeed($f3){
    	$f3->set('getFeed',$this->model->getFeed(array('user_id'=>$f3->get('SESSION.id'))));
	
		//$this->tpl['async']='partials/feed_old.html';
	
	}
	

	
	function _getNewPosts($f3){
		$f3->set('getNewPosts',$this->model->getNewPosts(array('user_id'=>$f3->get('SESSION.id'),'recentId'=>$f3->get('GET.recentId'))));
		
		$this->tpl['async']='partials/feed_old.html';
		
		//echo $f3->get('MAJ');
		
	}
	
	function _getSuggestArticles($f3){
	
	$getSuggestArticles_=$f3->set('getSuggestArticles',$this->model->getSuggestArticles(array('user_id'=>$f3->get('SESSION.id'))));
	
	foreach ($getSuggestArticles_ as $article){
		$map_art[]=$article;
	}
	if(count($map_art)<1){
		$f3->set('noSuggest',"Pas de suggestions");
		}	
	else{
		shuffle($map_art);
		$f3->set('articlesSuggestRand',$map_art);
	}
	
	$this->tpl['async']='partials/articles.html';
		
	}
	
}

?>