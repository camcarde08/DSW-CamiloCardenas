<?php

require_once '../../../model/DbClass.php';

class AuxInformeReanalisis {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getMuestrasReanalisis($fechaInicio, $fechaFin) {
        $muestrasReanalisis = [];
        $data = $this->getMuestrasRangoDias($fechaInicio, $fechaFin);
        $fechaInicioDate = new DateTime($fechaInicio);
        $fechaFinDate = new DateTime($fechaFin);
        foreach ($data as $muestra) {
            $tempFechaLlegada = new DateTime($muestra->fecha_llegada);

            // Se suman 18 meses a la fecha de llegada
            $tempFechaLlegada->add(new DateInterval('P18M'));

            // Mientras el año de la f. llegada sea menor al de la fecha consultada
            // validar si entra en el rango de reanálisis
            if ($tempFechaLlegada >= $fechaInicioDate && $tempFechaLlegada <= $fechaFinDate) {
                array_push($muestrasReanalisis, $muestra);
                break;
            }
        }
        return $muestrasReanalisis;
    }

    function getMuestrasRangoDias($fechaInicio, $fechaFin) {
        $fechaInicioDate = new DateTime($fechaInicio);
        $anioFin = $fechaInicioDate->format('Y');
        $diaInicio = $fechaInicioDate->format('d');
        $diaFin = (new DateTime($fechaFin))->format('d');
        $anioInicio = $fechaInicioDate->sub(new DateInterval('P2Y'));
        $SQL = "SELECT t1.*, t2.nombre as producto, t4.nombre as cliente 
                FROM sgm_muestra t1 
                join sgm_producto t2 on t1.id_producto = t2.id 
                join sgm_forma_farmaceutica t3 on t3.id = t2.id_formula_farma
                join sgm_terceros t4 on t4.id = t1.id_tercero
                where t3.id = 2 and t1.fecha_vencimiento > ?
                and day(t1.fecha_llegada) between ? and ?
                and year(t1.fecha_llegada) >= ? and year(t1.fecha_llegada) < ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaFin);
        $query->bindParam(2, $diaInicio);
        $query->bindParam(3, $diaFin);
        $query->bindParam(4, $anioInicio->format('Y'));
        $query->bindParam(5, $anioFin);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

}
