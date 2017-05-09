<?php


class lib_function_load {
    
     public $NET = array();
     public $register = array();
     public $invoke;
    
     public function __construct() {
    
         

    
    
    
   
    
          

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

