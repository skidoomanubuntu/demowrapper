<div class="credits-popup" id="credits" height="100%">
  <div class="credits-container">
    <table border="0"><tr><td width="100%">
    <div>
      <img src="./pirate.jpeg" width="30%" alt="Field Engineering IoT">
    </div>
	<h3><p>A production of <b><u>Canonical's Field Engineering IoT</u></b></p>
	<p>With valuable contributions from <b><u>Marketing</u></b> and <b><u>Product Management</u></b></p></h3>
	<h4><u>Contributors</u></h4>
	<script>
	for(var j=0; j<links.length; j++)
	{
	  if(links[j]['caption'].length) document.write('<u>' + links[j]['name'] + '</u>' + ' ' + links[j]['caption'] + '<br><br>');
	}
	</script>
	<p>Image generation by <b>Jean-Charles Verdié(@jcverdie)</b>, build-master of our Universe </p>
	<p>An idea and automation by <b>Steve Barriault(@skidooman)</b>, the skipper of the best crew of Linux plumbers around</p>
	<p>Menus by <b>Hayden Chambers</b> - who knows how to make this look all the more professional!</p>

	<p>Special thanks to <b>Lizzie Epton, Julie Chevrier, Nathan Hart, Felicia Jia and Bertrand Boisseau</b> 
	<p>Running on <b><u>Ubuntu Core</u></b>, the most secure Linux of the IoT realm</p>      

  </div>
  </td>
  <td valign="top"><span id="credits-close" onclick="closeCredits();" style="cursor:default"><h2>X</h2></span></td>
  </tr></table>
</div>

<script>
// Scripts to open or close the config menu
function openCredits() {
  document.getElementById("credits").style.display = "block";
}

function closeCredits() {
  document.getElementById("credits").style.display = "none";
}

</script>
