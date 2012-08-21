<?php
class Message {
  public function __construct() {
    $classId = "b2a5879426a4709fffe14992258204ddbf5f8b80e9a7fa44cc39d11a4d4a021f";
  }
  
  private function ok() {
    return $auth->checkSession();
  }
  
  private function attributes($bean, $attributes = array('type' => false, 'value' => false) ) {  
    if( is_array($attributes['type']) && is_array($attributes['value']) ){
      $attributes = array_filter(array_map('trim', array_combine( $attributes['type'], $attributes['value'] ))); 
      if( count($attributes) > 0 ) R::attribute($bean, $attributes);
    }
  }

  public function get( $ids = array() ) {
    if( !$this->ok() ) return false;
    $ids = (is_array($ids)) ? $ids : array($ids);
    $m = R::find('message', ' id IN (?) AND recipient = ? AND deleted = false ', array(implode(",",$ids), $_SESSION['user_id']) );
    return $m;
  }

  public function getAll($userId = null) {
    if( !$this->ok() ) return false;
    //Admin super powers!
    $userId = is_null($user) ? $_SESSION['user_id'] : $user->admin ? $userId : $_SESSION['user_id'];
    $m = R::find('message', ' recipient = ? AND deleted = false ', array($userId) );
    return $m;
  }

  /*
   Valid Options are: { 
    'parent':'parent message id',
    'title':'title string', 
    'priv':'private boolean', 
    'tags':'comma separated tag string', 
    'attribs':{
      'type':'key array',
      'value':'value array'
    }
   }
  */
  public function send($recip, $message, $opts = null, $sender = null) {
    if( !$this->ok() ) return false;
    //Admin super powers!
    $sender = is_null($sender) ? $_SESSION['user_id'] : $user->admin ? $sender : $_SESSION['user_id'];
   
    $m = R::dispense('message');
    $m->user_id = $recip;
    $m->sender = $sender;
    $m->message = $message;
    $m->read = null;
    $m->created = R::$f->now();
    $m->deleted = false;
    if( !is_null($opts) ) {
      if( isset( $opts->parent ) ) $m->parent = R::load('message', $opts->parent);
      if( isset( $opts->private ) ) $m->priv = $opts->private;
      if( isset( $opts->title ) ) $m->title = $opts->title;
      if( isset( $opts->tags ) ) R::tag($m, array_filter(array_map('trim', explode( ',', $opts->tags ))) );
      if( isset( $opts->attribs->type ) && isset( $opts->attribs->value ) ) {
        $this->attributes($m, $opts->attribs->typ, $opts->attribs->value);
      }
    }
    return (R::store($m) != null) ? true : false;
  }

  public function read($ids) {
    if( !$this->ok() ) return false;
    $ids = (is_array($ids)) ? $ids : array($ids);
    $m = R::find('message', ' id IN (?) AND recipient = ? ', array(implode(",",$ids), $_SESSION['user_id']) );
    $now = R::$f->now();
    foreach($m as $message) {
      $message->read = $now;
    }
    return (R::storeAll($m) != null) ? true : false;
  }  
  
  public function delete($ids) {
    if( !$this->ok() ) return false;
    $ids = (is_array($ids)) ? $ids : array($ids);
    $m = R::find('message', ' id IN (?) AND recipient = ? ', array(implode(",",$ids), $_SESSION['user_id']) );
    return (R::trashAll($m) != null) ? true : false;
  }  
  
}
?>