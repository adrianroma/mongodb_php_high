<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class app_variable{
    
    public $core;
    public $soft;
    public $cache;
    public $hard;
    public $main_entity;
    public $spell;
    private $network;
    private $net;
    private $data;
    private $id;
    private $mail;
    private $variable;
    private $node;
    
    public function __construct(app_core $CORE,app_soft $SOFT,app_redis $CACHE,app_hard $HARD,$NETWORK) {
   
    date_default_timezone_set('America/Mexico_City');   
    $this->core = $CORE;
    $this->soft = $SOFT;
    $this->cache = $CACHE;
    $this->hard = $HARD;
    $this->network = $NETWORK;
    
  
    

    $this->GET_CONFIG();
    
    

    }
    
    public function GET_CONFIG(){
        
        
       
         if($this->soft->CHEK_ENTITY('base_config')){
             
              // $this->soft->DELETE_ENTITIES('base_config');
              $config=$this->soft->GET_ENTITY_VALUE_ID('base_config','0'); 
              $this->id =$config['id'];
              $this->net= $config['network'];
              $this->data = $config;
  
             
         }else{
              $config =$this->network['lib']['function']['hard']->GET_ENTITY_VALUE('6737438947:config',100);
              
              foreach($config as $conf){
              $this->soft->SET_ENTITY_VALUE('base_config',$conf,'id');
              }
         }
         
         
          if($this->soft->CHEK_ENTITY('base_data')){
              
               $this->variable=$this->soft->GET_ENTITY_VALUE_ID('base_data','0'); 
               
              
          }else{
              $data =$this->network['lib']['function']['hard']->GET_ENTITY_VALUE('6737438947:data',100);
               foreach($data as $dat){
              $this->soft->SET_ENTITY_VALUE('base_data',$dat,'id');
              }
          }
             
           
         
        
    }
    
    public function ADD_CLIENT($nick,$region,$secret,$time){
        
        $date = date('H:i:s');
        $total = 0;
        $user = $nick.'@'.$date.'@'.$region;
        
        $this->main_entity = $user;
        $this->user = $user;
        
        $hash = hash('sha256',$this->main_entity.'.client');
        
        if(!isset($_COOKIE['entity'])){
      
        
        $data = $this->data['user'];
       
        
        $data['time'] = $date;
        if(isset($data['update'])){
        $data['update'] = 1+ $data['update'];
        }
        $data['data']['key'] =$hash;
        $data['data']['secret'] =$secret;
        setcookie('entity',$user);
        $_COOKIE['entity'] = $user;
        $this->cache->setData($user,$data);
        $this->cache->timeOut($user,$time);
 
        
        $object = $this->cache->getData($user);
         
       
        
        $this->cache->set[$user] = $object;
        
     
        
        
        }else{
  
        $user = $_COOKIE['entity'];

        
        $data=$this->cache->getData($user);    
            
        if(count($data)==0){
       
        $data = $this->data['user'];
    
        
        $data['time'] = $date;
        if(isset($data['update'])){
        $data['update'] = 2+ $data['update'];
        }
        $data['data']['key'] =$hash;
        $data['data']['secret'] =$secret;
           
        $this->cache->setData($user,$data);
        $this->cache->timeOut($user,$time);
        
          
        $user  =  $_COOKIE['entity'];
        $object = $this->cache->getData($user);
         
        
        
        $this->cache->set[$user] = $object;
        }
        }
        
        
    }
    
    
    public function DELL_CLIENT(){
           
        if(isset($_COOKIE['entity'])){
           $this->cache->delete($_COOKIE['entity']);
           unset($_COOKIE['entity']); 
           setcookie('entity', null, -1, '/');
           return TRUE;
        }else{
           return FALSE; 
        }
        
        
    }
    
    
    
    public function GET_CACHE_DATA($key='*'){
        
      
        if(isset($_COOKIE['entity'])){
        $user  =  $_COOKIE['entity'];
        $object = $this->cache->getData($user);
      
        }
        
       
       
        if($key=='*'){
        if(isset($object['data'])){    
        return $object['data'];
        }else{
        return array();
        }
        }else{
            
         $_key_part = explode(':',$key);    
           
          $instruct='';
        
        foreach($_key_part as $kyprt){
            
        $instruct .='["'.$kyprt.'"]';    
            
          }
      
          eval('if(isset($object["data"]'.$instruct.')){ $data = $object["data"]'.$instruct.'; }else{ $data=""; }');
       
          return $data;
        }
        
    }
    
    
    public function SET_CACHE_DATA($key='*',$data=''){
                
        $user  =  $_COOKIE['entity'];
        $object = $this->cache->getData($user);   
        if($key!='*'){
        $_key_part = explode(':',$key);
     
        $instruct='';

        foreach($_key_part as $kyprt){
            
        $instruct .='["'.$kyprt.'"]';    
            
        }
    
        eval('$object["data"]'.$instruct.'=$data;');
        try{
        $this->cache->setData($user,$object);
        return TRUE;
        }catch(ErrorException $e){     
            return $e;            
        }
        
        }else{
        
        if($data!=''){    
        eval('$object["data"]=$data;');
         try{
        $this->cache->setData($user,$object);
         }catch(ErrorException $e){
            return $e;  
         }
        return TRUE;
        }else{
        return FALSE;    
        }    
            
        }
        
    }
    
    
    public function GET_ALL(){
                
         $VARIABLES = $this->soft->GET_ALL_ENTITIES();

         return $VARIABLES;
    }
    
    
    public function DELETE_ENTITY($ENTITY){
        
        $this->soft->DELETE_ENTITY($ENTITY);
     
    }
    
    
    public function DELTE_ALL(){
        
        $ALL =  $this->GET_ALL();
        
        foreach($ALL as $VARIABLE_ENTITY){
            
            $this->DELETE_ENTITY($VARIABLE_ENTITY);
            
        }
        
    }
    

    public function GET_ALL_TYPE_VALUE(){
        
        return array('variable','static','cache','node','process');
     
    }

 
    public function SEARCH_VARIABLE_VALUE($VARIABLE,$SEARCH,$ATTRIBUTE='value'){
            
        
           $_PART = $this->PARTS($VARIABLE);
           
          $RESULT = $this->soft->SEARCH_ENTITY_VALUE($_PART['entity'],$SEARCH,$ATTRIBUTE);
        
          return $RESULT;
          //var_dump($RESULT);
          
    }

    
    public function SEARCH_VARIABLE_VALUES($VARIABLE,$SEARCH)
    {
        
          $_PART = $this->PARTS($VARIABLE);
           
          
          
          $RESULT = $this->soft->SEARCH_ENTITY_VALUES($_PART['entity'],$SEARCH);
        
          return $RESULT;
        
        
    }
    
    
    public function WEIGHT_VARIABLE($VARIABLE){
        
         $TYPE =$this->TYPE_VARIABLE($VARIABLE);
         if($TYPE['variable']=='full'){
            $Size = $this->soft->GET_ENTITY_SIZE($VARIABLE);
           return array('size'=>$Size['avgObjSize']);
             
         }else{
             
           $VAL = $this->VARIABLE($VARIABLE);
           
           return  array('items'=>count($VAL));
            
             
         }
         
        
    }
    
    public function SHARD_VARIABLE($VARIABLE,$BY){
   
            $VL = $this->VARIABLE_VALUE($VARIABLE);
 
            
            $SHARD = array();
            
            $TYPE = $this->TYPE_VARIABLE($VARIABLE);
    
            
            if($TYPE['variable']=='full'){
                
                $ALL = $this->VARIABLE($VARIABLE);
                
                foreach($ALL as $variable){
                    
                     if($BY=='entity'){
                       
                         $SHARD[$variable['entity']][$variable['id']]=$variable;
                     
                     }elseif($BY=='set'){
                         
                         $SHARD[$variable['set']][]=$variable['id'];
                         
                     }elseif($BY=='state'){
                         
                         $SHARD[$variable['state']][]=$variable['id'];
                         
                     }elseif($BY=='type'){
                         
                         $SHARD[$variable['type']][]=$variable['id'];
                         
                         
                     }
                    
                }
                
              
               $UP_VARIABLE = $this->UP_VARIABLE($VARIABLE);
               
               
               
               $ENTITIES_ID=array();
               
               foreach($SHARD as $KEY=>$_VARIABLE){
                   
                    foreach($_VARIABLE as $key=>$_variable){
                      
                          unset($_variable['_id']);
                          $entity_id = explode(':',$key);
                          
                          $entity = $VARIABLE.':'.$entity_id[0];
                        
                          if(!in_array($entity,$ENTITIES_ID)){
                          $ENTITIES_ID[]=$entity;
                          }
                          
                          if(!$this->soft->CHEK_ENTITY($entity)){
                          $this->soft->SET_ENTITY_VALUE($entity,$_variable,'id');
                          }
                        
                    }
               }
        
               
               foreach($UP_VARIABLE as $ky=>$up_variable){
                   
                      
                      $UP_VALUES =  $this->GET_VARIABLE_VALUE_BY_ID($up_variable);
                      
                
                   
                      foreach($UP_VALUES as $key_up=>$up_values){
                          
                          
                          foreach($up_values as $key=>$value){
                              
                              if($value==$VARIABLE){
                                  
                                  unset($up_values[$key]);
                                  break;
                              }
                              
                          }
                          
                         
                          
                          foreach($ENTITIES_ID as $entity_id){
                              
                              array_push($up_values,$entity_id);
                              
                          }
                          
                           $UP_VALUES[$key_up]= $up_values;
                           
                          
                          
                      }
                      
                      
                      foreach($UP_VALUES as $_id=>$_up_values){
                          
                           $this->SET_VARIABLE_VALUE_BY_ID($_id,$_up_values);
                          
                          
                      }
                       
                      //$this->SET_VARIABLE_VALUE_BY_ID($up_variable, $VALUE);

                   
               }
               
               if($this->soft->CHEK_ENTITY($VARIABLE)){
               $this->soft->DELETE_ENTITY($VARIABLE);
               }
               
               
                
            }elseif($TYPE['variable']=='simple'){
                
               
                
               $VALUE = $this->VARIABLE_VALUE($VARIABLE);
                
               foreach($VALUE as $value){
                   
                 
               } 
                
                
            }
            
            
            
           
            
            
        
    }

    
    public function UP_VARIABLE($VARIABLE){
        
        
         $variable = array();
         $PARTS = $this->PARTS($VARIABLE);
       
         $TYPE = $this->TYPE_VARIABLE($PARTS['entity']);
   
         
         
         if($TYPE['variable']=='full'){
             
             $VAR=  $this->VARIABLE($PARTS['entity']);
             
             foreach($VAR as $var){
                 
                 $variable[]=$var['id'];
                 
             }
         }elseif($TYPE['variable']=='simple'){
             
               
              $variable[] = $PARTS['entity'];
             
         }
         
         
         return $variable;
    }
    
    public function SUB_VARIABLE($VARIABLE){
    
          $variable = array();
           $VAR= $this->VARIABLE($VARIABLE);
        
           foreach($VAR as $var){
               
                  foreach($var['value'] as $value){
                      
                       if($this->IS_VARIABLE($value)){
                           
                           $variable[]= $value;
                           
                       }
                      
                  }
               
           }
        
        return $variable;   
    }
    

    public function SET_VARIABLE($ENTITY,$SET,$STATE,$TXT,$VALUE,$DATA=array()){
        
        
            $PART=explode(":",$ENTITY);
            if(count($PART)==1){
            $VALUE=array(
            "id"=>$ENTITY.":".$SET.":".$STATE,
            "entity"=>$ENTITY,    
            "set"=>$SET,
            "state"=>$STATE,
            "is"=>'dynamic',    
            "text"=>$TXT,
            "value"=>$VALUE,
            "type"=>'variable',    
            "rate"=>"90",
            "sort"=>array("0"),
            "reference"=>array("*")   
            );
            
            if(count($DATA)!=0){ 
              $VALUE = array_merge($VALUE,$DATA);
            }
    
           $this->soft->SET_ENTITY_VALUE($ENTITY, $VALUE,'id');
            }else{
             
              $_PART = $this->PARTS($ENTITY); 
     
                
             $VALUE=array(
            "id"=>$_PART['id'].":".$SET.":".$STATE,
            "entity"=>$_PART['id'],    
            "set"=>$SET,
            "state"=>$STATE,
            'is'=>'dynamic',     
            "text"=>$TXT,
            "value"=>$VALUE,
            "type"=>'variable',     
            "rate"=>"90",
            "sort"=>array("0"),
            "reference"=>array("*")     
            );
              
            if(count($DATA)!=0){ 
              $VALUE = array_merge($VALUE,$DATA);
            }
             
              
            $this->soft->SET_ENTITY_VALUE($_PART['entity'], $VALUE,'id');
            
            
            
            }
            
            $this->ADD_VARIABLE($ENTITY);
    }
    
    public function TREE_VARIABLE($VARIABLE){
        
        
             

             if($this->CHECK_VARIABLE($VARIABLE)){
      
                $TREE_UP =explode(":",$VARIABLE);                 
                $LAST = (count($TREE_UP))-1;
                unset($TREE_UP[$LAST]);                
               $VARIABLE_UP  = implode(":",$TREE_UP);  
               
               
               
               if($this->CHECK_VARIABLE($VARIABLE_UP)){
                   
                   $TYPE=$this->TYPE_VARIABLE($VARIABLE_UP);
                   
                   if($TYPE['variable']=='full'){
                   
                       $VARIABLE_UP_PART = explode(':',$VARIABLE_UP);
                       
                       $LAST_UP = (count($VARIABLE_UP_PART))-1;
                       
                         
                       
                      // $this->GET_VARIABLE($VARIABLE_UP.':'.$VARIABLE_UP,$VARIABLE_UP ,$SET,'true');
                   
                   
                   }else{
                       
                   }
                   
                   
               }else{
                   
                   $VARIABLE_PART = explode(":",$VARIABLE_UP);
                   
                   
                   $this->SET_VARIABLE($VARIABLE_UP, $VARIABLE_UP,"true",$VARIABLE_UP, array($VARIABLE));
                        
              
                   
                   
               }
                   
              
               
               
               
                      
//                      if(!$this->CHECK_VARIABLE($VARIABLE_UP)){                      
//                              $UP_TREE = explode(":",$VARIABLE_UP);
//                              $LAST_UP = (count($UP_TREE))-1;
//                              $TXT = $UP_TREE[$LAST_UP];
//                              unset($UP_TREE[$LAST_UP]);                              
//                              $VARIABLE_SET = implode(":",$UP_TREE);                              
//                              if($VARIABLE_SET==""){
//                                  $VARIABLE_SET=$VARIABLE;
//                              }                              
//                              $this->SET_VARIABLE($VARIABLE_UP,$VARIABLE_SET,"true",$TXT,array($VARIABLE));                          
//                      }else{
//                          
//                              $UP_TREE = explode(":",$VARIABLE_UP);
//                              $LAST_UP = (count($UP_TREE))-1;
//                              
//                              unset($UP_TREE[$LAST_UP]);                              
//                              $VARIABLE_SET = implode(":",$UP_TREE);                              
//                              if($VARIABLE_SET==""){
//                                  $VARIABLE_SET=$VARIABLE;
//                              }                 
//                            
//                          
//                          
//                          
//                          
//                              $VARIABLE_UP_VALUE = $this->GET_VARIABLE($VARIABLE_UP.':'.$VARIABLE_UP,$VARIABLE_SET,"true"); 
//                              
//                              echo "<pre>";
//                              var_dump($VARIABLE_UP_VALUE);
//                              echo "</pre>";
//                      }
                          
             }else{
                 
                               return array("variable"=>"not found");
             }

    }
    
    
    public function ROOT_VARIABLE(){
        
        
        
    }
    
    
    public function TYPE_VARIABLE($VARIABLE){
        
         $_VARIABLE = $this->PARTS($VARIABLE);
        
         if($_VARIABLE['entity']==$VARIABLE){
             
          $VALUE = $this->soft->GET_ENTITY_VALUE($_VARIABLE['entity']);
          if(count($VALUE)!=0){
              $TYPE = array('variable'=>'full');
          }else{
              $TYPE = array('variable'=>'process');
          }
          
         }else{
             
          
          $VALUE = $this->soft->GET_ENTITY_VALUE_BY_ID($_VARIABLE['entity'],'entity',$_VARIABLE['id']);
         
          if(count($VALUE)!=0){
              $TYPE = array('variable'=>'simple');
          }else{
              
              $VALUE = $this->soft->GET_ENTITY_VALUE($VARIABLE);
              
              if(count($VALUE)!=0){
              $TYPE = array('variable'=>'full');
              }else{
              $TYPE = array('variable'=>'empty');    
              }
              
              
          }
              
          
          
          
             
         }
        
        
        return $TYPE;
    }
    
    public function GET_VARIABLE_BY_ID($VARIABLE_ID){
        
        $IDS = explode(':',$VARIABLE_ID);
        
        return $this->GET_VARIABLE($IDS[0],$IDS[1],$IDS[2]);
        
        
    }
    
    public function GET_VARIABLE_VALUE_BY_ID($VARIABLE_ID){
        
         $IDS = explode(':',$VARIABLE_ID);
         
         return $this->GET_VARIABLE_VALUE($IDS[0],$IDS[1],$IDS[2]);
    }
    
    
    public function SET_VARIABLE_VALUE_BY_ID($VARIABLE_ID,$VALUE){
        
         $IDS = explode(':',$VARIABLE_ID);
         
         $this->SET_VARIABLE_VALUE($IDS[0],$IDS[1],$IDS[2], $VALUE);
        
    }
    
    
    public function GET_VARIABLE($VARIABLE,$SET,$STATE,$LIMIT=10,$SORT=array()){
        
       
         $TYPE = $this->TYPE_VARIABLE($VARIABLE);
          
             if($TYPE['variable']=='full'){
                 
                  $ID = $VARIABLE.':'.$SET.':'.$STATE;
                 
                 
                  $VALUE =  $this->soft->GET_ENTITY_VALUE($VARIABLE,$LIMIT);
            
                      
                   return $VALUE;
    
                 
             }else{
     
                     $_PARTS =  $this->PARTS($VARIABLE);
                    
                      
                     $ID = $_PARTS['id'].':'.$SET.':'.$STATE;
                     
                     $VALUE =  $this->soft->GET_ENTITY_VALUE_BY_ID($_PARTS['entity'],'id',$ID,$LIMIT);
                     
                     return $VALUE;
                 
             }
             
        
    }
    
    
    public function GET_VARIABLE_ATTRIBUTE($VARIABLE,$SET,$STATE,$ATTRIBUTE){
        
             $TYPE = $this->TYPE_VARIABLE($VARIABLE);
          
             if($TYPE['variable']=='full'){
                 
                  $VALUE = array();
                 
                  $ID = $VARIABLE.':'.$SET.':'.$STATE;
                 
                  $VALUES =  $this->soft->GET_ENTITY_VALUE($VARIABLE,'id',$ID);
            
                  foreach($VALUES as $values){
                     
                     if($values['set']==$SET && $values['state']==$STATE){ 
                     $VALUE[$values['id']]= $values[$ATTRIBUTE];   
                     }
                      
                  }
           
                   return $VALUE;

                 
             }else{

                     $_VARIABLE =  $this->PARTS($VARIABLE);
                     $ID = $_VARIABLE['id'].':'.$SET.':'.$STATE;                 
                     $VALUE = array();
                      
                     $VALUES =  $this->soft->GET_ENTITY_VALUE_BY_ID($_VARIABLE['entity'],'id',$ID);
                                          
                     foreach($VALUES as $values){
                         
                         $VALUE[$values['id']]=$values[$ATTRIBUTE];                       
                     }
        
                     return $VALUE;
                 
             }
  
            
    }
    
    
    public function SET_VARIABLE_ATTRIBUTE($VARIABLE,$SET,$STATE,$ATTRIBUTE,$_VALUE){
        
             $TYPE = $this->TYPE_VARIABLE($VARIABLE);
        
             if($TYPE['variable']=='full'){
                 
                  $VALUE = array();
                 
                  $ID = $VARIABLE.':'.$SET.':'.$STATE;
                 
                  $VALUES =  $this->soft->GET_ENTITY_VALUE($VARIABLE,'id',$ID);
            
                  foreach($VALUES as $values){
                       
                      if($values['set']==$SET && $values['state']==$STATE){
  
                        $this->soft->SET_ENTITY_VALUE_ID($VARIABLE,'id',$values['id'],array($ATTRIBUTE=>$_VALUE));

                      }
                  }
           
                   return $VALUE;

                 
             }else{

                     $_VARIABLE =  $this->PARTS($VARIABLE);
                      
                     $ID = $_VARIABLE['id'].':'.$SET.':'.$STATE;
     
                     
              
                     
                    $this->soft->SET_ENTITY_VALUE_ID($_VARIABLE['entity'],'id',$ID,array($ATTRIBUTE=>$_VALUE));
     
                    return TRUE;
                 
             }
        
    }

    public function SET_VARIABLE_VALUE($VARIABLE,$SET,$STATE,$VALUE){
        
        
            $this->SET_VARIABLE_ATTRIBUTE($VARIABLE,$SET,$STATE,'value',$VALUE);
        
    }
    
    
    public function GET_VARIABLE_VALUE($VARIABLE,$SET,$STATE){
        
           return $this->GET_VARIABLE_ATTRIBUTE($VARIABLE,$SET,$STATE,'value');
        
    }
    
    
    public function EVAL_VALUE($VALUE,$SET,$STATE){
        
           $_VALUE = array();
        
             if(is_string($VALUE)){
              
               if($this->IS_VARIABLE($VALUE)){
                 
                     $VAL=$this->GET_VARIABLE_VALUE($VALUE, $SET, $STATE);
                
                     if($VAL!=NULL){
                     $_VALUE[] = $VAL; 
                     }
             } 
              
              
          }else{
            
              foreach($VALUE as $values){
                  
                  foreach($values as $value){
                      $VAL = $this->EVALUE($value,$SET,$STATE);
                    
                      if($VAL!=NULL){
                      $_VALUE[]  = $VAL;
                      }
                      
                  }
                  
              }
              
              
          }
          
          return $_VALUE;
        
        
    }
    
    
    public function EVALUE($VALUE,$SET,$STATE){
        
        $_VALUE=array();
        
        if(is_string($VALUE)){
        
             if($this->IS_VARIABLE($VALUE)){
                 $VAL = $this->GET_VARIABLE_VALUE($VALUE, $SET, $STATE);
                if($VAL!=NULL){
                 $_VALUE[] = $VAL; 
                }
             } 
            
        }else{
            $VAL = $this->EVAL_VALUE($VALUE);
            
            if($VAL!=NULL){
            $_VALUE[] = $VAL;
            }
        }
        
        return $_VALUE;
    }
    
    
    
    public function DELETE_VARIABLE($VARIABLE,$SET,$STATE){
        
            $TYPE = $this->TYPE_VARIABLE($VARIABLE);
             
            if($TYPE['variable']=='full'){
                
                $this->soft->DELETE_ENTITY($VARIABLE);
            }elseif($TYPE['variable']=='simple'){
                
                
        
                 $_PARTS =$this->PARTS($VARIABLE);

                var_dump($_PARTS);
                 
                $RESULT=$this->soft->DELETE_VALUE($_PARTS['entity'],array("entity"=>$_PARTS["id"],"set"=>$SET,"state"=>$STATE));
                 
                var_dump($RESULT);
                 
                
            }
            
           $this->CLEAN_VARIABLE($VARIABLE);
           //$this->soft->DELETE_ENTITY();
        
    }
    
    

    

    

    
    
    
    
    

    
    public function CHECK_VARIABLE($VARIABLE){
        
         if($this->soft->GET_ENTITY_VALUE_BY_ID('variable:0','id',$VARIABLE)){
             return TRUE;
         }else{
             return FALSE;
         }
        
    }

    
    public function ADD_VARIABLE($VARIABLE){
   
           $this->soft->SET_ENTITY_VALUE('variable:0',array('id'=>$VARIABLE,'state'=>'true'),'id');
    }
    
    public function CLEAN_VARIABLE($VARIABLE){
        
         $this->soft->DELETE_VALUE('variable:0',array('id'=>$VARIABLE));
        
    }
    
    
    
    public function IS_VARIABLE($VARIABLE){
        
         if(is_string($VARIABLE)){
         if ( preg_match('/\s/',$VARIABLE) ){
          return FALSE;   
         }else{    
        
            $_VARIABLE= $this->PARTS($VARIABLE);
        
         if($_VARIABLE['entity']==$VARIABLE){
              $variable = $this->TYPE_VARIABLE($VARIABLE);
            
              if($variable['variable']!=FALSE){
                  return TRUE;
              }else{
                  return FALSE;
              }
         }else{
         return TRUE;    
         }
         }
         }else{
           return FALSE;  
         }
         
    }
    
    
    public function ALL_VARIABLE_VALUE($VARIABLE){
        
        
        $VAL=array();
        
        $VALUE = $this->VARIABLE($VARIABLE,1000);
        
        foreach($VALUE as $value){
            
             $values = $value['value'];
             
             $set = $value['set'];
             
             $state = $value['state'];
             
             $entity = $value['entity'];
            
             foreach($values as $variable){
          
                 
                 if(is_string($variable)){
                 $VAL[][$entity][$set][$state] = $this->ALL_VARIABLE_VALUE($variable);
                 }else{
                 $VAL[][$entity][$set][$state] = $variable;    
                 }                 
                
                 
             }
             
        }
        
       return $VAL;
        
    }
    
    
    public function VARIABLE($VARIABLE,$LIMIT=10){
        
           $_VARIABLE=$this->PARTS($VARIABLE);
      
          
          if($_VARIABLE['entity']==$VARIABLE){
             $VALUE = $this->soft->GET_ENTITY_VALUE_BY_ID($_VARIABLE['entity'],'entity',$_VARIABLE['id']);
          }else{
                   
             $VALUE = $this->soft->GET_ENTITY_VALUE_BY_ID($_VARIABLE['entity'],'entity',$_VARIABLE['id']); 
             
             if(count($VALUE)==0){
             
             $VALUE = $this->soft->GET_ENTITY_VALUE($VARIABLE,$LIMIT); 
                 
             }
            

          } 
    
          return $VALUE;
     
           
    }
    
    
    public function VARIABLE_VALUE($VARIABLE,$LIMIT=10){
        
          $VARIABLES = $this->VARIABLE($VARIABLE,$LIMIT);
        
          $VAL= array();
          
          foreach($VARIABLES as $variable){
              
              
              $VAL[$variable['entity'].":".$variable['set'].":".$variable['state']]=$variable['value'];
              
              
          }
        
         return $VAL;
    }
    
        public function VARIABLE_ATTRIBUTE($VARIABLE,$ATTRIBUTE,$LIMIT=10){
        
          
            
          $VARIABLES = $this->VARIABLE($VARIABLE,$LIMIT);
        
          
         return $VARIABLES;
    }
    
    
    
    public function VALUE($VALUE){
        
          $VAL = array();
        
          foreach($VALUE as $key=>$value){
              
               if(is_array($value)){
                  
                   if(array_key_exists('operation', $value)){
                     
                        $key;
                       
                       
                       $parts = explode('.',$value['operation']);
                         
                       
                      $output = $this->network['lib']['function']['hard']->LOAD($value['input']);
                      
                      $VAL[$key]= $output;
                       
                       
                   }else{
                  $val = $this->VALUE($value);
                  if($val!=NULL){
                 $VAL[$key] = $val;
                  }
                  }
               }else{
                   
                   if($this->IS_VARIABLE($value)){
                     $val = $this->VARIABLE_VALUE($value);
                     if($val!=NULL){
                 $VAL[$key] = $val;   
                     }else{
                        
                         
                         
                  $VAL[$key] = $value;  
                     }
                   }
                   
               }
          }
        
          return $VAL;
          
    }
    
    
    
    public function PARTS($VARIABLE){
        

      
         $PARTS = explode(':',$VARIABLE);        
        
         
         $TOTAL = count($PARTS);
         
         if($TOTAL==1){
           
              $PROCESS = explode('.',$VARIABLE);
             
             if(count($PROCESS)==1){
              
             return array('entity'=>$VARIABLE,'id'=>$VARIABLE);
             }else{
             return array('entity'=>$VARIABLE,'id'=>$VARIABLE);    
             }
         }else{
         $initial =0;

         $VALUE=$PARTS[$TOTAL-1];
         
         array_pop($PARTS);
        
         $ENTITY = implode(':',$PARTS);
         
         return array('entity'=>$ENTITY,'id'=>$VALUE);
         }
         
    }
    
    
  
  
    public function GET_VALUE($VARIABLE){
         
        
        
    }
    
 
    public function SET_USER($ENTITY_NAME,$SET,$STATE,$NICK,$CLASIFICATION,$EMAIL,$PASSWORD,$NODE='node:default'){
        
        
        
        $this->SET_VARIABLE($ENTITY_NAME,$SET,$STATE,$NICK,array($NODE));
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'type','user');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'classification',$CLASIFICATION);
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'data','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'service','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'password',$PASSWORD);
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'key','feedtofood');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'token','masterfeed');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'level','0');        
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'email',$EMAIL);
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'region','');
         
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'store',''); 
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'mobile','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'date','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'payment','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'address','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'finance','');
   
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'group','');
        
        $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NAME,$SET,$STATE,'checked','false');
        
        
    }
    
    
    public function SET_NODE($ENTITY_NODE,$SET,$STATE,$NAME,$VALUE){
        
          $this->SET_VARIABLE($ENTITY_NODE,$SET,$STATE,$NAME,array($VALUE));
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NODE,$SET,$STATE,'type','node');
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NODE,$SET,$STATE,'node_in',array('0'=>'*'));
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NODE,$SET,$STATE,'node_out',array('0'=>'*'));
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_NODE,$SET,$STATE,'cache','cache:default');
        
         
    }
    
    
    public function SET_PROCESS($ENTITY_PROCESS,$SET,$STATE,$NAME,$VALUE,$ACTION,$TYPE_INPUT,$TYPE_OUTPUT){
        
          $this->SET_VARIABLE($ENTITY_PROCESS,$SET,$STATE,$NAME,array($VALUE));
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_PROCESS,$SET,$STATE,'type','process');
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_PROCESS,$SET,$STATE,'action',array());
          
           $this->SET_VARIABLE_ATTRIBUTE($ENTITY_PROCESS,$SET,$STATE,'process',$PROCESS);
          
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_PROCESS,$SET,$STATE,'input',$TYPE_INPUT);
        
          $this->SET_VARIABLE_ATTRIBUTE($ENTITY_PROCESS,$SET,$STATE,'output',$TYPE_OUTPUT);
        
    }
    
    public function NODE_EVALUE($NODE){

         $this->NODE($NODE);
         
         if(is_array($this->node)){
         foreach($this->node as $key=>$value){
             
             //echo $value;
            
             
         }
         }
         
         
         
        
         return $this->node;
        
    }
    
    
    public function NODE($NODE,$KEY=''){
        
         if(is_array($NODE)){
         foreach($NODE as $key=>$value){
        
            if(is_array($value)){
            
                 $this->NODE($value,$key);
                
            }else{
                 
                  if($KEY==''){
                 $this->node[$key] = $value;
                  }else{
                 $this->node[$KEY.':'.$key] = $value;    
                  }
            }
            
         }
         
       }
        
        
    }
    
    
 
    public function GET_DATA_TYPES(){
        
         array('text','number','boolean','array','date','instruction','none','structure');
        
        
    }
    
    
    
    public function ADD_WORD($word){
        
   $handle = fopen("./lib/Spanish.dic", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
        
        if(!mb_detect_encoding($line, 'UTF-8', true)){
        $strline = utf8_decode($line);
        }else{
        $strline = $line;    
        }
        $line_spell = explode('/',$strline);
        
      //echo $line_spell[0];
      
    }

    fclose($handle);
} else {
    // error opening the file.
}
        
    }
    
    
}