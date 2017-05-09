<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of load
 *
 * @author aromerov
 */


class app_load {
    
     public $NET = array();
     public $register = array();
     public $invoke;
    
     public function __construct() {
    
         
    
         
    foreach (glob("./*/*.php") as $filename)
    {
        
        if (!strpos($filename, 'load.php') !== false) {
            include $filename;          
         
        }
        
          $entity = str_replace(array('./','/','.php'),array('','.',''),$filename);
              
          $entity_code = str_replace('.','_',$entity);
            
           $this->register['soft'][] = $entity_code;
           
    }
    
    //$this->Lib('lib:function');
    
    $this->LoadFunctions(array('lib.function.hard','lib.function.load','lib.function.mail','lib.function.html','lib.function.image'));
    
   
    
          

    }
    
    public function Lib($ENTITY){
        
           
            
             $PATH = str_replace(':','/', $ENTITY);
        
            foreach (glob("./".$PATH."/*.php") as $filename)
    {
        
        if (!strpos($filename, 'load.php') !== false) {
            include $filename;          
         
        }
        
          $entity = str_replace(array('./','/','.php'),array('','.',''),$filename);
              
          $entity_code = str_replace('.','_',$entity);
            
           $this->register['ext'][] = $entity_code;
           
    }
    
        
        
    }
    
    
     public function Run(){
         
         $CORE = new app_core($this->NET);

         
         $HARD = new app_hard($this->NET);
         
         $CONFIG = new app_config($this->NET);
         
         $CACHE = new app_redis($this->NET);
        
         $SOFT =  new app_soft($this->NET);
         
         $VARIABLE = new app_variable($CORE, $SOFT, $CACHE, $HARD,$this->NET);
        
         
         $INSTRUCTION = new app_instruction($VARIABLE,$this->NET);
       
         
     }
     
     



     
     public  function LoadFunctions($functions){
        
         
         
         
        foreach($functions as $data){
            
            
        $this->register['functions'][] = $data;
        
        
        $this->LoadConfiguration($data);
        
         
         $entity_parts  = explode('.',$data);
         
         $string_array ='';
         
         foreach($entity_parts as $part){
     
             $string_array.='["'.$part.'"]';
             
         }
  
       $dataClass = str_replace('.','_',$data);
        
        eval('$action= new '.$dataClass.'($this->register);');
        
        eval ('$this->NET'.$string_array.' = $action;');
         
        }
         
     }
    
    
    
     public function LoadConfiguration($data){
         
         
         
         $_data = str_replace('.','/',$data);
         
         
         $filename = './'.$_data.'.php';
            
         include $filename;
        
    
         
         
         
     }
     
     
     public function PHP_PATH($entity){
         
         
         $_entity = str_replace('.','/',$entity);
         
         
         $_entity = './'.$_entity.'.php';
         
         
         return $_entity;
         
     }

}

