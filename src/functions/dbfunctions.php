<?php

function connectDB()
{
    $conn=mssql_connect("xcom.ddns.net", "sa", "jYcC5DLt");
    mssql_select_db("SemillasR3", $conn);
    return $conn;
}

function query($conn , $query)
{
    $result = mssql_query($query, $conn);
    return $result;
}

function countRows($query)
{
    $q = mssql_num_rows($query);
    return $q;
}

function parse($query)
{
    $result = mssql_fetch_array($query);
    return $result;
}

function cerrar($conn)
{
    mssql_close($conn);  
}

function listarVentas($conn)
{
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultor_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, fv.FormularioVenta_usuario as usuario
            from FormularioVenta as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            order by fv.FormularioVenta_fecha desc ";
    $result = query($conn, $sql);
    return $result;
}

function listarVisitas($conn){
    $sql = "select fv.FormularioVisita_id as id, fv.FormularioVisita_Fecha as fecha, a.Agricultor_nombre as agricultor, 
            fv.FormularioVisita_usuario as usuario, fv.Observaciones as observacion
            from FormularioVisita as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function detalleVenta($id, $conn){
    $sql = "select  fv.FormularioVenta_fecha as fecha, 
            fv.FormularioVenta_Supsiembre as superficiesiembra,
            fv.FormularioVenta_intSiembra as intencionsiembra,
            fv.FormularioVenta_intSiembraCuri as intencionsiembraanterior, 
            fv.FormularioVenta_RendTemp as rendimiento,
            fv.FormularioVenta_hibridosCuri as hibridoscuri, 
            fv.FormularioVenta_hibridosOtros as hibridosotros,
            fv.FormularioVenta_hecRiego as riego, 
            fv.FormularioVenta_hecSecano as secano, 
            fv.FormularioVenta_obsv as comentario, 
            fv.FormularioVenta_im as imagen,
            a.Agricultor_nombre as agricultor,
            a.Agricultor_nomFantasi as razon,
            a.email as email, 
            a.Telefono as fono, 
            a.ubicacion as ubicacion, 
            v.Variedad_nombre as variedad
            from FormularioVenta fv inner join Agricultor a on fv.Agricultor_id =  a.Agricultor_id 
            inner join Variedad  v on fv.Variedad_id = v.Variedad_id
            where fv.FormularioVenta_id =".$id;
    $result = query($conn, $sql);
    return $result;

}

function detalleVisita($id, $conn){
     $sql = "select  fv.FormularioVisita_fecha as fechaVisita,
            fv.FormularioVisita_estCrecimient as estadocrecimiento,
            fv.FormularioVisita_dSemSiebra as densidad,
            fv.FormularioVisita_enferBacteria as bacteriales,
            fv.FormularioVisita_enfFungosas as fungosas,
            fv.FormularioVisita_estMalezas as malezas,
            fv.FormularioVisita_insectos as insectos,
            fv.FormularioVisita_humdad as humedad,
            fv.Observaciones as observaciones,
            fv.FormularioVisita_recomendacion as recomendaciones,
            fv.FormularioVisita_im as imagen,
            a.Agricultor_id as agricultorid ,
            a.Agricultor_nombre as agricultor,
            a.Agricultor_nomFantasi as razon,
            a.email as email,
            a.Telefono as fono,
            a.ubicacion as ubicacion,
            v.Variedad_nombre as variedad,
            v.variedad_id
            from FormularioVisita fv inner join Agricultor a on fv.Agricultor_id =  a.Agricultor_id
            inner join Variedad  v on fv.Variedad_id = v.Variedad_id
            where fv.FormularioVisita_id ='" . $id . "'";
    $result = query($conn, $sql);
    return $result;
}

function listarventasfecha($conn, $inicial, $final){
    $sql = "select fv.FormularioVenta_fecha as fecha, 
            fv.FormularioVenta_id as id , 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, 
            fv.FormularioVenta_usuario as usuario
            from FormularioVenta as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where fv.FormularioVenta_fecha between '".$inicial."' and '".$final."'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvisitasfecha($conn, $inicial, $final){
    $sql = "select fv.FormularioVisita_id as id, 
            fv.FormularioVisita_Fecha as fecha, 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVisita_usuario as usuario, 
            fv.Observaciones as observacion
            from FormularioVisita as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where fv.FormularioVisita_Fecha between '".$inicial."' and '".$final."'
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarventasagricultor($conn, $nombre){
    $sql = "select fv.FormularioVenta_fecha as fecha, 
            fv.FormularioVenta_id as id , 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, 
            fv.FormularioVenta_usuario as usuario
            from FormularioVenta as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where a.Agricultor_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvisitasagricultor($conn, $nombre){
    $sql = "select fv.FormularioVisita_id as id, 
            fv.FormularioVisita_Fecha as fecha, 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVisita_usuario as usuario, 
            fv.Observaciones as observacion
            from FormularioVisita as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where a.Agricultor_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarventasvendedor($conn, $nombre){
    $sql = "select fv.FormularioVenta_fecha as fecha, 
            fv.FormularioVenta_id as id , 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, 
            fv.FormularioVenta_usuario as usuario
            from FormularioVenta as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where fv.FormularioVenta_usuario LIKE '%".$nombre."%'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvisitasvendedor($conn, $nombre){
    $sql = "select fv.FormularioVisita_id as id, 
            fv.FormularioVisita_Fecha as fecha, 
            a.Agricultor_nombre as agricultor, 
            fv.FormularioVisita_usuario as usuario, 
            fv.Observaciones as observacion
            from FormularioVisita as fv inner join Agricultor as a on fv.Agricultor_id = a.Agricultor_id
            where fv.FormularioVisita_usuario LIKE '%".$nombre."%'
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}


?>