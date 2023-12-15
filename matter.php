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
	//request="http://"  + window.location.hostname + ":" + "5002/Performdevops?" +  "demoname=" + command;
        request = "http://<?php echo gethostbyname(gethostname()); ?>:5002/Performdevops?demoname=" + command;
	xhttp.open("GET", request, true);
	xhttp.send();
}

function sendGet(url)
{
  try{
     //command = "http://192.168.8.199:5002/Performdevops?demoname=Bulb%201%20OFF
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
                if (xhttp.readyState == 4 && xhttp.status == 200) {
                        var responseTxt = JSON.parse(xhttp.responseText);
                        let str = responseTxt.PerformdevOpsRes;
                }
        };
        xhttp.open("GET", url, true);
        xhttp.send();
     }
  catch(error){}
}


var soundServerURLStart = 'http://jukebox:5000/jukebox?command=start'
var soundServerURLStop = 'http://jukebox:5000/jukebox?command=stop'

var frequency = 4000; // Change colors every four seconds
var validColors = ['Red', 'Green', 'Blue', 'Yellow', 'Cyan', 'Lilac', 'Pink'];
var intensity = ['', 'Half'];
var numberOfBulbs = 2;
var duration = 60000;
//var duration = 20000;

function turnMusicOn() { sendGet(soundServerURLStart); }
function turnMusicOff() { sendGet(soundServerURLStop); }

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

function getRandomInt(max){
   return Math.floor(Math.random() * (max));
}

function goDiscoDingoGo()
{
   // turn the disco ball on
   processCommand('Plug%20on');
   var currentColor = Array(2);
   console.log(currentColor);
   sendGet(soundServerURLStart);
   

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
        // Give the previous commands a chance to be processed, say same amount of time as frequency
        sleep(frequency).then(() => {
          console.log('proceeding to shut down');
          sendGet(soundServerURLStop);
          sleep(1000).then(()=>{processCommand('Plug%20off');  console.log('Plug shut down');});

          for (var i = 0; i < numberOfBulbs; i++){
              var plugNumber = i + 1;
              var timeToWait = 2000 + (i*1000);
              sleep(1000).then(() => {processCommand('Bulb%20' + plugNumber + '%20OFF'); console.log('plug ' + plugNumber + ' shut down');});
          }
       });
    }, duration);
}

var newInterval = 0;
var intervalID = 0;

function goDiscoDingoGoPrashant()
{
   // turn the disco ball on
   processCommand('AllOn');
   var currentColor = Array(2);
   console.log(currentColor);
   sendGet(soundServerURLStart);
   
   setTimeout(function() {
	   intervalID = setInterval(function() {
	        processCommand('DiscoOn'); // discoON needs to be turning on the light in a random color, each of the lights a different random
	    }, frequency);
	    setTimeout(function() {
	        newInterval = setInterval(function() {
	        	clearInterval(intervalID);
	        	sendGet(soundServerURLStop);
	        	processCommand('AllOff'); // discoOFF needs to be turning off the plug too
	        }, frequency);
                setTimeout(function () {
			clearInterval(newInterval);
		}, frequency*2);	        
	        
	    }, duration);
    }, frequency*2);
}

function shutdown()
{
  	if (newInterval) clearInterval(newInterval);

	newInterval = setInterval(function() {
		clearInterval(intervalID);
		sendGet(soundServerURLStop);
		processCommand('AllOff'); // discoOFF needs to be turning off the plug too
	}, frequency);
	setTimeout(function () {
		clearInterval(newInterval);
	}, frequency*2);


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
   <tr><td colspan="9"><h2>Bulb 1</h2></td></tr>
   <tr>
    <td><a href="#" onclick="processCommand('Bulb%201%20OFF')"><img src="./lightbulb_grey.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20White')"><img src="./lightbulb.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Red')"><img src="./lightbulb_red.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Green')"><img src="./lightbulb_green.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Blue')"><img src="./lightbulb_blue.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Yellow')"><img src="./lightbulb_yellow.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Cyan')"><img src="./lightbulb_cyan.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Lilac')"><img src="./lightbulb_lilac.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%201%20Pink')"><img src="./lightbulb_pink.svg" height="70"></a></td>
   </tr>
   <tr><td colspan="9"><h2>Bulb 2</h2></td></tr>
   <tr>
    <td><a href="#" onclick="processCommand('Bulb%202%20OFF')"><img src="./lightbulb_grey.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20White')"><img src="./lightbulb.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Red')"><img src="./lightbulb_red.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Green')"><img src="./lightbulb_green.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Blue')"><img src="./lightbulb_blue.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Yellow')"><img src="./lightbulb_yellow.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Cyan')"><img src="./lightbulb_cyan.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Lilac')"><img src="./lightbulb_lilac.svg" height="70"></a></td>
    <td><a href="#" onclick="processCommand('Bulb%202%20Pink')"><img src="./lightbulb_pink.svg" height="70"></a></td>
   </tr>
   <tr>
    <td colspan="9"><h2>Plug 1</h2></td>
   </tr>
   <tr>
    <td><a href="#" onclick="processCommand('Plug%20off')"><img src="./plug_off.svg" height="70"></td>
    <td><a href="#" onclick="processCommand('Plug%20on')"><img src="./plug.svg" height="70"></td>
   </tr>
   <tr>
    <td colspan="9"><h2>Sound <a href="#" onclick="turnMusicOn()">ON</a> or <a href="#" onclick="turnMusicOff()">OFF</a></h2></td>
   </tr>
  </table>
  </td>
  <td width="50%"></td>
  <td valign="top">
    <a href="#" onclick="goDiscoDingoGoPrashant()"><img src="./disco_dingo.jpg" width="500"></a>
    <h2><center><p>GO DISCO DINGO GO!</p>
    <p><i>Press the image to start</i></p>
    <p><a href="#" onclick="shutdown();">EMERGENCY SHUTDOWN!</p>
    </center></h2>
  </td>
</tr></table>
</body>
</html>

