<?php
	#index 
	require("admin/module.template.inc.php");
	
	$templates = new Template('./template/');
	
	$templates->set_filenames(array("body" => "document.html"));
	
	$templates->pparse("body");
?>