<?php
	#index 
	require("admin/module.template.inc.php");
	require("admin/module.reader.inc.php");
	$templates = new Template('./template/');
	$reader = new Reader();
	$templates->set_filenames(array("body" => "document.html"));
	
	$reader->GenerujIndex();
	
	var_dump($reader);	
	
	$templates->pparse("body");
?>