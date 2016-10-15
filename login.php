<?php

  session_start();
  if (!isset($_SESSION['UserId'])) {
    header('Location: login.php');
    exit;
  }

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
  <link rel="stylesheet" type="text/css" href="resources/css/gmaps.css">
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK6W34CCNplz4LpPN9eOYpCOaJGOYycyU"></script>
  <script type="text/javascript" src="bower_components/gmaps/gmaps.min.js"></script>
  <script type="text/javascript" src="bower_components/markerclustererplus/dist/markerclusterer.min.js"></script>
  <script type="text/javascript" src="bower_components/js-cookie/src/js.cookie.js"></script>
</head>
<body>
  <?php include_once('include/navbar.php'); ?>
  
  <div class="row navOptionsRow">
    
    <div class="col-md-12 navOptionsCol">
      
      <!-- <select class="selectpicker" id="">
        <option selected="selected" disabled="disabled">Distancia (500 mts)</option>
        <option value="0.310686">500 Metros</option>
        <option value="0.621371">1 Kilometro</option>
        <option value="3.10686">5 Kilometros</option>
        <option value="6.21371">10 Kilometros</option>
      </select> -->

      <select class="selectpicker" id="" onchange="location = this.value;">

        <?php if(isset($_GET['range']) AND !empty($_GET['range'])): ?>
          <?php if($_GET['range'] == 0.3): ?>
            <option selected="selected" disabled="disabled">Distancia (500 mts)</option>
          <?php elseif($_GET['range'] == 0.6): ?>
            <option selected="selected" disabled="disabled">Distancia (1 km)</option>
          <?php elseif($_GET['range'] == 3.1): ?>
            <option selected="selected" disabled="disabled">Distancia (5 kms)</option>
          <?php elseif($_GET['range'] == 6.2): ?>
            <option selected="selected" disabled="disabled">Distancia (10 kms)</option>
          <?php elseif($_GET['range'] >= 6.3): ?>
            <option selected="selected" disabled="disabled">Distancia (<?=$_GET['range']?> ml)</option>
          <?php else: ?>
            <option selected="selected" disabled="disabled">Distancia (<?=$_GET['range']?> ml)</option>
          <?php endif; ?>
        <?php else: ?>
          <option selected="selected" disabled="disabled">Distancia (500 mts)</option>
        <?php endif; ?>

        <option value="?range=0.3">500 Metros</option>
        <option value="?range=0.6">1 Kilometro</option>
        <option value="?range=3.1">5 Kilometros</option>
        <option value="?range=6.2">10 Kilometros</option>
      </select>

      <select class="selectpicker" id="">
        <option value="allCat" selected="selected" disabled="disabled">Categorias</option>
        <option value="all">Todas</option>
        <option>Comidas</option>
        <option>Bancos</option>
        <option>Salud</option>
        <option>Ferreterias</option>
      </select>

      <button class="btn btn-warning" href="#!" id="findMe">¡CERCA A MI!</button>

      <div class="clearfix"></div>

    </div>

  </div>

  <div id="map"></div>
  
  <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bower_components/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
  <script type="text/javascript">
    $('.selectpicker').selectpicker({
      style: 'btn-primary'
    });
  </script>
</body>
</html>