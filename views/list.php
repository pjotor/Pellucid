<!DOCTYPE html>
<html>
<head>
	<title><?= $title; ?></title>
</head>
<body>
<?php
	if(count($list) == 0 ) echo "<p>No entries in list</p>";
	
	echo "<hr/><pre>Debug:\n\n";
	var_dump($list); 
	echo "</pre>";	
?>
</body>
</html>
