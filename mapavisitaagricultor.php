<?php
session_start();

if (!isset($_SESSION['email'])) {

    echo "No tienes permiso para entrar a esta pagina";
} else {
include 'includes/header.php';
include 'src/clases/Marker.php';
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
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 10,
            center: {lat: -36.8308521, lng: -73.0582368}
        });
        <?php $markers1 = Marker::agroVisitaMarkers(); ?>
        <?php while (list(, $valor) = each($markers1)) {
        echo " var marker = new google.maps.Marker({";
        echo "position: {lat:" . $valor->getLatvisita() . ",lng:" . $valor->getLngvisita() . "},";
        echo " title: '" . $valor->getAgricultorvisita() . " / ". $valor->getLatvisita() .",". $valor->getLngvisita() ."',";
        echo "map: map});";
        echo "var infowindow = new google.maps.InfoWindow({";
        echo "content:'". $valor->getUbicacionvisita() ."' });";
        echo "google.maps.event.addListener(marker, 'click', function() { ";
        echo "infowindow.open(map,marker); ";
        echo "});"; 
    }
        ?>
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFMa4pd7uMEU0NRi7dHS7YVBcFQvKG5Ow&signed_in=true&callback=initMap"></script>
<?php include 'includes/footer.php'; } ?>