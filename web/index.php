<?php

if (isset($_GET['h'])) {
  header('Access-Control-Allow-Origin: *');
  header('Location: view.php?h=' . $_GET['h']);
}

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type"
        content="application/xhtml+xml; charset=UTF-8" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta http-equiv="X-Clacks-Overhead" content="GNU Terry Pratchett" />
  <title>FHU</title>
  <meta
    name="description"
    content="FM hbr2 uploader"
  />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap styles -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet"
        type="text/css"
        media="screen"
        href="css/style.css" />
  <link rel="icon" type="image/png"
        href="favicon.ico" />
  <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
  <script src="js/fhu.js"></script>
</head>

<body>

<h1>FM hbr2 uploader</h1>

<div id="content" class="container">
  <div id="noJsBanner">Please enable JavaScript</div>
</div>
<div class="container">
  <button class="add btn btn-primary" onclick="addNewUploadElement();">Add more</button>
</div>
<div class="container">
  <div id="stats" class="uploadElement"></div>
</div>

<div class="hidden" id="template">
  <div class="uploadElement">
    <form class="uploadForm" enctype="multipart/form-data" method="post" action="#">
      <div>
        <label>Please select .hbr2 file (max. 300kb)
          <input type="file" name="file" />
        </label>
        <button type="button" class="close pull-right" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br />
        Status: <span class="status">waiting for file</span>
      </div>
    </form>
    <div class="links hidden">
      <div class="link">
        <a class="btn btn-secondary watch" target="_blank">
          Watch
        </a>
        <input size="60" type="text" name="watch" />
        <button class="btn btn-primary copy">Copy link</button>
      </div>
      <div class="link">
        <a class="btn btn-secondary download" target="_blank">
          Download
        </a>
        <input size="60" type="text" name="download" />
        <button class="btn btn-primary copy">Copy link</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
