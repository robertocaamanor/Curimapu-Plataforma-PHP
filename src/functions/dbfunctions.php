<?php

function connectDB()
{
    $conn=mssql_connect("xcom.ddns.net", "sa", "jYcC5DLt");
    mssql_select_db("semillasr4", $conn);
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

function listarVentas($conn, $inicial, $final)
{
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultorr_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, fv.FormularioVenta_imagem_GXI as imagen
            from FormularioVenta as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVenta_fecha between '".$inicial."' and '".$final."'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarAgricultores($conn)
{
    $sql = "select Agricultorr_id as id, Agricultorr_nombre as Nombre
            from Agricultorr order by Agricultorr_nombre";
    $result = query($conn, $sql);
    return $result;
}

function buscarAgricultor($conn, $nombre){
    $sql = "select Agricultorr_id as id, Agricultorr_nombre as Nombre
            from Agricultorr where Agricultorr_nombre LIKE '%".$nombre."%'";
    $result = query($conn, $sql);
    return $result;
}

function listarVisitas($conn, $fechainicial, $fechafinal){
    $sql = "select fv.FormularioVisita_fecha as fecha, fv.FormularioVisita_id as id , a.Agricultorr_nombre as agricultor, 
            fv.Observaciones as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre, fv.FormularioVisita_im_GXI as imagen
            from FormularioVisita as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVisita_fecha BETWEEN '".$fechainicial."' AND '".$fechafinal."'
            order by fv.FormularioVisita_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function detalleVenta($id, $conn){
    $sql = "select fv.FormularioVenta_fecha as fecha, 
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
            a.Agricultorr_Contacto as contacto,
            a.Agricultorr_Telefono as fono, 
            a.Agricultorr_ubicacion as ubicacion, 
            fv.FormularioVenta_Variedad as variedad,
            fv.Especies_id as Especie,
            e.Especies_nombre as nombreespecie
            from FormularioVenta fv inner join Agricultorr as a on fv.Agricultorr_id =  a.Agricultorr_id inner join [gam].[User] as u on a.UserID = u.UserName inner join Especies as e on e.Especies_id = fv.Especies_id
            where fv.FormularioVenta_id =".$id;
    $result = query($conn, $sql);
    return $result;

}

function detalleAgricultores($id, $conn){
    $sql = "select a.Agricultorr_nombre as nombre,
            a.agricultorr_ubicacion as ubicacion,
            a.agricultorr_Telefono as telefono,
            a.agricultorr_email as email,
            a.agricultorr_Ubicacion as ubicacion,
            a.agricultorr_rut as rut,
            a.agricultorr_contacto as contacto,
            a.UserID as Vendedor
            from agricultorr a inner join [gam].[User] as u on a.UserID = u.UserName
            where a.Agricultorr_id =".$id;
    $result = query($conn, $sql);
    return $result;

}

function detalleVisita($id, $conn){
     $sql = "select  fv.FormularioVisita_fecha as fechaVisita,
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
            from FormularioVisita fv inner join Agricultorr as a on fv.Agricultorr_id =  a.Agricultorr_id inner join [gam].[User] as u on a.UserID = u.UserName inner join Especies as e on e.Especies_id = fv.Especies_id
            where fv.FormularioVisita_id ='" . $id . "'";
    $result = query($conn, $sql);
    return $result;
}

function listarventasfecha($conn, $inicial, $final){
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultorr_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVenta as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVenta_fecha between '".$inicial."' and '".$final."'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvisitasfecha($conn, $inicial, $final){
    $sql = "select fv.FormularioVisita_fecha as fecha, fv.FormularioVisita_id as id , a.Agricultorr_nombre as agricultor, 
            fv.Observaciones as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVisita as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVisita_Fecha between '".$inicial."' and '".$final."'
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarventasagricultor($conn, $nombre){
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultorr_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVenta as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where a.Agricultorr_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarvisitasagricultor($conn, $nombre){
    $sql = "select fv.FormularioVisita_fecha as fecha, fv.FormularioVisita_id as id , a.Agricultorr_nombre as agricultor, 
            fv.Observaciones as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVisita as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where a.Agricultorr_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVisita_Fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarventasagricultormixto($conn, $inicial, $final, $nombre){
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultorr_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVenta as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVenta_fecha between '".$inicial."' and '".$final."' AND a.Agricultorr_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}
function listarvisitasagricultormixto($conn, $inicial, $final, $nombre){
    $sql = "select fv.FormularioVisita_fecha as fecha, fv.FormularioVisita_id as id , a.Agricultorr_nombre as agricultor, 
            fv.Observaciones as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVisita as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVisita_fecha between '".$inicial."' and '".$final."' AND a.Agricultorr_nombre LIKE '%".$nombre."%'
            order by fv.FormularioVisita_fecha desc";
    $result = query($conn, $sql);
    return $result;
}

function listarventasvendedormixto($conn, $inicial, $final, $nombre){
    $sql = "select fv.FormularioVenta_fecha as fecha, fv.FormularioVenta_id as id , a.Agricultorr_nombre as agricultor, 
            fv.FormularioVenta_obsv as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVenta as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVenta_fecha between '".$inicial."' and '".$final."' AND u.UserNameSpace LIKE '%".$nombre."%'
            order by fv.FormularioVenta_fecha desc";
    $result = query($conn, $sql);
    return $result;
}
function listarvisitasvendedormixto($conn, $inicial, $final, $nombre){
    $sql = "select fv.FormularioVisita_fecha as fecha, fv.FormularioVisita_id as id , a.Agricultorr_nombre as agricultor, 
            fv.Observaciones as observacion, a.Agricultorr_ubicacion as Ubicacion,
            e.Especies_nombre as nombreespecie, u.UserFirstName as PrimerNombre, u.UserLastName as SegundoNombre
            from FormularioVisita as fv inner join Agricultorr as a on fv.Agricultorr_id = a.Agricultorr_id inner join Especies as e on e.Especies_id = fv.Especies_id inner join [gam].[User] as u on a.UserID = u.UserName
            where fv.FormularioVisita_fecha between '".$inicial."' and '".$final."' AND u.UserNameSpace LIKE '%".$nombre."%'
            order by fv.FormularioVisita_fecha desc";
    $result = query($conn, $sql);
    return $result;
}


?>