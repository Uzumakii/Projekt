<?php
/*
==================================================================
- Program -
Manga Reader.

- Zasada działania -

Według wytycznych, program ma za zadanie przede wszystkim
wyświetlać w sposób przyjazny użytkownikowi obrazki
pobierane z folderu w tym wypadku do kultowej
już mangi.

+	Copyright (C) 2013 +

+ Krzysztof Pazdur <pazdurk@gmail.com> (https://github.com/efik)
+ Tomasz Tomala	<twój@email> (https://github.com/NightWalker23)
			
			
Niniejszy program jest wolnym oprogramowaniem; możesz go 
rozprowadzać dalej i/lub modyfikować na warunkach Powszechnej
Licencji Publicznej GNU, wydanej przez Fundację Wolnego
Oprogramowania - według wersji 2-giej tej Licencji lub którejś
z późniejszych wersji. 

Niniejszy program rozpowszechniany jest z nadzieją, iż będzie on 
użyteczny - jednak BEZ JAKIEJKOLWIEK GWARANCJI, nawet domyślnej 
gwarancji PRZYDATNOŚCI HANDLOWEJ albo PRZYDATNOŚCI DO OKREŚLONYCH 
ZASTOSOWAŃ. W celu uzyskania bliższych informacji - Powszechna 
Licencja Publiczna GNU. 

Z pewnością wraz z niniejszym programem otrzymałeś też egzemplarz 
Powszechnej Licencji Publicznej GNU (GNU General Public License);
jeśli nie - napisz do Free Software Foundation, Inc., 675 Mass Ave,
Cambridge, MA 02139, USA.

==================================================================
*/
	#===============================================#
	# Klasy dzięki którym możliwe będzie stworzenie #
	# programu Manga Reader                         #
	#===============================================#
	require("reader/module.template.inc.php");
	require("reader/module.reader.inc.php");
	
	
	#===============================================#
	# Wywoływanie klas i ustawianie ich parametrów  #
	#===============================================#	
	$szablon 	= new Template('./template/'); # Od tej pory Folder ./template/ będzie naszym punktem tworzenia styli
	$reader 	= new Reader();				   # Główny silnik programu
	
	


	
	#===============================================#
	# Czynność wykonywana tylko raz w przypadku gdy #
	# program nie znajdzie swoich plików            #
	#===============================================#
	if(!$reader->PobierzIndex())
	{
		$reader->GenerujIndex();
	}
	
	#===============================================#
	# Zmienne które przechwycą to co leci           #
	# parametrem $_GET.                             #
	#===============================================#
	$manga_hash_id 		= $_GET['m'];	# mangi kodowane w md5
	$manga_rozdzial 	= $_GET['r'];   # rozdziały mang
	$manga_strona 		= $_GET['s'];	# strony aktualnego rozdziłu


	$wystopil_blad = false;
	
	if(isset($manga_hash_id) && isset($manga_rozdzial) && isset($manga_strona))
	{
		// Pobieramy sobie mangę sprawdzając zgodność hashy z tymi w indexie.
		$aktualna_manga = $reader->GetkManga($manga_hash_id);

		// Jeżeli tablica nie jest pusta.
		if(count($aktualna_manga) != 0 && is_numeric($manga_strona) && is_numeric($manga_rozdzial))
		{

			#===============================================#
			# Pobiera liste obrazów z wybranego rozdziału   #
			#===============================================#
			$lista_zdjec = glob($aktualna_manga["nazwa"].'/'.$manga_rozdzial.'/*.jpg');
			$ile_zdjec	 = count($lista_zdjec);
			 
			if($ile_zdjec == 0 )
			{
				$wystopil_blad = true;
			}
			else
			{
				if($manga_strona > $ile_zdjec)
				{
					$wystopil_blad = true;	
				}
				else
				{
					# Pierwsza pętla która przerobi mi te obrazki na strony dla readera.
					$i = 0;	// licznik pętli
					do
					{
						$szablon->assign_block_vars('wybor_stron',array(
							'STR' => ($i == ($manga_strona-1)) ? '<li class="current">'.($i+1).'</li>' : '<li><a href="?m='.$manga_hash_id.'&r='.$manga_rozdzial.'&s='.($i+1).'">'.($i+1).'</a></li>'
						));
					
						$i++;
					
					}
					while( $i < $ile_zdjec);
				}
			}
			
			// sprawdzanie czy nie przekroczyliśmy indexu.
			if( $manga_rozdzial >= 1  && $manga_rozdzial <= $aktualna_manga["rozdz"])
			{
				
				// wyświetlanie rozdziałów
				$i = 1;
				do
				{
					$szablon->assign_block_vars('rozdzialy',array(
						'ROZ' => ($i ==  $manga_rozdzial ) ?  '<li class="current"> Rozdział '.($i).'</li>' : '<li><a href="?m='.$manga_hash_id.'&r='.$i.'&s=1"> Rozdział '.$i.'</a></li>' 
					
					));	
					$i++;
				}
				while ( $i <= $aktualna_manga["rozdz"]);		
			}
			else
			{
				$wystopil_blad = true;
			}
		} // koniec: jeśli tablica nie jest pusta.
		else
		{
			$wystopil_blad = true;
		}
	}
	else
	{
		$wystopil_blad = true;
	}

		if($wystopil_blad)
		{
			#===============================================#
			# Ustawiamy przestrzen nazw oraz przypisujemy   #
			# ja do konkretnego pliku który będzie szablonem#
			#===============================================#	
			$szablon->set_filenames(array(
				'error' => 'error_template.tpl')
			);

			$szablon->pparse("error");
			exit;	
		}
		else
		{
			#===============================================#
			# Ustawiamy przestrzen nazw oraz przypisujemy   #
			# ja do konkretnego pliku który będzie szablonem#
			#===============================================#	
			$szablon->set_filenames(array(
				'body' => 'main_template.tpl')
			);
			 $szablon->assign_vars(array(
			 		
					'LEFT_IMAGE' => ($manga_strona == 1) ? "#" : '?m='.$manga_hash_id.'&r='.$manga_rozdzial.'&s='.($manga_strona-1),
					'IMAGE' => $lista_zdjec[$manga_strona-1],					
					'RIGHT_IMAGE' => ($manga_strona == $ile_zdjec) ? "#" : '?m='.$manga_hash_id.'&r='.$manga_rozdzial.'&s='.($manga_strona+1),
					'MAX_NB' => $ile_zdjec,
					'AKT_POS' => $manga_strona,		
					'PAGE_TITLE' => basename($aktualna_manga['nazwa']),			
		
					));		 	
			$szablon->pparse("body");
		}
?>