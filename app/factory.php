<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class app_factory{
    
public $class;
public $instances;
public $methods;
public $variables;
public $network;
    
public function __construct($NETWORK) {
    
   $this->network = $NETWORK;

}

public function SET($CLASS){
    
       $use =NULL;
       
       
    
       $this->class[$CLASS] = new ReflectionClass($CLASS);
    
      
    
    $reflectionParameters = $this->class[$CLASS]->getConstructor()->getParameters();
    
    
    
    $dependencies = [];
foreach( $reflectionParameters AS $param )
{
   
    
    // We instantiate the dependent class
    // and push it to the $dependencies array 
    if($param->getName()=='VARIABLE'){
        
        if(isset($this->instances['app_variable'])){
          $use=$this->instances['app_variable'];
        }
    }
    
    
    
    if($use!=NULL){
    $dependencies[] = $use;   
    }else{
    $dependencies[] = $param->getClass()->newInstance();
    }
}

// The last step is to construct our base object
// and pass in the dependencies array
$this->instances[$CLASS] = $this->class[$CLASS]->newInstanceArgs($dependencies);
    
    

     
    $methods = get_class_methods($this->instances[$CLASS]);

    
    $variables=get_class_vars(get_class($this->instances[$CLASS]));

   
    
      
    $this->methods[$CLASS] = $methods; 
    $this->variables[$CLASS]= $variables;
    
    
    return $this->instances[$CLASS];
}
    


}