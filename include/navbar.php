<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?=HOME_URL.'index.php'?>">Outlet</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="<?=HOME_URL.'index.php'?>">Mapa <span class="sr-only">(current)</span></a></li>
        <li><a href="<?=HOME_URL.'listado.php'?>">Listado</a></li>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Cuenta <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
          <li><a href="login.php">Iniciar Sesion</a></li>
          <li class="divider"></li>
          <li><a href="registro.php">Registro</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
