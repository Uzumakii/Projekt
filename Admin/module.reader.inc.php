<?php

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
		public function GenerujIndex()
		{
			if($this->ilemang != 0)
			{
				for($i=0; $i < $this->ilemang; $i++)
				{
					$rozdzialow = count(glob($this->mangi[$i].'/*',GLOB_ONLYDIR));
					 $struktura[] = array(
									"nazwa" =>$this->mangi[$i],
									"md5" => md5($this->mangi[$i]),
									"rozdz" => ($rozdzialow)
								 );
				}
			}
			var_dump($struktura);
		}
	}


?>