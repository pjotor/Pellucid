<?php
class Auth {
  private $_siteKey;

  public function __construct() {
    $this->siteKey = "88904dfadc657ffabae4f22046c2a3e9b2862e53367d640774e0b2881e0e5866";
    $this->start();
  }

  public function start() {
    $a = session_id();
    if(empty($a)) session_start();  
  }
  
  public function randomString($length = 32) {
    return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
  }

  protected function hashData($data) {
    return hash_hmac('sha512', $data, $this->_siteKey);
  }

  private function log($type, $id) {
    $activity = R::dispense('activity');
    $activity->user_id = $id;
    $activity->ip = $_SERVER['REMOTE_ADDR'];
    $activity->request = $_SERVER['REQUEST_TIME'];
    $activity->access = R::$f->now();
    $activity->type = $type;
    R::store($activity);  
  }

  public function createUser($email, $password, $is_admin = false) {			
  
    $user = R::findOne('user', ' email = ? ', array($email));

    if(!$user) {
      //Generate users salt
      $user_salt = $this->randomString();
          
      //Salt and Hash the password
      $password = $user_salt . $password;
      $password = $this->hashData($password);

      //Commit values to database here.
      $user = R::dispense('user');
      $user->email = $email;
      $user->created = R::$f->now();
      $user->admin = $is_admin;
      $user->active = true;
      $user->verified = false;    
      $user->session_id = false;
      $user->token = false;
      $user->salt = $user_salt;
      $user->password = $password;
      $user->code = $this->randomString(16);

      $created = R::store($user);
      
      if($created != NULL){
        $this->log("created", $created);
        return $user;
      }
    }
    return false;
  }

  public function login($email, $password) {
    //Select users row from database base on $email
    $user = R::findOne('user', ' email = ? ', array($email));

    if($user) {
    
      //Salt and hash password for checking
      $password = $user->salt . $password;
      $password = $this->hashData($password);
        
      //Check email and password hash match database row
      if( $user->password === $password ) {
      
        if((boolean) $user->active) {
        
          if((boolean) $user->verified) {
            //Email/Password combination exists, set sessions
            $token = $_SERVER['HTTP_USER_AGENT'] . $this->randomString();
            $token = $this->hashData($token);
              
            //Setup sessions vars
            $_SESSION['token'] = $token;
            $_SESSION['user_id'] = $user->id;
              
            $user->session_id = session_id();
            $user->token = $token;
            
            //Logged in
            if(R::store($user) != null) {
              $this->log("login", $user->id);
              return $user;
            } 
            
            $this->log("not logged in?", $user->id);
            return false;
          } else {
            $this->log("not verified", $user->id);
            return false;
          }
        } else {
          $this->log("not active", $user->id);
          return false;
        }
        $this->log("bad password", $user->id);
      }
    }
    //No match, reject
    return false;
  }
  
  //Returns a reset code for mail/link
  public function resetPassword($email) {
    $user = R::findOne('user', ' email = ? ', array($email));
    if($user) {
      $this->log("reset initialized" . $user->id);
      $user->code = $this->randomString(16);
      R::store($user);
      return $user->code;
    }
    return false;
  }

  public function validateReset($email,$code,$new_pass) {
    $user = R::findOne('user', ' email = ? AND code = ? AND active = ? AND verified = ? ', array($email, $code, true, true));
    if($user) {
      $user->password = $this->hashData($user->salt . $new_pass);
      $user->code = $this->randomString(16);
      R::store($user);
      return true;
    }
    return false;
  }
  
  public function checkSession() {
    if( !isset($_SESSION['user_id']) ) return false;
   
    //Load session user
    $user = R::load('user', $_SESSION['user_id']);
    if($user->id) {
      //Check ID and Token
      if(session_id() == $user->session_id && $_SESSION['token'] == $user->token) {
        //Id and token match, refresh the session for the next request
        $this->refreshSession($user);
        return true;
      }
    }
    return false;
  }

  private function refreshSession($user) {
    //Regenerate id
    session_regenerate_id();
      
    //Build the token
    $token = $_SERVER['HTTP_USER_AGENT'] . $this->randomString();
    $token = $this->hashData($token); 
      
    //Store in session
    $_SESSION['token'] = $token;
    
    $user->session_id = session_id();
    $user->token = $token;
    
    //Logged in
    if(R::store($user) != null) {
      return true;
    }   
    return false;    
  }
  
  public function verifyUser($email, $code) {
    $user = R::findOne('user', ' email = ? AND code = ? AND active = ? AND verified = ? ', array($email, $code, true, false));

    if(!$user) {
      $user = R::findOne('user', ' email = ? ', array($email));
      if(!$user) {
        $this->log("bad verification: " . $email, null);
      } else {
        $this->log("bad verification", $user->id);
      }
    } else {
      $user->active = true;
      $user->verified = true;
      if( R::store($user) != null ) {
        $this->log("verification", $user->id);
        $this->refreshSession($user);
        return $user;
      }
    }
    return false;
  }
  
  public function logout() {  
    if( isset($_SESSION['user_id']) ) {
      $this->log("logout", $_SESSION['user_id']);
    }
    $a = session_id();
    if(empty($a)) session_destroy();
    unset($_SESSION['user_id']);
  }
}
?>