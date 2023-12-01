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
  font-size: '40px';
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
  <td>
  <table border="0">
   <tr>
    <td>Bulb 1</td>
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
    <td>Plug </td>
    <td><a href="#" onclick="processCommand('Plug%20off')"><img src="./plug_off.svg" height="70"></td>
    <td><a href="#" onclick="processCommand('Plug%20on')"><img src="./plug.svg" height="70"></td>
   </tr>
  </table>
  </td>
</tr></table>
</body>
</html>

