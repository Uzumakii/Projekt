<!doctype html>
<html>
<head>
  
<meta charset="utf-8">
<title>{PAGE_TITLE} - Reader Manga</title>
<link href="template/reader.css" rel="stylesheet" type="text/css">
<script src="template/js/jquery-1.9.1.min.js"  type="text/javascript"></script>
<script>
function launchFullScreen(element) {
  if(element.requestFullScreen) {
    element.requestFullScreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullScreen) {
    element.webkitRequestFullScreen();
  }
}
function cancelFullscreen() {
  if(document.cancelFullScreen) {
    document.cancelFullScreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitCancelFullScreen) {
    document.webkitCancelFullScreen();
  }
}
</script>
</head>

<body>
	
	<header>
    <div class="btn_back">
    
    </div>
    		 <div id="przyciski">
               <div class="przycisk_chapter" id="przycisk_01">Wybierz Rozdział&nbsp;&nbsp;<strong>&darr;</strong>               </div>
               <div class="przycisk_manga" id="przycisk_02">Wybierz Stronę &nbsp;&nbsp;<strong>&darr;</strong></div>
               <img id="view-fullscreen" title="Pełny Ekran"   src="template/images/fulscr.png" >

<div id="rozdzial" class="box" style="display:none">
	<ul>
   		 <!-- BEGIN rozdzialy -->
    	 {rozdzialy.ROZ} 
        <!-- END rozdzialy -->
    </ul>
</div>	




<div id="strona" class="box" style="display:none">
	<ul>
<!-- BEGIN wybor_stron -->
    	{wybor_stron.STR}
<!-- END wybor_stron -->
    </ul>
</div>		




		</div>
    </header>
<div id="odstep">
</div>
 
	<div class="reszta_02" align="center" >
    	<a href="{LEFT_IMAGE}"><div class="strzalka" id="strzalka_lewa" draggable="true"></div></a>
		<img src="{IMAGE}"  width="50%" id="obraz">
        <a href="{RIGHT_IMAGE}"><div class="strzalka"    id="strzalka_prawa" draggable="true"></div></a>
        
	</div>
 
<script>

function scin()
{
	launchFullScreen(document.documentElement);
	$("#obraz").animate({height: "100%",width: "100%"},800);
	$(".strzalka").addClass("schowaj");
}
function scout()
{
	cancelFullscreen();
	$("#obraz").animate({height: "50%",width: "50%"},800);
	$(".strzalka").removeClass("schowaj");
}
var opened = false;

$("#view-fullscreen").click(function(e) {
    	if(opened)
		{
			scout();
			opened = false;
		}
		else
		{
			scin();
			opened = true;
		}
});

$("#przycisk_01").click(function()
{
	$("#rozdzial").fadeIn(800);
});
$("#przycisk_02").click(function()
{
	$("#strona").fadeIn(800);
});
	$("#strona").mouseleave(function(e) {
        $("#strona").fadeOut(800);
    });
	$("#rozdzial").mouseleave(function(e) {
        $("#rozdzial").fadeOut(800);
    });
	
	
	// Maksymanlna strona: informacja dla funkcji spr strzałki aby po osiągnięciu tej wartości (aktualna_pozycja) się odpowiednia strzałka chowała.
	var maksymalna_strona = {MAX_NB};
	var aktualna_pozycja = {AKT_POS};
	var minimalna_strona = 1;
	$(document).ready(function()
	{
		if(aktualna_pozycja == minimalna_strona)
		{
			$("#strzalka_lewa").hide();
		}
		else if ( aktualna_pozycja == maksymalna_strona)
		{
			$("#strzalka_prawa").hide();
		}
	}
	);
	
document.onkeypress = document.onkeydown = function(e) {
  if (! e) e = event;
  var arrows = [ 39, 37];
  for (key in arrows) {
    if (arrows[key] == e.keyCode)
	{
		if(arrows[key] == 37)
		{
			if(aktualna_pozycja > minimalna_strona)
			window.location = '{LEFT_IMAGE}';
		}
		else
		{
			if(aktualna_pozycja < maksymalna_strona)
			window.location = '{RIGHT_IMAGE}';
		}
	}
  } 
}
</script>
</body>
</html>
