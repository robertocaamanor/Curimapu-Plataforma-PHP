<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/5/2016
 * Time: 09:26
 */
include('src/functions/dbfunctions.php');

class Marker
{
    private $fecha;
    private $fechavisita;
    private $vendedornombre;
    private $vendedorapellido;
    private $vendedorvisitanombre;
    private $vendedorvisitaapellido;
    private $ubicacion;
    private $ubicacionvisita;
    private $especie;
    private $especievisita;
    private $lat;
    private $lng;
    private $latvisita;
    private $lngvisita;
    private $id;
    private $idvisita;
    private $agricultor;
    private $agricultorvisita;
    private $idagricultor;
    private $idagricultorvisita;
    private $idvendedor;
    private $fechainicial;
    private $fechafinal;
    private $fechainicialvisita;
    private $fechafinalvisita;
    private $buscarvendedor;
    private $buscaragricultor;
    private $buscarvendedorvisita;
    private $buscaragricultorvisita;
    private $posicion;

    /**
     * Marker constructor.
     */
    public function __construct()
    {
    }


    /**
     * @return array
     */
    public static function listMarkers()
    {
        $markerList = array();
        try {
            $sql = ("select FormularioVentafecha as Fecha,
                    FormularioVentaid as Id,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultorr on FormularioVenta.Agricultorr_id = Agricultorr.Agricultorr_id");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setUbicacion($row['Ubicacion']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function listVisitaMarkers()
    {
        $markerList = array();
        try {
            $sql = ("select FormularioVisitaFecha as Fecha,
                    FormularioVisitaid as Id,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVisita.FormularioVisita_posicion as latlng
                    from FormularioVisita
                    left join Agricultorr on FormularioVisita.Agricultorr_id = Agricultorr.Agricultorr_id");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFechavisita($date);
                $marker->setIdvisita($row['Id']);
                $marker->setUbicacionvisita($row['Ubicacion']);
                $marker->setLatvisita(trim($locations[0]));
                $marker->setLngvisita(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function searchMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        try {
            $sql = ("select FormularioVentafecha as Fecha,
                    FormularioVentaid as Id,
                    Agricultorr.Agricultorr_nombre as NombreAgricultor,
                    Agricultorr.Agricultorr_id as IdAgricultor,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    u.UserFirstName as PrimerNombre,
                    u.UserLastName as SegundoNombre,
                    e.Esppecienombre as Especies,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultorr on FormularioVenta.Agricultorr_id = Agricultorr.Agricultorr_id
                    left join [gam].[User] as u on u.UserName = Agricultorr.UserID
                    left join Esppecie as e on e.Esppecieid = FormularioVenta.Esppecieid
                    where FormularioVentaid = '$id'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setIdagricultor($row['IdAgricultor']);
                $marker->setUbicacion($row['Ubicacion']);
                $marker->setEspecie($row['Especies']);
                $marker->setAgricultor($row['NombreAgricultor']);
                $marker->setVendedornombre($row['PrimerNombre']);
                $marker->setVendedorapellido($row['SegundoNombre']);
                $marker->setPosicion($row['latlng']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function searchVisitaMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        try {
            $sql = ("select FormularioVisitaFecha as Fecha,
                    FormularioVisitaid as Id,
                    Agricultorr.Agricultorr_nombre as Agricultorvisita,
                    FormularioVisita.Agricultorr_id as IdAgricultorvisita,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    e.Esppecienombre as Especie,
                    u.UserFirstName as PrimerNombre,
                    u.UserLastName as SegundoNombre,
                    FormularioVisita.FormularioVisita_posicion as latlng
                    from FormularioVisita
                    left join Agricultorr on FormularioVisita.Agricultorr_id = Agricultorr.Agricultorr_id
                    left join [gam].[User] as u on u.UserName = Agricultorr.UserID
                    left join Esppecie as e on e.Esppecieid = FormularioVisita.Esppecieid
                    where FormularioVisitaid = '$id'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $datevisita = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFechavisita($datevisita);
                $marker->setIdvisita($row['Id']);
                $marker->setEspecieVisita($row['Especie']);
                $marker->setIdagricultorvisita($row['IdAgricultorvisita']);
                $marker->setUbicacionvisita($row['Ubicacion']);
                $marker->setVendedorvisitanombre($row['PrimerNombre']);
                $marker->setVendedorvisitaapellido($row['SegundoNombre']);
                $marker->setAgricultorvisita($row['Agricultorvisita']);
                $marker->setLatvisita(trim($locations[0]));
                $marker->setLngvisita(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function agroMarkers()
    {
        $markerList = array();
        $idagricultor = $_GET['id'];
        try {
            $sql = ("select FormularioVenta.FormularioVentafecha as Fecha,
                    FormularioVenta.FormularioVentaid as Id,
                    Agricultorr.Agricultorr_nombre as NombreAgricultor,
                    FormularioVenta.Agricultorr_id as IdAgricultor,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultorr on FormularioVenta.Agricultorr_id = Agricultorr.Agricultorr_id
                    where FormularioVenta.Agricultor_id = '$idagricultor'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setUbicacion($row['Ubicacion']);
                $marker->setIdagricultor($row['IdAgricultor']);
                $marker->setAgricultor($row['NombreAgricultor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function agroVisitaMarkers()
    {
        $markerList = array();
        $idagricultor = $_GET['id'];
        try {
            $sql = ("select FormularioVisitaFecha as Fecha,
                    FormularioVisitaid as Id,
                    Agricultorr.Agricultorr_nombre as AgricultorNombre,
                    FormularioVisita.Agricultorr_id as IdAgricultor,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVisita.FormularioVisita_posicion as latlng
                    from FormularioVisita
                    left join Agricultorr on FormularioVisita.Agricultorr_id = Agricultorr.Agricultorr_id
                    where FormularioVisita.Agricultorr_id = '$idagricultor'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFechavisita($date);
                $marker->setIdvisita($row['Id']);
                $marker->setUbicacionvisita($row['Ubicacion']);
                $marker->setIdagricultorvisita($row['IdAgricultor']);
                $marker->setAgricultorvisita($row['AgricultorNombre']);
                $marker->setLatvisita(trim($locations[0]));
                $marker->setLngvisita(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function fechaMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        $inicio = $_POST['inicio'];
        $final = $_POST['final'];
        $nombrevendedor = $_POST['busquedavendedor'];
        try {
            $sql = ("select FormularioVenta.FormularioVentafecha as Fecha,
                    FormularioVenta.FormularioVentaid as IdVenta,
                    Agricultorr.Agricultorr_nombre as NombreAgricultor,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultorr on FormularioVenta.Agricultorr_id = Agricultorr.Agricultorr_id
                    left join [gam].[User] as u on u.UserName = Agricultorr.UserID
                    where FormularioVenta.FormularioVentafecha BETWEEN '".$inicio."' AND '".$final."' AND u.UserID LIKE '%".$nombrevendedor."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $fechainicial = date_format(new DateTime($inicio), "Y-m-d");
                $fechafinal = date_format(new DateTime($final), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setFechainicial($fechainicial);
                $marker->setFechafinal($fechafinal);
                $marker->setbuscarVendedor($nombrevendedor);
                $marker->setbuscarAgricultor($nombreagricultor);
                $marker->setId($row['IdVenta']);
                $marker->setUbicacion($row['Ubicacion']);
                $marker->setAgricultor($row['NombreAgricultor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function fechaAgricultorMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        $inicio = $_POST['inicio'];
        $final = $_POST['final'];
        $nombreagricultor = $_POST['busquedaagricultor'];
        try {
            $sql = ("select FormularioVenta.FormularioVentafecha as Fecha,
                    FormularioVenta.FormularioVentaid as IdVenta,
                    Agricultorr.Agricultorr_nombre as NombreAgricultor,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultorr on FormularioVenta.Agricultorr_id = Agricultorr.Agricultorr_id
                    where FormularioVenta.FormularioVentafecha BETWEEN '".$inicio."' AND '".$final."' AND Agricultorr.Agricultorr_nombre LIKE '%".$nombreagricultor."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $fechainicial = date_format(new DateTime($inicio), "Y-m-d");
                $fechafinal = date_format(new DateTime($final), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setFechainicial($fechainicial);
                $marker->setFechafinal($fechafinal);
                $marker->setbuscarAgricultor($nombreagricultor);
                $marker->setId($row['IdVenta']);
                $marker->setUbicacion($row['Ubicacion']);
                $marker->setAgricultor($row['NombreAgricultor']);
                $marker->setLat(trim($locations[0]));
                $marker->setLng(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function fechaVisitaMarkers()
    {
        $markerList = array();
        $idvisita = $_GET['id'];
        $iniciovisita = $_POST['inicio'];
        $finalvisita = $_POST['final'];
        $nombrevendedorvisita = $_POST['busquedavendedor'];
        try {
            $sql = ("select FormularioVisita.FormularioVisitaFecha as Fecha,
                    FormularioVisita.FormularioVisitaid as Id,
                    Agricultorr.Agricultorr_nombre as AgricultorNombre,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVisita.FormularioVisita_posicion as latlng
                    from FormularioVisita
                    left join Agricultorr on FormularioVisita.Agricultorr_id = Agricultorr.Agricultorr_id
                    left join [gam].[User] as u on u.UserName = Agricultorr.UserID
                    where FormularioVisitaFecha BETWEEN '".$iniciovisita."' AND '".$finalvisita."' AND u.UserID LIKE '%".$nombrevendedorvisita."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $datevisita = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $fechainicialvisita = date_format(new DateTime($iniciovisita), "Y-m-d");
                $fechafinalvisita = date_format(new DateTime($finalvisita), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFechavisita($datevisita);
                $marker->setFechainicialvisita($fechainicialvisita);
                $marker->setFechafinalvisita($fechafinalvisita);
                $marker->setbuscarVendedorvisita($nombrevendedorvisita);
                $marker->setIdvisita($row['Id']);
                $marker->setUbicacionvisita($row['Ubicacion']);
                $marker->setAgricultorvisita($row['AgricultorNombre']);
                $marker->setLatvisita(trim($locations[0]));
                $marker->setLngvisita(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }

    public static function fechaVisitaAgricultorMarkers()
    {
        $markerList = array();
        $idvisita = $_GET['id'];
        $iniciovisita = $_POST['inicio'];
        $finalvisita = $_POST['final'];
        $nombreagricultorvisita = $_POST['busquedaagricultor'];
        try {
            $sql = ("select FormularioVisitaFecha as Fecha,
                    FormularioVisitaId as Id,
                    Agricultorr.Agricultorr_nombre as AgricultorNombre,
                    Agricultorr.Agricultorr_ubicacion as Ubicacion,
                    FormularioVisita.FormularioVisita_posicion as latlng
                    from FormularioVisita
                    left join Agricultorr on FormularioVisita.Agricultorr_id = Agricultorr.Agricultorr_id
                    where FormularioVisitaFecha BETWEEN '".$iniciovisita."' AND '".$finalvisita."' AND Agricultorr.Agricultorr_nombre LIKE '%".$nombreagricultorvisita."%'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $datevisita = date_format(new DateTime($row['Fecha']), "Y-m-d");
                $fechainicialvisita = date_format(new DateTime($iniciovisita), "Y-m-d");
                $fechafinalvisita = date_format(new DateTime($finalvisita), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFechavisita($datevisita);
                $marker->setFechainicialvisita($fechainicialvisita);
                $marker->setFechafinalvisita($fechafinalvisita);
                $marker->setbuscarAgricultorvisita($nombreagricultorvisita);
                $marker->setIdvisita($row['Id']);
                $marker->setUbicacionvisita($row['Ubicacion']);
                $marker->setAgricultorvisita($row['AgricultorNombre']);
                $marker->setLatvisita(trim($locations[0]));
                $marker->setLngvisita(trim($locations[1]));
                array_push($markerList, $marker);
            }

            return ($markerList);
        } catch (Exception $e) {
            die(print_r(json_encode(), true));
        }
    }




    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdvisita()
    {
        return $this->idvisita;
    }

    public function setIdvisita($idvisita)
    {
        $this->idvisita = $idvisita;
    }

    public function getIdagricultor()
    {
        return $this->idagricultor;
    }

    public function setIdagricultor($idagricultor)
    {
        $this->idagricultor = $idagricultor;
    }

    public function getIdagricultorvisita()
    {
        return $this->idagricultorvisita;
    }

    public function setIdagricultorvisita($idagricultorvisita)
    {
        $this->idagricultorvisita = $idagricultorvisita;
    }

    public function getIdvendedor()
    {
        return $this->idvendedor;
    }

    public function setIdvendedor($idvendedor)
    {
        $this->idvendedor = $idvendedor;
    }

    public function getFechainicial()
    {
        return $this->fechainicial;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechainicial($fechainicial)
    {
        $this->fechainicial = $fechainicial;
    }

    public function getFechafinal()
    {
        return $this->fechafinal;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechafinal($fechafinal)
    {
        $this->fechafinal = $fechafinal;
    }

    public function getFechainicialvisita()
    {
        return $this->fechainicialvisita;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechainicialvisita($fechainicialvisita)
    {
        $this->fechainicialvisita = $fechainicialvisita;
    }

    public function getFechafinalvisita()
    {
        return $this->fechafinalvisita;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechafinalvisita($fechafinalvisita)
    {
        $this->fechafinalvisita = $fechafinalvisita;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getFechavisita()
    {
        return $this->fechavisita;
    }

    /**
     * @param mixed $fecha
     */
    public function setFechavisita($fechavisita)
    {
        $this->fechavisita = $fechavisita;
    }

    /**
     * @return mixed
     */
    public function getVendedornombre()
    {
        return $this->vendedornombre;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedornombre($vendedornombre)
    {
        $this->vendedornombre = $vendedornombre;
    }

    public function getVendedorapellido()
    {
        return $this->vendedorapellido;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedorapellido($vendedorapellido)
    {
        $this->vendedorapellido = $vendedorapellido;
    }

    public function getVendedorvisitanombre()
    {
        return $this->vendedorvisitanombre;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedorvisitanombre($vendedorvisitanombre)
    {
        $this->vendedorvisitanombre = $vendedorvisitanombre;
    }

    public function getVendedorvisitaapellido()
    {
        return $this->vendedorvisitaapellido;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedorvisitaapellido($vendedorvisitaapellido)
    {
        $this->vendedorvisitaapellido = $vendedorvisitaapellido;
    }

    public function getbuscarVendedor()
    {
        return $this->buscarvendedor;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarVendedor($buscarvendedor)
    {
        $this->buscarvendedor = $buscarvendedor;
    }

    public function getbuscarVendedorvisita()
    {
        return $this->buscarvendedorvisita;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarVendedorvisita($buscarvendedorvisita)
    {
        $this->buscarvendedorvisita = $buscarvendedorvisita;
    }

    public function getbuscarAgricultor()
    {
        return $this->buscaragricultor;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarAgricultor($buscaragricultor)
    {
        $this->buscaragricultor = $buscaragricultor;
    }

    public function getbuscarAgricultorvisita()
    {
        return $this->buscaragricultorvisita;
    }

    /**
     * @param mixed $vendedor
     */
    public function setbuscarAgricultorvisita($buscaragricultorvisita)
    {
        $this->buscaragricultorvisita = $buscaragricultorvisita;
    }


    /**
     * @return mixed
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;
    }

    public function getUbicacionvisita()
    {
        return $this->ubicacionvisita;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setUbicacionvisita($ubicacionvisita)
    {
        $this->ubicacionvisita = $ubicacionvisita;
    }

    public function getAgricultor()
    {
        return $this->agricultor;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setAgricultor($agricultor)
    {
        $this->agricultor = $agricultor;
    }

    public function getAgricultorvisita()
    {
        return $this->agricultorvisita;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setAgricultorvisita($agricultorvisita)
    {
        $this->agricultorvisita = $agricultorvisita;
    }

    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    public function getEspecieVisita()
    {
        return $this->especievisita;
    }

    /**
     * @param mixed $ubicacion
     */
    public function setEspecieVisita($especievisita)
    {
        $this->especievisita = $especievisita;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    public function getLatvisita()
    {
        return $this->latvisita;
    }

    /**
     * @param mixed $lat
     */
    public function setLatvisita($latvisita)
    {
        $this->latvisita = $latvisita;
    }

    /**
     * @return mixed
     */
    public function getLngvisita()
    {
        return $this->lngvisita;
    }

    /**
     * @param mixed $lng
     */
    public function setLngvisita($lngvisita)
    {
        $this->lngvisita = $lngvisita;
    }

    public function getPosicion()
    {
        return $this->posicion;
    }

    /**
     * @param mixed $lng
     */
    public function setPosicion($posicion)
    {
        $this->posicion = $posicion;
    }


}