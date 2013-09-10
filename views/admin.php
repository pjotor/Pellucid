<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<title><?= $title; ?> - Admin</title>
	<link rel="stylesheet" type="text/css"  href="/Pellucid/css/admin.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script>
	$(document).ready(function(){
		$(".collapsable .collapse, .collapsable pre").hide();
		$(".collapsable span").click(function(){
			$(this).siblings("pre, span").toggle();
		});
	});
	</script>
</head>

<body>

	<div class="wrapper">
	
		<h1 class="logo">PELLUCID ADMIN</h1>
		<p class="txt_right">Logged in as <strong><?= $user->email; ?></strong>  <span class="v_line"> | </span> <a href="logout"> Logout</a></p>
	
		<div id="searchform">
			<form method="get" action="">
			<input type="text" value="find something good..." class="search_box" name="search" onclick="this.value='';"  />
			<input type="submit" class="search_btn" value="SEARCH" />
			</form>
		</div>	

	<!-- Navigation -->
	
		<div class="navigation">
				<ul>
					<li><a<?= $title == "overview" ? ' class="active"' : ''; ?> href="/Pellucid/admin">OVERVIEW</a></li>				
					<li><a<?= $title == "players" ? ' class="active"' : ''; ?> href="/Pellucid/admin/players">PLAYERS</a></li>
					<li><a<?= $title == "characters" ? ' class="active"' : ''; ?> href="/Pellucid/admin/characters">CHARACTERS</a></li>
					<li><a<?= $title == "plots" ? ' class="active"' : ''; ?> href="/Pellucid/admin/plots">PLOTS</a></li>
					<li><a<?= $title == "groups" ? ' class="active"' : ''; ?> href="/Pellucid/admin/groups">GROUPS</a></li>
					<li><a<?= $title == "users" ? ' class="active"' : ''; ?> href="/Pellucid/admin/users">USERS</a></li>
					<li><a<?= $title == "games" ? ' class="active"' : ''; ?> href="/Pellucid/admin/games">GAMES</a></li>
				</ul>
		</div>
		
		<div class="clear"></div>
	
		<div class="content">
		
	<!-- Intro -->
		
				<div class="in author">
					<h2>All <?= $title ?></h2>
				<!--
					<p>Author <a href="#">Bruce Lee</a> | created 10-14-08</p>
				//-->
				</div>
			
				<div class="line"></div>
				
	<!-- Checks -->
	<!--
			<div class="check_main">
					
				<div class="check">
					<div class="good"><img src="/Pellucid/images/check.gif" alt="check" class="icon" />Nice work <strong>Ninja Admin!</strong></div>
				</div>
				<div class="check">
					<div class="bad"><img src="/Pellucid/images/x.gif" alt="check" class="icon" />You need more training, please <a href="#">try again</a>.</div>
				</div>
				
			</div>
	//-->
	

<?php

	switch($title) {	
		case "players": 
include "admin/list/players.php";
		break;
/*		
		case "games": 
include "admin/list/games.php";
		break;
*/		
		case "users":
		
$items = R::findAll($type);
foreach( $items as $item ) {
	$content[] = array(
		"name" => $item->email,
		"id" => $item->id,
		"attributes" => array()
	);
}
include "admin/list/default.php";
		break;

		case "overview": 
include "admin/list/overview.php";
		break;		
		
		default: 
include "admin/list/default.php";	
	} 
?>	

	<!-- Form -->
	<!--			
				<div class="in forms">
					<form id="form1" name="form1" method="post" action="">
	
      				<p><strong>TITLE</strong><br />
					<input type="text" name="name" class="box" /></p>
					 
	  				<p><strong>AUTHOR</strong><br />
							<select name="date_end" class="box2" >
        					<option selected="selected"> Bruce Lee</option>
							<option>Jackie Chan</option>
        					<option>John Claude Van Damme</option>
        					<option>Ben Johnson</option>
					  </select></p>
					
	  				<p><strong>STORY</strong><br />
					<textarea name="mes" rows="5" cols="30" class="box" ></textarea></p> 

					<p><input name="submit" type="submit" id="submit"  tabindex="5" class="com_btn" value="UPDATE" /></p>
					</form>
			
				</div>
	//-->
		</div>
		
		<p class="footer"><a href="#">ADVANCED  SEARCH</a> <span class="v_line"> |</span> <a href="#">LOGOUT</a></p>
		
	</div>
	
<?php
	echo "<hr/><pre>Debug:\n\n";
	var_dump($user); 
	echo "</pre>";	
?>	
</body>
</html>
