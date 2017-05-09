<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!Doctype html>
<html id="html">
<head id="head">
<title id="title"><?php echo "servicios y suministros gastronomicos" ?></title>
<meta id="description" name="description" content="<?php ?>">
<meta id="keywords" name="keywords" content="<?php ?>">
<meta id="geo" name="geo.position" content="<?php ?>">    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link id="skin.default" rel="stylesheet" type="text/css" href="./html/skin/default.css">
<?php foreach($this->SKIN() as $skin): ?>
<link id="skin.default" rel="stylesheet" type="text/css" href="<?php echo $skin; ?>">
<?php endforeach; ?>
<script id="add.script" src="./html/script/prototype.js" ></script> 
  <script id="add.back" src="./html/script/prototype/back.js" ></script>
<?php foreach($this->SCRIPTS() as $script): ?>
<script id="add.script" src="<?php ?>"></script> 
<?php endforeach; ?>
</head>
<body id="body">  
<div id="header">
<span class="header_content">
<h1 class="message" id="company" style="display:block"><img  title="logo" class="logo" src="./html/ftf/FEEDTOFOOD.svg" /><a class="trade" >Feed to Food</a><a class="description_trade"> a gastronomic company</a></h1>    
</span>        
</div>
<div id="contet">        
<div id="steps">
</div>
</div>
<div id="footer">
<?php foreach($this->LINKS() as $foot): ?>
<span>            
</span>
<?php endforeach; ?>
</div>
<?php $this->ADD(); ?>
</body>
</html>