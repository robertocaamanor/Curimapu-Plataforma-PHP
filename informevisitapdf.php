<?php
include 'src/php2pdf/class.ezpdf.php';
include('src/php2pdf/class.backgroundpdf.php');
include 'src/functions/dbfunctions.php';
$id = $_GET['id'];
$conn = connectDB();
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
$pdf->ezStream();

?>