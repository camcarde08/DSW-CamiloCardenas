<?php

require_once '../../../model/DbClass.php';
require_once '../../../vendor/autoload.php';
require_once '../../../eloquent/database.php';
require_once '../../../eloquent/models/Ensayo.php';
require_once '../../../eloquent/models/EnsayoMuestra.php';
require_once '../../../eloquent/models/EnsayoMuestraReactivoLote.php';
require_once '../../../eloquent/models/Muestra.php';
require_once '../../../eloquent/models/Producto.php';
require_once '../../../eloquent/models/ProductoEnsayo.php';
require_once '../../../eloquent/models/ProductoEnsayoReactivo.php';
require_once '../../../eloquent/models/Reactivo.php';

class AuxInformeUsoReactivosMuestra {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getInfoUsoReactivosMuestra($idReactivos, $fechaInicio, $fechaFin) {
        $idReactivos = implode(',', $idReactivos);
        $SQL = "SELECT CONCAT(t1.prefijo, '-', t1.custom_id) AS muestra, 
                t5.nombre AS reactivo, t6.nombre AS producto, t4.descripcion AS ensayo 
                FROM sgm_muestra t1 
                JOIN sgm_ensayo_muestra t2 ON t2.id_muestra = t1.id 
                JOIN sgm_ensayo_muestra_reactivo_lote t3 ON t3.id_ensayo_muestra = t2.id 
                JOIN sgm_ensayo t4 ON t4.id = t2.id_ensayo 
                JOIN sgm_reactivo t5 ON t5.id = t3.id_reactivo 
                JOIN sgm_producto t6 ON t6.id = t1.id_producto 
                WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_reactivo in(?)";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idReactivos);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
                $error = $query->errorInfo();
        }
    }

}
