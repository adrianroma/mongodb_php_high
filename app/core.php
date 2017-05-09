<?php
class app_core {

    public $hash;
    public $action;
    public $isRest;
    public $isData;
    public $lastUrl;
    public $allParameters;
    public $parameters=array();
    public $longParameters=array();
    public $ip;
    public $session;
    public $baseURL;
    public $url;
    public $currentURL;
    public $query = array();
    public $net;
    public $is;
    
    
    
 
    public function __construct($network='') {
        
        $keyhash = md5("elizabeth");
        $this->hash = $keyhash;
        
        $this->network = $network;
        
        $this->currentURL = $this->Action();
        
        $this->query = $this->QUERY();
        
        
       
    }
    
    public static function HELLO(){
       
        //return $this->network;
        
    }

    /*
     * Generate on Fly Methods on PHP
     * 
     * 
     */

    public function __call($method, $args) {
        if (isset($this->$method)) {
            $func = $this->$method;
            return call_user_func_array($func, $args);
        }
    }
    
    
     /*
     * Get Current Url On Page
     * 
     * @param $type full or short URL
     * 
     */
    
    public function getURL($type = '') {
        if ($type == 'full') {
            $pageURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        } elseif($type == 'request') {
            $pageURL = $_SERVER[REQUEST_URI];
        }else{
            $pageURL = "http://$_SERVER[HTTP_HOST]/";
        }
        return $pageURL;
    }
    
    
    public function getBaseUrl(){
        
         $this->url = $this->getURL();
         
         $url =  str_replace(array('http://','/'),array('',''),$this->url);
        
         $this->baseURL=$url;
         
         return $url;
        
        
        
    }
    
    public function checkPageURL($word){
        
        
        if (strpos($this->action,$word) !== false) {
            
               if($this->action==$word){
                 return 1;  
               }else{
                 return 2;  
               }
            
        }else{
            return 0;
        }
        
        
    }
    
        /*
     * Get TRUE Request and Set Parameters;
     * 
     * 
     */

