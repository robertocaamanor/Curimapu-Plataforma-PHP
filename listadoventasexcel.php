<?php
    include 'src/functions/dbfunctions.php';
    require_once 'src/PHPExcel.php';
    $conexion = ConnectDB(); 
    $objXLS = new PHPExcel();
    $objSheet = $objXLS->setActiveSheetIndex(0);
    ////////////////////TITULOS///////////////////////////
    $objSheet->setCellValue('A1', 'Fecha');
    $objSheet->setCellValue('B1', 'Agricultor');
    $objSheet->setCellValue('C1', 'Especie');
    $objSheet->setCellValue('D1', 'Variedad');
    $objSheet->setCellValue('E1', 'Contacto');
    $objSheet->setCellValue('F1', 'Comuna');
    $objSheet->setCellValue('G1', 'Teléfono');
    $objSheet->setCellValue('H1', 'E-mail' );
    $objSheet->setCellValue('I1', 'Superficie Sembrado Temporada Anterior');
    $objSheet->setCellValue('J1', 'Intención de siembra total');
    $objSheet->setCellValue('K1', 'Intención de siembra Curimapu');
    $objSheet->setCellValue('L1', 'Rendimiento Temporada Anterior');
    $objSheet->setCellValue('M1', 'Híbridos temporada anterior');
    $objSheet->setCellValue('N1', 'Híbridos externos temporada anterior');
    $objSheet->setCellValue('O1', 'Hectareas Riego');
    $objSheet->setCellValue('P1', 'Hectareas Secano');
    $objSheet->setCellValue('Q1', 'Observaciones');
    $objSheet->setCellValue('R1', 'Recomendaciones');

        $numero=1;
        $can=mssql_query("select fv.FormularioVentafecha as fecha, 
            fv.FormularioVenta_Supsiembre as superficiesiembra,
            fv.FormularioVenta_intSiembraTota as intencionsiembra,
            fv.FormularioVenta_intSiembraCuri as intencionsiembraanterior, 
            fv.FormularioVenta_RendTemp as rendimiento,
            fv.FormularioVenta_hibridosCuri as hibridoscuri, 
            fv.FormularioVenta_hibridosOtros as hibridosotros,
            fv.FormularioVenta_hecRiego as riego, 
            fv.FormularioVenta_hecSecano as secano, 
            fv.FormularioVenta_obsv as comentario, 
            fv.FormularioVenta_recomendacione as recomendaciones, 
            fv.FormularioVenta_imagem_GXI as imagen,
            a.Agricultorr_nombre as agricultor,
            a.Agricultorr_email as email, 
            a.Agricultorr_Telefono as fono, 
            a.Agricultorr_ubicacion as ubicacion, 
            a.Agricultorr_Contacto as contacto,
            fv.FormularioVentaVariedad as variedad,
            fv.Esppecieid as Especie,
            e.Esppecienombre as nombreespecie
            from FormularioVenta fv inner join Agricultorr as a on fv.Agricultorr_id =  a.Agricultorr_id inner join [gam].[User] as u on a.UserID = u.UserName inner join Esppecie as e on e.Esppecieid = fv.Esppecieid
            order by fv.FormularioVentafecha desc", $conexion);
        while($dato=mssql_fetch_array($can)){
            $numero++;
            $objSheet->setCellValue('A'.$numero, date_format(new DateTime($dato['fecha']), 'd-m-y') );
            $objSheet->setCellValue('B'.$numero, $dato['agricultor']);
            $objSheet->setCellValue('C'.$numero, $dato['nombreespecie']);
            $objSheet->setCellValue('D'.$numero, $dato['variedad']);
            $objSheet->setCellValue('E'.$numero, $dato['contacto']);
            $objSheet->setCellValue('F'.$numero, $dato['ubicacion']);
            $objSheet->setCellValue('G'.$numero, $dato['fono']);
            $objSheet->setCellValue('H'.$numero, $dato['email']);
            $objSheet->setCellValue('I'.$numero, $dato['superficiesiembra']);
            $objSheet->setCellValue('J'.$numero, $dato['intencionsiembra']);
            $objSheet->setCellValue('K'.$numero, $dato['intencionsiembraanterior']);
            $objSheet->setCellValue('L'.$numero, $dato['rendimiento']);
            $objSheet->setCellValue('M'.$numero, $dato['hibridoscuri']);
            $objSheet->setCellValue('N'.$numero, $dato['hibridosotros']);
            $objSheet->setCellValue('O'.$numero, $dato['riego']);
            $objSheet->setCellValue('P'.$numero, $dato['secano']);
            $objSheet->setCellValue('Q'.$numero, $dato['comentario']);
            $objSheet->setCellValue('R'.$numero, $dato['recomendaciones']);
        }
        
    $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
    $objXLS->getActiveSheet()->setTitle('VENTAS');
    $objXLS->getActiveSheet()->getStyle('A1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objXLS->getActiveSheet()->getStyle('A1:R1')->getFill()->getStartColor()->setARGB('FCFF33');
    // Add some data
    $objXLS->getActiveSheet()->getStyle("A1:R1")->getFont()->setBold(true);
    $objXLS->getActiveSheet()->getStyle('A1:R1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objXLS->setActiveSheetIndex(0);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="listadoventas.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
    $objWriter->save('php://output');
?>