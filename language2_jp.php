<?php
	// Disable any translation files if present
	include "language_void.php";
	// Need to create a jp file to indicate Japanese mode
	$myfile = fopen('jp','w') or die ('unable to switch language mode');
	fwrite($myfile, 'Japanese');
	fclose($myfile);
	header("Location: index.php");
?>
