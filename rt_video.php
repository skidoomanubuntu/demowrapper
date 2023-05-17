<html>
<style>
body, html {
    min-height: 100%;
    min-width: 100%;
    overflow: hidden;
    padding: 0;
    margin: 0;
}
</style>

<body width="100%" height="100%">
  <video width="100%" height="100%" preload="auto" autoplay loop>
    <source src="rt_video.mp4" type="video/mp4">
    <?php if(file_exists('jp') && file_exists('rt_video.mp4.JP.vtt')) {
         echo '<track label="Japanese" kind="subtitles" srclang="jp" src="rt_video.mp4.JP.vtt" default />';} 
         else {
           if(file_exists('rt_video.mp4.EN.vtt'))
             echo '<track label="English" kind="subtitles" srclang="en" src="rt_video.mp4.EN.vtt" default />';
         }
    ?>  
    <!-- <source src="movie.ogg" type="video/ogg"> -->
  Your browser does not support the video tag.
  </video>
</body>
</html>


