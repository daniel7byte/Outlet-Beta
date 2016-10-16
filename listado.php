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
  <script type="text/javascript">
    var latitud;
    var longitud;
    Cookies.remove('lat');
    Cookies.remove('lng');
    function geoFindMe() {
      if (!navigator.geolocation){
        console.log('Geolocation is not supported by your browser');
        return;
      }
      function success(position) {
        latitude  = position.coords.latitude;
        longitude = position.coords.longitude;
        Cookies.set('lat', position.coords.latitude);
        Cookies.set('lng', position.coords.longitude);
        console.log(position);
      };
      function error() {
        console.log('Unable to retrieve your location');
      };
      navigator.geolocation.getCurrentPosition(success, error);
    }

    geoFindMe();

  </script>
</head>
<body>

  <?php include_once('include/navbar.php'); ?>

  <div class="container" style="margin-top: 60px;">
    <div class="row" style="padding-left: 4px; padding-top: 4px; padding-bottom: 4px;">


      <select class="selectpicker" id="range">
        <!-- onchange="location = this.value;" -->
        <?php
          if(isset($_GET['cat']) AND !empty($_GET['cat'])){
            $cat = $_GET['cat'];
          }else{
            $cat = '%';
          }
        ?>
        <?php if(isset($_GET['range']) AND !empty($_GET['range'])): ?>
          <?php if($_GET['range'] == 0.3): ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (500 mts)</option>
          <?php elseif($_GET['range'] == 0.6): ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (1 km)</option>
          <?php elseif($_GET['range'] == 3.1): ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (5 kms)</option>
          <?php elseif($_GET['range'] == 6.2): ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (10 kms)</option>
          <?php elseif($_GET['range'] >= 6.3): ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (<?=$_GET['range']?> ml)</option>
          <?php else: ?>
            <option value="listado.php?cat=<?=$cat?>&range=<?=$_GET['range']?>" selected="selected">Distancia (<?=$_GET['range']?> ml)</option>
          <?php endif; ?>
        <?php else: ?>
          <option value="listado.php?cat=<?=$cat?>&range=0.3" selected="selected">Distancia (500 mts)</option>
        <?php endif; ?>
        <option  data-divider="true"></option>
        <option value="listado.php?cat=<?=$cat?>&range=0.3">500 Metros</option>
        <option value="listado.php?cat=<?=$cat?>&range=0.6">1 Kilometro</option>
        <option value="listado.php?cat=<?=$cat?>&range=3.1">5 Kilometros</option>
        <option value="listado.php?cat=<?=$cat?>&range=6.2">10 Kilometros</option>
      </select>
      <button class="btn btn-warning" id="findMe" onclick="location = $('#range').val();"><span class="glyphicon glyphicon-screenshot"></span></button>

      <?php if(isset($_GET['range']) AND !empty($_GET['range'])): ?>
        <a class="btn btn-success" href="index.php?cat=<?=$cat?>&range=<?=$_GET['range']?>"><span class="glyphicon glyphicon-globe"></span></a>
      <?php else: ?>
        <a class="btn btn-success" href="index.php?cat=<?=$cat?>&range=0.3"><span class="glyphicon glyphicon-globe"></span></a>
      <?php endif; ?>

      <a class="btn btn-primary" href="categorias.php"><span class="glyphicon glyphicon-search"></span></a>

      <div class="clearfix"></div>


    </div>
    <div class="row">
      <?php
        $query = $mysql->prepare("SELECT id, descripcion, valorAntes, valorAhora, titulo, icon, nombreEmpresa, categoria, direccion, latitud, longitud, SQRT(POW(69.1 * (latitud - :lat), 2) + POW(69.1 * (:lng - longitud) * COS(latitud / 57.3), 2)) AS distance FROM sucursales WHERE categoria LIKE :cat HAVING distance < :range ORDER BY distance ASC");

        // WHERE categoria = ":cat"

        if(isset($_COOKIE['lat']) AND isset($_COOKIE['lng']) AND isset($_GET['range']) AND !empty($_GET['range']) AND isset($_GET['cat'])){
          $arrayQuery = array(
            ':lat' => $_COOKIE['lat'],
            ':lng' => $_COOKIE['lng'],
            ':range' => $_GET['range'],
            ':cat' => $_GET['cat']
          );
        }else{
          $arrayQuery = array(
            ':lat' => 3.4227857999999998,
            ':lng' => -76.55079080000002,
            ':range' => 0.310686,
            ':cat' => '%'
          );
        }

        $query->execute($arrayQuery);

        $result = $query->fetchAll();

        foreach ($result as $data):
      ?>

        <div class="panel panel-primary" style="border-radius: 0px;">
          <div class="panel-heading" style="border-radius: 0px;">
            <?=$data['titulo']?> | <span class="badge"><?=$data['categoria']?></span>
            <!-- <span class="label label-info"><?#=$data['categoria']?></span> -->
          </div>
          <div class="panel-body">
            <?php if($data['icon'] != ''){
              echo "<img src='resources/images/marker/bussiness/".$data['icon']."' class='img img-responsive' />";
            }else {
              if($data['categoria'] == 'Bancos'){
                echo "<img src='resources/images/marker/place-to-stay.png' class='img img-responsive' />";
              }elseif($data['categoria'] == 'Comidas'){
                echo "<img src='resources/images/marker/fastfood.png' class='img img-responsive' />";
              }elseif($data['categoria'] == 'Salud'){
                echo "<img src='resources/images/marker/farmacia.png' class='img img-responsive' />";
              }elseif($data['categoria'] == 'Ferreterias'){
                echo "<img src='resources/images/marker/theme-park.png' class='img img-responsive' />";
              }else{
                echo "<img src='resources/images/marker/cupon.png' class='img img-responsive' />";
              }
            } ?>
            <hr>
              <label>PROMOCION:</label>
              <p>
                <span style="color: #9E9E9E;">
                  Antes: <s><em><?=$data['valorAntes']?></em></s>
                </span>
                <br>
                <span style="color: #4CAF50; font-size: 30px;">
                  Ahora: <strong><?=$data['valorAntes']?></strong>
                </span>
              </p>
            <hr>
            <label>DESCRICION:</label>
            <blockquote>
              <p><?=$data['descripcion']?></p>
              <small>Empresa: <cite title="Source Title"><?=$data['nombreEmpresa']?></cite></small>
            </blockquote>
          </div>
          <div class="panel-footer" style="border-radius: 0px;">
            <a class="btn btn-success btn-sm col-xs-12 col-md-12" href="cupon.php?id=<?=$data['id']?>">MAS DETALLES <span class="glyphicon glyphicon-plus"></span></a>
            <div class="clearfix"></div>
          </div>
        </div>

      <?php endforeach; ?>
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
