<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {
    $sql = "update FormularioVisita  set Variedad_id='".$_POST['variedad']."',
            FormularioVisita_fecha='" . $_POST['fecha'] . "',
            FormularioVisita_estCrecimient='" . $_POST['estadocrecimiento'] . "',
            FormularioVisita_dSemSiebra='" . $_POST['densidad'] . "',
            FormularioVisita_enferBacteria='" . $_POST['enfermedadesbacteriales'] . "',
            FormularioVisita_enfFungosas='" . $_POST['enfermedadesfungosas'] . "',
            FormularioVisita_estMalezas='" . $_POST['malezas'] . "',
            FormularioVisita_insectos='" . $_POST['insectos'] . "',
            FormularioVisita_humdad='" . $_POST['humedad'] . "',
            Observaciones='" . $_POST['observaciones'] . "',
            FormularioVisita_recomendacion='" . $_POST['recomendaciones'] . "'
            where FormularioVisita_id='" . $_POST['formularioId'] . "'";


    $recurso = mssql_prepare($con, $sql);

    if (mssql_execute($recurso)) {
       echo "Agregado correctamente";
   } else {
        echo "No Agregado";
    }
}

//include 'includes/footer.php';

?>