<?php 
    function correoventa($id, $especie, $fecha){
    	$conn = ConnectDB();	    
		$result = detalleventa($id,$conn);
    	if (!class_exists("phpmailer")) {
			require_once('src/phpmailer/class.phpmailer.php');
		}
    	//include("src/phpmailer/class.phpmailer.php");

    	if (!class_exists("smtp")) {
			require_once('src/phpmailer/class.smtp.php');
		}
    	
		include 'src/php2pdf/class.ezpdf.php';
		include('src/php2pdf/class.backgroundpdf.php');
	    //include("src/phpmailer/class.smtp.php");
		$row = mssql_fetch_array($result);

		    //$varname = $_FILES['informepdf']['name'];

			//$vartemp = $_FILES['informepdf']['tmp_name'];

			//$archivo=$_FILES['informepdf'];

		    	$f= date("d-m-Y H:i:s");

		  $mensaje = "Se adjunta archivo del reporte PDF de Ventas numero ".$id."<br/><br/>Fecha: ".$fecha."<br/>Especie: ".$especie;

		    //$mails = strtolower($mails);

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

			//$mail->AddAddress($emailagricultor); //Puede ser Hotmail

			//$mail->AddAddress('rvillagran@xhost.cl');
			$lista1 = "SELECT * FROM correos";
			$lista2 = query($conn, $lista1);
			while($listadomails = parse($lista2)){
				$mail->AddAddress($listadomails['correo']);
			}

			//$mail->AddAddress('rvillagran@xcom.cl');

			$mail->Subject='Semillas - Visita Ventas, '.$especie.', '.$fecha.'';

			$mail->Body=$mensaje;

			$pdf = new backgroundPDF('letter', 'portrait', 'image', array('img' => 'img/curisemillas.jpg', 'width' => 522, 'height' => 410, 'xpos' =>50, 'ypos' => 290));
		$pdf->selectFont('src/php2pdf/fonts/Helvetica.afm');

		$datacreator = array (
		'Title'=>'Informe venta');

		$pdf->addInfo($datacreator);
		$pdf->ezText("\n".utf8_decode("N° Formulario: ").$id,12,array('justification'=>'right')); 
		$pdf->ezImage("http://i.imgur.com/pNyRasn.jpg", 0, 80, 'none', 'left');
		$pdf->ezText("\nINFORME SEGUIMIENTO DE VENTAS",20,array('justification'=>'center'));

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>"Fecha: ".date_format(new DateTime($row['fecha']), 'd-m-y'),'type'=>utf8_decode("Contacto: ".$row['contacto']))
		,array('name'=>"Agricultor: ".utf8_decode($row['agricultor']),'type'=>utf8_decode("Ubicación: ".$row['ubicacion']))
		,array('name'=>"Especie: ".utf8_decode($row['nombreespecie']),'type'=>utf8_decode("Teléfono: ").$row['fono'])
		,array('name'=>"Variedad: ".utf8_decode($row['variedad']),'type'=>"E-Mail: ".utf8_decode($row['email']))
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\n",12); 
		$data = array(
		array('name'=>'1.Superficie sembrado temporada anterior:','type'=>$row['superficiesiembra'].' has')
		,array('name'=>utf8_decode("2.Intención de siembra total:"),'type'=>$row['intencionsiembra'].' has')
		,array('name'=>utf8_decode("3.Intención de siembra Curimapu:"),'type'=>$row['intencionsiembraanterior'].' has')
		,array('name'=>'4.Rendimiento temporada anterior: ','type'=>$row['rendimiento'].' qq/has')
		,array('name'=>'5.Hibrido(s) usado temporada pasada: ','type'=>$row['hibridoscuri'])
		,array('name'=>'6.Hibrido(s) usado temporada pasada otras empresas: ','type'=>$row['hibridosotros'])
		,array('name'=>utf8_decode("7.Hectáreas Riego:"),'type'=>$row['riego'].' has')
		,array('name'=>utf8_decode("8.Hectáreas Secano:"),'type'=>$row['secano'].' has')
		);
		$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
			  ,'width'=>500,'fontSize' => 12,'showLines'=>1, 'cols'=>array("name" => array('width'=>250), "type" => array('width'=>250))));

		$pdf->ezText("\nObservaciones:\n".utf8_decode($row['comentario']),12,array('left'=>30)); 
		$pdf->ezText("\nRecomendaciones:\n".utf8_decode($row['recomendaciones']),12,array('left'=>30));


		ob_end_clean();


			$documento_pdf = $pdf->ezOutput();
			$fichero = fopen('pdfventas/informeventa'.$id.'.pdf','wb');
			fwrite ($fichero, $documento_pdf);
			fclose ($fichero);

			$mail->addAttachment('pdfventas/informeventa'.$id.'.pdf');


			//$mail->AltBody="Texto que debe decir lo mismo que el Body, pero sin etiquetas HTML";

			$exito = $mail->Send();

			if($exito){

			     $mail->ClearAddresses();

			     echo "<br/>";

			     $d = "UPDATE FormularioVenta SET bandera = 'E' WHERE FormularioVentaid='".$id."'";

			     $qd = query($conn, $d);

			     

			}else {

			    $fallido = "UPDATE FormularioVenta SET bandera = 'F' WHERE FormularioVentaid='".$id."'";

			     $sqlfallido = query($conn, $fallido);

			}
    }

 ?>