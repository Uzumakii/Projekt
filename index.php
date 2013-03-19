<?php
	#index 
	require("admin/module.template.inc.php");
	require("admin/module.reader.inc.php");
	$templates = new Template('./template/');
	$reader = new Reader();
	
$templates->set_filenames(array(
	'body' => 'document.html')
);

	if(!$reader->PobierzIndex())
	{
		$reader->GenerujIndex();
	}
	$manga_hash_id =  $_GET['m'];
	$manga_rozdzial = $_GET['r'];
	$manga_strona = $_GET['s'];
	
	if(isset($manga_hash_id) && isset($manga_rozdzial) && isset($manga_strona))
	{
		
		$aktualna_manga = $reader->GetkManga($manga_hash_id);
	 
		if(count($aktualna_manga) != 0)
		{
			/*
			
				Prowizoryczne wyswietlanie stron
			
			*/
			$files = glob($aktualna_manga["nazwa"].'/'.$manga_rozdzial.'/*.jpg');
			$ile = count($files);
			 

			$i = 0;
			do
			{
				$templates->assign_block_vars('wybor_stron',array(
					'STR' => ($i  == ($manga_strona-1)) ? '<li class="current">'.($i+1).'</li>' : '<li><a href="?m='.$manga_hash_id.'&r='.$manga_rozdzial.'&s='.($i+1).'">'.($i+1).'</a></li>'
				
				));	
				$i++;
			}
			while ( $i < $ile);
			
			/*
				
				Prowizoryczne wyświetlanie rozdzialów
			
			*/

			$i = 1;
			do
			{
				$templates->assign_block_vars('rozdzialy',array(
					'ROZ' => ($i ==  $manga_rozdzial ) ?  '<li class="current">'.($i).'</li>' : '<li><a href="?m='.$manga_hash_id.'&r='.$i.'&s=1">'.$i.'</a></li>' 
				
				));	
				$i++;
			}
			while ( $i <= $aktualna_manga["rozdz"]);		
		}
	}
	
	
	 
	$templates->pparse("body");
?>