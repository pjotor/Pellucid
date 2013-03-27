<?php
class Engine {
  public function __construct() {
    
  }
  
  /****
  Helpers
  ****/  
  //Format and kill with JSONP
  private function jsonp($data, $kill = true) { 
    $callback = filter_input(INPUT_GET, "callback", FILTER_SANITIZE_STRING);
    $json = json_encode($data);
    $ret = ($callback) ? "$callback(" . $json . ");" : $json;
    if($kill){ 
      header("Content-type: application/json");
      die( $ret );
    }
    echo $ret;
  }
  
  
  //Strip out representational data from bean
  private function collectData($container) {
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
  private function tags($bean, $tags = null) {
    if( strlen($tags) > 0 ) {
      $tags = array_filter(array_map('trim', explode( ',', $tags )));
      if( count($tags) > 0 ) R::tag($bean, $tags);
    }
  }
        
  //Handle attributes
  private function attributes($bean, $attributes = array('type' => false, 'value' => false) ) {  
    if( is_array($attributes['type']) && is_array($attributes['value']) ){
      $attributes = array_filter(array_map('trim', array_combine( $attributes['type'], $attributes['value'] ))); 
      if( count($attributes) > 0 ) R::attribute($bean, $attributes);
    }
  }

  /****
  Engine
  ****/  
  //Main save action (this is more a POC than anything else)
  //POST for save/update, GET for get
  
  public function save( $p, $bean = false ) {
    $rNow = R::$f->now();
    
    if( !$bean ) {
      $bean = ( stristr(@$p['type'], 'group') ) ? 
        R::dispense('group') :  
        R::dispense($p['type']);
        
      $type = $p['type'];
    } else {
      $type = $bean->type;
    }  
    
    //No id, create new
    if (!$bean->id) {
      $bean->type = $type;
      $bean->updated = $rNow;
      $bean->created = $rNow;
      
      if( $type != "realation"){
        //Name is used for human readable representation in lists and are _not_ unique
        if( !isset($p['name']) ) die("missing name");
        $bean->name = $p['name'];  
      }
      
      //Every entety belongs to a game (unless it's a game, user or player)
      if( !in_array($type, array("game","user")) ) { 
		if( !isset( $p['game'] ) )
			$this->jsonp( array( "error" => "missing game" ) );
			
	  	$game = R::findOne('game',$p['game']);
		if( !$gamse ) $this->jsonp( array( "error" => "missing game" ) );
		
		$bean->game = $game;  
      }

      //Every player belongs to a user, and a user can have _one_ player
      if( $type == "player" ) { 
        if( !isset( $p['user'] ) ) $this->jsonp( array( "error" => "missing user" ) );
      }
	  	  
    } else {
      $bean->updated = $rNow;
      $overWrite = isset($p['overwrite']);
    }
    
    //Main save rutine
    switch ($type) {
      case  "game":
		if( !$bean->creator ) $bean->creator = $_SESSION['user_id'];
      break;
      
      case "player":
	    $user = R::findOne('user',$p['user']);
		if( !$user ) $this->jsonp( array( "error" => "missing user" ) );
		$bean->user = $user;
      break;
      
      case "character":
        if( !is_array( @$p['players'] ) ) {
          $this->jsonp( array( "error" => "missing player(s)") );
        }
        $bean->active = false;
     
        //This is soooo fugly!
        $owners = R::batch('player',$p['players']);
        foreach($owners as $owner) {
          $owner->sharedCharacter[] = $bean;
          R::store($owner);
        }
      break;

      case "realation":
        if( !isset( $p['character']['init'] ) || !isset( $p['character']['recip'] ) ) {
          $this->jsonp( array( "error" => "missing character(s)") );
        }
        
        $inits = R::batch('character', $p['character']['init']);
        $recipians = R::batch('character', $p['character']['recip']);

        foreach($inits as $init) {
          foreach($recipians as $recip) {
            $rel = R::load( 'character_character', R::associate( $init, $recip ) );
            $this->tags( $rel, @$p['tags'] );
            $this->attributes( $rel, array('type'=>@$p['attrib']['type'], 'value'=>@$p['attrib']['value']) );
          }
        }
 
        $this->jsonp( array( "stored" => $p['character']['init'] ) );
      break;      
      
      case "plot":
        $bean->active = false;
        
        if( isset($p['parent']) ) $bean->plot = R::load('plot', $p['parent']);
        
        if( is_array( @$p['characters'] ) ) {
          $owners = R::batch('character',$p['characters']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }            
        }
        
        if( is_array( @$p['group'] ) ) {
          $owners = R::batch('group',$p['group']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }            
        }
      break;

      case "group":
        if( is_array( @$p['players'] ) ) {
          $owners = R::batch('player',$p['players']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }             
        }
		
        if( is_array( @$p['characters'] ) ) { 
          $owners = R::batch('character',$p['characters']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }             
        }		
      break;    	  

      case "playerGroup":
        if( is_array( @$p['players'] ) ) {
          $owners = R::batch('player',$p['players']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }             
        }
      break;        
      
      case "characterGroup":
        if( is_array( @$p['characters'] ) ) { 
          $owners = R::batch('character',$p['characters']);
          foreach($owners as $owner) {
            $owner->sharedCharacter[] = $bean;
            R::store($owner);
          }             
        }
      break;          

      default:
      $this->jsonp( array( "error" => "no such method") );
    }
    
    if( isset($p['tags']) ) $this->tags( $bean, $p['tags'] );
    if( isset($p['attrib']) ) $this->attributes( $bean, array('type'=>$p['attrib']['type'], 'value'=>$p['attrib']['value']) );

    return (R::store($bean) != null) ? $bean : false;
  }

  public function get($type, $id = null) {
    $ids = $id ? is_array($id) ? $id : array($id) : false;
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
    
        if( $type != "game" && isset($item->game)) {
          $data['game'] = array(
            'id' => $item->game->id,
            'name' => $item->game->name
          );
        }        
    
      if ($item->id) {
        switch ($type) {
          case  "game":
//            $data['players'] = $this->collectData($item->ownPlayer);
            $data['chars'] = $this->collectData($item->ownCharacter);
            $data['groups'] = $this->collectData($item->ownGroup);
            $data['plots'] = $this->collectData($item->ownPlot);
            
          break;
          
          case "user":
            $data['player'] = $this->collectData($item->ownPlayer);
            $data['active'] = $item->active;

          break;
          		  
		  
          case "player":
            $data['chars'] = $this->collectData($item->sharedCharacter);
            $data['groups'] = $this->collectData($item->sharedGroup);
            $data['active'] = $item->active;

          break;
          
          case "character":
            $data['players'] = $this->collectData($item->sharedPlayer);
            $data['groups'] = $this->collectData($item->sharedGroup);
            $data['active'] = $item->active;
            $data['plots'] = $this->collectData($item->sharedPlot);
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
            $data['players'] = $this->collectData($item->sharedPlayer);

          break;      

          case "characterGroup":
            $data['characters'] = $this->collectData($item->sharedCharacter);
            $data['plots'] = $this->collectData($item->sharedPlot);

          break;               

          case "group":
            $data['players'] = $this->collectData($item->sharedPlayer);
            $data['characters'] = $this->collectData($item->sharedCharacter);
            $data['plots'] = $this->collectData($item->sharedPlot);
            $data['type'] = $item->type;             

          break;   
          
          case "plot":
            $data['characters'] = $this->collectData($item->sharedCharacter);
            $data['groups'] = $this->collectData($item->sharedGroup);
            $data['parent'] = $item->plot != null ?
              array(
                'id' => $item->plot->id,
                'name' => $item->plot->name
              ) : false;

          break;

          default:
          $this->jsonp( array( "error" => "no such method") );
          
        }
      }
      $rows[] = $data;
    }
	
    return $rows;
  }
}
?>