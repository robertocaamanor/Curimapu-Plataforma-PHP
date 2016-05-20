<?php
    include 'src/functions/dbfunctions.php';
    require_once 'src/PHPExcel.php';
    $conexion = ConnectDB(); 
    $objXLS = new PHPExcel();
    $objSheet = $objXLS->setActiveSheetIndex(0);
    ////////////////////TITULOS///////////////////////////
    $objSheet->setCellValue('A1', 'Fecha');
    $objSheet->setCellValue('B1', 'Superficie Siembra');
    $objSheet->setCellValue('C1', 'Intencion siembra');
    $objSheet->setCellValue('D1', 'Rendimiento');
    $objSheet->setCellValue('E1', 'Hibridos Usados');
    $objSheet->setCellValue('F1', 'Otros hibridos');
    $objSheet->setCellValue('G1', 'Riego');
    $objSheet->setCellValue('H1', 'Secano');
    $objSheet->setCellValue('I1', 'Comentario');
    $objSheet->setCellValue('J1', 'Agricultor');
    $objSheet->setCellValue('K1', 'Razon');
    $objSheet->setCellValue('L1', 'Email');
    $objSheet->setCellValue('M1', 'Fono');
    $objSheet->setCellValue('N1', 'Ubicacion');

        $numero=1;
        $can=mssql_query("select  fv.FormularioVenta_fecha as fecha, 
            fv.FormularioVenta_Supsiembre as superficiesiembra,
            fv.FormularioVenta_intSiembraCuri as intencionsiembra, 
            fv.FormularioVenta_RendTemp as rendimiento,
            fv.FormularioVenta_hibridosCuri as hibridoscuri, 
            fv.FormularioVenta_hibridosOtros as hibridosotros,
            fv.FormularioVenta_hecRiego as riego, 
            fv.FormularioVenta_hecSecano as secano, 
            fv.FormularioVenta_obsv as comentario, 
            a.Agricultor_nombre as agricultor,
            a.Agricultor_nomFantasi as razon,
            a.email as email, 
            a.Telefono as fono, 
            a.ubicacion as ubicacion 
            from FormularioVenta as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            order by fv.FormularioVenta_fecha desc", $conexion);
        while($dato=mssql_fetch_array($can)){
            $numero++;
            $objSheet->setCellValue('A'.$numero, date_format(new DateTime($dato['fecha']), 'd-m-y'));
            $objSheet->setCellValue('B'.$numero, $dato['superficiesiembra']);
            $objSheet->setCellValue('C'.$numero, $dato['intencionsiembra']);
            $objSheet->setCellValue('D'.$numero, $dato['rendimiento']);
            $objSheet->setCellValue('E'.$numero, $dato['hibridoscuri']);
            $objSheet->setCellValue('F'.$numero, $dato['hibridosotros']);
            $objSheet->setCellValue('G'.$numero, $dato['riego']);
            $objSheet->setCellValue('H'.$numero, $dato['secano']);
            $objSheet->setCellValue('I'.$numero, $dato['comentario']);
            $objSheet->setCellValue('J'.$numero, $dato['agricultor']);
            $objSheet->setCellValue('K'.$numero, $dato['razon']);
            $objSheet->setCellValue('L'.$numero, $dato['email']);
            $objSheet->setCellValue('M'.$numero, $dato['fono']);
            $objSheet->setCellValue('N'.$numero, $dato['ubicacion']);
        }
        
    $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objXLS->getActiveSheet()->setTitle('VENTAS');
    $objXLS->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="listadoventas.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
    $objWriter->save('php://output');
?>