<html>

<!-- The entry in the "links" determines which demos are available on the bottom menu !-->
<script>

/* In this dictionary we list what links we have in the menu */
/* The utility menus are NOT part of this populating         */
var links = [
  // Main website interface
  {'name': 'Ubuntu',
   'url': window.location.protocol + '//' + window.location.hostname + ':80/default.php',
   'caption': 'By <b>Taiten Peng <i>(@Taitenpeng)</i></b> and <b>J-C Verdié<i>(@jcverdie)</i></b><br><i>Master Linux plumbers</i>',
   'image': 'web.svg'},

   // Ogra's demo with camera
   {'name': 'camera',
    'url': window.location.protocol + '//' + window.location.hostname + ':6063',
    'caption': 'By <b>Oliver Grawert<i>(@ogra)</i></b><br><i>Master Linux plumber</i>',
    'image': 'camera1.svg'},


   // Diego's demo with Sensors
   {'name': 'sensors',
    'url': window.location.protocol + '//' + window.location.hostname + ':7880/ui',
    'caption': 'By <b>Diego Bruno <i>(@dbruno74)</i></b><br><i>Master Linux plumber</i>',
    'image': 'node.svg'},

    // Automotive mp4 video
    {'name': 'auto',
     'url': window.location.protocol + '//' + window.location.hostname + ':4000',
     'caption': 'By <b>Bugra Aydogar <i>(@bugraaydogar)</i></b><br><i>Master Linux plumber</i>',
     'image': 'car.svg'},

     // Automotive video
     {'name': 'video',
      'url': window.location.protocol + '//' + window.location.hostname + '/auto_video.html',
      'caption': '',
      'image': 'video.png'}

];

// The current URL that is displayed
var currentURL = links[0]['url'];

// This function is called during the initial populating of the menu
function getLinkHTMLEntry(index)
{
  var myString = '<td valign="top" align="left">' +
    '<center><br><a href=\"' + links[index]['url'] +
    '\" onclick=\"writeTitle(\'' + links[index]['caption'] +
    '\');updateCurrentURL(\'' + links[index]['url'] + '\');\" target="main"><img src=\"' + links[index]['image'] +
    '\" height=\"40\" width=\"40\" border=\"0\"><br>' + links[index]['name'] +
    '</a></center></td><td width="5%">&nbsp;</td>' ;
  return myString;
}

// Simple function to update the URL displayed in the main window
// It would be simpler to just read the src value from the iframe,
// however if you are on another domain (which you are if you go from one port
// to the next) you cannot do this
function updateCurrentURL(value)
{
  currentURL = value;
}

// This causes the page to rotate between different demonstration
var timeToRotation = 36000 // Time in miliseconds between rotations
var rotationFlag = false; // Flag that tracks if we are rotating or not
function rotateDemos()
{
  // If the demos were rotating, shut it down
  if (rotationFlag){
    rotationFlag = false;
    return;
  }
  rotationFlag = true;
  var currentDemo = 0; // Based on the global var links
  setInterval(() => {
    if (!rotationFlag) return;
      // Update the demo being shown
      document.getElementsByName("main")[0].src = links[currentDemo]['url'];
      writeTitle(links[currentDemo]['title']);
      currentDemo++;
      if (currentDemo >= links.length) currentDemo = 0;
  }, timeToRotation);
}

/* This function ensures that whenever we move the mouse the menu will be displayed */
/* When the mouse moves, the pointer events are being reestablished for 5 seconds,  */
/* which enables the user to click in the iframe. After 5 seconds, the pointer      */
/* are disabled again, and moving the mouse repeats the cycle                       */
var timeout_stack = 0;
function mouseMove()
{
  // It is necessary to reenable pointers events, otherwise we cannot click anywhere
  // in the iframe
  document.getElementsByName("main")[0].style.pointerEvents="auto";
  timeout_stack += 1;
  document.getElementById("navigation").style.visibility="visible";
  setTimeout(() => {
    timeout_stack -= 1;
    if (timeout_stack == 0)
    {
      const box = document.getElementById('navigation');
      box.style.visibility = 'hidden';
    }
    // We may have overriden the pointer events to be able to click
    document.getElementsByName("main")[0].style.pointerEvents="none";
    //$('iframe').css('pointer-events', 'none');
  }, 5000); // 5 secs delay here
}

/* This function displays or hides the platform icons, titles or URL divs */
/* depending on whether they were displaying or not                       */
function toggleDiv(id)
{
  if (document.getElementById(id).style.visibility == 'visible')
    document.getElementById(id).style.visibility = 'hidden';
  else document.getElementById(id).style.visibility = 'visible';
}

