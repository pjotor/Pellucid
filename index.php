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
 
// Display game by id 
mvc\get('/game/:id/*/', 
  function($p){
    $game  = R::findOne('game', ' id = ? ', array($p['id']) );
    $data = array(
      "title" => $game->name,
	  "game" => $game,
	  "info" => $GLOBALS['egn']->get("game", $p['id'])
    );
	
    mvc\render('views/game.php', $data);    
}
);

mvc\post('/game/:id', 
  function($p){
    $game  = R::findOne('game', ' id = ? ', array($p['id']) );
	
	if( $game->id ) {
		if( !( isAdmin() || isOwner($game) ) ) die("auth fail");

	echo "<hr/><pre>Game:\n\n";
	var_dump($game); 
	echo "</pre>";
		
	echo "<hr/><pre>POST:\n\n";
	$game = $GLOBALS['egn']->save($_POST, $game);
	var_dump($game); 
	echo "</pre>";
		
	}

    $data = array(
      "title" => $game ? $game->name : "Game not found",
	  "game" => $game,
	  "info" => $GLOBALS['egn']->get("game", $p['id'])
    );
	
    mvc\render('views/game.php', $data);    
}
);

// Lists games by comma separated tags (any)
mvc\get('/games/:tags', 
  function($p){
    $games = R::tagged( 'game', $p['tags'] );
    $data = array(
      "title" => "Game list",
      "list" => array()
    );
    
    foreach($games as $game) {
      $data["list"][] = $game;
    }

    mvc\render('views/games.php', $data);    
  }
);

// Lists games by comma separated tags (all)
mvc\get('/all/games/:tags', 
  function($p){
    $games = R::taggedAll( 'game', explode(",",$p['tags']) );
    $data = array(
      "title" => "Game list",
      "list" => array()
    );
    
    foreach($games as $game) {
      $data["list"][] = $game;
    }

    mvc\render('views/games.php', $data);    
  }
);

// Lists games
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

    mvc\render('views/games.php', $data);    
  }
);
/*
// Create new game (save)
mvc\post('/new/game', function($p){
	if(isAdmin()) {
		$game = $GLOBALS['egn']->save($_POST);	
		echo "<a href=\"../game/{$game->id}\">Game \"{$game->name}\" created</a>";
	}
  }
);

// Create new game (form)
mvc\get('/new/game', function($p){
	mvc\render('views/' . (isAdmin() ? 'new' : 'first') . '.php');     
  }
);
*/
  //==================================
  //"new" methods
  //==================================


// Create new child (form)
mvc\get('/new/:type/:parent/:parentId', function($p){
	$data = array(
		"type" => $p['type'],
		"parent" => R::findOne($p['parent'], ' id = ? ', array($p['parentId']) ),
		"user" => user()
	);
	
	mvc\render(
		'views/' . (isAdmin() ? 'new' : 'first') . '.php',
		$data
	);      
});

// Create new object (form)
mvc\get('/new/:type', function($p){
	$data = array(
		"type" => $p['type'],
		"parent" => false,
		"user" => user()		
	);
	
	mvc\render(
		'views/' . (isAdmin() ? 'new' : 'first') . '.php',
		$data
	);      
});

// Create new game (save)
mvc\post('/new/:type', function($p){
	if(isAdmin()) {
		$item = $GLOBALS['egn']->save($_POST);	
		echo "<a href=\"../{$p['type']}/{$item->id}\">{$p['type']} \"{$item->name}\" created</a>";
	}
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
<?php
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
<?php
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
<?php
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
<?php
	}
);

mvc\post('/signup', 
	function ($p){
    $user = $GLOBALS['auth']->createUser($_POST['email'], $_POST['pass']);  
    echo $user ? "activation code sent (" . $user->code . ")" : 'failed in crating user';
	}
);

  //==================================
  //debug methods
  //==================================
  
mvc\get('/warm', function(){ 
  $bean = R::find('game',1);
  $p = array(
    "name" => 'Game One',
    "tags" => 'fun, loving, death',
    "attrib" => array(
      'type' =>  array("gengre","players"),
      'value'=>  array("horror","8-10")
    )
  );
  
  var_dump( $GLOBALS['egn']->get("player") );
});

mvc\get('/test', function(){
  //echo '<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>';
  
  $bean = R::find('game',1);
  $p = array(
    "name" => 'Game One',
    "tags" => 'fun, loving, death',
    "attrib" => array(
      'type' =>  array("gengre","players"),
      'value'=>  array("horror","8-10")
    )
  );
  
  var_dump( $GLOBALS['egn']->get("player") );
});

  //==================================
  //admin methods
  //==================================
  
mvc\get('/admin', 
	function (){
		$data = array(
		  "title" => "welcome",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/players', 
	function (){
		$data = array(
		  "title" => "players",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		$data['players'] = $GLOBALS['egn']->get("player");
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/characters', 
	function (){
		$data = array(
		  "title" => "characters",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/plots', 
	function (){
		$data = array(
		  "title" => "plots",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/groups', 
	function (){
		$data = array(
		  "title" => "groups",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/users', 
	function (){
		$data = array(
		  "title" => "users",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

  //==================================
  //base methods
  //==================================
  
mvc\get('/', 
	function (){
		$data = array(
		  "title" => "welcome",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false
		);
		
		mvc\render(
			'views/first.php', 
			$data
		);
	}
);

  //==================================
  //Helpers
  //==================================
function user(){
	return isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false;
}  
function canAccess($data = false, $admin = false) {
	if(!$data) header( 'Location: /Pellucid' );
	if(!$data["user"]) header( 'Location: /Pellucid' );
	if($admin && !$data["user"]->admin) header( 'Location: /Pellucid' );
}  
function isOk() {
  return $GLOBALS['auth']->checkSession();
}
function isAdmin() {
  return R::findOne('user', ' id = ?', array($_SESSION['user_id']))->admin == 1;
}
function isOwner($game) {
  return $game->cretor == $_SESSION['user_id']; 
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
