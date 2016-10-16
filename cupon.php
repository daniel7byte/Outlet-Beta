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
      <?php
        $query = $mysql->prepare("SELECT * FROM sucursales WHERE id = :id LIMIT 1");

        $arrayQuery = array(
          ':id' => $_GET['id']
        );

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
