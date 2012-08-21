<?

  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require_once('inc/libs.php');
//-----------------------------------------------  

var_dump( R::find('character', ' id IN (?) ', array("1,2,3") ) );
?>