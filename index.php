<html>
<head><META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
</head>

<?php include 'language_inc.php'?>
<!-- The entry in the "links" determines which demos are available on the bottom menu !-->
<script>

// This populates a list of snaps. The txt file was generated after the board was launched based on a REST API call.
var snaps ="<?php if (file_exists('list_snaps.txt')) {echo shell_exec('cat list_snaps.txt');}?>";

// This detects a list of boards that are available (or not) on the network
var additional_boards=[<?php $connection=@fsockopen('core-car',5000); if(is_resource($connection)) {echo '"core-car",';}?>];

// Also certain items will only show up if the video is in www
var videos = "<?php echo implode(' ', glob('*.mp4'));?>";

/* In this dictionary we list what links we have in the menu */
/* The utility menus are NOT part of this populating         */
var links = [
  // Main website interface
  {'name': translate_direct('Home'),
   'url': window.location.protocol + '//' + window.location.hostname + ':80/default.php',
   'caption': 'By <b>Taiten Peng <i>(@Taitenpeng)</i></b> and <b>J-C Verdié<i>(@jcverdie)</i></b><br><i>Master Linux plumbers</i>',
   'image': 'web.svg', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'lighttpd'},

   // Ogra's demo with camera
   {'name': translate_direct('AI'),
    'url': window.location.protocol + '//' + window.location.hostname + ':6063',
    'caption': 'By <b>Oliver Grawert<i>(@ogra)</i></b><br><i>Master Linux plumber</i>',
    'image': 'camera1.svg', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'opencv-html-demo'},

   // Diego's demo with Sensors
   {'name': translate_direct('Sensors'),
    'url': window.location.protocol + '//' + window.location.hostname + ':7880/ui',
    'caption': 'By <b>Diego Bruno <i>(@dbruno74)</i></b><br><i>Master Linux plumber</i>',
    'image': 'node.svg', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'node-red-demo'},

    // Code update demo
    {'name': translate_direct('Update'),
     'url': window.location.protocol + '//' + window.location.hostname + ':4000',
     'caption': 'By <b>Bugra Aydogar <i>(@bugraaydogar)</i></b><br><i>Master Linux plumber</i>',
     'image': 'update.svg', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'device-controller'},

     // Matter demo
     {'name': translate_direct('Matter'),
      'url': window.location.protocol + '//' + window.location.hostname + ':5001',
      'caption': 'By <b>Prashant Dhumal <i>(@prashantdhumal)</i></b><br><i>Master Linux plumber</i>',
      'image': 'matter.png', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'dht11'},

     // Core car
     {'name': translate_direct('Core Car'),
      'url': window.location.protocol + '//core-car:5000',
      'caption': 'By <b>Steve Bariault <i>(@skidooman)</i></b><br><i>MacGyvering plumber dispatcher</i>',
      'image': 'car.svg', 'logos_loc':'NW', 'caption_loc':'NE', 'snap':'core-car'},

     // Automotive video
     {'name': translate_direct('Auto'),
      'url': window.location.protocol + '//' + window.location.hostname + '/auto_video.html',
      'caption': '',
      'image': 'car.svg', 'logos_loc':'NW', 'caption_loc':'NE', 'snap':'auto_video.mp4'},

     // Real-time video
     {'name': translate_direct('Real-time'),
      'url': window.location.protocol + '//' + window.location.hostname + '/rt_video.php',
      'caption': '',
      'image': 'rt.svg', 'logos_loc':'SW', 'caption_loc':'SE', 'snap':'rt_video.mp4'}

];

// The current URL that is displayed
var currentURL = links[0]['url'];

