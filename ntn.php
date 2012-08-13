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
  require_once('inc/libs.php');

 /*
  $type = 'group';
  
  $item = R::load('plot',2);

  $data = array(
    'name' => $item->name,
    'attributes' => R::attribute($item),
    'tags' => R::tag($item)
  );

  if( $type != "game" ) {
    $data['game'] = $item->game->id;
  }
  
  $data['characters'] = $item->sharedCharacter;
  $data['groups'] = $item->sharedGroup;
*/

  function setOwners($bean, $ownerType, $ids) {
    $owners = R::batch($ownerType,$ids);
    
    
    foreach($owners as $owner) {
    
$share =  'shared' . ucfirst($bean->type);

var_dump($owner);
    
      $owner->$share[] = $bean;
      R::store($owner);
    }
  }     
  
  $data = R::load('character',1);
  setOwners($data, 'player', array(1));
  R::store($data);
  
  var_dump($data->sharedPlayer);
  
?>