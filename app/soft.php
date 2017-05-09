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
class app_soft {
    
    public $config;
    public $mongoDB;
    public $DB;
    public $mongoActive = FALSE;
    public $helper;
    public $network;
    private $host;
    private $node;
    public $limit;
    
    
    //put your code here
    public function __construct($NETWORK) {
  
    $this->network=$NETWORK;  
    
    $config=$this->network['lib']['function']['hard']->GET_ENTITY_VALUE('6737438947:config');
      
    $this->host= $config["0"]['database']["H"];
    $this->node= $config["0"]['database']["0"];
    
    
    $this->connection();
 
    
    }
    
     /*
     * 
     *
     *
     */

    public function connection() {


        if (isset($_SERVER['SERVER_ADDR'])) {
            $currentHost = $_SERVER['SERVER_ADDR'];
        } else {
            $currentHost = '';
        }

        if ($currentHost == '127.0.0.1') {

            $host = $this->host['host'];
            $database = $this->host['database'];
            $this->mongoDB = $database;
            $port = $this->host['port'];
            //$username = 'adrian';
            $username= $this->host['username'];
            $password = $this->host['password'];

            $connecting_string = sprintf('mongodb://%s:%d/%s', $host, $port, $database);
            try{
            $connection = new MongoClient($connecting_string, array('username' => $username, 'password' => $password));
            
            $this->DB = $connection->selectDB($this->host['database']);
            $this->mongoActive = TRUE;
            }catch(Exception $e){
                
                $this->mongoActive = FALSE;
                $this->helper=$e;
            }
        } else {

# get the mongo db name out of the env
// $mongo_url = parse_url(getenv("MONGO_URL"));
//$dbname = str_replace("/", "", $mongo_url["path"]);
            
            //mongodb://<dbuser>:<dbpassword>@ds045644.mlab.com:45644/heroku_1vt0mn2v

            $host = $this->node['host'];
            $database = $this->node['database'];
            $this->mongoDB = $database;
            $port = $this->node['port'];
            $username = $this->node['username'];
            $password = $this->node['password'];

            $connecting_string = sprintf('mongodb://%s:%d/%s', $host, $port, $database);
            
             try{
            $connection = new MongoClient($connecting_string, array('username' => $username, 'password' => $password));
            $this->DB = $connection->selectDB($this->node['database']);
            $this->mongoActive = TRUE;
             }catch(Exception $e){
             $this->mongoActive = FALSE;    
             $this->helper=$e;   
             }
        }
    }
    
    
    public function GET_ENTITY_SIZE($entity){
        
        $dbname = $this->DB;
        
        $stats =$dbname->command(array('collStats' => $entity,'scale'=>1024));
        
       
        
        return $stats;
        
    }
    
    
    public function GET_ALL_ENTITIES() {
        if($this->mongoActive){
        $dbname = $this->DB;
        $collections = $dbname->getCollectionNames();
        return $collections;
        }else{
        return array();    
        }
    }
    
    public function GET_ENTITIES($ENTITY,$ID='0'){

         
         return  GET_ENTITY_VALUE_ID($ID.':entities',$ENTITY);       
    
         
    }
    
    public function SET_ENTITIES($ENTITY,$TYPE='system',$ID='0'){
        
        if($this->mongoActive){
        $dbname = $this->DB;
        
        $group = explode(':',$ENTITY);
      
        $this->SET_ENTITY_VALUE($ID.':entities',array("id"=>$ENTITY,"type"=>$TYPE,'group'=>$group),'id');

        
        }else{
        return array();    
        }
        
    }
    
    public function QUERY_ENTITIES($LIKE,$ID='0'){
        
        
        return $this->SEARCH_LIKE($ID.':entities','id',$LIKE);
        
        
    }
    
    
    public function DELETE_ENTITIES($ENTITY){
        
        if($this->mongoActive){

        $this->DELETE_VALUE('entities',array('id'=>$ENTITY));
        
        }else{
        return array();    
        }
        
        
        
    }
    
    
    public function SEARCH_ENTITY($ENTITY){
        
        if($this->mongoActive){
        $dbname = $this->DB;
        $collections = $dbname->getCollectionNames();
        return $collections;
        }else{
        return array();    
        }
        
        
        
    }
    
