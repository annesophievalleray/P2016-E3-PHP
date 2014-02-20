<?php
class Controller{
  
protected $tpl;
protected $model;
protected $redirection=true;

public function __construct(){
	//print_r($f3->hive());
	$f3=\Base::instance();
	if($f3->get('PATTERN')!='/'&& !$f3->get('SESSION.id')){
		$f3->reroute('/');
	};
	
}

  public function beforeroute(){
    $model=substr(get_class($this),0,strpos(get_class($this),'_')+1).'model';
    if(class_exists($model)){
      $this->model=new $model();
    }
  }
  
  
  public function afterroute($f3){
    if($f3->get('AJAX')//&& !$this->redirection 
	){
      echo View::instance()->render($this->tpl['async']);
    }else if(!$f3->get('AJAX')){
      echo View::instance()->render($this->tpl['sync']);
    }
  } 
  
}
?>