<?php
    include 'src/functions/dbfunctions.php';
    require_once 'src/PHPExcel.php';
    $conexion = ConnectDB(); 
    $objXLS = new PHPExcel();
    $objSheet = $objXLS->setActiveSheetIndex(0);
    ////////////////////TITULOS///////////////////////////
    $objSheet->setCellValue('A1', 'Nombre Agricultor');
    $objSheet->setCellValue('B1', 'Variedad');
    $objSheet->setCellValue('C1', 'Fecha');
    $objSheet->setCellValue('D1', 'Fungosas');
    $objSheet->setCellValue('E1', 'Malezas');
    $objSheet->setCellValue('F1', 'Bacteria');
    $objSheet->setCellValue('G1', 'Crecimiento');
    $objSheet->setCellValue('H1', 'Poblacion');
    $objSheet->setCellValue('I1', 'Insectos');
    $objSheet->setCellValue('J1', 'Siembra');
    $objSheet->setCellValue('K1', 'Recomendacion');

        $numero=1;
        $can=mssql_query("select a.Agricultor_nombre, v.Variedad_nombre, fv.FormularioVisita_Fecha, fv.FormularioVisita_enferBacteria, fv.FormularioVisita_enfFungosas, fv.FormularioVisita_estMalezas, fv.FormularioVisita_estCrecimient, fv.FormularioVisita_poblacion, fv.FormularioVisita_insectos, fv.FormularioVisita_dSemSiebra, fv.FormularioVisita_recomendacion  FROM FormularioVisita fv, Agricultor a, Variedad v WHERE fv.Agricultor_id = a.Agricultor_id AND fv.Variedad_id = v.Variedad_id",  $conexion);
        while($dato=mssql_fetch_array($can)){
            $numero++;
            $objSheet->setCellValue('A'.$numero, $dato['Agricultor_nombre']);
            $objSheet->setCellValue('B'.$numero, $dato['Variedad_nombre']);
            $objSheet->setCellValue('C'.$numero, date_format(new DateTime($dato['FormularioVisita_Fecha']), 'd-m-y'));
            $objSheet->setCellValue('D'.$numero, $dato['FormularioVisita_enferBacteria']);
            $objSheet->setCellValue('E'.$numero, $dato['FormularioVisita_enfFungosas']);
            $objSheet->setCellValue('F'.$numero, $dato['FormularioVisita_estMalezas']);
            $objSheet->setCellValue('G'.$numero, $dato['FormularioVisita_estCrecimient']);
            $objSheet->setCellValue('H'.$numero, $dato['FormularioVisita_poblacion']);
            $objSheet->setCellValue('I'.$numero, $dato['FormularioVisita_insectos']);
            $objSheet->setCellValue('J'.$numero, $dato['FormularioVisita_dSemSiebra']);
            $objSheet->setCellValue('K'.$numero, $dato['FormularioVisita_recomendacion']);
        }
        
    $objXLS->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
    $objXLS->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
    $objXLS->getActiveSheet()->setTitle('VISITAS');
    $objXLS->setActiveSheetIndex(0);
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="listadovisitas.xls"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objXLS, 'Excel5');
    $objWriter->save('php://output');
?>