<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>


<h3><a href="logout">logout</a></h3>

<h3><a href="games">games</a></h3>

<h3><a href="users">users</a></h3>

<h3><a href="messages">messages</a></h3>

<?php
	if($user->admin){
		echo "<h3><a href=\"new_game\">new games</a></h3>";
	}
?>

<?php
	echo "<hr/><pre>Debug:\n\n";
	var_dump($user); 
	echo "</pre>";	
?>

</body>
</html>
