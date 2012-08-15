<?php
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require('inc/libs.php');

//MiMViC setup
use MiMViC as mvc;


mvc\post('/add',
	function ($params){
		$sh = R::dispense('shouts');
		$sh->import($_POST, 'name,message,public');
		$id = R::store($sh);
		if($id){
			?><script> window.location = '/Pellucid'; </script><?php
		}else{
			echo 'Some problem occured';
		}
	}
);

mvc\get('/delete/:id', function($p){
	$shout  = R::findOne('shouts', ' id = :id ', array(':id'=> $p['id']) );
	if($shout){
		if( !R::trash($shout) ){
			?><script> window.location = '/Pellucid'; </script><?php
		}else{
			echo 'Deletion failed';
		}
	}else{
		echo 'No such entity';
	}
});

mvc\get('/', 
	function (){
		?>
		<h1>Shoutbox!</h1>
		<form action="add" method="POST">
			<input type="text" name="name" id="name" value="" />
			<input type="text" name="message" id="message" value="" />
			<input type="submit" value="add" />
		</form>
		<div>
			<?php
				$shouts  = R::find('shouts', '1 = 1 order by id desc');
				foreach($shouts as $shout){
					?>
						<div> <a href="delete/<?php echo $shout->id;?>">X</a> <strong><?php echo $shout->name; ?>:</strong> <?php echo $shout->message; ?></div>
					<?php
				}
			?>
			
		</div>
		<?php
	}
);

?>
<!DOCTYPE html>
<html>
<head>
	<title>MVC shoutbox</title>
</head>
<body>
<?php

mvc\start();

?>
</body>
</html>

