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

require "./lib/less/lessc.inc.php";

class lib_function_html {

    public $data = array();
    public $wallKey= array();
    public $text =array();
    public $var = array();
    public $network = array();
    public $theme = array();
    
    //put your code here
    public function __construct() {


    }
    
    public function RENDER(app_variable $VARIABLE,$DATA,$NETWORK){
       
    $this->network = $NETWORK;    
    $this->variable=$VARIABLE;
    if(is_array($DATA)){
    $this->data = $DATA;    
    }
    
    $this->GET_VARIABLE(); 
    
  
    $this->LOAD_THEME("HTML:BRICK");
    
    $this->BLOCKS("HTML:BRICK",$this->data);
        
    //include('./html/bricks/page.php');
      
        
    
    
    }
    
    
    public function LOAD_THEME($THEME){
        
        
       $this->theme=$this->network['lib']['function']['hard']->LOAD($THEME);

    }
    
    
    
    public function BLOCKS($THEME,$DATA){
        
        
        foreach($DATA as $block=>$content){
            
           
             
              if(strpos($block, ':') !== false){
           
                 
              $file= $this->LIST_BLOCK($THEME,$block);
                
              if(file_exists($file)){  
                
                 include($file);
             
              }
            
              }
              
              if(is_array($content)){
                  
                  
                  $this->BLOCKS($THEME,$content);
                  
              }
            
            
             
             
         
             
             
        }
        
        
    }
    
    
    public function LIST_BLOCK($THEME,$BLOCK_NAME){
 
       //$BLOCK = 
        
        $CONTENT = $THEME.':'.$BLOCK_NAME;
       
       
        if(in_array($CONTENT,$this->theme)){
            
            
            $CONTENT = str_replace(":","/",$CONTENT);
            
            $CONTENT = "./".$CONTENT.".php";
            
            return $CONTENT;
        }else{
            
            
            return "./DEFAULT/DEFAULT.php";
            
        }
       
        
//        $BRICKS = explode(":",$BLOCK_NAME); 
//        
//       $BLOCK='./HTML/BRICK/NOT_FOUND.php'; 

//       
//       $LIST = array(
//             "HEAD"=>array("MAIN"=>'./HTML/BRICK/HEAD/MAIN.php'),
//           
//             "HEADER"=>array("DEFAULT"=>'./HTML/BRICK/HEADER/MAIN.php',"MAIN"=>"./HTML/BRICK/HEADER/DEFAULT.php"),
//            
//             "CONTENT"=>array("MAIN"=>'./HTML/BRICK/CONTENT/MAIN.php',"404"=>"./HTML/BRICK/CONTENT/404.php"),
//            
//             "FOOTER"=>array("MAIN"=>'./HTML/BRICK/FOOTER/MAIN.php')
//
//            );
//       
//       if(isset($LIST[$BRICKS[0]][$BRICKS[1]])){
//       $BLOCK=$LIST[$BRICKS[0]][$BRICKS[1]];
//       }
//        return $BLOCK; 
    }
    
    
    public function SKIN(){
    
    $skin = array();    
        
    if(isset($this->data['head:main.skin'])){    
    }
    return $skin;   
        
    }
    
    
    public function SCRIPTS(){
        
    $script = array();

     if(isset($this->data['head:main.instruction'])){
     
     }
     
    return $script;    
        
    }
    
    
    public function LINKS(){
        
    $links = array();    
      
    
        
    return $links;    
    }
    
    
    public function ADD(){
        
        
     include('./html/bricks/test.php');   
        
    }
    
    
    public function TOOL(){
        
        
        
        
        
    }
    
    

    
    
    public function GET_VARIABLE(){
        
        $ALL_TEXT= array();
        
        foreach($this->data as $DATA){
          
             if(is_array($DATA)){
                 
                 foreach($DATA as $type=>$data){
                     
                     if($type=="TEXT"){
                         
                         
                        $data["OUT"];
                        
                        if(isset($data["OUT"])){
                        $ALL_TEXT = array_merge($ALL_TEXT, $data["OUT"]);
                        }
                     }else{
                         
                         foreach($data["OUT"] as $key=>$variable){
                             
                             $this->var[$key]=$variable;
                             
                             
                         }
                         
                         
                         
                     }
                     
                 }
                 
             }
        }
        
          $this->text = $ALL_TEXT;
          
         
        
    }
    
    
    public function TEXT($TEXT){
        
        
        if(isset($this->text[$TEXT])){
        return $this->text[$TEXT];
        }else{
        return $TEXT;    
        }
        
    }
    
    
    
    public function VARIABLE($ID){
        
         
        if(isset($this->var[$ID])){
        return $this->var[$ID];
        }else{
        return $ID;    
        }
        
    }
    
    public function LINK($TEXT){
        
        
        return $TEXT;
        
    }
    
    
    public function IMAGE($VAR){
       
        
        return $VAR;
    }
       
}
