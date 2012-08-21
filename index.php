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
  
mvc\post('/game/:id/:what/:oid/:action', 
  function($p){
    echo "TODO: do " . $p['action'] . " to " . $p['what'] .  " w. id: " . $p['oid'] . " belonging to game id: " . $p['id'];
  }
);   
  
mvc\get('/game/:id/:what/:oid', 
  function($p){
    echo "TODO: show " . $p['what'] .  " w. id: " . $p['oid'] . " belonging to game id: " . $p['id'];
  }
);   

mvc\get('/game/:id/:what', 
  function($p){
    echo "TODO: show " . $p['what'] .  " belonging to game id: " . $p['id'];
  }
);  
  
mvc\get('/game/:id', 
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

mvc\get('/games', 
  function(){
    $games = R::findAll( 'game', ' ORDER BY created DESC ' );
    $data = array(
      "title" => "Game list",
      "games" => array()
    );
    
    foreach($games as $game) {
      $data["games"][] = $game;
    }

    mvc\render('views/game.php', $data);    
  }
);

mvc\post('/my/:what/:id/:action', 
	function ($p){
    echo "TODO: do " . $p['action'] .  " to my " . $p['what'] . " w. id: " . $p['id'];
	}
);

mvc\get('/my/:what/:id', 
	function ($p){
    echo "TODO: my " . $p['what'] . " w. id: " . $p['id'];
	}
);
mvc\get('/my/:what', 
	function ($p){
    echo "TODO: my " . $p['what'] . " page";
	}
);

mvc\get('/my', 
	function (){
    echo "TODO: my user page";
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

mvc\post('/login', 
	function (){
    $a = $GLOBALS['auth']; 
    //$f = $GLOBALS['msg'];
    
    if( $a->checkSession()) {
      echo "already logged in!";
      return;
    }
    
    $user = $a->login($_POST['email'], $_POST['pass']);
    
    echo $user ? "logged in!" : "ops!";
    /*
      $f->add('i', "You are logged in!") : 
      $f->add('e', 'Login failed.');
    */
      
    //header("Location: {$base}/login");
	}
);

mvc\get('/logout', 
	function (){
    $a = $GLOBALS['auth'];
    if( !$a->checkSession()) {
      echo "ok";
      return;
    }
    $a->logout();
    echo "bye!";
	}
);

mvc\get('/user/reset', 
	function ($p){
    echo "TODO: password reset info/form";
	}
);

mvc\post('/user/reset', 
	function ($p){
    echo "TODO: password reset function (w. code)";    
	}
);

mvc\get('/user/verify/:code', 
	function ($p){
    echo "TODO: user verification (w. code)";
	}
);

mvc\get('/signup', 
	function ($p){
    echo "TODO: signup info/form";
	}
);

mvc\post('/signup', 
	function ($p){
    echo "TODO: signup function (w. connect/openid)";
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
