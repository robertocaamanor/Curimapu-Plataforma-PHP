<?php

/**
 * Created by PhpStorm.
 * User: matias
 * Date: 11/5/2016
 * Time: 09:26
 */
include($_SERVER['DOCUMENT_ROOT'] . '/curimapuweb/src/functions/dbfunctions.php');

class Marker
{
    private $fecha;
    private $vendedor;
    private $ubicacion;
    private $lat;
    private $lng;
    private $id;

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
            $sql = ("select FormularioVenta_fecha as Fecha,
                    FormularioVenta_id as Id,
                    Vendedor_nombre as Vendedor,
                    ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultor on FormularioVenta.Agricultor_id = Agricultor.Agricultor_id
                    left join Vendedor on Vendedor_id=FormularioVenta.FormularioVenta_usuario");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setVendedor($row['Vendedor']);
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

    public static function searchMarkers()
    {
        $markerList = array();
        $id = $_GET['id'];
        try {
            $sql = ("select FormularioVenta_fecha as Fecha,
                    FormularioVenta_id as Id,
                    Vendedor_nombre as Vendedor,
                    ubicacion as Ubicacion,
                    FormularioVenta.FormularioVenta_gps as latlng
                    from FormularioVenta
                    left join Agricultor on FormularioVenta.Agricultor_id = Agricultor.Agricultor_id
                    left join Vendedor on Vendedor_id=FormularioVenta.FormularioVenta_usuario
                    where FormularioVenta_id = '$id'");
            $conn = connectDB();
            $result = query($conn,$sql);

            while ($row = mssql_fetch_array($result)) {
                $marker = new Marker();
                $date = date_format(new DateTime($row['fecha']), "Y-m-d");
                $locations = explode(',', $row['latlng']);
                $marker->setFecha($date);
                $marker->setId($row['Id']);
                $marker->setVendedor($row['Vendedor']);
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

    /**
     * @return mixed
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    /**
     * @param mixed $vendedor
     */
    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;
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


}