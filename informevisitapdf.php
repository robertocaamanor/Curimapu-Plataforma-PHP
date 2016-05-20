<?php
include 'src/php2pdf/class.ezpdf.php';
include 'src/functions/dbfunctions.php';
$id = $_GET['id'];
$conn = connectDB();
$result = detallevisita($id,$conn);
$row = mssql_fetch_array($result);

$pdf =& new Cezpdf('letter','portrait');
$pdf->selectFont('src/php2pdf/fonts/Times-Roman.afm');

$datacreator = array (
'Title'=>'Informe visita');

$pdf->addInfo($datacreator);


$pdf->ezText("\nINFORME VISITA CULTIVO",12,array('justification'=>'center'));
$pdf->ezText("\n".utf8_decode("N°").$id,12,array('justification'=>'right')); 

$data = array(
array('name'=>utf8_decode("Razón social: ".$row['razon']),'type'=>"Fecha: ".date_format(new DateTime($row['fechaVisita']), 'd-m-y'))
,array('name'=>"Agricultor: ".utf8_decode($row['agricultor']),'type'=>utf8_decode("Ubicación:".$row['ubicacion']))
,array('name'=>utf8_decode("Teléfono:").$row['fono'],'type'=>"Email: ".utf8_decode($row['email']))
,array('name'=>"Variedad: ".utf8_decode($row['variedad']),'type'=>"")
);
$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
	  ,'width'=>500,'fontSize' => 12,'showLines'=>0));

$pdf->ezText("\n",12); 
$data = array(
array('name'=>'1.Estado de crecimiento: '.utf8_decode($row['estadocrecimiento']),
	  'type'=>'5.Plantas por metro: '.utf8_decode($row['densidad']))
,array('name'=>'2.Enfermedades Bacteriales: '.utf8_decode($row['bacteriales']),
	  'type'=>'6.Enfermedades Fungosas: '.utf8_decode($row['fungosas']))
,array('name'=>'3.Cultivo: '.$row['malezas'],
	  'type'=>'7.Insectos: '.$row['insectos'])
,array('name'=>'4.Humedad: '.$row['humedad'],)
);
$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
	  ,'width'=>500,'fontSize' => 12,'showLines'=>0));

$pdf->ezText("\nOBSERVACIONES GENERALES DEL CULTIVO:\n".utf8_decode($row['observaciones']),12,array('left'=>30)); 
$pdf->ezText("\n\n\n\n",12); 
$pdf->ezText("\nRECOMENDACIONES:\n".utf8_decode($row['recomendaciones']),12,array('left'=>30)); 


ob_end_clean();
$pdf->ezStream();

?>