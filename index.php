<!DOCTYPE HTML>
<?php // <html manifest="application.manifest">?>
<head>
<meta charset="UTF-8">
<title>LinderMem</title>

<!-- Linder intnet11 Lab3 -->

<meta name="viewport" content="width = device-width; initial-scale=1; maximum-scale=1; user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<link rel="apple-touch-icon" href="img/touchicon.png" />
<?php // <link rel="apple-touch-startup-image" href="startup.png"> ?>

<!-- 320x460 for iPhone 3GS -->
<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and not (-webkit-min-device-pixel-ratio: 2)" href="img/startup.png" />

<!-- 640x920 for retina display -->
<link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="img/startup2x.png" />
<? /*
<!-- iPad Portrait 768x1004 -->
<link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: portrait)" href="startup-iPad-portrait.png" />

<!-- iPad Landscape 1024x748 -->
<link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: landscape)" href="startup-iPad-landscape.png" />
*/ ?>


<?php // <link rel="stylesheet" media="all" href="memorystyle.css" /> ?>

<link rel="stylesheet" media="all" href="css/masterstyle.css" />

<link rel="stylesheet" media="all and (max-device-width: 480px) and (orientation:portrait)" href="css/iphonestyle_portrait.css" />
<link rel="stylesheet" media="all and (max-device-width: 480px) and (orientation:landscape)" href="css/iphonestyle_landscape.css" />

<?php /*
<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:portrait)" href="ipad-portrait.css" />
<link rel="stylesheet" media="all and (device-width: 768px) and (device-height: 1024px) and (orientation:landscape)" href="ipad-landscape.css" />
*/ ?>

<link rel="stylesheet" media="all and (min-device-width: 481px)" href="css/computer.css" />

<script type="text/javascript">

// är det spelare 1s tur?
var spelare1 = true;

var spelare1score = 0;
var spelare2score = 0;

var val1;
var val2;

var klick = 0;

var retina = window.devicePixelRatio > 1 ? true : false;


if (retina || (window.innerHeight > 700)) {
    // the user has a retina display or a screen height more than 700px

	var loadkort = ["http://farm5.static.flickr.com/4110/5190565123_cbc79d99ba_q.jpg",
	"http://farm5.static.flickr.com/4151/5191071610_7e17a8ef11_q.jpg",
	"http://farm5.static.flickr.com/4130/5074234337_f26fb0d3a1_q.jpg",
	"http://farm5.static.flickr.com/4126/5074831048_a820d4b730_q.jpg",
	"http://farm5.static.flickr.com/4133/5197870406_eb6d43a6bd_q.jpg",
	"http://farm5.static.flickr.com/4145/5197240603_1803c320e2_q.jpg",
	"http://farm5.static.flickr.com/4145/5190423191_7c95f7b129_q.jpg",
	"http://farm5.static.flickr.com/4130/5197872626_9e4f3fc16d_q.jpg"];

}
else {
    // the user has a non-retina display

	var loadkort = ["http://farm5.static.flickr.com/4110/5190565123_cbc79d99ba_s.jpg",
	"http://farm5.static.flickr.com/4151/5191071610_7e17a8ef11_s.jpg",
	"http://farm5.static.flickr.com/4130/5074234337_f26fb0d3a1_s.jpg",
	"http://farm5.static.flickr.com/4126/5074831048_a820d4b730_s.jpg",
	"http://farm5.static.flickr.com/4133/5197870406_eb6d43a6bd_s.jpg",
	"http://farm5.static.flickr.com/4145/5197240603_1803c320e2_s.jpg",
	"http://farm5.static.flickr.com/4145/5190423191_7c95f7b129_s.jpg",
	"http://farm5.static.flickr.com/4130/5197872626_9e4f3fc16d_s.jpg"];
}

var kort = loadkort.concat(loadkort);


function load() {

	// blandar om bland korten!
	kort.sort(function() {return 0.5 - Math.random()})
	
	
	// preload bilderna!
	preload_image_object = new Image();

	for (var i=0; i<kort.length; i++) 
		preload_image_object.src = kort[i];

	
	// resettar spelplanen, om ett nytt spel ska anropas!
	for (var i=1; i<kort.length+1; i++) {
		document.getElementById("kort"+(i)).src = "cardback.svg";
		document.getElementById("kort"+(i)).className = "kort"; // klickpekaren
	}

	//alert("hej");

	
	resetpointsandtext();
	

}


