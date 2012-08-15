<?php session_start() ?>
<?php include('class.flash.php') ?>

<?php 
  $flash = new Flash(); 
  
 
?>

<html>
  <head></head>
  <body>
  <?php if ($flash->hasFlash('success')){ ?>
    <h1><?php echo $flash->getFlash('success') ?></h1>
  <?php } ?>
  This is index.php<br />
  <a href="contactus.php">Go to contact us</a>
  </body>
</html>