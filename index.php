<?php
	#index 
	require("admin/module.template.inc.php");
	require("admin/module.reader.inc.php");
	$templates = new Template('./template/');
	$reader = new Reader();
	$templates->set_filenames(array("body" => "document.html"));
	if(!$reader->PobierzIndex())
	{
		$reader->GenerujIndex();
	}
	
	
	
	$templates->pparse("body");
?>