function click(id) {


/*

* första klicket

	vänder ett kort.

	första klicket blir "ej klickbart"

* andra klicket

	par eller inte par

	om par, kollar vilken spelare, ge poäng. samma spelare får fortsätta. behåll kort "öppna".
	kolla om någon vinnit spelet. om toalt antalpar är >= 8 spelet är avslutat. i så fall, vem vann?!

	om ej par, byt spelare och vänd tillbaka kort. (efter 2 sek? alt om man trycker på någon annan...?)

*/


	if(document.getElementById("kort"+(id)).src.indexOf("cardback") != -1) { // kollar om kortet är "greenbox", dvs baksidan upp.
	
		if (val2 != null) { // dvs, restore-funktionen har ännu inte hunnit köras... går fortfarande att se felvända kort...

			restorekort(); // kör restore utan delay. lika innan de vänts tillbaka automatiskt gör enbart att restore körs direkt, inte att man vänder någon ny...
	
			//updatetext("Inge stress tack, var god vänta!");
		}

		else {

			yetanotherclick();
		
			if(val1 == null) {
			
				document.getElementById("kort"+(id)).src = kort[id-1]; // gör bild synlig.
				document.getElementById("kort"+(id)).className = "kortnoclick"; // tar bort klickpekaren
			
				val1 = id;
			
				updatetext("Håller tummen...");

			}

			else {
		
				document.getElementById("kort"+(id)).src = kort[id-1]; // gör bild synlig.
				document.getElementById("kort"+(id)).className = "kortnoclick"; // tar bort klickpekaren
			
				val2 = id;

				// par eller inte par?! det är frågan...
					
				if (kort[val1-1] == kort[val2-1]) {
			
					//updatetext("PAR!!! Du får fortsätta!");
					
					if (spelare1) {
						updatetext("PAR!!! Spelare 1 får fortsätta!");
					}
	
					else {
						updatetext("PAR!!! Spelare 2 får fortsätta!");
					}
					
					if (spelare1) {
						yetanotherpair(1);
					}
					else { yetanotherpair(2); }
					
					val1 = null;
					val2 = null;

					// Är spelet klart nu?!?!?!?!?!?! Bäst att kolla upp det!!!
					
					if ((spelare1score + spelare2score) >= 8) {
					
						var vinnare;
						
						if (spelare1score > spelare2score) {
							vinnare = "Spelare 1 är vinnaren!";
							spelare1 = false;
						}
						else if (spelare1score == spelare2score) {
							vinnare = "Lika. Ingen vinnare, kör igen!";
						}
						else {
							vinnare = "Spelare 2 är vinnaren!";
							spelare1 = true;
						}						
						
						var nyttspel;
						
						nyttspel = ' <span style="color: #98ff9f; cursor: pointer" onclick="load()">Igen?</span>';
						
						updatetext("GAME OVER! " + vinnare + nyttspel);
					
					}
				}
			
				else {
				
					updatetext("Inte par...");
				
					// vänder tillbaka brickorna och rensar val1 och val2. // MÅSTE SKE EFTER NÅGRA SEKUNDER SÅ ATT DET GÅR ATT SE!!!
				
					setTimeout("restorekort()", 3000);
			
				}
		
			}
			
		}
		
	}

	
	else {
	
		// händer inget om man klickar på ett vänt kort just nu....
			
	}

}

function yetanotherpair(player) {

	if (player == 1) {
		spelare1score++;
		document.getElementById("paircounter_1").innerHTML = spelare1score;
	}
	
	else {
		spelare2score++;
		document.getElementById("paircounter_2").innerHTML = spelare2score;
	}	

}


function yetanotherclick() {

	klick++;
	//document.getElementById("clickcounter").innerHTML = klick;

}


function updatetext(message) {

	document.getElementById("infotext").innerHTML = message;

}

function resetpointsandtext() {

//	updatetext("Nytt spel! Spelare 1 börjar alltid.");
	
	if (spelare1) {
		updatetext("Nytt spel! Spelare 1 börjar.");
	}
	
	else {
		updatetext("Nytt spel! Spelare 2 börjar.");
	}
	
	document.getElementById("paircounter_1").innerHTML = 0;
	document.getElementById("paircounter_2").innerHTML = 0;
	spelare1score = 0;
	spelare2score = 0;
	
	document.getElementById("options").className = "ishidden";
	
}


function restorekort() {
	
	// BEHÖVER EN IF-SATS SOM KOLLAR OM DEN REDAN HAR KÖRTS!!!!!
	
	if (val1 !=null && val2 !=null) {
			
		document.getElementById("kort"+(val1)).src = "cardback.svg";
		document.getElementById("kort"+(val1)).className = "kort"; // klickpekaren
	
		document.getElementById("kort"+(val2)).src = "cardback.svg";
		document.getElementById("kort"+(val2)).className = "kort"; // klickpekaren
		
		val1 = null;
		val2 = null;
		
		if (spelare1) {
			updatetext("Spelare 2:s tur.");
			spelare1 = false;
		}
	
		else {
			updatetext("Spelare 1:s tur.");
			spelare1 = true;
		}
	}

}

