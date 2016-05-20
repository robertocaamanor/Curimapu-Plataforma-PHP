<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Curimapu</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link
        href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/jquery-swipe-nav.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="js/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>    
    <script src="js/jquery.Rut.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMa4pd7uMEU0NRi7dHS7YVBcFQvKG5Ow&signed_in=true&callback=initMap"></script>
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
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
        $("#daterange2").daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,            
            locale: {
              format: 'YYYY-MM-DD'
            }
        });
    });
  </script>
</head>
<body>

<div class="sidebar">
    <ul>
        <li><a href="#" id="alternar-respuesta-ej2"><span class="glyphicon glyphicon-save"></span> Informes</a>

        </li>
        <div id="respuesta-ej2" style="display:none">
            <ul>
                <li><a href="listarventas.php">Seguimiento ventas</a></li>
                <li><a href="listarvisitas.php">Visitas cultivo</a></li>
            </ul>
        </div>
        <li><a href="nuevovendedor.php"><span class="glyphicon glyphicon-user"></span> Nuevo vendedor</a></li>
        <li><a href="mapa.php"><span class="glyphicon glyphicon-map-marker"></span> Mapa</a></li>
        <li><a href="logout.php"><span class="glyphicon glyphicon-exclamation-sign"></span> Salir</a></li>
    </ul>
</div>

<div class="contenido">
    <a href="#" class="menu-bar"><span class="glyphicon glyphicon-menu-hamburger"></span></a>