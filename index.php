<?php
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require('inc/libs.php');
  
  //MiMViC setup
  use MiMViC as mvc;

  //==================================
  //Methods
  //==================================
  

  //==================================
  //game methods
  //==================================  
mvc\post('/game/:id/:what/:oid/:action', 
  function($p){
    $object  = R::findOne($p['what'], ' id = ? AND game_id = ?', array($p['oid'], $p['id']) );
    
    echo "TODO: do " . $p['action'] . " to " . $p['what'] .  " w. id: " . $p['oid'] . " belonging to game id: " . $p['id'];
  }
);   
  
mvc\get('/game/:id/:what/:oid', 
  function($p){
    $object  = R::findOne($p['what'], ' id = ? AND game_id = ?', array($p['oid'], $p['id']) );
    $data = array(
      "title" => $p['what']
    );
    
    if( $object ) {
      $data['game'] = R::load('game', $p['id']);
      $data['object'] = $object;
    }    
    
    mvc\render("views/one.php", $data); 
  }
);   

mvc\get('/game/:id/:what', 
  function($p){
    $list  = R::find( substr($p['what'], 0, -1), ' game_id = ? ', array($p['id']) );
    
    $data = array(
      "title" => $p['what']
    );
    
    if( $list ) {
      $data['game'] = R::load('game', $p['id']);
      $data['list'] = $list;
    }
    
    mvc\render('views/list.php', $data); 
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
      "list" => array()
    );
    
    foreach($games as $game) {
      $data["list"][] = $game;
    }

    mvc\render('views/list.php', $data);    
  }
);

  //==================================
  //user methods
  //==================================

mvc\post('/my/:what/:id/:action', 
	function ($p){
    if( !isOk() ) return;
    echo "TODO: do " . $p['action'] .  " to my " . $p['what'] . " w. id: " . $p['id'];
	}
);

mvc\get('/my/:what/:id', 
	function ($p){
    if( !isOk() ) return;
    echo "TODO: my " . $p['what'] . " w. id: " . $p['id'];
	}
);
mvc\get('/my/:what', 
	function ($p){
    if( !isOk() ) return;
    echo "TODO: my " . $p['what'] . " page";
	}
);

mvc\get('/my', 
	function (){
    if( !isOk() ) return;
    echo "TODO: my user page";
	}
);

  //==================================
  //login/out methods
  //==================================
  
mvc\get('/login', 
	function (){
    if( isOk() ) {
      echo "already logged in!";
      return;
    }
?>
<form action="login" method="POST">
  <input type="text" name="email" placeholder="email">
  <input type="password" name="pass" placeholder="password">
  <input type="submit" value="login"><br/>
</form>  
<?
	}
);

mvc\post('/login', 
	function (){
    if( isOk() ) {
      echo "already logged in!";
      return;
    }
    
    $user = $GLOBALS['auth']->login($_POST['email'], $_POST['pass']);
    echo $user ? "logged in!" : "ops!";
	}
);

mvc\get('/logout', 
	function (){
    if( !isOk() ) {
      echo "ok";
      return;
    }
    $GLOBALS['auth']->logout();
    echo "bye!";
	}
);

  //==================================
  //user methods
  //==================================
  
mvc\get('/user/reset/:code', 
	function ($p){
?>
<form action="user/reset" method="POST">
  <input type="text" name="email" placeholder="email">
  <input type="text" name="code" placeholder="reset code" value="<?= $p['code']; ?>">
  <input type="password" name="pass" placeholder="new password">
  <input type="submit" value="set"><br/>
</form>  
<?
	}
);

mvc\post('/user/reset/request', 
	function ($p){
    $code = $GLOBALS['auth']->resetPassword($p['email']);
    echo $code ? "reset code sent (" . $code . ")" : 'failed in reseting password';
	}
);

mvc\get('/user/reset', 
	function ($p){
?>
<form action="user/reset/request" method="POST">
  <input type="text" name="email" placeholder="email">
  <input type="submit" value="reset"><br/>
</form>  
<?
	}
);

mvc\post('/user/reset', 
	function ($p){
    $changed = $GLOBALS['auth']->validateReset($p['email'],$p['code'],$p['pass']);
    echo $changed ? 'password changed' : 'password change failed';  
	}
);

mvc\get('/user/verify/:email/:code', 
	function ($p){
    $verified = $GLOBALS['auth']->verifyUser($p['email'],$p['code']); 
    echo $verified ? 'your email was verified!':'verification failed';
	}
);

  //==================================
  //signup methods
  //==================================
  
mvc\get('/signup', 
	function ($p){
?>
<form action="signup" method="POST">
  <input type="text" name="email" placeholder="email">
  <input type="password" name="pass" placeholder="password">
  <input type="submit" value="create"><br/>
</form>  
<?
	}
);

mvc\post('/signup', 
	function ($p){
    $user = $GLOBALS['auth']->createUser($_POST['email'], $_POST['pass']);  
    echo $user ? "activation code sent (" . $user->code . ")" : 'failed in crating user';
	}
);

mvc\get('/test', function(){
  echo '<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>';
  
  $bean = R::load('game',1);
  $p = array(
    "name" => 'Game One',
    "tags" => 'fun, loving, death',
    "attrib" => array(
      'type' =>  array("gengre","players"),
      'value'=>  array("horror","8-10")
    )
  );
  
  var_dump( $GLOBALS['egn']->save($p, $bean) );
  

});

  //==================================
  //base methods
  //==================================
  
mvc\get('/', 
	function (){
    $data = array(
      "title" => "welcome"
    );
    mvc\render('views/first.php', $data);
	}
);

  //==================================
  //Helpers
  //==================================
  
function isOk() {
  return $GLOBALS['auth']->checkSession();
}
function flash($m, $t = 'i') {
  $GLOBALS['msg']->add($t, $m);
}
function s  ($s) { 
  return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_STRING); 
}
function i  ($s) { 
  return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_NUMBER_INT); 
}
function e  ($s) { 
  return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_EMAIL); 
}
function a_s($s) { 
  return filter_input_array(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_STRING); 
}
function a_i($s) { 
  return filter_input_array(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_NUMBER_INT); 
}

//Render
mvc\start();
?>
