<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {
    $sql = "update FormularioVisita  set 
            FormularioVisita_estCrecimient='" . $_POST['estadocrecimiento'] . "',
            FormularioVisita_dSemSiebra='" . $_POST['dossemsiembra'] . "',
            FormularioVisita_enferPlagas='" . $_POST['enfermedades'] . "',
            FormularioVisita_poblacion='" . $_POST['poblacion'] . "',
            FormularioVisita_estMalezas='" . $_POST['malezas'] . "',
            FormularioVisita_humdad='" . $_POST['humedad'] . "',
            Observaciones='" . $_POST['observaciones'] . "',
            FormularioVisita_recomendacion='" . $_POST['recomendaciones'] . "',
            FormularioVisita_FechaMod = GETDATE()
            where FormularioVisita_id='" . $_POST['visitaid'] . "'";


    $recurso = mssql_query($sql, $con);
    if ($recurso) {
       echo "Actualizado correctamente";
   } else {
        echo "No Actualizado";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=modinformevisita.php?id=".$_POST['visitaid']."'>";  
}

//include 'includes/footer.php';

?>