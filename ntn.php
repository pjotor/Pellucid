<?
  //Global settings
  require_once('inc/settings.php');
/*
  $db = (object) array(
    'database' => 'gossamer_test',
    'user' => 'root',
    'password' => ''
  );  
*/ 
  //DB & Template Libs
  require_once('inc/libs.php');
//-----------------------------------------------  
  
  
  $r = R::load('character', 1);
  
  $relationships = R::related( $r, 'character');
  
  foreach(  $relationships as $id => $bean ){   
    $rel = R::load('character_character', $id);
    $tags = R::tag( $rel );
    $attribs = R::attribute( $rel );
    
    var_dump( $bean->name );
    var_dump( $tags );
    var_dump( $attribs );
  }
?>