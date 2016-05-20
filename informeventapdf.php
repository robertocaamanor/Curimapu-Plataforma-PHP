<?php

include 'src/php2pdf/class.ezpdf.php';
include 'src/functions/dbfunctions.php';

$id = $_GET['id'];
$conn = connectDB();
$result = detalleventa($id,$conn);
$row = mssql_fetch_array($result);

$pdf =& new Cezpdf('letter','portrait');
$pdf->selectFont('src/php2pdf/fonts/Times-Roman.afm');

$datacreator = array (
'Title'=>'Informe venta');

$pdf->addInfo($datacreator);


$pdf->ezText("\nINFORME SEGUIMIENTO DE VENTAS",12,array('justification'=>'center'));
$pdf->ezText("\n".utf8_decode("N°").$id,12,array('justification'=>'right')); 

$data = array(
array('name'=>utf8_decode("Razón social: ".$row['razon']),'type'=>"Fecha: ".date_format(new DateTime($row['fecha']), 'd-m-y'))
,array('name'=>"Agricultor: ".utf8_decode($row['agricultor']),'type'=>utf8_decode("Ubicación:".$row['ubicacion']))
,array('name'=>utf8_decode("Teléfono:").$row['fono'],'type'=>"Email: ".utf8_decode($row['email']))
,array('name'=>"Variedad: ".utf8_decode($row['variedad']),'type'=>" ")
);
$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
	  ,'width'=>500,'fontSize' => 12,'showLines'=>0));

$pdf->ezText("\n",12); 
$data = array(
array('name'=>'1.Superficie sembrado temporada anterior:','type'=>$row['superficiesiembra'])
,array('name'=>utf8_decode("2.Intención de siembra(superficie):"),'type'=>$row['intencionsiembra'])
,array('name'=>'3.Rendiemiento temporada anterior: ','type'=>$row['rendimiento'])
,array('name'=>'4.Hibrido(s) usado temporada pasada: ','type'=>$row['hibridoscuri'])
,array('name'=>'5.Hibrido(s) usado temporada pasada otras empresas: ','type'=>$row['hibridosotros'])
,array('name'=>utf8_decode("6.Hectáreas Riego:"),'type'=>$row['riego'])
,array('name'=>utf8_decode("7.Hectáreas Secano:"),'type'=>$row['secano'])
);
$pdf->ezTable($data,array('name'=>'<i>Alias</i>','type'=>'Type'),'',array('showHeadings'=>0,'shaded'=>0
	  ,'width'=>350,'fontSize' => 12,'showLines'=>0));

$pdf->ezText("\nComentarios:".utf8_decode($row['comentario']),12,array('left'=>30)); 


ob_end_clean();
$pdf->ezStream();

?>