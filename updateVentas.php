<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {

    $sql = "update FormularioVenta set Variedad_id='".$_POST['variedad']."',
            FormularioVenta_fecha='".$_POST['fecha']."',
            FormularioVenta_Supsiembre='".$_POST['superficiesiembra']."',
            FormularioVenta_intSiembra='".$_POST['intencionsiembra']."',
            FormularioVenta_intSiembraCuri='".$_POST['intencionsiembraanterior']."',
            FormularioVenta_RendTemp='".$_POST['rendimientoanterior']."',
            FormularioVenta_hibridosCuri='".$_POST['hibridoscuri']."',
            FormularioVenta_hibridosOtros='".$_POST['hibridosotros']."',
            FormularioVenta_hecRiego='".$_POST['hectareasriego']."',
            FormularioVenta_hecSecano='".$_POST['hectareassecano']."',
            formularioVenta_obsv='".$_POST['comentarios']."'
            where FormularioVenta_id='".$_POST['formularioId']."'";


    $recurso = mssql_query($sql, $con);

    if ($recurso) {
        echo "Agregado correctamente";
    } else {
        echo "No Agregado";
    }
}else
    echo "vacio";

//include 'includes/footer.php';

?>