    public function Action() {
         
        $this->ip = $this->getIpClient();

        if ($this->action == '') {
          
            $urlstring = $_SERVER['REQUEST_URI'];
       
            if (strpos($urlstring, '/rest/') !== false) {
                 $urlstring = str_replace('/rest/','/',$urlstring);
                $this->isRest = TRUE;
                $this->isData= FALSE;
            } else {
                $this->isRest = FALSE;
                $this->isData = FALSE;
            }
            
                
            
            
            

            if (strpos($urlstring, '?') !== false) {
                
                $this->isData = TRUE;
                $this->clearURL = 0;
                $fullURL = explode('?', $urlstring);
                $urlstring = $fullURL[0];
                $this->allParameters = urldecode($fullURL[1]);
                $parameterFull = explode('&', $fullURL[1]);
                
                foreach ($parameterFull as $key => $parameter) {
                    if (strpos($parameter, '=') !== false) {
                        
                        $parameterData = explode('=', $parameter);
                        
                        $this->parameters[$parameterData[0]] = $parameterData[1];
                    } else {
                       
                        $this->longParameters[$key] = $parameter;
                    }
                }
            } else {
                $this->clearURL = 1;
            }

            $urlstring = substr($urlstring, 1);
            
            if ($urlstring == '') {
         
                $urlstring = '/';
            }
         
            $this->action = urldecode($urlstring);
            
            if($urlstring=='admin'){
                if (session_status() == PHP_SESSION_NONE) {
                session_start();
                $cookie_name = "key";
                $key = $this->generateRandomString(12);
                setcookie($cookie_name,$key,NULL, "/"); // 86400 = 1 day
                $_SESSION['key'] = $key;
                }

            }else{
                if (session_status() == PHP_SESSION_NONE) {
                session_start();   
                $cookie_name = "key";
                $key = $this->generateRandomString(12);
                setcookie($cookie_name,$key,NULL, "/"); // 86400 = 1 day
                $_SESSION['key'] = $key;
                }
            }
           

        } else {
            
            $urlstring = $this->action;
        }
  
        return $urlstring;
    }

    
    public function QUERY($_QUERY=''){
        
          
        
            if($_QUERY==''){
                $_QUERY=$this->action;
            }
        
          
            
                $QUERY = explode(".",$_QUERY);
    
     
           
                
             if(count($QUERY)>=3){
            
             $data = $this->CONVERT($QUERY);
               
             return array('type'=>'instruction','query'=> $data);
             
             }else{            
            
             return  $this->TYPE_QUERY($_QUERY);
             }   
            
             
        
    }
     public function TYPE_QUERY($QUERY){
        
 
     
     if(ctype_alnum($QUERY)) {
        
        return array('type'=>'text','query'=>array($QUERY));
       
        
    }else{
     if (preg_match('/[\'^\/£$%&*()}{@#~?><>,|=+¬-]/', $QUERY))
     {
          
          $_QUERY = explode(' ',$QUERY);
         
          $DATA = array();
          
          $VALUE = array();
          
          if(count($_QUERY)>1){
              
              foreach($_QUERY as $data_query){
                  
                  $data_query = '('.$data_query.')';
                                
                  $data_query = str_replace('=','=>',$data_query);
                 
                   $data_query = str_replace(array('=>(','))'),array('|','!'),$data_query);
                  
                  $data_query = str_replace(array('(',')','=>',','),array('("','")','"=>"','","'),$data_query);
                  
                  
                   $data_query = str_replace(array('|','!',')"'),array('"=>array("','"))',')'),$data_query);
                  
                 
                   
                   
                   
                   try{
                   
                  // echo 'array_push($DATA,array".$data_query.");';     
           
                   $result = @eval('array_push($DATA,array'.$data_query.'); return TRUE;');
                  
                  
                   }catch(ParseError $e){
                       
                   
                   }
                  
                 
              }
              
          
              
              foreach($DATA as $data){
                  
                  
                  foreach($data as $key=>$value){
                      
                      $VALUE[$key]=$value;
                      
                  }
                  
              }
              
        
            return array('type'=>'data','query'=>$VALUE);  
              
          }
          
          if (preg_match('/[\'^\/]/', $QUERY)){
         $PARTS = explode('/',$QUERY);
          
           if($PARTS[0]==''&&$PARTS[1]==''){
            return array('type'=>'section','query'=>array('*'));   
           }else{
            return array('type'=>'section','query'=>$PARTS);
           }
          } 
          
          if (preg_match('/[\'^|]/', $QUERY)){
              
          $SPLIT = explode('|',$QUERY);
         
            return array('type'=>'split','query'=>$SPLIT);
         
          } 
          if (preg_match('/[\'^@]/', $QUERY)){
              
          $ORDER = explode('@',$QUERY);
          
            return array('type'=>'order','query'=>$ORDER);
          
          }
          
          
           if(preg_match('/[\'^&]/', $QUERY)){
            
          $AND = explode('&',$QUERY); 
            
            return array('type'=>'and','query'=>$AND);
              
          }
          
          
          if(preg_match('/[\'^=]/', $QUERY)){
            
          $AND = explode('=',$QUERY); 
            
            return array('type'=>'equal','query'=>$AND);
              
          }
          
         if(preg_match('/[\'^-]/', $QUERY)){
            
          $PARTS = explode('-',$QUERY); 
            
            return array('type'=>'part','query'=>$PARTS);
              
          }
             
         
       
    // one or more of the 'special characters' found in $string
     }else{
         
        $QUERY = explode(' ',$QUERY);
         
        if($QUERY[0]==''){
        return array('type'=>'section','query'=>array('*'));    
        }else{
               
        
        return array('type'=>'text','query'=>$QUERY);
        }
     }
    } 
        
    }
    
    
    
    
    /*
     * Get Current Ip Client
     * 
     * @return string ip adress
     */

    public function getIpClient() {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $this->ip = $_SERVER['REMOTE_ADDR'];
        }
        return $this->ip;
    }
    
    
    public function Redirect($url, $permanent = false)
    {
    if (headers_sent() === false)
    {
    	header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
    }
    
    

    
    
    public function compare($A,$B){
        
        
        
        
        
    }
    public function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
    
    public function CONVERT($DATA){
        
        $_data = array();
        
        foreach($DATA as $data){
            
          $element = explode('=',$data);
           
          if(isset($element[1])){ 
          $_data[$element[0]]=$element[1];
          }else{
          $_data[$element[0]]='';
          }
        }
        
        return $_data;
        
    }
    
    

}


