<?php 
	include 'src/functions/dbfunctions.php';
	include 'includes/header.php';
	$con=mssql_connect("xcom.ddns.net", "sa", "jYcC5DLt");
	mssql_select_db("SemillasCurimapuBD", $con);
	if(!empty($_POST)){
 
		$nombre=$_POST['nombrevendedor'];
		$telefono=$_POST['telefono'];
		$rut=$_POST['rut'];
		$email=$_POST['email'];
		$password=md5($_POST['password']);
		$perfilid=$_POST['perfil'];
		$sql= "INSERT into Vendedor(Vendedor_nombre, Vendedor_fono, Vendedor_rut, Vendedor_email, Vendedor_pass, PerfilId)values('$nombre', '$telefono', '$rut', '$email', '$password', '$perfilid')";
		 
		//Te faltaba esta linea
		 
		$recurso=mssql_query($sql);
		 
		//Para mas seguridad usa el valor retornado por sqlsrv_execute
		 
		if($recurso){
		      echo"Agregado correctamente";
		}else{
		      echo"No Agregado";
		}
		echo "<br><br>Sera redirigido en algunos segundos...";
    	echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=nuevovendedor.php'>";
	}

	include 'includes/footer.php';

 ?>