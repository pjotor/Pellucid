<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
<h1><?= $game->name; ?></h1>

<?php
	echo "<hr/><pre>Info:\n\n";
	var_dump($info); 
	echo "</pre>";	
	echo "<hr/><pre>Game:\n\n";
	var_dump($game); 
	echo "</pre>";	
	echo "<hr/><pre>Session:\n\n";
	var_dump($_SESSION['user_id']); 
	echo "</pre>";		
?>
</body>
</html>
