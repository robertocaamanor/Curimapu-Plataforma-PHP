<?php 

	//$con = ConnectDB();
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$perfilid = $_POST['perfil'];
	$con=mssql_connect("xcom.ddns.net", "sa", "jYcC5DLt");
	mssql_select_db("SemillasCurimapuBD", $con);

	$sql="SELECT * FROM Vendedor WHERE Vendedor_email='".$email."' and Vendedor_pass='".$password."' and PerfilId='".$perfilid."'";
	$res=mssql_query($sql);
	 
	$x=0;
	while($row=mssql_fetch_array($res)) {
	if ($row['Vendedor_email']==$email && $row['Vendedor_pass']==$password && $row['PerfilId']==$perfilid) { 
	        $x=1;	        
	    }
	    else {
	        $x=0;}
	    } 
	    if($x==1) {
	echo '<font color="black" size="+1">';
	session_start(); 
	$_SESSION['email']= $email;
	$_SESSION['perfil'] = $perfilid;
	echo "Bienvenido";
	echo '<p>';
	echo '<br>';
	header('Location: listarventas.php');
	exit;
	    }
	    else {echo "Datos incorrectos, por favor intente nuevamente";
	    echo "<META HTTP-EQUIV='refresh' CONTENT='5; URL=index.php'>"; 
	    }
	mssql_free_result($res);
	mssql_close();

 ?>