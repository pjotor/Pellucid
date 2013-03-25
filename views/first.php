<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>

<h1>Welcome!</h1>

<?php
	$loginOut = (!$user) ? "login" : "logout";
	echo "<h3><a href=\"$loginOut\">$loginOut</a></h3>";
?>

<?php
	echo "<hr/><pre>Debug:\n\n";
	var_dump($user); 
	echo "</pre>";	
?>

</body>
</html>