    public function SEARCH_ENTITY_VALUE($ENTITY,$VALUE,$ID='value'){
        
  
        
     if($this->mongoActive){
           $db = $this->DB;
           $collection = $db->selectCollection($ENTITY);
         
           $collectionObject = $collection->find(array($ID=>$VALUE));
           
           $total = $collectionObject->count();
           
           $result = $this->encodeCollection($collectionObject);
         
          
           
            return $result;
     }
        
        
        
    }
    
    
    public function SEARCH_ENTITY_VALUES($ENTITY,$ID_VALUES){
        
     if($this->mongoActive){
           $db = $this->DB;
           $collection = $db->selectCollection($ENTITY);
       
        
           foreach($ID_VALUES as $ID_VALUE){
           
              

           $collectionObject = $collection->find($ID_VALUE);
           $result = $this->encodeCollection($collectionObject);
           
           return $result;
           }
           
           
         
          
           
           
     }
        
        
    }
    
    
    
    public function CHEK_ENTITY($ENTITY){ 
        $ok = FALSE;
        if($this->mongoActive){
        $dbname = $this->DB;
        $collections = $dbname->getCollectionNames();
       
        foreach($collections as $collection){
            if($ENTITY==$collection){
                $ok = TRUE;
                break;
            }
        }
        return $ok;
        }else{
        return $ok;    
        }           
    }
    
    
  
    public function SET_ENTITY($ENTITY,$INDEX=FALSE){
       
        $db = $this->DB;
        
        try{
        $newCollection = $db->createCollection(
         $ENTITY,
          array(
             "autoIndexId" =>$INDEX
               )
          );
       
        }catch(MongoConnectionException $e){
        var_dump($e);
        }
        
    }
    
    
    public function DELETE_ENTITY($ENTITY){
        
        $db = $this->DB;
        
        $collection = $db->$ENTITY;
        
        $response = $collection->drop();
        
        return $response;
        
    }

    
     public function SET_ENTITIES_VALUES($ENTITY,$VALUES,$SECURE_INDEX){
        
        
         foreach($VALUES as $VALUE){
            
             
             $RESULT=$this->SET_ENTITY_VALUE($ENTITY, $VALUE, $SECURE_INDEX);
             
            
             
         }
         
         
        
     }
    
    
    
     public function SET_ENTITY_VALUE($ENTITY,$VALUE,$SECURE_INDEX){
        
        
         
        if($this->mongoActive){  
            
        $db = $this->DB;
        $collection = $db->$ENTITY;
        
        //var_dump($ENTITY);

        if(!$this->CHEK_ENTITY($ENTITY)){
        //$ENTITY='data';
        $this->SET_ENTITY($ENTITY);    
        
        $indexes = $this->checkIndex($ENTITY);
       
        if (count($indexes) == 0) {
           
           try{ 
           $collection->ensureIndex(array($SECURE_INDEX => 1), array('unique' => TRUE,'dropDups' => TRUE));
           }catch (MongoCursorException $e) {
              //var_dump($e);  
           }
        }
       
        }
          

        
            try {
                $collection->insert($VALUE);
            } catch (MongoCursorException $e) {
               
             
              return array("insert"=>"false");
            }
        
         
        }else{
            return array("mongo"=>"not connection");
        }
         
         
     }
     
     
     public function SET_ENTITY_VALUE_ID($ENTITY,$ID,$VALUE,$VALUES){
         
         if($this->mongoActive){ 
          $db = $this->DB;
     
           $collection = $db->selectCollection($ENTITY);
       
           
           $collection->update(array($ID=>$VALUE),array('$set'=>$VALUES));
          
          }
         
     }
     
     public function UNSET_ENTITY_VALUE_ID($ENTITY,$ID,$VALUE,$VALUES){
         
           if($this->mongoActive){ 
          $db = $this->DB;
     
           $collection = $db->selectCollection($ENTITY);
           
           $collection->update(array($ID=>$VALUE),array('$unset'=>$VALUES));
          
          }
         
     }
     
     
     public function GET_ENTITY_VALUE($ENTITY,$LIMIT=10,$SORT=array()){
         
        if($this->mongoActive){ 
        $db = $this->DB;
        
        
        $collectionObject = $db->selectCollection($ENTITY)->find();
        
       
        $total = $collectionObject->count();
        
        if(count($SORT)==0){
         
        $collectionObject->sort($SORT);    
     
        $collectionObject->limit($LIMIT);
             
        }else{
        
        
        $collectionObject->limit($LIMIT);

        }
        
        $result = $this->encodeCollection($collectionObject);
     
        return $result;
        }else{
        return array();    
        }  
         
       
         
     }
     
     
     public function GET_ENTITY_VALUE_ID($ENTITY,$ID,$LIMIT=1){
         
                
         
        if($this->mongoActive){ 
        $dbname = $this->DB;

        $collection = $dbname->selectCollection($ENTITY);
        
        $indexes=$this->checkIndex($ENTITY);
    
        
        if(isset($indexes[0])){
        $id=$indexes[0];
        }else{
        $id ='id';    
        }
         
        $collectionObject = $collection->find(array($id=>$ID))->limit($LIMIT);

        $result = $this->encodeCollection($collectionObject);

        if(isset($result[0])){
        
        return $result[0];
        }else{
        return array();    
        }
       
        
        } 
     }
     
