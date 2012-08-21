<?
//Global settings
require_once('inc/settings.php');
$db = (object) array(
  'database' => 'gossamer_cms',
  'user' => 'root',
  'password' => ''
);  
//DB & Template Libs
require_once('inc/libs.php');
?>  
<html>
  <head>
    <title>RedBean CMS | Example</title>
  </head>
  <body color='black'>
    <h1>CMS Example</h1>
    
    <?php 
      $self = $_SERVER["PHP_SELF"]."?";

      $pid = isset($_GET["pid"]) && strlen($_GET['pid']) > 0 ? $_GET["pid"] : 1;

      if (!R::load("page",1)->id) {
        $page=R::dispense("page");
        $page->title="root";
        R::store($page);
      }
    ?>
    <?php 
    
      if(isset($_GET["type"]) && $_GET["type"]=="editpage"){
        $page = R::load("page",$_GET["id"]);
    ?>
    
  <form
  action="<?=$self?>type=savepage&id=<?=$_GET["id"]; ?>
  &pid=<?=$pid; ?>" method="post">
  <input type="text" name="title" value="<?= $page->title; ?>"  placeholder="title.."/>
  <br /><textarea name="intro" placeholder="descriptive paragraph.."><?= $page->intro; ?></textarea>
  <br /><textarea name="body" placeholder="main body.."><?= $page->body; ?></textarea>
  <br/><input type="text" value="<?= implode(",",R::tag($page)); ?>" name="tags" placeholder="tags, comma separated..">
  <br /><input type="submit" name="save" value="save" />
  </form>
    
    <?php 
    
    } else { 
  
      if(isset($_GET["type"]) && $_GET["type"]=="savepage"){
        $parent = R::load( "page", $pid);
        $page = R::load("page", $_GET["id"] );
        $page->import($_POST, "title,intro,body");
        $page->page = $parent;

        if( isset($_POST['tags']) && strlen($_POST['tags']) > 0 ) {
          $tags = array_filter(array_map('trim', explode( ',', $_POST['tags'] )));
          if( count($tags) > 0 ) R::tag($page, $tags);
        }

        if( isset($_POST['attribute']) ){
          $attributes = array_filter(
            array_map(
              'trim', 
              array_combine(
                $_POST['attribute']['type'], 
                $_POST['attribute']['value']
              )
            )
          ); 
          if( count($attributes) > 0 ) R::attribute($page, $attributes);
        }
        
        R::store($page);
      }
      

      $currentparent = R::load("page",$pid);
      
      $pages = $currentparent->ownPage;
      foreach($pages as $page): 
    ?>
    
  <br /><a href="<?=$self?>type=editpage&id=<?= $page->id; ?>
    &pid=<?= $_GET["pid"]; ?>">edit</a>
  <a href="<?=$self?>type=overview&pid=<?=$page->id;?>">beneath</a>
  <span><?=$page->title?></span>
  <br />
      
    <?php 
      endforeach; 
    ?>
    
  <br/>
    
    <?php 
      if (isset($_GET["pid"]) && $_GET["pid"] > 1): 
    ?>
    
  <a href="<?=$self?>type=overview&pid=<?=
  $currentparent->parent_id?>">page up</a>
      
    <?php 
      endif; 
    ?>
    
  <a href="<?=$self?>type=editpage&pid=<?=
  $currentparent->id?>&id=0">add new page</a> 
    
    <?php 
      } 
    ?>
  </body>
</html>