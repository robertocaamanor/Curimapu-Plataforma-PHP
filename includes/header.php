<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Curimapu Semillas</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/jquery-swipe-nav.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>    
    <script src="js/jquery.Rut.min.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
    }
</style>
<script>
  $(function() {
        $("#daterange1").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,  
            "drops": "up",        
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
        $("#daterange2").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,    
            "drops": "up",        
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
        $("#daterange3").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,  
            "drops": "up",        
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
        $("#daterange4").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,    
            "drops": "up",        
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
    });
  </script>
  <link rel="shortcut icon" href="http://i.imgur.com/akQX3eo.png">
</head>
<body>

<div class="sidebar">
    <div class="datos">
        <img src="http://i.imgur.com/YSA9qj6.png" alt="">
    </div>
    <ul>
        <li><a href="#" id="alternar-respuesta-ej2"><span class="glyphicon glyphicon-save"></span> Informes</a>

        </li>
        <div id="respuesta-ej2" style="display:none">
            <ul>
                <li><a href="listarventas.php">Seguimiento ventas</a></li>
                <li><a href="listarvisitas.php">Visitas cultivo</a></li>
            </ul>
        </div>
        <?php session_start(); if($_SESSION['perfil'] == 2) { ?>
        <li><a href="nuevovendedor.php"><span class="glyphicon glyphicon-user"></span> Nuevo usuario web</a></li>
        <li><a href="nuevoagricultor.php"><span class="glyphicon glyphicon-user"></span> Nuevo agricultor</a></li>
        <li><a href="listaragricultores.php"><span class="glyphicon glyphicon-user"></span> Lista agricultores</a></li>
        <?php } ?>
        <?php if($_SESSION['perfil'] != 3) { ?>
        <li><a href="#" id="alternar-respuesta-ej3"><span class="glyphicon glyphicon-map-marker"></span> Mapa</a></li>

        <div id="respuesta-ej3" style="display:none">
            <ul>
                <li><a href="mapa.php">Mapa ventas</a></li>
                <li><a href="mapavisita.php">Mapa visitas</a></li>
            </ul>
        </div>
        <?php } ?>
        <li><a href="cambiarpassword.php"><span class="glyphicon glyphicon-pencil"></span> Cambiar contraseña</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-exclamation-sign"></span> Salir</a></li>
    </ul>
</div>

<div class="contenido">
    <a href="#" class="menu-bar"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
    <div class="header">
        <img src="http://i.imgur.com/OqpeQZm.png" alt="">
    </div>