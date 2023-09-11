<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>

  <!-- Loads all styles -->
  <link rel="stylesheet" href="html/css/bootstrap.min.css">
  <link rel="stylesheet" href="html/css/main.css">
  <link rel="stylesheet" href="html/css/texture.css">

  <link rel="stylesheet" href="html/js/lib/bootstrap.css"></link>
  <!-- Loads all libraries -->
  <script src="html/js/lib/jquery-3.3.1.min.js"></script>
  <script src="html/js/lib/bootstrap.min.js"></script>

  <script src="html/js/lib/bowser-2.4.0-es5.js"></script>
  <script type="module" src="html/js/lib/zoom.js"></script>
  <script type="module" src="html/js/tools/sizecheck.js"></script>
  <script src="html/setup/functions_texture.js"></script>

    <script type="module" src="html/js/init-index.js"></script>
</head>
<body class="background">

  <!-- Modal -->
  <div class="modal fade" id="browser-warning" tabindex="-1" role="dialog" aria-labelledby="browser-warning-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="browser-warning-title">Your browser is not supported</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Ok. I will use another browser.">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <span id="browser-warning-message"></span>
        </div>
        <div class="modal-footer">
          <button data-dismiss="modal" type="button" class="btn btn-primary">I understood</button>
        </div>
      </div>
    </div>
  </div>
  <script src="html/setup/min_browser_versions.js"></script>
  <script src='html/js/tools/browser-detection.js'></script>



  <div id="loader" class="justify-content-center">
    <p>Loading experiment...</p>
  </div>
  <div id="zoom-message" class="wrong-message">
    <br/><h1>This experiment requires a 100% zoom level</h1>
    <p id="zoom">Your current zoom is <span id=zoomValue></span>%.</p>
    <p>Please, zoom in the page until this message disappears.<br>
      You can also press Ctrl+0 (on Windows or Linux) or Cmd+0 (on Macos) to reset the zoom.</p>
  </div>
  <div id="dimension-message" class="wrong-message">
    <br/><h1>Your browser window does not fit the study screen</h1>
    <canvas id="windowsize" width="350px" height="200px"></canvas>
    <p>It may be happening because your browser window is too small or the page is zoomed in.</p>
    <p>Please resize your window until this message disappears or zoom out the page.</p>
  </div>
  <main class="container" id="content">
    <div class="row justify-content-center">
      <?php
      require_once "html/setup/functions.php";
      global $config;
      loadConfig();
 
      if ($config["use_fixed_frame"]){
        ?>
        <style type="text/css">
            .background {
              background-color: #E0E0E0;
            }
        </style>      
      <iframe id="experiment" src="content.php?<?php echo http_build_query($_GET);?>"></iframe>

      <?php 
      } else {
        ?>

        <?php

        include("content.php");

      }
      ?>
    </div>
  </main>
      <noscript>
        <h1>Your browser is blocking Javascript.</h1>
        <p>
          This page requires javascript to function properly, that is, to collect your answers and send them back to us. If you want to participate in this study, please allow scripts to be executed and then reload the page. <br>
          If you don't know how to do that, you can <a href="https://www.whatismybrowser.com/guides/how-to-enable-javascript/auto" target="_BLANK">learn how here</a>.
        </p>
      </noscript>

</body>
</html>
