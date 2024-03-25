<?php
   if (file_exists('offline')) !unlink('offline');
   else { 
        $myfile = fopen('offline','w') or die ('unable to switch language mode');
        fwrite($myfile, 'offline');
        fclose($myfile);
   }
   header("Location: index.php");
?>

