<div class="recognition" id="recognizing">
<!-- By default, the first demo is shown !-->
<script language="Javascript">
document.write(links[0]['caption']);
</script>
</div>

<script>
function show_recognition(status, index)
{
   if (status){
      repositionRecognition(links[index]['recognition']);
      document.getElementById('recognizing').style.visibility = 'visible';
   }
   else document.getElementById('recognizing').style.visibility = 'hidden';
}

// This repositions a floating div
function repositionRecognition(pos)
{
  element = document.getElementById('recognizing');
  // What needs to be done depends on where we are trying to locate the div
  if ((pos=='N'))
  {
     element.style.bottom=null;
     element.style.top=0;
  } 
  else  
  {
     element.style.top = null;
     element.style.bottom = 0;
  }
}

function updateRecognition(index)
{
  repositionRecognition(links[index]['recognition']);
  // Only show the box if there is something to be shown
  if(links[index]['caption']){
     document.getElementById('recognizing').innerHTML = links[index]['caption'];
     document.getElementById('recognizing').style.opacity = 0.8;
  }
  else document.getElementById('recognizing').style.opacity = 0.0;
}

</script>


