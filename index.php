<?php
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require('inc/libs.php');
  
  //MiMViC setup
  use MiMViC as mvc;

  //==================================
  //Load methods
  //==================================

mvc\get('/game/:id/*', 
  function($p){
    $game  = R::findOne('game', ' id = ? ', array($p['id']) );
    $data = array(
      "title" => "Game - not found",
    );
    
    $data['game'] = ($game) ? $game : false;
    if($game) $data['title'] = "Game - " . $game->name;

    mvc\render('views/game.php', $data);    
}
);

mvc\get('/login', 
	function (){
    $data = array(
      "title" => "login"
    );
    mvc\render('views/login.php', $data);
	}
);

mvc\get('/', 
	function (){
    $data = array(
      "title" => "welcome"
    );
    mvc\render('views/first.php', $data);
	}
);

  
  //Render
  mvc\start();
?>
