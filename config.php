<div class="config-popup" id="config" height="100%">
  <form action="/action_page.php" class="config-container">
    <table border="0" width="100%"></tr>
      <td><h2>Config</h2></td>
      <td><span id="config-close" onclick="closeConfig();" style="cursor:default"><h2>X</h2></span></td>
    </tr></table>
    <table border="0" height="100%">
       <tr>
          <td>
             <label class="switch">
                <input type="checkbox" id='logo_checkbox'>
                <span class="slider round"></span>
             </label>
          </td>
          <td><h3>Show logos</h3>
          </td>
          <td width="20%"></td>
          <td>
             <label class="switch">
                <input type="checkbox" id='recognition_checkbox'>
                <span class="slider round"></span>
             </label>
          </td>
          <td><h3>Show recognition</h3>
          </td>
       </tr>
       <tr>
          <td>
             <label class="switch">
                <input type="checkbox" id='rotate_checkbox'>
                <span class="slider round"></span>
             </label>
          </td>
          <td><h3>Rotate demos</h3>
          </td>
          <td width="20%"></td>
          <td>
            <label class="switch">
                <input type="checkbox" id='offline_checkbox'>
                <span class="slider round"></span>
             </label>
          </td>
          <td><h3>Offline demos</h3>
          </td>
       </tr>

       <tr>
          <td>
             <select name="languages" id="language">
                <option value="en">English</option>
                <option value="jp">日本語</option>
             </select>
          </td>
          <td><h3>Languages</h3>
          </td>
          <td width="20%"></td>
          <td>
             <select name="interval" id="interval">
                <option value="36000">1 minute</option>
             </select>
          </td>
          <td><h3>Interval</h3>
          </td>
       </tr>
    </table>
  </form>
</div>

<script>
// Scripts to open or close the config menu
function openConfig() {
  document.getElementById("config").style.display = "block";
}

function closeConfig() {
  document.getElementById("config").style.display = "none";
}

const logos_checkbox = document.getElementById('logo_checkbox');
const recognition_checkbox = document.getElementById('recognition_checkbox');
const rotate_checkbox = document.getElementById('rotate_checkbox');
const language_select = document.getElementById('language');
const offline_checkbox = document.getElementById('offline_checkbox');

// Event handlers
// When logos need to be shown or removed
logos_checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    show_logos(true, currentIndex);
  } else {
    show_logos(false, currentIndex);
  }
});

// When attributions need to be shown or removed
recognition_checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    show_recognition(true, currentIndex);
  } else {
    show_recognition(false, currentIndex);
  }
});

// When demos need to be rotated or stopped
rotate_checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    rotateDemos(true, document.getElementById('interval').value);
  } else {
    rotateDemos(false, document.getElementById('interval').value);
  }
});

// When the language is changed
language_select.addEventListener('change', (event) => {
  window.location.href = 'language2_' + language.value + '.php';
});

// Should a particular demo be offline?
offline_checkbox.addEventListener('change', (event) => {
  window.location.href = 'offline.php';
});

// Set default language
var mySelect = document.getElementById('language');
function initialize_language(){
   var language = 'en';
   var jp = <? if (file_exists('jp')) echo 'true'; else echo 'false';?>;
   if (jp) language = 'jp';  
   for(var i, j = 0; i = mySelect.options[j]; j++) {
      if(i.value == language) {
	 mySelect.selectedIndex = j;
	 break;
	 }
   }
   // While at it, also set the offline mode
   var offline = <? if (file_exists('offline')) echo 'true'; else echo 'false'; ?>;
   if (offline) offline_checkbox.checked = 'true';
}




</script>
