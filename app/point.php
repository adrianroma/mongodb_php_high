<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

   
        //$this->variable->SHARD_VARIABLE('user:admin','entity');
   
     
        //$VALUE = $this->variable->VARIABLE_VALUE('user');
    
        //echo "<pre>";
        //var_dump($VALUE);
        //echo "</pre>";
        
        //$V=$this->variable->soft->GET_ENTITY_VALUE('base_config');
    
            //$VAL=$this->variable->VARIABLE_VALUE('user');
    
            //$VALUE = $this->variable->VALUE($VAL);
            
            //$VALUE = $this->variable->SUB_VARIABLE('user');
    
           //  $VALUE = $this->variable->UP_VARIABLE('user:admin');
           //$INPUT=array('general:data:input:simple');
           //$OUTPUT=array('general:data:input:simple');
           
    
           //$VALUE = $this->variable->SET_VALUE_PROCESS('load','lib.function.hard',$INPUT,$OUTPUT);
    
           //$this->variable->SET_VARIABLE('node','system','true','node',$VALUE);
    
            //$VAL=$this->variable->GET_VARIABLE_VALUE('node','system','true');
    
        
            
            // $VALUE = $this->variable->VALUE($VAL);
           
          // echo "<pre>";
          // var_dump($VALUE);
          // echo "</pre>"; 
        
//         $VALUE=$this->variable->GET_VARIABLE_VALUE('user','system','true');
//         
//         $_VAL = $this->variable->EVAL_VALUE($VALUE,'system','true');
//         
//          echo "<pre>";
//          var_dump($_VAL);
//         echo "</pre>";
         
    
//          if(count($VALUE)==0){
//          $this->variable->SET_VARIABLE('user','system','true','User',array('user:admin','user:guest'));
//          }else{
//          
//          //$this->variable->DELETE_VARIABLE('user','system','true');    
//          //$this->variable->DELETE_VARIABLE('user','system','true');    
//              
//          }
//          
//          
//           $USER = $this->variable->GET_VARIABLES("user:guest:default");
//                
//           if(count($USER)==0){
//               
//          $this->variable->SET_VARIABLE('user:guest:default','system','true','Guest',array(array("nick"=>'default',"password"=>'guest','node'=>'*','state'=>'true','data'=>'')));  
//              
//          $this->variable->SET_VARIABLE('user:admin:default','system','true','Admin',array(array("nick"=>'default',"password"=>'gastronomica','node'=>'*','state'=>'true','data'=>'')));  
//           }else{
//           echo "<pre>";    
//           //var_dump($USER);
//           echo "</pre>";
          // }
           
//           $ARTIFICIAL = $this->variable->GET_VARIABLES("user:guest:search");
//           
//           
//             if(count($ARTIFICIAL)==0){
//                 
//                $this->variable->SET_VARIABLE('user:guest:search','system','true','AI',array(array("nick"=>'search',"password"=>'01010101','node'=>'*','state'=>"true",'data'=>'')));  
//                $this->variable->SET_VARIABLE('user:admin:search','system','true','AI',array(array("nick"=>'admin_search',"password"=>'01010101','node'=>'*','state'=>"true",'data'=>'')));  
//                $this->variable->SET_VARIABLE('user:admin:search','system','false','AI',array(array("nick"=>'admin_search',"password"=>'01010101','node'=>'false','state'=>"false",'data'=>'')));  
//                
//             }
           
             
            //$VALUE = $this->variable->GET_VARIABLE("user:guest:search","system","true");
             
    
             // $VALUE = $this->variable->ALL_VARIABLE_VALUE("user");
    
           // $VALUE = $this->variable->SET_VARIABLE_ATTRIBUTE("user:guest","system","true","average",array("60"));
    
       
            
//               $ALL =  $this->variable->GET_ALL();
//             
//               
//               foreach($ALL as $variables){
//                   
//                   if($variables!="base_config" && $variables!="base_data"){
//                       
//                       var_dump($variables);
//                      //$this->variable->DELETE_ENTITY($variables);
//                   }
//                  
//                   
//                   
//               }
             
            //$this->variable->SET_VARIABLE('simple:me','user','true','Esto es Simple','Simple');
           
            //$this->variable->SET_VARIABLE('simple:you','guest','true','Esto es Yo','Complex');
            
           // $this->variable->SET_VARIABLE('simple:machine','guest','false','Esto es Maquina','Inteligence');
            
            
            // $this->variable->SET_VARIABLE('simple:machine','guest','true','Esto es Maquina','Artificial');
            
           //$this->variable->SET_VARIABLE_ATTRIBUTE('user:admin:default','nick','');
          
           //$this->variable->UNSET_VARIABLE_ATTRIBUTE('user:admin:default','nick','');
           
           //$VALUE=$this->variable->GET_VARIABLE_ATTRIBUTE('user:admin:default','value');
           
           //$VALUE = $this->variable->GET_VARIABLE_SET('user:admin:default',"system");
           
           //$this->variable->SET_VARIABLE_SET('user:admin:default','system','admon');
           
           //$this->variable->DELETE_VARIABLE("user:guest:fool");
           
            //$VALUE =$this->variable->GET_VARIABLE_STATE('user:guest:artificial','static');
             
            //var_dump($VALUE);
            
           // $TYPE = $this->variable->TYPE_VARIABLE('user:guest');
         
            
          // $DOWN_VAR =  $this->variable->DOWN_VARIABLE('user:guest:default');
             
           //$VALUE = $this->variable->FULL_VARIABLE_VALUE('user');
           
           //$this->variable->DELETE_VARIABLE("simple:me","user","true");
           
           //  $this->variable->DELETE_VARIABLE_SET("simple:you","guest");
           
            //$VALUE =  $this->variable->GET_VARIABLE_SET_VALUE("simple:me","user");
            
            //var_dump($VALUE);
             
           //echo "<pre>";
           //var_dump($DOWN_VAR);
           //echo "</pre>"; 
           
        //$this->variable->GET_VARIABLE('name');
    
        //echo "HERE";
    
        //echo $this->variable->GET_VARIABLE('0:variable:user:guest');
    
     
