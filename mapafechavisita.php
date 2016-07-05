<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
include 'includes/header.php';
include 'src/clases/Marker.php';
$conn = connectDB();
$fechahoy = date( "Y-m-d" );
  $semana = date( "Y-m-d", strtotime("-7 days",strtotime($fechahoy)));
if(isset($_POST['inicio'],$_POST['final'], $_POST['busquedavendedor'])){
  $inicio = $_POST['inicio'];
  $final = $_POST['final'];
  $vendedor = $_POST['busquedavendedor'];
  $result = listarvisitasvendedormixto($conn, $inicio, $final, $vendedor);
}
else{
  $result = listarVisitas($conn, $semana, $fechahoy);
}
?>
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
        padding-top: 10px;
        width: 80%;
        margin: 0 auto;
    }
</style>
<div id="map"></div>
<br>
<div class="sitio-principal">
<?php include 'includes/buscadormapavisita.php'; ?>
<hr/>
   <?php 
      $hoy = date( "Y-m-d" );
      $ayer = date( "Y-m-d", strtotime("-1 day",strtotime($hoy)));
      $semana = date( "Y-m-d", strtotime("-7 days",strtotime($hoy)));
      $primero = 1;
       do {
      while($row=mssql_fetch_array($result))
      {
       $date = date_format(new DateTime($row['fecha']), 'Y-m-d');
       if($primero){
        $compare = $date;
        $primero = 0;?>
        <div class="panelsemillas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php
            if($date == $hoy)
              echo "Hoy";
            else echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">

       <?php }
       if($compare==$date){?>
          <div class="list-group">
            <a href="mapasearchvisita.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['nombreespecie']; ?></b></p>                      
                      <p class="list-group-item-text"><b>Ubicacion: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php }
      else{
        $compare = $date?>
        </div>
        </div>
         <div class="panelsemillas">
          <div class="panel-titulo">
            <h3 class="panel-title"><?php echo $date ?></h3>
          </div>
          <div class="panel-cuerpo">
          <div class="list-group">
            <a href="mapasearchvisita.php?id=<?php echo $row['id']; ?>" class="list-group-item">
              <div class="grupo">
                  <div class="img-principal">
                      <img src="http://odontopekes.com/wp-content/uploads/2016/01/facebookanon.jpg" alt="" class="img-circle">
                  </div>
                  <div class="cuerpo-principal">
                      <h4 class="list-group-item-heading">Agricultor: <?php echo $row['agricultor']; ?></h4>
                      <p class="list-group-item-text"><b>Vendedor: <?php echo $row['PrimerNombre']." ".$row['SegundoNombre']; ?></b></p>
                      <p class="list-group-item-text"><b>Especie: <?php echo $row['nombreespecie']; ?></b></p>                      
                      <p class="list-group-item-text"><b>Ubicacion: <?php echo $row['Ubicacion']; ?></b></p>
                      <p class="list-group-item-text"><b>Observación: <?php echo $row['observacion']; ?></b></p>
                  </div>
              </div>
            </a>
          </div>
      <?php } 
      }
      } while(mssql_next_result($result));
      cerrar($conn) ?>
</div>
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: {lat: -36.8308521, lng: -73.0582368}
        });
        <?php $markers1 = Marker::fechaVisitaMarkers(); ?>
        <?php while (list(, $valor) = each($markers1)) {
        echo " var marker = new google.maps.Marker({";
        echo "position: {lat:" . $valor->getLatvisita() . ",lng:" . $valor->getLngvisita() . "},";
        echo " title: '" . $valor->getAgricultorvisita() . " / ". $valor->getLatvisita() .",". $valor->getLngvisita() ."',";
        echo "map: map});";
    }
        ?>
    }
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMa4pd7uMEU0NRi7dHS7YVBcFQvKG5Ow&signed_in=true&callback=initMap"></script>
<?php include 'includes/footer.php'; } ?>