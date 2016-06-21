<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {

    $sql = "update FormularioVenta set 
            FormularioVenta_Supsiembre='".$_POST['superficiesiembra']."',
            FormularioVenta_intSiembraTota='".$_POST['intencionsiembra']."',
            FormularioVenta_intSiembraCuri='".$_POST['intencionsiembraanterior']."',
            FormularioVenta_RendTemp='".$_POST['rendimientoanterior']."',
            FormularioVenta_hibridosCuri='".$_POST['hibridoscuri']."',
            FormularioVenta_hibridosOtros='".$_POST['hibridosotros']."',
            FormularioVenta_hecRiego='".$_POST['hectareasriego']."',
            FormularioVenta_hecSecano='".$_POST['hectareassecano']."',
            FormularioVenta_obsv='".$_POST['comentarios']."',
            FormularioVenta_recomendacione='".$_POST['recomendaciones']."',
            FormularioVenta_FechaMod = GETDATE()
            where FormularioVenta_id='".$_POST['formularioId']."'";


    $recurso = mssql_query($sql, $con);

    if ($recurso) {
        echo "Agregado correctamente";         
    } else {
        echo "No Agregado";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=modseguimientoventas.php?id=".$_POST['formularioId']."'>"; 
}else
    echo "vacio";

//include 'includes/footer.php';

?>