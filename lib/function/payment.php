<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require ($_SERVER['DOCUMENT_ROOT'].'/lib/payment/Conekta.php');

class lib_function_payment {
    
    
     public function __construct() {
     
         
       Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");

       
         
     }
     
}