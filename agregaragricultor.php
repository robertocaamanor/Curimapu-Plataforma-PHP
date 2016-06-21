<?php 
	include 'src/functions/dbfunctions.php';
	include 'includes/header.php';
	$con = connectDB();
	if(!empty($_POST)){
 
		$nombre=$_POST['nombreagricultor'];
		$telefono=$_POST['telefono'];
		$rut=$_POST['rut'];
		$email=$_POST['email'];
		$comuna=$_POST['comuna'];
		$contacto=$_POST['contacto'];
		$userid=$_POST['user'];
		$sql= "INSERT into Agricultorr(Agricultorr_nombre, Agricultorr_telefono, Agricultorr_rut, Agricultorr_email, Agricultorr_ubicacion, UserID, Agricultorr_Contacto )values('$nombre', '$telefono', '$rut', '$email', '$comuna', '$userid', '$contacto')";
		 
		//Te faltaba esta linea
		 
		$recurso=mssql_query($sql, $con);
		 
		//Para mas seguridad usa el valor retornado por sqlsrv_execute
		 
		if($recurso){
		      echo"Agregado correctamente";
		}else{
		      echo"No Agregado";
		}
	}

	include 'includes/footer.php';

 ?>