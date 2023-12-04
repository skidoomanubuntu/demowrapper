<!DOCTYPE html>
<html>

<link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8"/>
<?php include 'language_inc.php' ?>
<style>

body, html {
  height: 100%;
}

body {
  /* The image used */
  background-image: url('wallpaper.png');

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  overflow: hidden;
  font-family: 'ubuntulight';
  font-size: '60px';
  color: white;
  font-weight: bold;
  height: 100%;
}

div.screen {
  color: white;
  font-weight: normal;
  <? if (file_exists('jp')) echo 'font-size: 30;'; else echo 'font-size: 40;';?>
  background-color: #300A24;
  overflow-y: hidden;
}

div.screen svg path {
  fill: #ffffff;
}

div.internalscreen {
   overflow-y: auto;
}

div.internalscreen thead th {
   position: sticky;
   top: 0;
}

.fixTableHead {
   overflow: auto;
   height: 50px;
}

.fixTableHead thead th {
   position: sticky;
   top: 0;
}
/*.tableFixHead {
      //width: 500px;
      table-layout: fixed;
      border-collapse: collapse;
      //display: block;
    }
      .tableFixHead tbody {
       display: inline-block;
       width: 100%;
      overflow-y: auto;
      overflow-x: hidden;
      max-height: 37vh;
    }
    .tableFixHead thead tr {
      display: inline-block;
      width: 100%;
    }
 */
}

a:link { color: white;}
a:active { color: orange;}
a:visited { color: white;}
a:hover { color: orange;}


</style>

<script>
function processCommand(command)
{
  //command = "http://192.168.8.199:5002/Performdevops?demoname=Bulb%201%20OFF
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
		if (xhttp.readyState == 4 && xhttp.status == 200) {
			var responseTxt = JSON.parse(xhttp.responseText);
			let str = responseTxt.PerformdevOpsRes;
		}
	};
	request="http://"  + window.location.hostname + ":" + "5002/Performdevops?" +  "demoname=" + command;
	xhttp.open("GET", request, true);
	xhttp.send();
}

var frequency = 4000; // Change colors every four seconds
var validColors = ['Red', 'Green', 'Blue', 'Yellow', 'Cyan', 'Lilac', 'Pink'];
var intensity = ['', 'Half'];
var numberOfBulbs = 1;
var duration = 60000;
//var duration = 20000;

function getRandomInt(max){
   return Math.floor(Math.random() * (max));
}

function goDiscoDingoGo()
{
   // turn the disco ball on
   processCommand('Plug%20on');
   var currentColor = Array(2);
   console.log(currentColor);

   var intervalID = setInterval(function() {
        for (var i = 0; i < numberOfBulbs;  i++)
        {
           //  Get a random number for bulb 1 based on length of validColors
           var seed = currentColor[i];
           while (seed == currentColor[i]){
              seed = getRandomInt(validColors.length);
              console.log('seed is now ' + seed);
           }
           // Also get the intensity
           /*console.log('intensity length ' + intensity.length);
           var intense = getRandomInt(intensity.length);
           console.log('intense ' + intense);*/

           //  Then processCommand, just like with the plug
           var plugNumber = i + 1;
           var command = 'Bulb%20' + plugNumber + '%20' + validColors[seed];
           //if (intense > 0) command += '%20' + intensity[intense];
           console.log(command);
           processCommand(command);
           currentColor[i] = seed;
           
        }

    }, frequency);
    setTimeout(function() {
        clearInterval(intervalID);
        processCommand('Plug%20off');
        for (var i = 0; i < numberOfBulbs; i++){
            var plugNumber = i + 1;
            processCommand('Bulb%20' + plugNumber + '%20OFF');
        }
    }, duration);
}
</script>
<body>
<table border="0">
<tr>
  <td align="center" valign="middle">
  <img src="./matter_black.svg">
  </td>
  <td width="50%"></td>
  <td align="center" valign="middle">
  <img src="./thread.svg" height="75">
  </td>
</tr>
<tr>
  <td valign="top">
  <table border="0">
   <tr>
    <td><a href="#" onclick="processCommand('Bulb%201%20OFF')"><img src="./lightbulb_grey.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20ON')"><img src="./lightbulb.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Red')"><img src="./lightbulb_red.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Green')"><img src="./lightbulb_green.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Blue')"><img src="./lightbulb_blue.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Yellow')"><img src="./lightbulb_yellow.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Cyan')"><img src="./lightbulb_cyan.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Lilac')"><img src="./lightbulb_lilac.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Pink')"><img src="./lightbulb_pink.svg" height="70"></a></td>
   </tr><tr>
    <td><a href="#" onclick="processCommand('Plug%20off')"><img src="./plug_off.svg" height="70"></td>
    <td><a href="#" onclick="processCommand('Plug%20on')"><img src="./plug.svg" height="70"></td>
   </tr>
  </table>
  </td>
  <td width="50%"></td>
  <td valign="top">
    <a href="#" onclick="goDiscoDingoGo()"><img src="./disco_dingo.jpg" width="500"></a>
    <font size="36"><center><p>GO DISCO DINGO GO!</p>
    <p><i>Press the image to start</i></p></center></font>
  </td>
</tr></table>
</body>
</html>

