<?php
include 'src/functions/dbfunctions.php';
//include 'includes/header.php';
$con = connectDB();
if (!empty($_POST)) {

    $sql = "update Agricultorr set 
           Agricultorr_nombre='".$_POST['nombreagricultor']."',
            Agricultorr_telefono='".$_POST['telefono']."',
           Agricultorr_email='".$_POST['email']."',
            Agricultorr_rut='".$_POST['rut']."',
            Agricultorr_ubicacion='".$_POST['comuna']."',
            Agricultorr_contacto='".$_POST['contacto']."',
            UserID='".$_POST['perfil']."'
            where Agricultorr_id='".$_POST['agricultorid']."'";


    $recurso = mssql_query($sql, $con);

    if ($recurso) {
        echo "Agregado correctamente";
    } else {
        echo "No Agregado";
    }
    echo "<br><br>Sera redirigido en algunos segundos...";
    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=modagricultores.php?id=".$_POST['agricultorid']."'>"; 
}else
    echo "vacio";

//include 'includes/footer.php';

?>