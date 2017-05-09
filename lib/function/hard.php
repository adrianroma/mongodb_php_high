<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of json
 *
 * @author aromerov
 */
class lib_function_hard {
    
    public $hash;
    public $scan=array();
    public $data=array();
    public $value = array();
    public $subEntity = array();
    public $file;
    public $container = array();
    //put your code here
    public function __construct($string = '0000000') {
  
    $this->hash = $string;     
        
    }
    
    public function LOAD($VARIABLE){
        
        
       $PATH = str_replace(':',"/", $VARIABLE);
        
         
         
       $PATH = './'.$PATH;
         
        
       $SCAN =$this->SCANING($PATH);
        
     
        foreach($SCAN as $KEY=>$VALUE){
          
           
           $_IN = explode(":",$KEY);
            
           unset($_IN[0]);
           
           $_IN = implode(":",$_IN);
           
           
           if(is_array($VALUE)){
               
               foreach ($VALUE as $_KEY=>$_VALUE){
                   
                   if (strpos($_VALUE, '.php') !== false) {
                   
                       $_VALUE = str_replace(".php","",$_VALUE);
                       
                       $this->container[]=$_IN.":".$_VALUE;
                   
                   }
                   
                   
               }
               
               
           }
           
           
           
            
        }
       
       
        
        
       return $this->container;
        
        
    }
    
    
    public function ENTITY_TO_PATH($ENTITY){
        
        
        $PATH = str_replace(':','/',$ENTITY);
        
        $PATH = './'.$PATH;
        
        return $PATH;
        
    }
    
    
    public function ENTITY_TO_ARRAY($ENTITY){
        
    $shardEntity = explode(":",$ENTITY);
    
    $SHARD = array();
    
    $shard ='';    
    
    foreach($shardEntity as $subEntity){
        
     $shard .='["'.$subEntity.'"]';   
        
        
    }
    

    eval('$SHARD'.$shard.'=1;');
        
    
    return $SHARD;
    
    
    }
    
    public function SET_ENTITY($ENTITY){
        
     $ENTITY_PARTS = explode(':',$ENTITY);
      
     $total = count($ENTITY_PARTS)-1; 
        
  
     $this->file = $ENTITY_PARTS[$total];
      
     unset($ENTITY_PARTS[$total]);
      
     
     $ENTITY = implode(':',$ENTITY_PARTS);
     
     
     
      $SHARD =  $this->ENTITY_TO_ARRAY($ENTITY);
  
        
      $this->SHARD($SHARD);
      
    }
    
    
    public function DELETE_UP_ENTITY($ENTITY) {
        
      
    
     $PATH = $this->ENTITY_TO_PATH($ENTITY);   
        
     if(is_dir($PATH)){   
         
    foreach(scandir($PATH) as $file) {
        if ('.' === $file || '..' === $file) continue;
        if (is_dir("$PATH/$file")) $this->DELETE_ENTITY("$PATH/$file");
        else unlink("$PATH/$file");
    }
    
    rmdir($PATH);
    return TRUE;
     }else{
    return FALSE;     
     }
    
     }
    
   
  
    
    public function GET_ENTITY_VALUE($ENTITY){
        
        $PATH = $this->ENTITY_TO_PATH($ENTITY);
        
        $PATH_FILE =$PATH.'.json';
        
        $VALUE = $this->OPEN($PATH_FILE);
        
        return $VALUE;
    }
    
    
    
    public function SET_ENTITY_VALUE($ENTITY,$VALUE){
        
        $PATH = $this->ENTITY_TO_PATH($ENTITY);
        
        $PATH_FILE =$PATH.'.json';        
        
        $this->SAVE($PATH_FILE, $VALUE);
        
    }
    
    
    public function DELETE_ENTITY($ENTITY){
        
        $PATH = $this->ENTITY_TO_PATH($ENTITY);
        
        $PATH_FILE =$PATH.'.json';        
        
        $this->DELETE($PATH_FILE);
        
    }
    
    
    public function SET_VALUE($VARIABLE,$SUB_ENTITY,$VALUE){  
    
         $string_array = str_replace(':','"]["',$SUB_ENTITY);
   
         eval('$VARIABLE["'.$string_array.'"]=$VALUE;');
                 
         return $VARIABLE;
        
    }
    
    
    public function DELETE_SUBENTITY($VARIABLE,$SUB_ENTITY){
        
         $string_array = str_replace(':','"]["',$SUB_ENTITY);
   
         eval('unset($VARIABLE["'.$string_array.'"])');
         
         return $VARIABLE;
    }
  
    
    