// This function is called during the initial populating of the menu
function getLinkHTMLEntry(index)
{

  // If the file list_snaps.txt has been created, we can verify if the snap is installed. If not, skip
  //if(snaps.length != 0 && !snaps.includes(links[index]['snap'])) {return "";} 
  // Also check if mp4 file exists if this is what is needed in lieu of a snap - or another node on the network
  if(snaps.length != 0 && !snaps.includes(links[index]['snap']) && !videos.includes(links[index]['snap']) && !additional_boards.includes(links[index]['snap'])) {return "";}
  var myString = '<td valign="top" align="center" width="100">' +
    '<center><br><a href=\"' + links[index]['url'] +
    '\" onclick=\"writeTitle(\'' + links[index]['caption'] +
    '\');updateCurrentURL(\'' + links[index]['url'] + '\', \'' + links[index]['logos_loc'] + '\', \'' + links[index]['caption_loc'] + '\');\" target="main"><img src=\"' + links[index]['image'] +
    '\" height=\"40\" width=\"40\" border=\"0\"><br>' + links[index]['name'] +
    '</a></center></td><td width="15">&nbsp;</td>' ;
  return myString;
}

// This is a dirty way to do it, but assignments to top and bottom cannot always be relied on from experience
var currentPos = "SW";

// This repositions a floating div
function repositionDiv(div, pos)
{
  if(currentPos == pos) return;
  else currentPos = pos;
  element = document.getElementById(div);
  // TO BE DONE - reposition the div
  //var oldOffsetHeight = element.offsetHeight; 
  var oldOffsetHeight = 35;
  imgs = element.getElementsByTagName('img');
  if(imgs.length > 1) 
  {
    oldOffsetHeight += imgs[0].clientHeight;
    oldOffsetHeight += imgs[1].clientHeight;
  }
  if(imgs.length > 2) oldOffsetHeight += imgs[2].clientHeight;

  if ((pos=='NW' || pos=='NE'))
  {
     element.style.top=0;
     element.style.bottom = element.clientHeight + oldOffsetHeight; 
  } 
  if ((pos=='SW' || pos=='SE'))  
  {
     element.style.bottom = 0;
     element.style.top = element.clientHeight - oldOffsetHeight;
  }
}


// Simple function to update the URL displayed in the main window
// It would be simpler to just read the src value from the iframe,
// however if you are on another domain (which you are if you go from one port
// to the next) you cannot do this
// While at it, update placement of diffs
function updateCurrentURL(value, logos_pos, caption_pos)
{
  currentURL = value;
  // Reposition logos and captions
  repositionDiv('ubuntu', logos_pos);


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

// This function is called after loading and ensures the logos are sized appropriately
function resizeLogos()
{
    // scaling factor: we would like the logos to be no more than 10% of the width of the screen
    var scalingFactor = 0.1;

    // Lock on to the images within our ubuntu div - these are our logos
    imgs = document.getElementById('ubuntu').getElementsByTagName('img');
    
    // How large is the 2nd image compared to the screen?
    if (imgs.length > 1)
    {
        var currentScaling = imgs[1].width/screen.width;
        imgs[1].width = imgs[1].width*scalingFactor/currentScaling; 

        // Apply the same scale to Core logo's height
        // imgs[0].height = imgs[0].height*scalingFactor/currentScaling;

        // If you have another logo, go ahead and do the scaling on width
        if(imgs.length > 2) { imgs[2].width = imgs[2].width*scalingFactor/currentScaling; }
   
        // resize the container div accordingly
        document.getElementById('ubuntu').style.width = imgs[1].width + 10 + 'px';

        // Adjust the Ubuntu Core logo to occupy 50% of the height
        imgs[0].width = imgs[1].width;
    }
}

// This gets invoked during load. In presence of a extra_link.json file, it will add demos
// to the links variable we have
function addDemoEntriesFromFile()
{
   <?php
      if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'extra_links.json'))
      {
          $json = file_get_contents($_SERVER['DOCUMENT_ROOT'] . 'extra_links.json');
          $data = json_decode($json, true);
          foreach ($data as $entry) echo 'links.push({
              "name":"' . $entry["name"] . '",' .
              '"url":"' . $entry["url"] . '",' .
              '"caption":"' . $entry["caption"] . '",' .
              '"image":"' . $entry["image"] . '",' . 
              '"logos_loc":"' . $entry["logos_loc"] . '",' . 
              '"caption_loc":"' . $entry["caption_loc"] . '",' . 
              '"snap":"' . $entry["snap"] . '"' . 
          '});'; 
      }
   ?>
}

// This call will add the additional demo entries from file extra_link.json
addDemoEntriesFromFile();
</script>

