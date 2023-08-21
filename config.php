<div class="config-popup" id="config" height="100%">
  <form action="/action_page.php" class="config-container">
    <h2>Config</h2>
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
       </tr>
    </table>
  </form>
</div>

<script>
function openConfig() {
  document.getElementById("config").style.display = "block";
}

function closeForm() {
  document.getElementById("config").style.display = "none";
}

const logos_checkbox = document.getElementById('logo_checkbox')

logos_checkbox.addEventListener('change', (event) => {
  if (event.currentTarget.checked) {
    alert('checked');
    show_logos(true);
  } else {
    alert('not checked');
    show_logos(false);
  }
})
</script>
