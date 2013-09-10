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
  //show methods
  //==================================  
  
// Show item
mvc\get('/show/:type/:id', function($p){
	$data = array(
		"title" => "show {$p['type']}",
		"type" => $p['type'],
		"parent" => false,
		"user" => user()
	);
	
	$data["content"] = $GLOBALS['egn']->get($p['type'], $p['id']);
	
	mvc\render(
		'views/show.php',
		$data
	);      
});
  
  //==================================
  //game methods
  //==================================  
  
mvc\post('/game/:id/:what/:oid/:action', 
  function($p){
//    $object  = R::findOne($p['what'], ' id = ? AND game_id = ?', array($p['oid'], $p['id']) );
    
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
		
		jsonp( array( 
		"success" => "{$p['type']} \"{$item->name}\" created",
		"link" => "{$p['type']}/{$item->id}"
		), false );
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
    
    $data = array(
      "title" => "hello",
	  "type" => "user"
    );
    
	$fetchUser = $GLOBALS['egn']->get("user", user()->id);
	if(!$fetchUser) die("no user!");

	$data["user"] = $fetchUser[0];
	
	$data["attributes"] = array();
	if( isset($data["user"]["attributes"]) ) {
		foreach ($data["user"]["attributes"] as $attrib) {
			$data["attribute"][$attrib["title"]] = $attrib["value"];
		}
	}
	
    mvc\render('views/update.php', $data);
	
	}
);

mvc\post('/my', 
	function (/*$p*/){
    if( !isOk() ) return;
	
//	var_dump($_POST);
	
    $user = R::findOne('user', ' id = ? ', array($_POST['user_id']) );
	
	if( $user->id ) {
		if( $user->id != $_SESSION['user_id'] ) 
			die("you can only update yourself");
	}
	
	$userObject = $GLOBALS['egn']->save($_POST, $user);	
	echo $userObject ? "updated!" : "something whent wrong :(";
	}
);

mvc\get('/me', 
	function (){
    if( !isOk() ) header("Location: /Pellucid/");
    
    $data = array(
      "title" => "hello",
	  "type" => "user"
    );
    
	$fetchUser = $GLOBALS['egn']->get("user", user()->id);
	if(!$fetchUser) header("Location: /Pellucid/");

	$data["user"] = $fetchUser[0];
	
	$data["attributes"] = array();
	if( isset($data["user"]["attributes"]) ) {
		foreach ($data["user"]["attributes"] as $attrib) {
			$data["attribute"][$attrib["title"]] = $attrib["value"];
		}
	}
	
    mvc\render('views/me.php', $data);
	
	}
);

  //==================================
  //login/out methods
  //==================================
  
mvc\get('/login', 
	function (){
    if( isOk() ) {
	  $user = user();	
      die("{name:'" . $user->name . "',loggedIn:true}");
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

mvc\post('/login/:ext', 
	function ($p){
		if( isOk() ) {
		  $user = user();
		  die('{"name":"' . $user->name . '","loggedIn":true}');
		}

		switch($p['ext']) {
			case "google":
				$url = "https://www.googleapis.com/oauth2/v1/tokeninfo";
				$resp = curl_json($url . "?access_token=" . $_POST['access_token']);
				$user = $GLOBALS['auth']->loginWithToken($resp["user_id"]);  
			break;
		} 
		die($user ? '{"name":"' . $user->name . '","loggedIn":true}' : '{"loggedIn":false}');
	}
);

mvc\post('/login', 
	function (){
		if( isOk() ) {
		  $user = user();
		  die('{"name":"' . $user->name . '","loggedIn":true}');
		}
		
		$user = $GLOBALS['auth']->login($_POST['email'], $_POST['pass']);
		die($user ? '{"name":"' . $user->name . '","loggedIn":true}' : '{"loggedIn":false}');
	}
);

mvc\get('/logout', 
	function (){
		if( !isOk() ) {
		die('{"loggedIn":false}');
		}
		
		$GLOBALS['auth']->logout();
		die('{"loggedIn":false}');
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
	function (/*$p*/){
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
	function (/*$p*/){
    $user = $GLOBALS['auth']->createUser($_POST['email'], $_POST['pass']);  
    echo $user ? "activation code sent (" . $user->code . ")" : 'failed in crating user';
	}
);
mvc\post('/signup/:ext', 
	function ($p){
		switch($p['ext']) {
			case "google":
				$url = "https://www.googleapis.com/oauth2/v1/tokeninfo";
				$resp = curl_json($url . "?access_token=" . $_POST['access_token']);
				$user = $GLOBALS['auth']->createUserFromToken($resp);  
			break;
		} 
		
    echo $user ? "user created from token" : 'failed in crating user';
	}
);
  //==================================
  //debug methods
  //==================================
  
mvc\get('/warm', function(){ 
  //$bean = R::find('game',1);
 /*
  $p = array(
    "name" => 'Game One',
    "tags" => 'fun, loving, death',
    "attrib" => array(
      'type' =>  array("gengre","players"),
      'value'=>  array("horror","8-10")
    )
  );
 */
  var_dump( $GLOBALS['egn']->get("player") );
});

mvc\get('/test', function(){
  //echo '<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>';
  
  $user = user();
  var_dump( $GLOBALS['egn']->get("user", $user->id) );

});

  //==================================
  //admin methods
  //==================================

mvc\get('/admin/:type/:id', 
	function ($p){
		$data = array(
		  "title" => $p["type"],
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		$data['content'] = $GLOBALS['egn']->get($p["type"], $p["id"]);
				
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin/:type', 
	function ($p){
		$data = array(
		  "title" => $p["type"],
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => [],
		  "type" => singular($p["type"])
		);
		
		canAccess($data, true);

		$data['content'] = $GLOBALS['egn']->get( $data["type"] );
				
		mvc\render(
			'views/admin.php', 
			$data
		);
	}
);

mvc\get('/admin', 
	function (){
		$data = array(
		  "title" => "overview",
		  "user" => isOk() ? R::findOne('user', ' id = ?', array($_SESSION['user_id'])) : false,
		  "alerts" => []
		);
		
		canAccess($data, true);
		
		$data['contents'] = array(
			"players" => $GLOBALS['egn']->get( "player" ),
			"games" => $GLOBALS['egn']->get( "game" )
		);
		
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
		
		if($data["user"]) header("Location: /Pellucid/me");
		
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
function singular($s) {
	return substr($s, -1) == "s" ? substr($s, 0, -1) : $s;
}

function curl_json($base_url, $json=true){

		$ch = curl_init();
		$headers = array();
		if($json) {
				$headers = array(
					'Content-type: application/json',
					'X-HTTP-Method-Override: GET'
				);
		}
		$options = array(
			CURLOPT_URL => $base_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_TIMEOUT => 5,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_MAXREDIRS => 3,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0
		);

		curl_setopt_array($ch, $options);
		
		$response = curl_exec($ch);
		
		echo curl_error($ch);
		echo "\n";
		
		if($response === false || curl_error($ch)) {
				curl_close($ch);
				return false;
		} else {
				curl_close($ch);
				return json_decode($response, true);
		}
}
function jsonp($data, $kill = true) { 
	$callback = filter_input(INPUT_GET, "callback", FILTER_SANITIZE_STRING);
	$json = json_encode($data);
	$ret = ($callback) ? "$callback(" . $json . ");" : $json;
	if($kill){ 
	  header("Content-type: application/json");
	  die( $ret );
	}
	echo $ret;
}
//Render
mvc\start();
