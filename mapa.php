<?php
session_start(); 

if(!isset($_SESSION['email'])) 
  { 

    echo "No tienes permiso para entrar a esta pagina"; 
  } 
  else 
  {   
include 'includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/curimapuweb/src/clases/Marker.php';
?>


<div id="map"></div>
<br>
<div>
    <table id="markers_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Ubicaci&oacute;n</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Fecha</th>
            <th>Vendedor</th>
            <th>Ubicaci&oacute;n</th>
        </tfoot>
        <tbody>

        <?php $markers = Marker::listMarkers(); ?>
        <?php
        while (list(, $valor) = each($markers)) {
            echo " <tr>";
            echo "<td>" . $valor->getFecha(). "</td>";
            echo "<td>" . $valor->getVendedor() . "</td>";
            echo "<td>" . $valor->getUbicacion() . "</td>";
            echo " </tr>";
        }
        ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: {lat: -36.8308521, lng: -73.0582368}
        });
        <?php $markers1 = Marker::listMarkers(); ?>
        <?php while (list(, $valor) = each($markers1)) {
        echo " var marker = new google.maps.Marker({";
        echo "position: {lat:" . $valor->getLat() . ",lng:" . $valor->getLng() . "},";
        echo " title: '" . $valor->getUbicacion() . "',";
        echo "map: map});";
    }
        ?>
    }
    $(document).ready(function() {
        $.extend($.fn.dataTable.defaults, {
            searching: false,
            ordering: false
        });
        $('#markers_table').DataTable({
            ordering: true,
            paging: false,
            "processing": true
        });
    });
    
</script>
<?php include 'includes/footer.php'; } ?>