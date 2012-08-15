<?php 
  session_start();
  include('class.flash.php');
  if (isset($_POST['btnsubmit']))
  {
    // do other method here like validation
    
    // now after the method above create a flash message that it is succesful and redirect to homepage
    $flash = new Flash(); 
    $flash->setFlash('success','Your inquire have successfully submitted, try refreshing again and the message is gone');
    // now redirect to homepage
    header("Location: index.php");
  }
?>
<html>
  <head></head>
  <body>
  <form method="post" action="">
    Name: <input type="text" name="name" value="" /><br />
    Email: <input type="text" name="email" value="" /><br />
    Contact: <input type="text" name="contact" value="" /><br />
    <input type="submit" name="btnsubmit" value="Submit" />
  </form>
  </body>
</html>