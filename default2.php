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
  background-image: url('wallpaper.jpg');

  /* Full height */
  height: 100%;

  /* Center and scale the image nicely */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  overflow: hidden;
  font-family: 'ubuntulight';
  font-size: '5px';
  height: 100%;
}

div.screen {
  color: white;
  font-weight: normal;
  <? if (file_exists('jp')) echo 'font-size: 30;'; else echo 'font-size: 40;';?>
  background-color: #300A24;
}

a:link { color: white;}
a:active { color: orange;}
a:visited { color: white;}
a:hover { color: orange;}

</style>
<body>
<table border="0">
<tr><td>
<div class='screen'>
<h2>
<table border='0' padding='3' spacing='10'>
  <th style='background-color: #111;' width="100%" colspan='4'>OS Details</th>
  <tr><td valign='top'><script>translate('OS')</script></td><td>&nbsp;&nbsp;</td><td valign='top'><?php echo php_uname('v');?></td>
  <td valign='top' align='center' rowspan='2'><img src='/logo.svg' height='70' border='0'><br>
  <font color='white' size='5'>Core</font>
  </td></tr>
  <tr><td valign='top'><script>translate('Kernel')</script></td><td>&nbsp;&nbsp;</td><td valign='top'><?php echo php_uname('r');?>
  </td><td rowspan='3'>
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
  
   if(endsWith(php_uname('r'), 'mtk'))
      echo "<img src='mediatek.png' height='25'>";
   // This is a ugly hack because there is no -xlx in the name yet, so by default we will assume anything that is not
   // specifically detailed here AND is ARM will be Xilinx
   else {
      if(php_uname('m') == 'aarch64') echo '<img src="/AMD.png" width="88">';
   }
  ?>
  </td></tr>

  <tr><td valign='top'><script>translate('Chipset')</script></td><td>&nbsp;&nbsp;</td><td valign='top'><?php echo php_uname('m');?>
  </td><td>
  <?php
   if(endsWith(php_uname('m'), 'aarch64'))
      echo "<img src='Arm_logo_2017.svg' height='25'>";
   if(endsWith(php_uname('m'), 'x86_64'))
   {
      echo "<img src='intel.png' width='113'>";
      if($_SERVER['SERVER_NAME'] == 'advantech') echo '<img src="/Advantech_logo.svg" width="113">';
   }
  ?>

  </td></tr>
  <tr><td valign='top'><script>translate('Name')</script></td><td>&nbsp;&nbsp;</td><td valign='top'><?php echo $_SERVER['SERVER_NAME'];?></td><td></td></tr>
  <tr><td valign='top'><script>translate('IP')</script></td><td>&nbsp;&nbsp;</td><td valign='top'><?php echo $_SERVER['SERVER_ADDR']; ?></td><td></td></tr>
</table>
</td>

<? if (file_exists('jp')) echo '<td width="10%">'; else echo '<td width="40%">';?>
</td>



<td>
<font color='#FFFFFF'>
<h1><script>translate('Welcome to Canonical')</script></h1>
</font>

</font>
</td></tr>
<tr><td></td></tr>
<tr>
<td>
<div class='screen' style='max-height: 40vh; overflow: hidden;'>
<table border='0' padding='3' spacing='10'>
  <th style='background-color: #111;' width="100%" colspan='5'><h2>Snaps</h2></th>
  <tr><td valign='top'>
	<div style='max-height: 37vh; overflow: visible;'>
	<h4>
	<?php if (file_exists('snap_list.txt')) 
	    {$json=file_get_contents('snap_list.txt'); 
	     $json_data=json_decode($json,true);
	     foreach($json_data as $key => $value)
	     {
	        if ($key=='result')
	        {
	           $stack = array();
	           foreach($value as $entry){
	              foreach($entry as $entry_key => $entry_value)
	              {
	                 if (!in_array($entry_value, $stack)){
	                    //print_r($entry_key . " " . $entry_value . "<br>");
	                    if($entry_key == 'snap' && !in_array($entry_value, $stack)) array_push($stack, $entry_value);
	                 }
	              }
	           }
	           $chunks = array_chunk($stack, ceil(count($stack)/ 3));
		   error_reporting(E_ERROR | E_PARSE); 
	           echo '<table border="0" width="100%">';
	           for($counter = 0; $counter < count($stack)/3; $counter++) {
	              echo '<tr><td>' . $chunks[0][$counter] . '</td>';
	              try {
			echo '<td>' . $chunks[1][$counter] . '</td>';
	              	echo '<td>' . $chunks[2][$counter] . '</td>';
		      }
                      catch (Exception $e) {}
	              echo '</tr>';
	           }
	           echo '</table>';

	        }
	     }
	    }?>
	</h4>
	</div>
</td></tr></table>

</h2>
</div>

</td>
<td></td>
<td>

<div class='screen' style='max-height: 40vh; overflow-y: auto; overflow-x: hidden;'>
<?php
  if (file_exists('usn_stats.php')) include 'usn_stats.php'; 
?>
</div>

</td>
</tr></table>
</body>
</html>

