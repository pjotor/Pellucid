<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<h1>Games</h1>
<ul>
<?php
	foreach(  $list as $game ){ 
		echo "<li><a href=\"/Pellucid/game/{$game->id}\">{$game->name}</a>";
	}
?>
</ul>
<body>
<?php
	if(count($list) == 0 ) echo "<p>No entries in list</p>";
	
	echo "<hr/><pre>Debug:\n\n";
	var_dump($list); 
	echo "</pre>";	
?>
</body>
</html>