<!-- The following will include the Ubuntu fonts !-->
<link rel="stylesheet" href="stylesheet.css" type="text/css" charset="utf-8"/>

<style>
body, html {
    font-family: ubuntu;
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
  position:absolute;
  top:expression(eval(document.documentElement.scrollTop+
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

div.recognition {
  position: fixed; 
  top : 25;
  left: 25;
  z-index: 15;
  visibility: hidden;
  background-color: #FFFFFF;
  text-align: center;
  padding: 5;
  color: #000000;
}


</style>

<body height="100%" width="100%" onload='resizeLogos()'><div class="overlay" onmousemove="mouseMove()">
  <!-- By default, the first demo is shown !-->
  <script language="Javascript">
  document.write('<iframe src="' + links[0]['url'] + '" title="Default" name="main" height="100%" width="100%" border=0 frameBorder=0></iframe>');
  currentURL = links[0]['url'];
  </script>
</div>

<div class="logo" id="ubuntu">
<center>
<!-- Select a logo based on the platform you are running on !-->
<?php
    // Function to check the string is ends
    // with given substring or not
    function endsWith($string, $endString)
    {
      $len = strlen($endString);
      if ($len == 0) {
        return true;
      }
      return (substr($string, -$len) === $endString);
    }

   echo "<img src='/core_white-orange_st_hex.svg' width='113' border='0'><br>";

   if(endsWith(php_uname('r'), 'mtk'))
      echo "<img src='mediatek.png' width='113'>";
   // This is a ugly hack because there is no -xlx in the name yet, so by default we will assume anything that is not
   // specifically detailed here AND is ARM will be Xilinx
   else {
      if(php_uname('m') == 'aarch64') echo '<img src="/AMD.png" width="88">';

   }
echo '<br><br>';
$core = php_uname('m');
if ($core == 'x86_64') echo '<img src="/intel.png" width="113">';
if ($_SERVER['SERVER_NAME'] == 'advantech') echo '<img src="/Advantech_logo.svg" with="113">';
if ($core == 'aarch64') echo '<img src="/Arm_logo_2017.svg" width="88">';
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
        <a href="#" onclick="toggleDiv('fame');">
        <img src="/core_white-orange_st_hex.svg" height="100" width="141">
        </a>
      </td>
      <script language="Javascript">
        for (var i=0; i < links.length; i++)
           document.write(getLinkHTMLEntry(i));
      </script>

      <td width="35%">
        &nbsp;
      </td>
      <td valign="top" align='right'>
        <font size="7">
        <table border="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="button" id='plumberButton' onclick="toggleDiv('plumber');toggleButton('plumberButton');"><script>translate('Captions')</script></div></td>
          </tr>
          <tr>
            <td><div class="button" id='ubuntuButton' onclick="toggleDiv('ubuntu');toggleButton('ubuntuButton');"><script>translate('Logo')</script></div></td>
          </tr>
          <tr>
            <td><div class="button" id='rotateButton' onclick="rotateDemos();toggleButton('rotateButton');"><script>translate('Rotate')</script></div></td>
          </tr>
        </table>
        </font>
      </td>

   </tr>
  </table>
</div>
<div class="recognition" id="fame">
<h3><p>A production of <b><u>Canonical's Field Engineering IoT</u></b></p>
<p>With valuable contributions from <b><u>Marketing</u></b> and <b><u>Product Management</u></b></p></h3>
<h4><u>Contributors</u></h4>
<script>
for(var j=0; j<links.length; j++)
{
  if(links[j]['caption'].length) document.write('<u>' + links[j]['name'] + '</u>' + ' ' + links[j]['caption'] + '<br>');
}
</script>
<p>Image generation by <b>Jean-Charles Verdié(@jcverdie)</b>, build-master of our Universe </p>
<p>An idea and menu by <b>Steve Barriault(@skidooman)</b>, the skipper of the best crew of Linux plumbers around</p>

<p>Special thanks to <b>Julie Chevrier, Nathan Hart, Felicia Jia and Bertrand Boisseau</b> 
<p>Running on <b><u>Ubuntu Core</u></b>, the most secure Linux of the IoT realm</p>
</div>
</body></html>