//      $this->variable = $this->factory->SET('app_variable');   
//      $install= $this->factory->SET('app_install');
//      $this->variable->ADD_CLIENT('guest','mx','feed',60);
//      $data=$this->variable->GET_CACHE_DATA();
//   
//      $_Query =$this->variable->core->QUERY();
//    
//     
//      
//      if($_Query['type']='action'){
//         
//       
//          foreach ($_Query['query'] as $query){
//              
//              if($query=='*'){
//                  $request='*';
//               break;   
//              }else{
//                  
//                  
//              }
//              
//              
//          }
//      
//      
//      
//      }
//      
//      
//      //$this->SEND_MAIL();
//      
//      
//      $this->PAY();
//
//      $VALUES = $this->GET_REQUEST_NODE($request);
//
//      //var_dump($VALUES);
//      
//      $this->VALUE($VALUES);
//    



//            if(count($user)!=0){ 
//                
//             if ($QUERY['query']['key'] == $user[0]['key']){   
//             
//            if(key_exists('operation', $QUERY['query']['instruction']) && key_exists('variable', $QUERY['query']['instruction']) && key_exists('set', $QUERY['query']['instruction']) && key_exists('state',$QUERY['query']['instruction']) && key_exists('attribute', $QUERY['query']['instruction']) && key_exist('value',$QUERY['query']['instruction']) ){
//                
//                 if( $QUERY['query']['instruction']['operation']=='set'){
//                     
//                     
//                       if($QUERY['query']['instruction']['attribute']=='value'){
//                  
//                      $this->variable->SET_VARIABLE($QUERY['query']['instruction']['variable'],$QUERY['query']['instruction']['set'],$QUERY['query']['instruction']['state'],'variable',$QUERY['query']['instruction']['value']);
//                       
//                      
//                       }elseif($QUERY['query']['instruction']['attribute']!='value'){
//                            
//                        
//                       $this->variable->SET_VARIABLE_ATTRIBUTE($QUERY['query']['instruction']['variable'],$QUERY['query']['instruction']['set'],$QUERY['query']['instruction']['state'],$QUERY['query']['instruction']['attribute'],$QUERY['query']['instruction']['value']);    
//                           
//                           
//                       }
//                       
//                     
//                 }
//   
//            }elseif(key_exists('operation', $QUERY['query']['instruction']) && key_exists('variable', $QUERY['query']['instruction']) && key_exists('set', $QUERY['query']['instruction']) && key_exists('state',$QUERY['query']['instruction'])){
//                
//              
//                if( $QUERY['query']['instruction']['operation']=='get'){
//               
//                    
//                    
//                   
//              $RESPONSE_VALUE = $this->variable->GET_VARIABLE($QUERY['query']['instruction']['variable'],$QUERY['query']['instruction']['set'],$QUERY['query']['instruction']['state']);
//                
//           
//              if($RESPONSE_VALUE!=NULL){
//              
//              if($RESPONSE_VALUE[0]['type']=='user'){
//                 unset($RESPONSE_VALUE[0]['password']);
//                 unset($RESPONSE_VALUE[0]['token']);
//                 unset($RESPONSE_VALUE[0]['payment_id']);
//                 unset($RESPONSE_VALUE[0]['address_id']);
//                 unset($RESPONSE_VALUE[0]['finance_id']);
//                 unset($RESPONSE_VALUE[0]['email']);
//                 unset($RESPONSE_VALUE[0]['level']);
//              }    
//              $QUERY['response'] = $RESPONSE_VALUE[0];
//              
//              }else{
//               $QUERY['response'] = '';    
//              }
//             
//              
//                }
//               
//            }elseif(key_exists('search', $QUERY['query']['instruction'])){
//                
//            }
//             
//            }
//             
//         }