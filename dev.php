<pre>
result:
<?php
  //Global settings
  require_once('inc/settings.php');
  
  //DB & Template Libs
  require('inc/libs.php');
  
  R::debug(true);
  
  if( isset($_POST["type"]) )
	var_dump( R::find($_POST["type"],$_POST["q"], explode(",",$_POST["a"])) );
	
  R::debug(false);
?>
</pre>
<hr>
<form method="POST">
<input name="type" value="<?= isset($_POST["type"]) ? $_POST["type"] : "" ?>" style="width: 90%"><br/>
<textarea name="q" style="width: 90%"><?= isset($_POST["q"]) ? $_POST["q"] : "" ?></textarea><br/>
<input name="a" value="<?= isset($_POST["a"]) ? $_POST["a"] : "" ?>" style="width: 90%"><br/>
<input type="submit" style="width: 90%">
</form>