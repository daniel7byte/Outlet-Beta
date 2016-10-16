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
  <link rel="stylesheet" type="text/css" href="resources/css/gmaps.css">
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK6W34CCNplz4LpPN9eOYpCOaJGOYycyU"></script>
  <script type="text/javascript" src="bower_components/gmaps/gmaps.min.js"></script>
  <script type="text/javascript" src="bower_components/markerclustererplus/dist/markerclusterer.min.js"></script>
  <script type="text/javascript" src="bower_components/js-cookie/src/js.cookie.js"></script>
  <script type="text/javascript">
    var map;
    var MyLat;
    var MyLng;
    var latlngCenter;

    Cookies.remove('lat');
    Cookies.remove('lng');

    $(document).ready(function(){

      var styleArray = [{"featureType":"landscape","stylers":[{"hue":"#FFA800"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.highway","stylers":[{"hue":"#53FF00"},{"saturation":-73},{"lightness":40},{"gamma":1}]},{"featureType":"road.arterial","stylers":[{"hue":"#FBFF00"},{"saturation":0},{"lightness":0},{"gamma":1}]},{"featureType":"road.local","stylers":[{"hue":"#00FFFD"},{"saturation":0},{"lightness":30},{"gamma":1}]},{"featureType":"water","stylers":[{"hue":"#00BFFF"},{"saturation":6},{"lightness":8},{"gamma":1}]},{"featureType":"poi","stylers":[{"hue":"#679714"},{"saturation":33.4},{"lightness":-25.4},{"gamma":1}]}];

      function initialize(){
        map = new GMaps({
          el: '#map',
          lat: ﻿3.45000,
          lng: -76.53333,
          zoom: 16,
          styles: styleArray,
          // markerClusterer: function(map) {
          //   return new MarkerClusterer(map);
          // },
          mapTypeControl: true,
          mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.BOTTOM_LEFT,
            position: google.maps.ControlPosition.BOTTOM_CENTER
          },
          zoomControl: true,
          zoomControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CENTER
          },
          scaleControl: true,
          streetViewControl: true,
          streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_BOTTOM
          }
        });

        var imageAvatar = {
          url: 'resources/images/marker/male.png',
        };

        GMaps.geolocate({
          success: function(position){
            map.setCenter(position.coords.latitude, position.coords.longitude);
            console.log(position.coords.latitude, position.coords.longitude);
            MyLat = (position.coords.latitude);
            MyLng = (position.coords.longitude);
            Cookies.set('lat', position.coords.latitude);
            Cookies.set('lng', position.coords.longitude);

            // Market de mi ubicacion
            map.addMarker({
              lat: position.coords.latitude,
              lng: position.coords.longitude,
              title: 'Mi Ubicacion',
              icon: imageAvatar,
              // icon: {
              //   url: 'http://maps.gstatic.com/mapfiles/circle.png',
              //   anchor: new google.maps.Point(10, 10),
              //   scaledSize: new google.maps.Size(10, 17)
              // },
              infoWindow: {
                content: 'Mi Ubicacion'
              }
            });
          },
          error: function(error){
            console.log('Geolocation failed: '+error.message);
          },
          not_supported: function(){
            console.log("Your browser does not support geolocation");
          },
          always: function(){
            console.log("Done!");
          }
        });

        var imgCuponComidas = {
          url: 'resources/images/marker/fastfood.png',
        };

        var imgCuponBancos = {
          url: 'resources/images/marker/place-to-stay.png',
        };

        var imgCuponSalud = {
          url: 'resources/images/marker/farmacia.png',
        };

        var imgCuponFerreterias = {
          url: 'resources/images/marker/theme-park.png',
        };

        var imgCuponOtros = {
          url: 'resources/images/marker/cupon.png',
        };

        <?php
          $query = $mysql->prepare("SELECT id, titulo, icon, nombreEmpresa, categoria, direccion, latitud, longitud, SQRT(POW(69.1 * (latitud - :lat), 2) + POW(69.1 * (:lng - longitud) * COS(latitud / 57.3), 2)) AS distance FROM sucursales WHERE categoria LIKE :cat HAVING distance < :range");

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

        map.addMarker({
          lat: <?=$data['latitud']?>,
          lng: <?=$data['longitud']?>,
          title: '<?=$data['titulo']?>',
          <?php

          if($data['icon'] != ''){
            echo "icon: 'resources/images/marker/bussiness/".$data['icon']."',";
          }else{
            if($data['categoria'] == 'Bancos'){
              echo 'icon: imgCuponBancos,';
            }elseif($data['categoria'] == 'Comidas'){
              echo 'icon: imgCuponComidas,';
            }elseif($data['categoria'] == 'Salud'){
              echo 'icon: imgCuponSalud,';
            }elseif($data['categoria'] == 'Ferreterias'){
              echo 'icon: imgCuponFerreterias,';
            }else{
              echo 'icon: imgCuponOtros,';
            }
          }
          ?>
          infoWindow: {
            content: '<p><?=$data['titulo']?></p><p><?=$data['nombreEmpresa']?></p><p><?=$data['categoria']?></p><a class="btn btn-success btn-sm" href="cupon.php?id=<?=$data['id']?>">MAS DETALLES</a>'
          }
        });
      
        <?php endforeach; ?>

        // click: function(e){
        //   if(console.log)
        //     console.log(e);
        //   alert('You clicked in this marker');
        // },
        // mouseover: function(e){
        //   if(console.log)
        //     console.log(e);
        // },


      }

      google.maps.event.addDomListener(window, 'load', initialize);
      // google.maps.event.addDomListener(window, 'resize', initialize);
      google.maps.event.addDomListener(window, 'resize', function(){
        map.setCenter(MyLat, MyLng);
      });

      $('#findMe').click(function() {
        initialize();
      });

    });

  </script>
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

      <?php if(isset($_GET['cat']) AND !empty($_GET['cat'])): ?>
        <option value="index.php?cat=<?=$_GET['cat']?>&range=0.3">500 Metros</option>
        <option value="index.php?cat=<?=$_GET['cat']?>&range=0.6">1 Kilometro</option>
        <option value="index.php?cat=<?=$_GET['cat']?>&range=3.1">5 Kilometros</option>
        <option value="index.php?cat=<?=$_GET['cat']?>&range=6.2">10 Kilometros</option>
      <?php else: ?>
        <option value="index.php?cat=%&range=0.3">500 Metros</option>
        <option value="index.php?cat=%&range=0.6">1 Kilometro</option>
        <option value="index.php?cat=%&range=3.1">5 Kilometros</option>
        <option value="index.php?cat=%&range=6.2">10 Kilometros</option>
      <?php endif; ?>

      </select>

      <button class="btn btn-warning" href="#!" id="findMe"><span class="glyphicon glyphicon-screenshot"></span></button>

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