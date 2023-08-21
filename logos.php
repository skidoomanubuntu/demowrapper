<div class="logo" id="logos">
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

   echo "<img src='/logo.svg' height='70' border='0'><br>";
   echo "<font color='white' size='10'>Core</font>";
   if(endsWith(php_uname('r'), 'mtk'))
      echo "<img src='mediatek.png' width='113'>";
   // This is a ugly hack because there is no -xlx in the name yet, so by default we will assume anything that is not
   // specifically detailed here AND is ARM will be Xilinx
   else {
      if(php_uname('m') == 'aarch64') echo '<img src="/AMD.png" width="88">';

   }
//echo '<br><br>';
$core = php_uname('m');
if ($core == 'x86_64') echo '<img src="/intel.png" width="113">';
if ($_SERVER['SERVER_NAME'] == 'advantech') echo '<img src="/Advantech_logo.svg" width="113">';
if ($core == 'aarch64') echo '<img src="/Arm_logo_2017.svg" width="88">';
echo '</b></font>';
?>
</center>
</div>
<script>
function show_logos(status)
{
   if (status){
      repositionLogos();
      document.getElementById('logos').style.visibility = 'visible';
      alert('visibility' + document.getElementById('logos').style.visibility);
   }
   else document.getElementById('logos').style.visibility = 'hidden';
}

// This repositions a floating div
function repositionLogos()
{
  //if(currentPos == pos) return;
  //else currentPos = pos;
  element = document.getElementById('logos');
  var pos = 'SE';
  var heightOffset = 0;
  var widthOffset = 0;
  var imgs = element.getElementsByTagName('img');
  
  // What should be the height?
  if(imgs.length > 0) heightOffset += imgs[0].clientHeight;
  if(imgs.length > 1) heightOffset += imgs[1].clientHeight;
  if(imgs.length > 2) heightOffset += imgs[2].clientHeight;
  heightOffset += 70;
  alert('heightOffset' + heightOffset);

  // What should be the width?
  if(imgs.length > 0) widthOffset = imgs[0].clientWidth;
  if(imgs.length > 1 && imgs[1].clientWidth > widthOffset) widthOffset = imgs[1].clientWidth;
  if(imgs.length > 2 && imgs[2].clientWidth > widthOffset) widthOffset = imgs[2].clientWidth;
  /*alert('widthOffset' + widthOffset);
  alert('width client' + window.innerWidth);
  */
  // What needs to be done depends on where we are trying to locate the div
  if ((pos=='NW' || pos=='NE'))
  {
     element.style.top=0;
     element.style.bottom = element.clientHeight + heightOffset + 'px'; 
  } 
  if ((pos=='SW' || pos=='SE'))  
  {
     element.style.bottom = 0;
     element.style.top = element.clientHeight - heightOffset + 'px';
  }
  if ((pos=='NE' || pos=='SE'))
  {
    element.style.right = 0;
    element.style.left = null;
    element.style.width = widthOffset + 'px';
  }
  if ((pos=='NW' || pos=='SW'))
  {
    element.style.left = 0;
    element.style.right = element.clientWidth + widthOffset + 'px';
  }
  /*alert('top' + element.style.top);
  alert('bottom' + element.style.bottom);
  alert('right' + element.style.right);
  alert('left' + element.style.left);*/
}

</script>
