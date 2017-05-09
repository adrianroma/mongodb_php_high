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
    
    public $core;
    public $variable;
    public $baseUrl;
    public $data;
    public $wallKey=array();
    
    //put your code here
    public function __construct() {


    }
    
    public function RENDER(app_variable $VARIABLE,$DATA){
        
        $this->variable = $VARIABLE;
        $this->data = $DATA;
        
        
        
        $this->baseUrl = 'http://'.$this->variable->core->getBaseUrl();
        
        $query =  $this->variable->core->QUERY();
        
        
        $doc = new DOMDocument();
        $html = '<!Doctype html><html id="html"><head id="head"><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body id="body"></body></html>';
        $doc->validateOnParse = true; //<!-- this first
        $doc->preserveWhiteSpace = true;
        
        $doc->loadHTML($html);
        
        $this->wallBrick();
        
        //$this->core->getBaseUrl();
        
        
       $less = new lessc;
       $less->checkedCompile("./html/skin/input.less","./html/skin/output.css"); 
        
        if(in_array('edit',$query['query'])){
           
        $urls= array(
                     array('url'=>$this->baseUrl.'/html/bricks/title.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/skin_edit.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/icon_16.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/icon_32.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script/request.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script/back.php','data'=>array('simple'=>'text')), 
                     array('url'=>$this->baseUrl.'/html/bricks/edit.php','data'=>array('simple'=>'text'))
                     
            );    
            
        }else{
        
        $urls= array(
                     array('url'=>$this->baseUrl.'/html/bricks/title.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/skin.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/icon_16.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/icon_32.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script/back.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/script/request.php','data'=>array('simple'=>'text')),
                     array('url'=>$this->baseUrl.'/html/bricks/message.php','data'=>array('aditional.text'=>'make better cousine')),
                     array('url'=>$this->baseUrl.'/html/bricks/test.php?target=message.default','data'=>array('simple'=>'text')) 
                     
            );
        }
        
        foreach ($urls as $_data){
   
            
        $data=$this->tagHTML($_data['url'],$_data['data']);
        
        $nodesImport = $data['node'];
     
        foreach($nodesImport as $nodeImport){
        
        $node = $doc->importNode($nodeImport, true);
        
       
        if($node->nodeName=='link'){
            
           $url = $node->getAttribute('href');
           
           $url =  str_replace('./',$this->baseUrl.'/',$url);
            
          
           
           $node->setAttribute('href',$url);
        }

        if($node->nodeName=='script'){
            
           $url = $node->getAttribute('src');
 
           $url =  str_replace('./',$this->baseUrl.'/',$url);
    
           
           $node->setAttribute('src',$url);
        }        
        
        
        
   
        
        $targetElement  = $doc->getElementById($data['target']);
   
     
        $targetElement->appendChild($node);
         
         }
        
         }
       
        
        return $doc->saveHTML();
        
    }
    
    public function tagHTML($url,$data){
        
          $doc = new DOMDocument();
          
          $DATA=$data;
          
          $content = @file_get_contents($url);
   
          
          $doc->loadHTML($content); 
        
          
          $images =$doc->getElementsByTagName('img');
          
          foreach($images as $image){
              
              $src = $image->getAttribute('src');
              
              $src = str_replace('./',$this->baseUrl.'/',$src);
              
              $image->setAttribute('src',$src);
              
          }
          
          $data = $doc->getElementById('body');
        
          
          
          $content = $data->getAttribute('data-content');
          
          $contents = explode(' ',$content);
        
          
         
          
          $target = $data->getAttribute('data-target');
          
         
          
          
          $nodes=array();
          
          foreach($contents as $cont){
              
              $_node = $doc->getElementById($cont);
              
              $allNodes = $_node->getElementsByTagName("*");
              
           
              foreach($allNodes as $subnodes){
                  
                   
                 
                   
                  
                  if($subnodes->getAttribute('id')==$DATA['search.text']){
                      
                    
                      
                    $text = $doc->createTextNode("Ⓒ feed to food");
                      
                      $subnodes->appendChild($text);
                      
                  }
                 
                  
              }
            
              
              $nodes[]=$_node;
          }
          
         // $node = $doc->getElementById($content);
 
          
          return array('node'=>$nodes,'target'=>$target);
        
        
    }
   
 
   
    public function wallBrick(){
        
        $_wall = array();
         
        if(is_array($this->data)){
         foreach($this->data as $key=>$data){
             
               $bricks= explode('.',$key);
             
               foreach($bricks as $brick){
                    
                  
                 
                  if (strpos($brick,':') !== false) {
                  
                  $elements = explode(":",$brick);    
                      
                  }else{
                      
                      
                  }
                                   
               }
              
             
         }

         
        }
        
        
          
         
    }
    
    
    public function brick($wall,$KEY=''){
        
        $_brick = array();
        
        if(is_array($wall)){
        foreach($wall as $key=>$brick){
            
           if(is_array($brick)){
              
                if($KEY!=''){ 
              $this->brick($brick,$KEY.':'.$key);
                
              
                }else{
              $this->brick($brick,$key);  
                }
               
           }else{
           
           if($KEY!=''){    
           $this->wallKey[$KEY.':'.$key]=$brick;
           }else{
           $this->wallKey[$key]=$brick;    
           }
           
           }
           
        }
        }
        
        
    }
    
    
    
    public function entity_to_url($entity){
        
        
         $url = $this->baseUrl.'/html/bricks/'.$entity.'.php';
         
         
        
    }
    
    
    

 public function URLIsValid($URL)
{
    $exists = true;
    $file_headers = @get_headers($URL);
    $InvalidHeaders = array('404', '403', '500');
    foreach($InvalidHeaders as $HeaderVal)
    {
            if(strstr($file_headers[0], $HeaderVal))
            {
                    $exists = false;
                    break;
            }
    }
    return $exists;
}
    



       
}
