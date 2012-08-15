<?php 
/** 
 * Flash-Messages 
 * 
 * Flash-Messages provide a way to preserve messages across different  
 * HTTP-Requests. This object manages those messages. 
 * 
 * Note: make sure you call session_start() in order to make this code work
 * 
 * @author: Bryan Jayson Tan
 * Date Created: August 19, 2010
 */ 
class Flash { 
  public function setFlash($name, $value)
  {
    $msg = serialize($value);
    $_SESSION['flash_message'][$name] = $msg;
  }
  public function getFlash($name, $default = null)
  {
    $msg = unserialize($_SESSION['flash_message'][$name]);
    if ($msg == "")
      return null;
    unset($_SESSION['flash_message'][$name]); // remove the session after being retrieve  
    return $msg;  
  }
  public function hasFlash($name)
  {
    if (!$_SESSION['flash_message'][$name])
    {
      return false;
    }
    return true;
  }
} 