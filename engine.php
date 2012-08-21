<?php
  /****
  Libs 'n' stuff
  ****/
  //Global settings
  require_once('inc/settings.php');
  //DB & Template Libs
  require_once('inc/libs.php');

  /****
  Helpers
  ****/  
  //Format and kill with JSONP
  function jsonp($data) { 
    $callback = filter_input(INPUT_GET, "callback", FILTER_SANITIZE_STRING);
    $json = json_encode($data);
    header("Content-type: application/json");
    die( ($callback) ? "$callback(" . $json . ");" : $json );
  }
  
  $my_string = filter_input(INPUT_GET, ‘my_string’, FILTER_SANITIZE_STRING);
  
  //Strip out representational data from bean
  function collectData($container) {
    $data = array();
    foreach($container as $item) {
      $data[] = array(
        'id' => $item->id,
        'name' => $item->name
      );
    } 
    return $data;
  }
  
  //Handle tags
  function tags($bean, $tags = null) {
    if( strlen($tags) > 0 ) {
      $tags = array_filter(array_map('trim', explode( ',', $tags )));
      if( count($tags) > 0 ) R::tag($bean, $tags);
    }
  }
        
  //Handle attributes
  function attributes($bean, $attributes = array('type' => false, 'value' => false) ) {  
    if( is_array($attributes['type']) && is_array($attributes['value']) ){
      $attributes = array_filter(array_map('trim', array_combine( $attributes['type'], $attributes['value'] ))); 
      if( count($attributes) > 0 ) R::attribute($bean, $attributes);
    }
  }
  
  function s  ($s) { return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_STRING); }
  function i  ($s) { return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_NUMBER_INT); }
  function e  ($s) { return filter_input(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_EMAIL); }
  function a_s($s) { return filter_input_array(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_STRING); }
  function a_i($s) { return filter_input_array(INPUT_GET | INPUT_POST, $s, FILTER_SANITIZE_NUMBER_INT); }
    
  /****
  Engine
  ****/  
  //Main save action (this is more a POC than anything else)
  //POST for save/update, GET for get
  if (isset($_POST['type'])) {
  
    $rNow = R::$f->now();
    $type = s('type');
    $id = i('id');
    $data = R::load($type, $id);
    
    if (!$data->id) {
      $data = ( stristr($type, 'group') ) ? 
        R::dispense('group') :  
        R::dispense( $type );

      $data->type = $type;
      $data->updated = $rNow;
      $data->created = $rNow;
      
      if( $type != "realation"){
        //Name is used for human readable representation in lists and are _not_ unique
        if( !@$_POST['name'] ) die("missing name");
        $data->name = s('name');  
      }
      
      //Every entety belongs to a game (unless it's a game)
      $game = i('game');
      if( $type != "game" && !strlen( $game ) ) { 
        jsonp( array( "error" => "missing game" ) );
      }

    } else {
      $data->updated = $rNow;
      $overWrite = isset(i('overwrite'));
    }

    //Extra percousion, $overWrite
    if( !$data->id || $overWrite ) {
      if( $type != "game" ) {
        $parent = R::load('game', $game);
        $data->game = $parent;
      }
    }

    switch ($type) {
      case  "game":
      break;
      
      case "player":
        $data->active = false;
      break;
      
      case "character":
        if( !is_array( @$_POST['players'] ) ) {
          jsonp( array( "error" => "missing player(s)") );
        }
        $data->active = false;
     
        //This is soooo fugly!
        $owners = R::batch('player',$_POST['players']);
        foreach($owners as $owner) {
          $owner->sharedCharacter[] = $data;
          R::store($owner);
        }
      break;

      case "realation":
        if( !isset( $_POST['character']['init'] ) || !isset( $_POST['character']['recip'] ) ) {
          jsonp( array( "error" => "missing character(s)") );
        }
        
        $inits = R::batch('character', $_POST['character']['init']);
        $recipians = R::batch('character', $_POST['character']['recip']);

        foreach($inits as $init) {
          foreach($recipians as $recip) {
            $rel = R::load( 'character_character', R::associate( $init, $recip ) );
            tags( $rel, @$_POST['tags'] );
            attributes( $rel, array('type'=>@$_POST['attrib']['type'], 'value'=>@$_POST['attrib']['value']) );
          }
        }
 
        jsonp( array( "stored" => $_POST['character']['init'] ) );
      break;      
      
      case "plot":
        $data->active = false;
        
        if( isset($_POST['parent']) ) $data->plot = R::load('plot', $_POST['parent']);
        
        if( is_array( @$_POST['characters'] ) ) {
          $owners = R::batch('character',$_POST['characters']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $data;
            R::store($owner);
          }            
        }
        
        if( is_array( @$_POST['group'] ) ) {
          $owners = R::batch('group',$_POST['group']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $data;
            R::store($owner);
          }            
        }
      break;

      case "playerGroup":
        if( is_array( @$_POST['players'] ) ) {
          $owners = R::batch('player',$_POST['players']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $data;
            R::store($owner);
          }             
        }
      break;        
      
      case "characterGroup":
        if( is_array( @$_POST['characters'] ) ) { 
          $owners = R::batch('character',$_POST['characters']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $data;
            R::store($owner);
          }             
        }
      break;          

      default:
      jsonp( array( "error" => "no such method") );
    }
    
    if( isset($_POST['tags']) ) tags( $data, $_POST['tags'] );
    if( isset($_POST['attrib']) ) attributes( $data, array('type'=>$_POST['attrib']['type'], 'value'=>$_POST['attrib']['value']) );

    jsonp( array( "stored" => R::store($data)) );
    
  } 
  
  if( isset($_GET['type']) ) {
  
    $ids = isset($_GET['id']) ?
      is_array($_GET['id']) ? $_GET['id'] : array($_GET['id']) : false;
    
    $type = $_GET['type'];
    
    if( stristr($type, 'group') ) {
      $where = ' type = ? ORDER BY updated DESC ';
      $type = 'group';
      $arg = $type;
    } else {
      $where = ' 1 = ? ORDER BY updated DESC ';
      $type = $type;
      $arg = "1";
    }
    
    $items = $ids ? R::batch($type, $ids) : R::find($type,$where, array($arg));

    $rows = array();

    foreach( $items as $item ) {
      $data = array(
          'name' => $item->name,
          'attributes' => R::attribute($item),
          'tags' => R::tag($item),
          'id' => $item->id, 
          'type' => $item->type
        );
    
        if( $type != "game" ) {
          $data['game'] = array(
            'id' => $item->game->id,
            'name' => $item->game->name
          );
        }        
    
      if ($item->id) {
        switch ($type) {
          case  "game":
            $data['players'] = collectData($item->ownPlayer);
            $data['chars'] = collectData($item->ownCharacter);
            $data['groups'] = collectData($item->ownGroup);
            $data['plots'] = collectData($item->ownPlot);
            
          break;
          
          case "player":
            $data['chars'] = collectData($item->sharedCharacter);
            $data['groups'] = collectData($item->sharedGroup);
            $data['active'] = $item->active;

          break;
          
          case "character":
            $data['players'] = collectData($item->sharedPlayer);
            $data['groups'] = collectData($item->sharedGroup);
            $data['active'] = $item->active;
            $data['plots'] = collectData($item->sharedPlot);
            $data['relations'] = array();
            
            $relationships = R::related( $item, 'character');
            foreach(  $relationships as $id => $bean ){   
              $rel = R::load('character_character', $id);
              $tags = R::tag( $rel );
              $attribs = R::attribute( $rel );
              $r = array(
                'character' => array( 'name' => $bean->name, 'id' => $bean->id ),
                'tags' => $tags,
                'attributes' => $attribs 
              );
              $data['relations'][] = $r;
            } 
            
          break;
          
          case "playerGroup":
            $data['players'] = collectData($item->sharedPlayer);

          break;      

          case "characterGroup":
            $data['characters'] = collectData($item->sharedCharacter);
            $data['plots'] = collectData($item->sharedPlot);

          break;               

          case "group":
            $data['players'] = collectData($item->sharedPlayer);
            $data['characters'] = collectData($item->sharedCharacter);
            $data['plots'] = collectData($item->sharedPlot);
            $data['type'] = $item->type;             

          break;   
          
          case "plot":
            $data['characters'] = collectData($item->sharedCharacter);
            $data['groups'] = collectData($item->sharedGroup);
            $data['parent'] = $item->plot != null ?
              array(
                'id' => $item->plot->id,
                'name' => $item->plot->name
              ) : false;

          break;

          default:
          jsonp( array( "error" => "no such method") );
          
        }
      }
      $rows[] = $data;
    }
    
    jsonp($rows);
  }
?>