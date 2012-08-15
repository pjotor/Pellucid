<?

  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require_once('inc/libs.php');
//-----------------------------------------------  

  if( isset($_GET['login']) && strlen(@$_POST['login_email'] . @$_POST['login_password'])) {
    $user = $auth->login($_POST['login_email'], $_POST['login_password']);
    
    (boolean) $user ? 
      $msg->add('i', "you are logged in as " . $user->email . ((boolean) $user->admin === true ? ", and you are admin!" : ".")) : 
      $msg->add('e', 'Login failed.');
            
  } else if( isset($_GET['create']) && strlen(@$_POST['new_email'] . @$_POST['new_password'])) {
    $user = $auth->createUser($_POST['new_email'], $_POST['new_password']);  
    (boolean) $user ? 
      $msg->add('i', "activationcode sent to: " . $user->email) : 
      $msg->add('e', 'failed in crating user');
                      
  } else if( isset($_GET['verify']) && strlen(@$_POST['verify_email'] . @$_POST['new_verify'])) {
    $verified = $auth->verifyUser($_POST['verify_email'],$_POST['new_verify']); 
    (boolean) $verified ? 
      $msg->add('i', "your email was verified!") : 
      $msg->add('e', 'verification failed.');
                          
  } else if( isset($_GET['logout']) ) {
    $auth->logout();
  }

  echo $msg->display();

  if (!isset($_SESSION['user_id'])) {
?>
<form action="?create" method="POST">
  create user<br/>
  <input type="text" name="new_email" placeholder="email">
  <input type="password" name="new_password" placeholder="password">
  <input type="submit" value="create"><br/>
</form>  
<form action="?verify" method="POST">
  verify<br/>
  <input type="text" name="verify_email" placeholder="email">
  <input type="text" name="new_verify" placeholder="verification code">
  <input type="submit" value="verify!"><br/>  
</form> 
<form action="?login" method="POST">
  login<br/>
  <input type="text" name="login_email" placeholder="email">
  <input type="password" name="login_password" placeholder="password">
  <input type="submit" value="login"><br/>
</form>   
<?php
  } else { 
    $logged_in = $auth->checkSession();
    if(!$logged_in){
      //Bad session, ask to login
      echo "bad session!";
      $auth->logout();
//      header( 'Location: ntn.php' );
    } else {
      echo "logged in!<br/>";
      echo "<a href=\"?logout\">logout</a><br/>";
    }
  }
?>