// This simple function updates the text within the title div
// This occurs each time we move laterally between demos
function writeTitle(text){
  //alert(text);
  document.getElementById('plumber').innerHTML = text;
}

// This script highlights the button in bright orange if the function has been selected
// Orange means ON, White means OFF
function toggleButton(idStr)
{
  if (document.getElementById(idStr).style.color == 'orange')
     document.getElementById(idStr).style.color = 'white';
  else document.getElementById(idStr).style.color = 'orange'
}

</script>

<!-- The following will include the Ubuntu fonts !-->
<link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8"/>

<style>
body, html {
    min-height: 100%;
    min-width: 100%;
    overflow: hidden;
    padding: 0;
    margin: 0;
}

iframe {
    min-height: 100%;
    min-width: 100%;
    padding: 0px;
    border: none;
    padding: 0;
    margin: 0;
    overflow: hidden;
    /* Necessary for mousemove to be effective on iframe */
    /* This will get suspended for 5 secs to give users the chance to click in
       the iframe */
    pointer-events: none;
}

a {
  font-weight: normal;
  font-size: 24;
}

a:link {
  color: white;
  text-decoration: none;
}

a:visited {
  color: white;
  text-decoration: none;
}

div.button{
  font-weight: normal;
  font-size: 24;
  color: white;
}

body {
  background-color: black;
  overflow: hidden;
  font-family: 'ubuntulight';
}

div.nav {
  z-index: 10;
  position: relative;
  min-height: 10%;
  min-width: 100%;
  margin-top: -10%;
  visibility: hidden;
  color: white;
}

div.logo {
  bottom:0;
  position:fixed;
  z-index:10;
  _position:absolute;
  _top:expression(eval(document.documentElement.scrollTop+
    (document.documentElement.clientHeight-this.offsetHeight)));

  right: -10;
  visibility: hidden;
  opacity: 0.50;
  background-color: #000000;
  text-align: center;
  padding: 5;
}

div.title {
  bottom: 0;
  position:fixed;
  z-index:10;
  _position:absolute;
  _top:expression(eval(document.documentElement.scrollTop+
    (document.documentElement.clientHeight-this.offsetHeight)));

  left: 10;
  visibility: hidden;
  opacity: 0.50;
  background-color: #000000;
  text-align: center;
  padding: 5;
  color: white;
}

</style>

<body height="100%" width="100%"><div class="overlay" onmousemove="mouseMove()">
  <!-- By default, the first demo is shown !-->
  <script language="Javascript">
  document.write('<iframe src="' + links[0]['url'] + '" title="Default" name="main" height="100%" width="100%" border=0 frameBorder=0></iframe>');
  currentURL = links[0]['url'];
  </script>
</div>

<div class="logo" id="ubuntu">
<center>
<img src="/core_white-orange_st_hex.svg" height="150" width="212" border="0">
<br>
<!-- Select a logo based on the platform you are running on !-->
<?php
$core = php_uname('m');
if ($core == 'x86_64') echo '<img src="/intel.png" height="60" width="100">';
if ($core == 'aarch64') echo '<img src="/Arm_logo_2017.svg" height="30" width="100">';
echo '</b></font>';
?>

</center>
</div>

<div class="title" id="plumber">
<!-- By default, the first demo is shown !-->
<script language="Javascript">
document.write(links[0]['caption']);
</script>
</div>

<div class="nav" id="navigation">
  <table border=0 bgcolor="black" width="100%" height="200">
    <tr>
      <td valign="top" align="left">
        <a href="#" onclick="alert(currentURL);">
        <img src="/core_white-orange_st_hex.svg" height="100" width="141">
        </a>
      </td>
      <script language="Javascript">
        for (var i=0; i < links.length; i++)
           document.write(getLinkHTMLEntry(i));
      </script>

      <td width="30%">
        &nbsp;
      </td>
      <td valign="top">
        <font size="7">
        <table border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="button" id='plumberButton' onclick="toggleDiv('plumber');toggleButton('plumberButton');">Captions</div></td>
          </tr>
          <tr>
            <td><div class="button" id='ubuntuButton' onclick="toggleDiv('ubuntu');toggleButton('ubuntuButton');">Logo</div></td>
          </tr>
          <tr>
            <td><div class="button" id='rotateButton' onclick="rotateDemos();toggleButton('rotateButton');">Rotate</div></td>
          </tr>
        </table>
        </font>
      </td>

   </tr>
  </table>
</div>

</body>
</html>
