<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8 />
	<title><?= $title; ?></title>
</head>
<body>
<pre>
<?php
	foreach ($content as $item) {
		$attributes = array();
		foreach ($item["attributes"] as $attrib) {
			$attributes[$attrib["title"]] = $attrib["value"];
		}
		
		echo "\n DATA ----------------------- \n";
		var_dump($item); 
		
		echo "\n ATTRIBUTES ----------------- \n";
		var_dump($attributes); 
		
		echo "\n ---------------------------- \n";
	}
?>
</pre>
</body>
</html>
