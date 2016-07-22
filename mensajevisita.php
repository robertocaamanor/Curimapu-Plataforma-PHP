<?php 

	function correovisita($id, $especie, $fecha){
		

		include 'src/php2pdf/class.ezpdf.php';
		include('src/php2pdf/class.backgroundpdf.php');
		$conn = ConnectDB();	
		$result = detallevisita($id,$conn);
		$row = mssql_fetch_array($result);

		$pdf = new backgroundPDF('letter', 'portrait', 'image', array('img' => 'img/curisemillas.jpg', 'width' => 522, 'height' => 410, 'xpos' =>50, 'ypos' => 290));
		$pdf->selectFont('src/php2pdf/fonts/Helvetica.afm');

		$datacreator = array (
		'Title'=>'Informe visita');

		$pdf->addInfo($datacreator);
		$pdf->ezText("\n".utf8_decode("N° Formulario: ").$id,12,array('justification'=>'right')); 
		$pdf->ezImage("http://i.imgur.com/pNyRasn.jpg", 0, 80, 'none', 'left');
		$pdf->ezText("\nINFORME VISITA CULTIVO",20,array('justification'=>'center'));

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>"Fecha: ".date_format(new DateTime($row['fecha']), 'd-m-y'),'type'=>utf8_decode("Contacto:".$row['contacto']))
		,array('name'=>"Agricultor: ".utf8_decode($row['agricultor']),'type'=>utf8_decode("Ubicación:".$row['ubicacion']))
		,array('name'=>"Especie: ".utf8_decode($row['nombreespecie']),'type'=>utf8_decode("Teléfono:").$row['fono'])
		,array('name'=>"Variedad: ".utf8_decode($row['variedad']),'type'=>"E-Mail: ".utf8_decode($row['email']))
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>'1.Estado de crecimiento: '.utf8_decode($row['estadocrecimiento']),
			  'type'=>'5.Poblacion: '.utf8_decode($row['poblacion']))
		,array('name'=>'2.Enfermedades y Plagas: '.utf8_decode($row['enfermedades']),
			  'type'=>'6.Dosis de Semilla a la Siembra: '.$row['dsemillasiembra'])
		,array('name'=>'3. Malezas: '.$row['malezas'])
		,array('name'=>'4.Humedad: '.$row['humedad'],)
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\nOBSERVACIONES GENERALES DEL CULTIVO:\n".utf8_decode($row['observaciones']),12,array('left'=>30)); 
		$pdf->ezText("\n\n\n\n",12); 
		$pdf->ezText("\nRECOMENDACIONES:\n".utf8_decode($row['recomendaciones']),12,array('left'=>30)); 


	ob_end_clean();
	$documento_pdf = $pdf->ezOutput();
	$fichero = fopen('pdfvisitas/informevisita'.$id.'.pdf','wb');
	fwrite ($fichero, $documento_pdf);
	fclose ($fichero);
	if (!class_exists("phpmailer")) {
			require_once('src/phpmailer/class.phpmailer.php');
		}
    	//include("src/phpmailer/class.phpmailer.php");

    	if (!class_exists("smtp")) {
			require_once('src/phpmailer/class.smtp.php');
		}

    //$varname = $_FILES['informepdf']['name'];

	//$vartemp = $_FILES['informepdf']['tmp_name'];

	//$archivo=$_FILES['informepdf'];

    	$f= date("d-m-Y H:i:s");

	  $mensaje = "Se adjunta archivo del reporte PDF de Visita Cultivo numero ".$id."<br/><br/>Fecha: ".$fecha."<br/>Especie: ".$especie;

	    //$mails = strtolower($mails);

	    //$sql = "SELECT correo FROM correos";

	    //$correos = query($conn, $sql);

	    //while($row = parse($correos)){

		//$mails=$row['correo'];

		//}

	    $mail=new PHPMailer();

		$mail->Mailer="IMAP";

		$mail->Helo = "www.xhost.cl"; //Muy importante para que llegue a hotmail y otros

		$mail->SMTPAuth=false;

		$mail->Host="webserver01.xhost.cl";

		$mail->Port=993; //depende de lo que te indique tu ISP. El default es 25, pero nuestro ISP lo tiene puesto al 26

		$mail->Username="rcaamano@xhost.cl";

		$mail->Password="roberto09101992";

		$mail->From="rcaamano@xhost.cl";

		$mail->FromName="E-MAIL DE PRUEBA";

		$mail->Timeout=60;

		$mail->IsHTML(true);

		//Enviamos el correo

		$lista1 = "SELECT * FROM correos";
		$lista2 = query($conn, $lista1);
		while($listadomails = parse($lista2)){
			$mail->AddAddress($listadomails['correo']);
		}

		//$mail->AddAddress($emailagricultor);

		$mail->Subject='Semillas - Visita Cultivo, '.$especie.', '.$fecha.'';

		$mail->Body=$mensaje;

		$mail->addAttachment('pdfvisitas/informevisita'.$id.'.pdf');



		//if ($archivo['name'] != "") { //si no esta vacio el nombre adjunta el archivo al correo

			//$mail->AddAttachment($vartemp, $varname);

		//}

		//$mail->AltBody="Texto que debe decir lo mismo que el Body, pero sin etiquetas HTML";

		$exito = $mail->Send();

		if($exito){

		     $mail->ClearAddresses();

		     $d = "UPDATE FormularioVisita SET bandera = 'E' WHERE FormularioVisitaid='".$id."'";

		     $qd = query($conn, $d);

		     

		}else {

		    $fallidos = "UPDATE FormularioVisita SET bandera = 'F' WHERE FormularioVisitaid='".$id."'";

		     $qfallidos = query($conn, $fallidos);

		}
	}

 ?>