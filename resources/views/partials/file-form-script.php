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

    let display = document.querySelector("#timer");

  function startTimer(duration, display) {
    let timer = duration,
      minutes,
      seconds;

    setInterval(function() {
      minutes = parseInt(timer / 60, 10);
      seconds = parseInt(timer % 60, 10);

      minutes = minutes < 10 ? "0" + minutes : minutes;
      seconds = seconds < 10 ? "0" + seconds : seconds;

      display.textContent = minutes + ":" + seconds;

      // if (--timer < 0) {
      //   timer = duration;
      // }
      ++timer
    }, 1000);
  }

  let submitBtn = document.querySelector('#submitBtn');

  let twentyMinutes = 60 * 20; // Change this value to set the desired timer duration

  submitBtn.addEventListener('click', function() {
    startTimer(0, display);
  });
</script>
