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
  font-size: '5px';
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
<body>
<table border="0">
<tr><td>
<div class='screen' style='max-height: 60vh; overflow: hidden;'>
<table border='0' padding='3' spacing='10'>
  <tr>
  <th style='background-color: #111;' width="100%" colspan='4'><h2>OS Details</h2></th></tr>
  <tr><td valign='top'><h3><script>translate('OS')</script></td><td>&nbsp;&nbsp;</h3></td><td valign='top'><h3><?php echo php_uname('v');?></h3></td>
  <td valign='top' align='center' rowspan='2'><img src='/logo.svg' height='70' border='0'><br>
  <font color='white' size='5'><b>Core</b></font>
  </td></tr>
  <tr><td valign='top'><h3><script>translate('Kernel')</script></td><td>&nbsp;&nbsp;</h3></td><td valign='top'><h3><?php echo php_uname('r');?></h3>
  </td></td></tr>

  <tr><td valign='top'><h3><script>translate('Chipset')</script></h3></td><td>&nbsp;&nbsp;</td><td valign='top'><h3><?php echo php_uname('m');?></h3>
  </td>
  <td rowspan='3'>
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
  <?php
   if(endsWith(php_uname('m'), 'aarch64'))
      echo "<img src='Arm_logo_2017.svg' height='25'>";
   if(endsWith(php_uname('m'), 'x86_64'))
   {
      echo "<img src='intel.png' width='113'>";
      if(gethostname() == 'advantech') echo '<img src="/Advantech_logo.svg" width="113">';
   }
  ?>

  </td></tr>
  <tr><td valign='top'><h3><script>translate('Name')</script></h3></td><td>&nbsp;&nbsp;</td><td valign='top'><h3><?php echo gethostname();?></h3></td><td></td></tr>
  <tr><td valign='top'><h3><script>translate('IP')</script></h3></td><td>&nbsp;&nbsp;</td><td valign='top'><h3><?php echo gethostbyname(gethostname()); ?></h3></td><td></td></tr>
  </table>
</td>

<? if (file_exists('jp')) echo '<td width="10%">'; else echo '<td width="40%">';?>
</td>

<td>
<font color='#FFFFFF'>
<h1><script>translate('Welcome to Canonical')</script></h1>
</font>

<div class='screen' style="max-height: 60vh;">
<?php
  $result=file_get_contents('http://' . $_SERVER['SERVER_ADDR'] . ':4042');
  $html=file_get_contents('http://' . $_SERVER['SERVER_ADDR'] . ':4042/cve');
  echo $html;
?>
</div>


</td>
</tr>
<tr><td></td><td></td><td></td></tr>
<tr>
<td>
<div class='screen' style='max-height: 60vh; overflow: hidden;'>
<table border='0' padding='3' spacing='10' width="100%">
  <tr width="100%">
  <th style='background-color: #111;' width="100%"><h2>Some Snaps & Packages</h2></th>
  </tr>
  <tr><td valign='top'>
	<div style='max-height: 55vh; overflow: visible;' width="100%">
	<h4>
	<?php if (file_exists('snap_data.json')) {
	     $json=file_get_contents('snap_data.json'); 
	     $json_data=json_decode($json,true);
	     $stack = array();
	     foreach($json_data as $snap => $packages)
	     {
		$newString = $snap . ' (' . count($packages) . ')';
		array_push($stack, $newString);
	     }
             asort($stack);
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
		elseif (file_exists('snap_list.txt')) 
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

<div class='screen' style="max-height: 60vh;">
<?php
  $html=file_get_contents('http://' . $_SERVER['SERVER_ADDR'] . ':4042/usn');
  echo $html;
?>
</div>

</td>
</tr></table>
</body>
</html>

