<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="header" id="header">
        <span class="titleMain">
            <p class="message" id="company" ><p><img class="logo" src="<?php echo $this->IMAGE("/html/ftf/FEEDTOFOOD_W_32.png"); ?>" ><a class="trade" >Feed to Food</a><a class="description_trade"><?php echo $this->TEXT("servicesAndSupplyGastronomic"); ?> </a></p>
        </span>
        <span class="users">
        
        </span> 
    
</div>
<div class="wall_center">
    <span class="brickLeft">*</span>
    <span class="brickCenter">
    <span class="searchInput">
        <?php  ?>
       <span class="searchTitle"><p><?php echo $this->TEXT('whereIsMyBussines'); ?></p></span>
       <input class="searchValue" value="<?php echo $this->VARIABLE('address'); ?>" type="text" placeholder="<?php echo $this->TEXT("anyPlace"); ?>" > 
    </span>
    <span class="searchInput">
       <span class="searchTitle"><p><?php echo $this->TEXT("wichServiceOrSupplyFind"); ?></p></span>
       <input class="searchValue" value="<?php echo $this->VARIABLE('service'); ?>" type="text" placeholder="<?php echo $this->TEXT("anySupplyOrService"); ?>" > 
    </span>
   
    <span class="searchInput">
       <span class="searchTitle"><p><?php echo $this->TEXT("goToSearch"); ?></p></span>
       <input class="searchValue" data="<?php echo $this->VARIABLE("goSearch"); ?>" type="button" value="<?php echo $this->TEXT("next"); ?>" > 
    </span>
    </span>
    <span class="brickRight">*</span>
  
    <div class="wall_register">
       
 
        
        <span class="inputBox">
             <p class="textTitle"><?php echo $this->TEXT("register"); ?></p>
        </span>
        
        
      
        <span class="inputBox">
            <p><b class="step">1</b>.-<?php echo $this->TEXT("email"); ?></p>
            <input type="text" placeholder="<?php echo $this->TEXT("myAccount@my_restaurant.com") ?>" >
        </span>
        
        <span class="inputBox">
            <p><b class="step">2</b>.-<?php echo $this->TEXT("myPassword"); ?></p>
            <input type="password" placeholder="<?php echo $this->TEXT("mySecretPassword"); ?>">
            
        </span>
        
        <span class="inputBox">
            <p><b class="step">3</b>.-<?php echo $this->TEXT("As"); ?></p>
            
            <button class="inputButton"><?php echo $this->TEXT("chef"); ?></button>
            
            <button class="inputButton"><?php echo $this->TEXT("Dueño de un Negocio"); ?></button>
            <span class="subInputButton" style="display:none;">
                <button class="inputButton"><?php echo $this->TEXT("Un Restarurant"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Un Bar"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Merendero"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Negocio de Comida Rapida"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Pasteleria"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Cafeteria"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Jugueria"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Heladeria"); ?></button>
                <button class="inputButton"><?php echo $this->TEXT("Panaderia"); ?></button>
                 
                
            </span>
            
            <button class="inputButton"><?php echo $this->TEXT("Sumunistrador Gastronomico"); ?></button>
 
            <button class="inputButton"><?php echo $this->TEXT("Servicio Gastronomico"); ?></button>
            
            
            
        </span>
        <span class="inputBox">
            <p><b class="step">4</b>.- <?php echo $this->TEXT("ready"); ?></p>
            <button class="inputButton"><?php echo $this->TEXT("begin"); ?></button>
        </span>
        
        
    </div>
    
    
    
</div>