       public function GET_ENTITY_VALUE_BY_ID($ENTITY,$BY,$ID,$LIMIT=10){
        
        if($this->mongoActive){ 
        $dbname = $this->DB;

        $collection = $dbname->selectCollection($ENTITY);
       
       
        $collectionObject = $collection->find(array($BY=>$ID))->limit($LIMIT);

        $result = $this->encodeCollection($collectionObject);

        
        return $result;
        
       
        
        } 
     }
     
     
    public function GET_ENTITY_VALUE_BY_IDS($ENTITY,$IDS=array()){
         
        if($this->mongoActive){ 
        $dbname = $this->DB;

        $collection = $dbname->selectCollection($ENTITY);
       
         
        $collectionObject = $collection->find($IDS);

        $result = $this->encodeCollection($collectionObject);

        
        return $result;
        
       
        
        } 
     } 
     
     
     
      public function encodeCollection($collectionObject){
        
        
        
        $structureArray = array();
        
        $i =-1;
        
        foreach($collectionObject as $object){
            
            $i++;
            
            unset($object["_id"]);
            
            
            $structureArray[$i]=$object;
            
        }
        
        return $structureArray;
        
    }
     
     
    public function checkIndex($collection) {
        if($this->mongoActive){ 
        $indexSet = array();
        $dbname = $this->DB;
        $collection = $dbname->selectCollection($collection);

        $indexes = $collection->getIndexInfo();

        foreach ($indexes as $key => $index) {

            $nameIndex = $index['name'];

            $name_code = explode('_', $nameIndex);

            if ($name_code[0] == '') {
                $name = 'id';
                $indexSet[] = 'id';
            } else {
                $name = $name_code[0];
                $indexSet[] = $name;
            }
        }
        return $indexSet;
        }else{
        return array();   
        }
    }
    
    
    
    public function GET_VALUE($VARIABLE,$NAME){
        
        $values = $this->VALUE($VARIABLE,$NAME); 
        
     
        $VALUE = array();
        
        foreach($values as $key=>$val){

            
            if (strpos($key,$NAME) !== false) {
                
                $VALUE[$key]=$val;
                
            }
  
        } 
        
        
        return $VALUE;
        
    }
    
    
    public function SET_VALUE($VARIABLE,$SUB_ENTITY,$VALUE){
            
            
         $string_array = str_replace(':','"]["',$SUB_ENTITY);
   
         eval('$VARIABLE["'.$string_array.'"]=$VALUE;');
                 
         return $VARIABLE;
            
        
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
    
    
    public function SEARCH($ENTITY, $searchWord, $limit = 1) {
        
        $result = array();
        $db = $this->DB;
        
        
        $collection = $db->$ENTITY;

        $cursor = $collection->find(
         array(
        '$text' => array('$' =>$searchWord)
             )
         )->limit($limit);
        

       foreach($cursor as $field){
           
           $result[] = $field;
           
       }
  
       
       return $result;


    
    }
    
    
    public function SEARCH_IN($ENTITY,$FIELDS=array('text'=>'value')){
        
        $dbname = $this->DB;

        $result =array();
        
        $collection = $dbname->selectCollection($ENTITY);
     
        
        
    }
    
    
    public function SEARCH_LIKE($ENTITY, $index, $like) {
        $dbname = $this->DB;

        $result =array();
        
        $collection = $dbname->selectCollection($ENTITY);

        $regularExpression = array($index => new MongoRegex("/" . $like . "/i"));

        $collectionObject = $collection->find($regularExpression);

        $result = $this->encodeCollection($collectionObject);
        
  
         
       
       
       return $result;
        
        
    }
    
    
 
    
    
    
        public function DELETE_VALUE($ENTITY, $data) {

        $dbname = $this->DB;
        $collection = $dbname->selectCollection($ENTITY);

        foreach ($data as $index => $value) {

            $find = $collection->find(array($index => array('$in' => array($value))));
            $counter = 0;
            foreach ($find as $found) {
                $counter++;
            }
            if ($counter != 0) {
                try {
                    $collection->remove(array($index => $value));
                    return array('result'=>TRUE);
                } catch (MongoCursorException $e) {
                    return array('result'=>FALSE);
                }
            } else {
                    return array('result'=>FALSE);
            }
        }
    }
       
}
