<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<html>
    <head>
        <title>message</title>
    </head>
    <body id="body" data-content="edit.default" data-target="body" > 
    <div class="header" id="edit.default">  
   
    <div id="section:0" class="section">    
    <span><h4>Edit</h4></span>
    <span class="input">            
    <input type="button" onclick="action('variable:add');" name="add" value="ADD VARIABLE">
    </span> 
    <br>
    <br>
    <span class="input"> 
    <input type="button" onclick="action('variable:load')" name="load" value="LOAD VARIABLE">
    </span> 
    <br>
    <br>
    <span class="input"> 
    <input type="button" onclick="action('variable:search')" name="load" value="SEARCH VARIABLE">
    </span>     
    </div>
   
    <div id="section:1" class="section">    
    <span><h4>Add Variable</h4></span>
    <span class="input">
    <h5>ENTITY</h5>    
    <input class="input_variable" type="text"  name="add" value="">
    </span> 
    <br>
    <span class="input"> 
    <h5>SET</h5>    
    <input class="input_variable" type="text"  name="set" value="">
    </span>
    <br>
    <span class="input"> 
    <h5>STATE</h5>    
    <input class="input_variable" type="text"  name="state" value="">
    </span>
    <br>
    <span class="input"> 
    <h5>TEXT</h5>    
    <input class="input_variable" type="text"  name="text" value="">
    </span> 
    <br>
    <span class="input"> 
    <h5>VALUE</h5> 
       
          <input class="add" type="button" value="Add Value"> 
          <br>
          <br>
          <div class="variable_values">
          
          <span>
          <br>    
          <p>entity</p>   
          <input class="input_variable" type="text"  name="entity:0" value="">
          <br>
          <br>
          <input type="button"  value="MULTI">
          <br>
          <br>
           <input type="button"  value="SIMPLE">
          <br>
          <br>
          </span>
          <br>    
          </div>        
    </span>  
    <br>
    <input type="button" class="add_variable" value="ADD VARIABLE" >
    </div>        
           
    </div>
    </body>
</html>