function hover(id) {
	
	if(document.getElementById("kort"+(id)).src.indexOf("cardback.svg") != -1) {

		document.getElementById("kort"+(id)).src = "cardback_hover.svg";	

	}
}

function unhover(id) {
	
	if(document.getElementById("kort"+(id)).src.indexOf("cardback_hover.svg") != -1) {
	
		document.getElementById("kort"+(id)).src = "cardback.svg";
		
	}
}

function blockMove() {
      event.preventDefault() ;
}

function openoptionbox() {
	document.getElementById("options").className = "isnothidden";
}

function closeoptionbox() {
	document.getElementById("options").className = "ishidden";
}


var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-265769-3']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

</head>

<body onload="load()" ontouchmove="blockMove()">

<header>
	<h1>Linder Memory</h1>
</header>

<table>

	<tr>
		<td><img src="cardback.svg" height="75" width="75" id="kort1" onclick="click(1)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(1)" onmouseout="unhover(1)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort2" onclick="click(2)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(2)" onmouseout="unhover(2)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort3" onclick="click(3)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(3)" onmouseout="unhover(3)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort4" onclick="click(4)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(4)" onmouseout="unhover(4)" '; ?>class="kort" /></td>
	</tr>
	
	<tr>
		<td><img src="cardback.svg" height="75" width="75" id="kort5" onclick="click(5)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(5)" onmouseout="unhover(5)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort6" onclick="click(6)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(6)" onmouseout="unhover(6)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort7" onclick="click(7)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(7)" onmouseout="unhover(7)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort8" onclick="click(8)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(8)" onmouseout="unhover(8)" '; ?>class="kort" /></td>
	</tr>
	
	<tr>
		<td><img src="cardback.svg" height="75" width="75" id="kort9" onclick="click(9)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(9)" onmouseout="unhover(9)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort10" onclick="click(10)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(10)" onmouseout="unhover(10)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort11" onclick="click(11)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(11)" onmouseout="unhover(11)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort12" onclick="click(12)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(12)" onmouseout="unhover(12)" '; ?>class="kort" /></td>
	</tr>
	
	<tr>
		<td><img src="cardback.svg" height="75" width="75" id="kort13" onclick="click(13)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(13)" onmouseout="unhover(13)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort14" onclick="click(14)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(14)" onmouseout="unhover(14)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort15" onclick="click(15)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(15)" onmouseout="unhover(15)" '; ?>class="kort" /></td>
		<td><img src="cardback.svg" height="75" width="75" id="kort16" onclick="click(16)" <?php if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(16)" onmouseout="unhover(16)" '; ?>class="kort" /></td>
	</tr>

</table>

<div id="textdisplay">
	
	<p id="infotext">Laddar, snart så!!</p>

	<p id="stats">Player 1: <span id="paircounter_1">0</span> Player 2: <span id="paircounter_2">0</span></p>

</div>

<div id="options" class="ishidden">
	<h2>Options</h2>
	<p><span class="onclicklink" onclick="load()">New Game</span></p>
	<p>Flickr/500px integration, save game, all english, are features which is coming soon...</p>
	<p><span class="onclicklink close" onclick="closeoptionbox()">Close</span></p>
</div>

<?php // <p>number of clicks: <span id="clickcounter">0</span>.</p> ?>

<?php // skapa en newgame(); funktion!!! ?>

<?php // 1.3?? <nav>Settings | <a href="http://marcuslinder.se/">About</a></nav> ?>

<nav><span class="onclicklink" onclick="openoptionbox()">Options</span> | <a href="http://marcuslinder.se/">marcuslinder.se</a>/memory [v1.2]</nav>


<footer>
	
	<p><a href="http://marcuslinder.se/">marcuslinder.se</a>/memory [v1.2]</p>

    <?php //if(!(strstr($_SERVER['HTTP_USER_AGENT'],'iPad') || strstr($_SERVER['HTTP_USER_AGENT'],'iPhone'))) echo 'onmouseover="hover(13)" onmouseout="unhover(13)" '; ?>

<?php // echo($_SERVER['HTTP_USER_AGENT']); ?>
</footer>

<div id="extraspace"><br><br><br></div>

<?php // <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />?>

</body>
</html>