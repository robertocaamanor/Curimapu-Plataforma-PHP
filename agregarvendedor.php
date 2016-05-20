<?php 
	include 'src/functions/dbfunctions.php';
	include 'includes/header.php';
	$con = connectDB();
	if(!empty($_POST)){
 
		$nombre=$_POST['nombrevendedor'];
		$telefono=$_POST['telefono'];
		$rut=$_POST['rut'];
		$email=$_POST['email'];
		$password=$_POST['password'];
		$sql= "INSERT into Vendedor(Vendedor_nombre, Vendedor_fono, Vendedor_rut, Vendedor_email, Vendedor_pass)values('$nombre', '$telefono', '$rut', '$email', '$password')";
		 
		//Te faltaba esta linea
		 
		$recurso=mssql_prepare($con, $sql);
		 
		//Para mas seguridad usa el valor retornado por sqlsrv_execute
		 
		if(mssql_execute($recurso)){
		      echo"Agregado correctamente";
		}else{
		      echo"No Agregado";
		}
	}

	include 'includes/footer.php';

 ?>