<script>
  document.getElementById('file').addEventListener('change', function(e) {
    console.log(e.target);
    if (e.target.files[0]) {
      var fileName = e.target.files[0].name;
      document.getElementById('displayName').innerText = fileName;
      document.getElementById('name').value = fileName;
    } else {
      document.getElementById('displayName').innerText = '';
      document.getElementById('name').value = '';
    }
  });

  document.getElementById('url').addEventListener('change', function(e) {
    if (e.target.value) {
      document.getElementById('name').value = getBasename(decodeURL(e.target.value));
    } else {
      document.getElementById('name').value = '';
    }
  });

  function getBasename(url) {
    var pathname = new URL(url).pathname;
    return pathname.substring(pathname.lastIndexOf('/') + 1);
  }


  function decodeURL(url) {
    return decodeURIComponent(url);
  }
</script>