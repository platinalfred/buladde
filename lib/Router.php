<?php 
Class Router(){
	public function controlPanel($defualt){
	   if(@$_GET['option'] != NULL){
		   $menu = ucwords(implode(" ", explode("_", @$_GET['option'])));
	   }else {
			$menu = ucwords("home");
	   }

	   if(@$_GET['submenu'] != NULL){
			//Remove | Character
			$string = substr(strstr($_GET['submenu'],"|",false),1);
		   @$item = ucwords(implode(" ",explode("_",$string)));
	   }else{
		   $item = ucwords(implode(" ", explode("_", $defualt)));
	   }

	   $header = $menu." - ".$item;
	   ?>
			<h1 id="main_header"><?php echo $header; ?></h1>
			<div id="tabs">
				<div id="internal_nav">
					<?php
						$this->internalMenu($item);
					?>
				</div>
				<div id="admin_content">
					  <!--Option Here -->
					 <?php
					 
						$task = $this->getTask();
						$content = new Route($task);
						//$content = new Content($task);
					  ?>

				</div>
			</div>
	   <?php
   }
 }