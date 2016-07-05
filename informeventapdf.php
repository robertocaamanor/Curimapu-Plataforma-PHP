<?php

include 'src/php2pdf/class.ezpdf.php';
include('src/php2pdf/class.backgroundpdf.php');
include 'src/functions/dbfunctions.php';

$id = $_GET['id'];
$conn = connectDB();
$result = detalleventa($id,$conn);
$row = mssql_fetch_array($result);

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
$pdf->ezStream();

?>