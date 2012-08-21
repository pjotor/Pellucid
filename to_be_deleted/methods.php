<?php

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

mvc\get('/delete/:id', 
  function($p){
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
}
);

mvc\get('/', 
	function (){
    $data = array(
      "title" => "welcome"
    );
    mvc\render('views/first.php', $data);
	}
);

?>