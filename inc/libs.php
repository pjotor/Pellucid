<?
  // RedBean ORM
  require_once('libs/redbean/rb.php');
  //DB setup
  R::setup("mysql:host=localhost;
    dbname={$db->database}",$db->user,$db->password);
  // StampTE, template manager
  require_once('libs/stamp/StampTE.php');
  //MiMViC framework
  require_once('libs/mimvic/uvic.php');

  //authorization class
  require_once 'libs/auth/auth.php';
  $auth = new Auth();

  //Flash messaging class
  require_once('libs/class.flash-messages.php');
  $msg = new Flash();

  //Messaging class
  require_once('libs/class.pm.php');
  $pm = new Message();
?>