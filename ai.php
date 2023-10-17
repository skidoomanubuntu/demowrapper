
<html>
  <head>
    <title>Video Streaming Demonstration</title>
<link rel="stylesheet" href="common.css">
<script>
function loadStream()
{
   url = window.location.protocol + '//' + window.location.host + ':6063/video_feed';
   document.getElementById('stream').src=url;
   resetSizeOfStream();
}
function resetSizeOfStream()
{
   var stream = document.getElementById('stream');
   var height = window.innerHeight - document.getElementsByTagName('header')[0].offsetHeight/2;
   stream.height = height;
}
</script>
  </head>
  <body onload='loadStream();'>
    <header>
      <table border='0' width='100%' height='100%'><tr><td align='center' valign='middle'>
      <center><h1><font color='white'>AI Demo On Ubuntu Core</font></h1></center>
      </td></tr></table>
    </header>
    <main style='top:60px;'>
      <center><img id="stream" src="/video_feed"></center>
    </main>
  </body>
</html>
