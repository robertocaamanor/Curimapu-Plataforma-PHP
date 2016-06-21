<?php
    include 'src/functions/dbfunctions.php';
    require_once 'src/PHPExcel.php';
    $conexion = ConnectDB(); 
    $objXLS = new PHPExcel();
    $objSheet = $objXLS->setActiveSheetIndex(0);
    ////////////////////TITULOS///////////////////////////
    $objSheet->setCellValue('A1', 'Fecha');
    $objSheet->setCellValue('B1', 'Nombre Agricultor');
    $objSheet->setCellValue('C1', 'Especie');
    $objSheet->setCellValue('D1', 'Variedad');
    $objSheet->setCellValue('E1', 'Contacto');
    $objSheet->setCellValue('F1', 'Comuna');
    $objSheet->setCellValue('G1', 'Telefono');
    $objSheet->setCellValue('H1', 'E-mail');
    $objSheet->setCellValue('I1', 'Estado de Crecimiento');
    $objSheet->setCellValue('J1', 'Enfermedades y Plagas');
    $objSheet->setCellValue('K1', 'Malezas');
    $objSheet->setCellValue('L1', 'Humedad');
    $objSheet->setCellValue('M1', 'Poblacion');
    $objSheet->setCellValue('N1', 'Dosis de Semilla a la Siembra');
    $objSheet->setCellValue('O1', 'Observaciones');
    $objSheet->setCellValue('P1', 'Recomendaciones');

        $numero=1;
        $can=mssql_query("select  fv.FormularioVisita_fecha as fechaVisita,
            fv.FormularioVisita_estCrecimient as estadocrecimiento,
            fv.FormularioVisita_dSemSiebra as dsemillasiembra,
            fv.FormularioVisita_enferPlagas as enfermedades,
            fv.FormularioVisita_estMalezas as malezas,
            fv.FormularioVisita_humdad as humedad,
            fv.FormularioVisita_poblacion as poblacion,
            fv.Observaciones as observaciones,
            fv.FormularioVisita_recomendacion as recomendaciones,
            fv.FormularioVisita_im_GXI as imagen,
            a.Agricultorr_id as agricultorid ,
            a.Agricultorr_nombre as agricultor,
            a.Agricultorr_email as email,
            a.Agricultorr_Telefono as fono,
            a.Agricultorr_Contacto as contacto,
            a.Agricultorr_ubicacion as ubicacion,
            fv.Especies_id as Especie,
            e.Especies_nombre as nombreespecie,
            fv.FormularioVisita_Variedad as variedad
            from FormularioVisita fv inner join Agricultorr as a on fv.Agricultorr_id =  a.Agricultorr_id inner join [gam].[User] as u on a.UserID = u.UserName inner join Especies as e on e.Especies_id = fv.Especies_id",  $conexion);
        while($dato=mssql_fetch_array($can)){
            $numero++;
            $objSheet->setCellValue('A'.$numero, date_format(new DateTime($dato['fechaVisita']), 'd-m-y'));
            $objSheet->setCellValue('B'.$numero, $dato['agricultor']);
            $objSheet->setCellValue('C'.$numero, $dato['nombreespecie']);
            $objSheet->setCellValue('D'.$numero, $dato['variedad']);
            $objSheet->setCellValue('E'.$numero, $dato['contacto']);
            $objSheet->setCellValue('F'.$numero, $dato['ubicacion']);
            $objSheet->setCellValue('G'.$numero, $dato['fono']);
            $objSheet->setCellValue('H'.$numero, $dato['email']);
            $objSheet->setCellValue('I'.$numero, $dato['estadocrecimiento']);
            $objSheet->setCellValue('J'.$numero, $dato['enfermedades']);
            $objSheet->setCellValue('K'.$numero, $dato['malezas']);
            $objSheet->setCellValue('L'.$numero, $dato['humedad']);
            $objSheet->setCellValue('M'.$numero, $dato['poblacion']);
            $objSheet->setCellValue('N'.$numero, $dato['dsemillasiembra']);
            $objSheet->setCellValue('O'.$numero, $dato['observaciones']);
            $objSheet->setCellValue('P'.$numero, $dato['recomendaciones']);
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
    $objXLS->getActiveSheet()->setTitle('VISITAS');
    $objXLS->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="listadovisitas.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
    $objWriter->save('php://output');
?>