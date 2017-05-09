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
<div class="wall_center_simple">
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
  

    
    
    
</div>

