<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require 'vendor/autoload.php';

class lib_function_login {
    
    
    
        public $core;
    
    public $APP_ID='1283852075016765';
    public $APP_SECRET='89c85201916e61cf1aeca4928e37b024';
    public $APP_VERSION ='v2.8';
    
    //put your code here
    public function __construct() {


     
       
    }
    
    public function LOGIN(){
        
   $fb = new Facebook\Facebook([
  'app_id' => $this->APP_ID,
  'app_secret' => $this->APP_SECRET,
  'default_graph_version' => $this->APP_VERSION
   ]);
   
   
   //$helper = $fb->getRedirectLoginHelper();

 // $permissions = ['email']; // Optional permissions
 // $loginUrl = $helper->getLoginUrl('http://www.feedtofood.com/user_register', $permissions);

  //echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
   
   
//   $helper = $fb->getRedirectLoginHelper();
//
//$permissions = ['email']; // Optional permissions
//$loginUrl = $helper->getLoginUrl('https://example.com/fb-callback.php', $permissions);
//
//echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
/* 
  
  <a href="https://www.facebook.com/v2.8/dialog/oauth?client_id=1283852075016765&amp;state=36c23bfd551d7cceb02f278230860598&amp;response_type=code&amp;sdk=php-sdk-5.4.4&amp;redirect_uri=http%3A%2F%2Fwww.feedtofood.com%2Ffb-callback.php&amp;scope=email">Log in with Facebook!</a>{
    "error": "access_denied",
    "error_code": "200",
    "error_description": "Permissions+error",
    "error_reason": "user_denied",
    "state": "36c23bfd551d7cceb02f278230860598"
}
  
  
 */
  
   
  
        
    }
    
    
    
    
    
}