    public function GET_VALUE($VARIABLE,$NAME){
        
        $values = $this->VALUE($VARIABLE,$NAME); 
        
     
  
        
        
        $VALUE = array();
        
        foreach($values as $key=>$val){

            if (strpos($key,$name) !== false) {
           
  
                
                $VALUE[$key]=$val;
                
            }
  
        } 
        
        
        return $VALUE;
        
    }
    
    
    public function VALUE($VARIABLE){
    
        $this->SUB_ENTITY($VARIABLE);
        
        $subEntities = $this->subEntity;
        
        $this->subEntity=array();
        
        return $subEntities;
        
        
    }
    
    public function SUB_ENTITY($VARIABLE,$KEY=''){
        
        foreach($VARIABLE as $key=>$value){
            
       
            if(is_array($value)){
                if($KEY!=''){
                $_KEY = $KEY.':'.$key;
                }else{
                $_KEY =$key;    
                }
                $this->subEntity[$_KEY]=$value;
                $this->SUB_ENTITY($value,$_KEY);
            }else{
                
                if($KEY!=''){
                $_KEY = $KEY.':'.$key;
                }else{
                $_KEY =$key;    
                }
                $this->subEntity[$_KEY]=$value;
                
                
            }
            
        }
        
        
        
    }
    
    
    public function SCANING($PATH){
        
    $this->SCAN($PATH);
    
    $SCANING= $this->scan;
    
    $this->scan = array();
    
    return $SCANING;
    
    }
    
    
    public function SCAN($PATH){  
               
    $FILES = scandir($PATH);
    
    $_IN_FILES = array();
    
    foreach($FILES as $file){
        
        if(is_dir($PATH.'/'.$file)){
            
          
            if( $file !== "." && $file !== ".."){
                
                 $PATH_NEXT=$PATH."/".$file;
                
                 $_ENTITY = str_replace('/',':',$PATH_NEXT);
                 
                 $this->scan[$_ENTITY]=1;
                
                 $this->SCAN_ENTITY($PATH_NEXT);
                
            }
        }else{
            
           $_PATH = str_replace('/',':',$PATH);
          
                if(isset($this->scan[$_PATH])){
                     $files = $this->scan[$_PATH];
                     
                     if(is_array($files)){
                         
                         array_push($files,$file);
                         $this->scan[$_PATH]=$files;
                         
                     }else{
                        $this->scan[$_PATH]=array($file); 
                     }
                     
                    
                }else{
                    $this->scan[$_PATH]=array($file);
                }        
        }
        
    }
  
      
    
    } 
    
    
    public function SCAN_ENTITY($PATH){
        
        $this->SCAN($PATH); 
        
        $SCAN = $this->scan;
          
        $SCAN_VALUES = $this->SCAN_VALUES($SCAN);
 
        return $SCAN_VALUES;
      
    }
    
    
    public function SCAN_VALUES($SCAN){
       
       $_IN_SCAN = array();
       
       
       foreach($SCAN as $key=>$entities){
           
   
            $PATH = str_replace(":","/",$key);
            $FILES = scandir('./'.$PATH);
     
            
            $files = array();
          foreach($FILES as $file){    
              if(!is_dir($PATH.'/'.$file)){
                   if( $file !== "." && $file !== ".."){
            
               array_push($files,$file);
                
                    }
              }
                
          }
            
          $_IN_SCAN[$key]=$files;
    
       }
       
       
       return $_IN_SCAN;
       
   } 
   
   
    public function OPEN($PATH){
        
    if(file_exists($PATH))    
    {
    $string = file_get_contents($PATH);
    $JSON = json_decode($string, true);
    return $JSON;
    }else{
    return array();    
    }
    }
    
    
    public function SAVE($PATH,$ARRAY){
        
    $CONTENT = json_encode($ARRAY,JSON_PRETTY_PRINT);        
    file_put_contents($PATH, $CONTENT);
        
    }
    
    public function DELETE($PATH){
        
      if(file_exists($PATH)){ 
        unlink($PATH);
        return TRUE;
        }else{
        return FALSE;    
     }
        
    }
   
    
    public function SHARD($SHARD,$LAST=''){
        
        foreach($SHARD as $key=>$shard){
            
            
            if(is_array($shard)){
                
                $LAST = $LAST."/".$key;
                
                $Directory = $LAST;
                     
                if(!file_exists(".".$Directory)){
                    
                     mkdir(".".$Directory, 0777);   
                }
                    
                
                $this->SHARD($shard,$LAST);
                
            }else{
                
               
                 $Directory = $LAST."/".$key;
                 if(!is_dir(".".$Directory)){
                  mkdir(".".$Directory, 0777);  
                 }
                 
                $CONTENT=array("default"=>array("default"));
                $this->SAVE(".".$Directory."/".$this->file.".json",$CONTENT);
                
            }
            
            
        }
        
        
    }
    
    
    public function GET_TYPE($ENTITY_TYPE,$VARIABLE){
        
        
        
        
        
    }
   
    
       
}
