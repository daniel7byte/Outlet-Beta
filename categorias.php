<?php

  // session_start();
  // if (!isset($_SESSION['UserId'])) {
  //   header('Location: login.php');
  //   exit;
  // }

  require_once('config/Constantes.php');
  require_once('config/MySQLConnect.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Outlet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="resources/css/flatly.min.css">
  <link rel="stylesheet" type="text/css" href="bower_components/bootstrap-select/dist/css/bootstrap-select.min.css">
  <link rel="stylesheet" type="text/css" href="resources/css/global.css">
  <script type="text/javascript" src="bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="bower_components/js-cookie/src/js.cookie.js"></script>
</head>
<body>

  <?php include_once('include/navbar.php'); ?>

  <div class="container" style="margin-top: 60px;">
    <div class="row" style="padding-top: 4px;">

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
          <a href="index.php?cat=Comidas&range=0.3">
            <img src="resources/images/cat/comidas.jpg" class="img img-responsive" />
          </a>
          <div class="caption">
            <h3>Comidas</h3>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
          <a href="index.php?cat=Bancos&range=0.3">
            <img src="resources/images/cat/bancos.jpg" class="img img-responsive" />
          </a>
          <div class="caption">
            <h3>Bancos</h3>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
          <a href="index.php?cat=Salud&range=0.3">
            <img src="resources/images/cat/salud.png" class="img img-responsive" />
          </a>
          <div class="caption">
            <h3>Salud</h3>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="col-xs-6 col-md-3">
        <div class="thumbnail">
          <a href="index.php?cat=Ferreterias&range=0.3">
            <img src="resources/images/cat/ferreterias.jpg" class="img img-responsive" />
          </a>
          <div class="caption">
            <h3>Ferreterias</h3>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

    </div>
  </div>

  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    $('.selectpicker').selectpicker({
      style: 'btn-primary'
    });
  </script>
</body>
</html>
