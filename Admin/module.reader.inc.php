﻿<?php

	class Reader
	{
		public $path = './';
		
		public $folder = 'files/';
			
		private $index_folderow = array();
		
		public $ilemang = 0;
		
		public $mangi = array();
		 		
			function __construct($directory = './',$folder = 'files/')
			{
					$this->path = $directory;
					$this->folder = $folder;
					Reader::IleMangWkatalogu();
			}
		
		public function IleMangWkatalogu()
		{
			$this->mangi = glob($this->path.$this->folder.'*',GLOB_ONLYDIR);
			$this->ilemang = count($this->mangi);
			
			
		}
		public function PobierzIndex()
		{
			if($this->ilemang != 0)
			{
			$this->index_folderow = unserialize(@file_get_contents($this->path.$this->folder.'.index$'));
			}
			else
			{
				return false;
			}
		
		}
		public function GenerujIndex()
		{
			if($this->ilemang != 0)
			{
				for($i=0; $i < $this->ilemang; $i++)
				{
					$rozdzialow = count(glob($this->mangi[$i].'/*',GLOB_ONLYDIR));
					 $struktura[] = array(
									"nazwa" =>$this->mangi[$i],
									"md5" => md5(basename($this->mangi[$i])),
									"rozdz" => ($rozdzialow)
								 );
				}
				@file_put_contents($this->path.$this->folder.'.index$',serialize($struktura)) or error_log("Unable to save database index",2);
			}
			else
			{
				return false;
			}
			 
		}
	}


?>