<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class app_instruction{
    

public $variable;
public $html;
public $services;
public $network;
public $client;
public $cache;
public $static;
public $dynamic;
public $data;
public $var;
public $text;
public $read;

public function __construct(app_variable $VARIABLE,$NETWORK) {
   
    $this->network = $NETWORK;
    $this->variable = $VARIABLE;
    
    $this->SET_CLIENT();
        
    $this->INSTRUCTIONS();

    //$this->CLEAN();
    
}


public function INSTRUCTIONS(){
       
    $this->INSTALL();
     
    $VALUE = $this->REQUEST();
 
}



public function REQUEST(){
   
     if(!$this->variable->core->isData){
   
     $QUERY = $this->variable->core->QUERY(); 
     
     if($QUERY['type']=='data'){
         
          $_RESPONSE = $this->REQUEST_DATA($QUERY);     
     
          $_RESPONSE = $this->EVALUE_NODE($_RESPONSE);
          
          
     }elseif($QUERY['type']=='section'){
 
          $_RESPONSE = $this->REQUEST_SECTION($QUERY);
       
          
          
          /**
             EVAULE HOME
           **/
          $_RESPONSE = $this->EVALUE_NODE($_RESPONSE);
          
              
     }elseif($QUERY['type']=='text'){
        
          $_RESPONSE = $this->REQUEST_TEXT($QUERY);
  
         
          
           $_RESPONSE = $this->EVALUE_NODE($_RESPONSE);
                   
     }else{
           
          $_RESPONSE = $this->REQUEST_CODE($QUERY);            
          $_RESPONSE = $this->EVALUE_NODE($_RESPONSE);
     }
       
     if($this->variable->core->isRest){   
      $this->TO_REST($_RESPONSE);
      }else{
      $this->TO_HTML($_RESPONSE);    
      } 
     
      }else{
  
          
      $JsonData= json_decode($this->variable->core->allParameters,TRUE);
 
         if($JsonData==NULL){
          
            if(count($this->variable->core->parameters)!=0){
              
                 $data = $this->variable->core->parameters;
                 
                 $QUERY=array('type'=>'data','query'=>$data);
                 
                 $_RESPONSE = $this->REQUEST_DATA($QUERY); 
                 
                 $_RESPONSE = $this->EVALUE_NODE($_RESPONSE);
                 
                 
                
            }elseif(count($this->variable->core->longParameters)!=0){
                
                
                $data = $this->variable->core->longParameters;
                
                 $QUERY=array('type'=>'text','query'=>$data);
                
                  $_RESPONSE = $this->REQUEST_TEXT($QUERY);
            }
             
         }else{
      
            $QUERY=array('type'=>'text','query'=>$JsonData);
                
            $_RESPONSE = $this->REQUEST_DATA($QUERY);
            
         }
         
      if($this->variable->core->isRest){   
      $this->TO_REST($_RESPONSE);
      }else{
      $this->TO_HTML($_RESPONSE);    
      } 
         
         
      }
    
    
}

public function EVALUE_NODE($NODE_VALUE){

    if(is_array($NODE_VALUE)){
     foreach($NODE_VALUE as $BLOCK=>$DATA){

        if(is_array($DATA)){
            
            
            foreach($DATA as $KEY=>$INSTRUCTION){
                
                   $DATA[$KEY] = $this->INSTRUCTION($INSTRUCTION);
            }
            
            
        }
     
        $NODE_VALUE[$BLOCK] = $DATA;
      
     }
   }
     
    return $NODE_VALUE;
}



public function CHECK_USER_KEY($USER_ENTITY,$KEY){
    
     $DATA_ENTITY = explode('.',$USER_ENTITY);
     
     $DATA_SET =  explode(":",$DATA_ENTITY[1]);

     $DATA_STATE = explode(":",$DATA_ENTITY[2]);
     
     $USER_DATA=$this->variable->GET_VARIABLE($DATA_ENTITY[0],$DATA_SET[1],$DATA_STATE[1]);
             
     if(isset($USER_DATA[0])){
     if($USER_DATA[0]['key']==$KEY){
      return TRUE;   
     }else{
      return FALSE;   
     }
     }else{
      return FALSE;   
     }
    
}

public function INSTRUCTION($INSTRUCTION){
    
    $VALUE= array("data"=>"");  
 
   
    if(isset($INSTRUCTION["PROCESS"])){
   
    if($INSTRUCTION["PROCESS"]=="TRANSLATE"){
        
        
        $VALUE = $this->TRANSLATE($INSTRUCTION);
        
    }elseif($INSTRUCTION["PROCESS"]=='SET_CACHE'){
        
        
        $VALUE = $this->SET_CACHE($INSTRUCTION);   
        
    }elseif($INSTRUCTION["PROCESS"]=="SEARCH"){
        
        
        $VALUE = $this->SET_SEARCH($INSTRUCTION);
        
    }elseif($INSTRUCTION["PROCESS"]=="SUGGEST"){
        
        
        $VALUE = $this->SET_SUGGEST($INSTRUCTION);
        
        
    }elseif($INSTRUCTION["PROCESS"]=="REGISTER"){
        
        
        $VALUE = $this->SET_REGISTER($INSTRUCTION);
        
    }elseif($INSTRUCTION["PROCESS"]=="GET"){
        
        $VALUE = $this->GET_GET($INSTRUCTION);
        
    }elseif($INSTRUCTION["PROCESS"]=="IMAGE"){
        
        
        $VALUE = $this->GET_IMAGE($INSTRUCTION);
    }
    
    }
    
    
    return $VALUE;
 
}


public function EVALUE_DATA($DATA){
    
    
     foreach($DATA as $KEY=>$VALUE){
         
         if(is_string($VALUE)){
             
               $VALUE_DATA = explode(".",$VALUE);
             
                   if(isset($this->var[$VALUE_DATA[0]])){
                   
                   
                       
              $DATA[$KEY] = $this->var[$VALUE_DATA[0]][$VALUE_DATA[1]];
                            
              
                            }else{
                             
              $DATA[$KEY] = $VALUE;                  
                            }
         }else{
              $DATA[$KEY] = $this->EVALUE_DATA($VALUE);
         }
         
     } 
    
    return $DATA;
}



public function EVALUE($STRING_VARIABLE,$LIMIT=10){
    
   
    
    if($LIMIT=='*'){        
      $LIMIT =1000;  
    }
    
    $VAR = array();
    
    if(is_string($STRING_VARIABLE)){
    $VARIABLE_VALUE = explode('.',$STRING_VARIABLE);    
    
    $VARIABLE = $VARIABLE_VALUE[0];
    
    foreach($VARIABLE_VALUE as $key=>$values){
        
        if($key!=0){
         $value_part = explode(':',$values);
        
         $VAR[$value_part[0]] = $value_part[1];
        
        }else{
            
         $VAR['variable'] = $values;   
        }
        
    }
   
    
      if(isset($VAR['set'])&& isset($VAR['state'])){
    
       
      $VALUE = $this->variable->GET_VARIABLE($VAR['variable'],$VAR['set'],$VAR['state'],$LIMIT);
    
      if(isset($VALUE[0])){
      
      if($VALUE[0]['type']=='user'){
          
          unset($VALUE[0]['password']);
          unset($VALUE[0]['key']);
          unset($VALUE[0]['token']);
          unset($VALUE[0]['payment_id']);
          unset($VALUE[0]['address_id']);
          unset($VALUE[0]['finance_id']);
      }    
          
          
      $VALUE = $VALUE[0];
      }else{
      $VALUE = array();   
      }
      
      }
      else{
    
         if(count($VAR)==1){
          $VALUE = $this->variable->VARIABLE($VAR['variable'],$LIMIT);    

         }
   
         
      }
    }else{
        
      $VALUE = $VAR;  
    }
      
    
    
      return $VALUE;
      
}


public function TRANSLATE($INSTRUCTION){

    
       $dictionary=$INSTRUCTION["IN"]["dictionary"];
    
       if(isset($this->data["language"])){
        $language = $this->data["language"];   
       }else{
       $language = "es";
       }
       
       if(isset($this->data["region"])){
           
       $region = $this->data["region"] ;   
       }else{
       $region = "mx";
       }
       
       $INSTRUCTION["IN"]["language"] =$language;
       $INSTRUCTION["IN"]["region"] =$region;

       
       $VALUE=$this->EVALUE($language.":".$region.":".$dictionary);

       
       if(isset($VALUE[0]['value'])){
       
       $INSTRUCTION["OUT"] = $VALUE[0]['value'];  
       
       if(is_array($VALUE[0]['value'])){
       foreach($VALUE[0]['value'] as $KEY=>$VALUE){
          $this->text[$KEY]=$VALUE;
       }
       }
  
       
       return $INSTRUCTION;
       }
    
}


public function SET_CACHE($INSTRUCTION){
     
          $INCOMING = $this->variable->core->parameters;
          
          $CACHE =$this->variable->GET_CACHE_DATA();
           
          
          
          if(count($CACHE)!=0){
              if(isset($INSTRUCTION['OUT']['cache'])){
          $INSTRUCTION['OUT']['cache']="TRUE";  
          if(isset($CACHE['object'])){
          foreach($CACHE["object"] as $key=>$cache){
              
              $this->cache[$key]=$cache;
              
          }
          }
              }
          }
           foreach($INSTRUCTION["IN"] as $key=>$data){
               
               if(isset($CACHE['object'][$key])){
               
               $INSTRUCTION["OUT"][$key] = $this->cache[$key];
               
               $this->data[$key] = $this->cache[$key];
               
               }elseif(isset($INCOMING[$key])){
               
               $this->data[$key] = $INCOMING[$key];     
                   
               $INSTRUCTION["OUT"][$key] = $INCOMING[$key];
               
               
               }else{
               $INSTRUCTION["OUT"][$key]="";    
               }
           }
           
           
 
           
           
        return $INSTRUCTION;  
    
}


public function SET_SEARCH($INSTRUCTION){
    
        foreach($INSTRUCTION["IN"] as $KEY=>$VALUE){
          
           if(isset($this->data[$KEY])){
            $INSTRUCTION["OUT"][$KEY] = $this->data[$KEY];
            }else{
             
                
            $INSTRUCTION["OUT"][$KEY]= ""; 
            }
              
          
          }
    
          
          
    
    
      
        foreach($INSTRUCTION["INPUT"] as $KEY=>$VALUE){
          
           if(isset($this->data[$KEY])){
            $INSTRUCTION["OUTPUT"][$KEY] = $this->data[$KEY];
            }else{
            $INSTRUCTION["OUTPUT"][$KEY]=""; 
             }
              
          
          }

       
       
        return $INSTRUCTION;
}


public function SET_SUGGEST($INSTRUCTION){
    
     
      foreach($INSTRUCTION["INPUT"] as $KEY=>$VALUE){
          
           if(isset($this->data[$KEY])){
            $INSTRUCTION["OUTPUT"][$KEY] = $this->data[$KEY];
            }else{
            $INSTRUCTION["OUTPUT"][$KEY]=""; 
             }
              
          
      }
    
    
      
      return $INSTRUCTION;
}


public function SET_REGISTER($INSTRUCTION){
    
    
    foreach($INSTRUCTION['IN'] as $KEY=>$VALUE){
        
        
        if(isset($this->data[$KEY])){
            $INSTRUCTION["OUT"][$KEY] = $this->data[$KEY];
        }else{
             $VALUE_DATA = explode(".",$VALUE);
             
             
            
             $VALUE = $this->EVALUE($VALUE_DATA[0]);
             $this->var[$VALUE_DATA[0]]=$VALUE;
            
            if(isset($VALUE[0])){
            $INSTRUCTION["OUT"][$KEY]= $VALUE[0]['register']; 
            }
        }
        
        
        
        
        
    }
    
    foreach($INSTRUCTION['INPUT'] as $KEY=>$VALUE){
        
        
        if(isset($this->data[$KEY])){
            
            $INSTRUCTION["OUTPUT"][$KEY] = $this->data[$KEY];
        }else{
            $INSTRUCTION["OUTPUT"][$KEY] ="";
        }
        
        
    }
    

            

    
    return $INSTRUCTION;
    
}


public function GET_GET($INSTRUCTION){

    
    foreach($INSTRUCTION["IN"] as $KEY=>$VARIABLE){
    
             
        
                $VALUE =  $this->EVALUE($VARIABLE); 
                
                unset($VALUE[0]["id"]);
                unset($VALUE[0]["entity"]);
                unset($VALUE[0]["set"]);
                unset($VALUE[0]["state"]);
                unset($VALUE[0]["text"]);
                unset($VALUE[0]["is"]);
                unset($VALUE[0]["reference"]);
                unset($VALUE[0]["type"]);
                unset($VALUE[0]["sort"]);
                unset($VALUE[0]["rate"]);
                
                
                
                 $EVALUATION =  $this->EVALUE_DATA($VALUE[0]);
                 
                 $this->var[$VARIABLE] = $EVALUATION;
                 
                if($VALUE!=NULL){
                unset($INSTRUCTION["OUT"]);    
                $INSTRUCTION["OUT"][$KEY] = $EVALUATION;
                }
                
    }
    
    
    return $INSTRUCTION;
    
}





public function GET_LIST($INSTRUCTION){
    
   
   $GET_VALUE = array();
   
    if(is_array($INSTRUCTION[1])){
    
    foreach($INSTRUCTION[1] as $VALUES){
        
         if(is_string($VALUES)){
             
           if(isset($INSTRUCTION[2])){ 
              
           $GET_VALUE[] = $this->EVALUE($VALUES,$INSTRUCTION[2]);
           }else{
           $GET_VALUE[] = $this->EVALUE($VALUES,'*');    
           }  
         }else{
             
           $GET_VALUE[] = $this->INSTRUCTION($VALUES);  
             
         }
        
    }
      
    }
    
    
    return $GET_VALUE;
      
}


public function GET_IMAGE($INSTRUCTION){
    
    
   
  
    foreach($INSTRUCTION["IN"] as $KEY=>$CONTENT){
    $VALUE = $this->EVALUE($CONTENT); 
    
    
                unset($VALUE[0]["id"]);
                unset($VALUE[0]["entity"]);
                unset($VALUE[0]["set"]);
                unset($VALUE[0]["state"]);
                unset($VALUE[0]["is"]);
                unset($VALUE[0]["text"]);
                unset($VALUE[0]["type"]);
                unset($VALUE[0]["rate"]);
                unset($VALUE[0]["sort"]);
                unset($VALUE[0]["reference"]);
               if(isset($this->var[$CONTENT])){
                $this->var[$CONTENT] = $VALUE[0];
    
                $INSTRUCTION["OUT"][$KEY]=$VALUE[0];
               }else{
                $INSTRUCTION["OUT"][$KEY]=$CONTENT;   
               }
    }
    
    
    return $INSTRUCTION;
}


public function SET_VARIABLE($INSTRUCTION){
    
    $IS_SET = array('SET'=>TRUE);
    

    
    
    
    
    
    return $IS_SET;
}


public function REQUEST_SECTION($QUERY){
            
     $query =  implode('_',$QUERY['query']);
  
     if($query=='*'){

     $query ='default';
     }

     $_VALUE = $this->GET_REQUEST_NODE($query);
           
     //$NODE = $this->variable->NODE_EVALUE($_VALUE);
          
     return $_VALUE;
        
}


public function REQUEST_DATA($QUERY){

         //$this->variable->core->isRest=FALSE; 
     
        if($this->variable->core->action=="/"){
            
            $query= "default";
        }else{
            $query= $this->variable->core->action;
        }
         
        $_VALUE = $this->GET_REQUEST_NODE($query);
        
        
        //$NODE = $this->variable->NODE_EVALUE($_VALUE);
       
        return $_VALUE;
          
         

}


public function REQUEST_TEXT($QUERY){
    
     
    
   
      if(count($QUERY['query'])==1){
     
          
          
           $_VALUE = $this->GET_REQUEST_NODE($QUERY['query'][0]);
          
      }else{
      
        $data = $this->variable->SEARCH_VARIABLE_VALUES("search:cocina:jefe",array(array("key"=>"cocina")));
      
      
      }
     
       
       
      return $_VALUE;
    
}


public function REQUEST_CODE($QUERY){
    
    
          $_VALUE = $QUERY;   
         
      return $_VALUE;
    
}




public function SET_CLIENT(){
    
    
    
    $this->variable->ADD_CLIENT('guest','us','127.0.0.1:cd.mx',60);
    
    if(isset($this->network['lib']['function']['login'])){
    $LOGIN = $this->network['lib']['function']['login']->LOGIN();  
    }
    
    
    
    

    
}


public function CLIENT_DATA(){
    
     return $this->variable->GET_CACHE_DATA();
    
}


public function GET_NETWORK(){
    
        $country_language='EN';
        $country_code='US';       
//        $region = @file_get_contents('http://freegeoip.net/json/');        
//        if($region!=NULL && $region!=FALSE){
//         $data_region=json_decode($region,true);
//          $country_code =  $data_region["country_code"];       
//        }else{     
//        }   
              
        $SET_REGION = $country_language.':'.$country_code;
        $SET_REGION = strtolower($SET_REGION);        
        return $SET_REGION;
    
}


public function GET_REQUEST_NODE($REQUEST){
    
    
          
    
          $SET_REGION=$this->GET_NETWORK();            
                    
          $SHARD = str_split($REQUEST);    
           
          $RESPONSE = $this->variable->GET_VARIABLE('request:'.$REQUEST,$SET_REGION,'true');
            
         
          
          if(isset($RESPONSE[0])){

              $NODE_VALUE = $this->variable->GET_VARIABLE("node:default","process","true");
              

          
          }else{
         
         
              $NODE_VALUE = $this->variable->GET_VARIABLE("node:404","process","true");
              
          }   
          
         
          
          return $NODE_VALUE[0]['value'][0];          
   
}


public function GET_REQUEST_NODE_BY_WORDS($WORDS){    
       // $RESPONSE =$this->variable->SEARCH_VARIABLE_VALUE('request:int:es:'.$SHARD[0].':'.$REQUEST,'inicio');
   
}



public function VALUE($VALUES){

  
    
}


public function TO_REST($DATA){
    
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($DATA,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
  
}





public function TO_HTML($DATA){
    
    header('Content-Type: text/html; charset=utf-8');
    $HTML= $this->network['lib']['function']['html']->RENDER($this->variable,$DATA,$this->network);
    echo $HTML;
   
}


public function CLEAN(){
 
    $this->variable->DELTE_ALL();
    
}


public function INSTALL(){
    

    
       if(!$this->variable->CHECK_VARIABLE('es:mx:text:site')){ 
           
       $this->read = $this->network['lib']['function']['hard'];
       $VARIABLE = $this->read->GET_ENTITY_VALUE('6737438947:variable');  
    
      
       
       foreach($VARIABLE[0] as $variable=>$data){
        
          if(isset($data['text'])){
           $text = $data['text'];
          
          
           unset($data['text']);
           
          }else{
           $text ="";   
          } 
          
          
           if(isset($data["value"])){
           $value = $data["value"];
           unset($data['value']);
           }else{
           $value ="";    
           }
           $this->variable->SET_VARIABLE($variable,'data','true',$text,$value,$data);
       }
       
        }
       /*
        * REQUEST AND SEARCH
        * 
        * 
        * 
        */

    
      if(!$this->variable->CHECK_VARIABLE('user:system:service')){      
             
      $VALUE = $this->network['lib']['function']['hard']->GET_ENTITY_VALUE('6737438947:data');  
 
      if(isset($VALUE[0]['user'])){
       $user_data = $VALUE[0]['user'];
   
       $this->variable->SET_USER($user_data['entity'],$user_data['type'],$user_data['state'],$user_data['nick'],$user_data['classification'],$user_data['email'],$user_data['password']);      
   
       }else{
           
       $user_data = array();   
      }     
          
      }
    
      if(!$this->variable->CHECK_VARIABLE('node:default')){

      $VALUE = $this->network['lib']['function']['hard']->GET_ENTITY_VALUE('6737438947:data');  

      foreach($VALUE[0] as $key=>$node_entity){
          
     
         
       if(isset($node_entity['value'])){
          $this->variable->SET_NODE($key,'process','true','default',$node_entity['value']);
         }
      }
     
      }   
     
      if(!$this->variable->CHECK_VARIABLE('request:a')){
   
      $spanish = array('a','b','c','d','f','g','h','i','j','k','l','m','n','ñ','o','p','q','r','s','t','u','v','w','x','y','z');
  
       foreach($spanish as $letter){
        $this->variable->SET_VARIABLE('request:'.$letter,'es:mx','true',$letter,'node:search');  
        $this->variable->SET_VARIABLE('request:'.$letter,'en:us','true',$letter,'node:search');   
        
      
       }
     }

     
     if(!$this->variable->CHECK_VARIABLE('request:default')){
      
          $this->variable->SET_VARIABLE('request:default','es:mx','true','default','node:default');
          $this->variable->SET_VARIABLE('request:default','en:us','true','default','node:default');
          $this->variable->SET_VARIABLE('request:todo:sobre:gastronomía','es:mx','true','default','node:all:about');
          
     }
  
     if(!$this->variable->CHECK_VARIABLE('request:chef')){
         
        
         $this->variable->SET_VARIABLE('request:chef','es:mx','true','chef','node:service:chef');
         $this->variable->SET_VARIABLE('request:chef','en:us','true','chef','node:service:chef');
          
     }
   
     if(!$this->variable->CHECK_VARIABLE('search:cocina:jefe')){
         
        
         $this->variable->SET_VARIABLE('search:cocina:jefe','es:mx','true','dictionary','node:dictionary',array("key"=>array("chef","cocina","jefe")));
        
          
     }
     

     
    //$this->variable->TREE_VARIABLE("request:chef");
     
    
    if($this->variable->CHECK_VARIABLE('request')){
        
       
        
    }
     
     
}

public function jsonRemoveUnicodeSequences($struct) {
        return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
}










}