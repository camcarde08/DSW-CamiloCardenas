<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEquiposDbModelClass
 *
 * @author andres
 */
class TablaEnsayoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllEnsayos() {
        $SQL = "select * from sgm_ensayo order by descripcion";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllActiveEnsayo() {
        $SQL = "SELECT * FROM sgm_ensayo WHERE activo = 1 and es_paquete = 0 ORDER BY descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function updateEnsayoById2($id, $precio, $tiempo, $plantilla, $descripcion, $codinterno, $orden, $prog_automatica) {
        $SQL = "UPDATE sgm_ensayo SET  precio_real = ?, tiempo = ?,id_plantilla = ?,descripcion = ?, codinterno = ?, orden = ?, prog_automatica = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $precio);
        $query->bindParam(2, $tiempo);
        $query->bindParam(3, $plantilla);
        $query->bindParam(4, $descripcion);
        $query->bindParam(5, $codinterno);
        $query->bindParam(6, $orden);
        $query->bindParam(7, $prog_automatica);
        $query->bindParam(8, $id);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function deleteEnsayoById($id) {
        $SQL = "UPDATE sgm_ensayo SET  activo = 0 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $id
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function insertEnsayo2($precio, $tiempo, $plantilla, $esPaquete, $descripcion, $codinterno, $prog_automatica) {
        $SQL = "INSERT INTO sgm_ensayo (precio_real,tiempo,id_plantilla, es_paquete, descripcion,codinterno,prog_automatica)VALUES(?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $precio);
        $query->bindParam(2, $tiempo);
        $query->bindParam(3, $plantilla);
        $query->bindParam(4, $esPaquete);
        $query->bindParam(5, $descripcion);
        $query->bindParam(6, $codinterno);
        $query->bindParam(7, $prog_automatica);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getAllEnsayosSinPaquetes() {
        $SQL = "select EYO.*, PL.descripcion as nombrePlantilla from sgm_ensayo EYO JOIN sgm_plantilla PL ON EYO.id_plantilla = PL.id where es_paquete = 0 and activo = 1 order by descripcion; ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function insertEnsayo($precio, $tiempo, $plantilla, $esPaquete, $descripcion) {
        $SQL = "INSERT INTO sgm_ensayo (precio_real,tiempo,id_plantilla, es_paquete, descripcion)VALUES(?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $precio);
        $query->bindParam(2, $tiempo);
        $query->bindParam(3, $plantilla);
        $query->bindParam(4, $esPaquete);
        $query->bindParam(5, $descripcion);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function getPaquetes() {
        $SQL = "select ens.*, eaa.id_area_analisis as id_area from sgm_ensayo ens left join sgm_ensayo_area_analisis eaa on eaa.id_ensayo = ens.id where ens.es_paquete = 1 and ens.activo = 1 order by descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getPaqueteDisponiblesByIdProducto($idProducto) {
        $SQL = "SELECT t1.* FROM sgm_ensayo t1 left join (select * from sgm_producto_paquete where id_producto = ?) t2 on t1.id = t2.id_ensayo WHERE t1.es_paquete = 1 and isnull(t2.id) and t1.activo = 1 order by t1.descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateEnsayoById($id, $precio, $tiempo, $plantilla, $descripcion) {
        $SQL = "UPDATE sgm_ensayo SET  precio_real = ?, tiempo = ?,id_plantilla = ?,descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $precio);
        $query->bindParam(2, $tiempo);
        $query->bindParam(3, $plantilla);
        $query->bindParam(4, $descripcion);
        $query->bindParam(5, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function insertPaquete($codigo, $descripcion) {
        $SQL = "INSERT INTO sgm_ensayo (descripcion,tiempo,es_paquete,codigo)VALUES(?,0,1,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $codigo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function updatePaqueteNom($codigo, $id, $descripcion) {
        $SQL = "UPDATE sgm_ensayo SET  descripcion = ?, codigo = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $codigo);
        $query->bindParam(3, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function deletePaqueteNom($id, $activo) {
        $SQL = "UPDATE sgm_ensayo SET  activo = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activo);
        $query->bindParam(2, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function deletePaqueteById($id) {
        $SQL = "UPDATE sgm_ensayo SET  activo = 0 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $id
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getEnsayosMic() {
        $SQL = "SELECT t3.* FROM sgm_ensayo_area_analisis t1 JOIN sgm_ensayo_paquete t2 ON t1.id_ensayo = t2.id_paquete JOIN sgm_ensayo t3 ON t2.id_ensayo = t3.id WHERE id_area_analisis = 2 group by t2.id_ensayo order by t3.descripcion";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = false;
        }
        return $data;
    }

    function updatePaqueteById($codigo, $descripcion, $id) {
        $SQL = "UPDATE sgm_ensayo SET codigo = ?, descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        $query->bindParam(3, $id);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getPaquetesAsociadosByIdProd($idProducto) {
        $SQL = "SELECT t1.*, t2.id as id_producto_paquete, t2.id_producto "
                . "FROM sgm_ensayo t1 "
                . "join sgm_producto_paquete t2 on t2.id_ensayo = t1.id "
                . "where t2.id_producto=? and t1.activo = 1 and t1.es_paquete = 1 "
                . "order by t1.descripcion asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getPaquetesDisponiblesByIdProd($idProducto) {
        $SQL = "SELECT t2.* "
                . "FROM (SELECT t1.* FROM sgm_producto_paquete t1 "
                . "WHERE t1.id_producto = ?) t3 "
                . "right join sgm_ensayo t2 ON t3.id_ensayo = t2.id "
                . "WHERE t3.id IS NULL and t2.activo = 1 and t2.es_paquete = 1 "
                . "order by t2.descripcion asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getEnsayosPaginacion($cantidad, $pagina
    , $descripcion, $precio_real, $tiempo, $plantilla, $codinterno, $orden) {
        $pagina = $pagina - 1;
        $descripcion = "%" . $descripcion . "%";
        $precio_real = "%" . $precio_real . "%";
        $tiempo = "%" . $tiempo . "%";
        $plantilla = "%" . $plantilla . "%";
        $codinterno = "%" . $codinterno . "%";
        $orden = "%" . $orden . "%";

        $registroInicial = $pagina * $cantidad;

        $SQL = "SELECT t1.*
            FROM sgm_ensayo t1 
            LEFT JOIN sgm_plantilla t2 ON t1.id_plantilla = t2.id 
            WHERE 
            IFNULL(t1.descripcion,'') like ? and 
            IFNULL(t1.precio_real,'') like ? and 
            IFNULL(t1.tiempo,'') like ? and 
            IFNULL(t2.descripcion,'') like ? and  
            IFNULL(t1.codinterno,'') like ? and  
            IFNULL(t1.orden,'') like ? and
            t1.es_paquete = 0 and t1.activo = 1 
            order by t1.descripcion asc 
            limit $registroInicial, $cantidad ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $precio_real);
        $query->bindParam(3, $tiempo);
        $query->bindParam(4, $plantilla);
        $query->bindParam(5, $codinterno);
        $query->bindParam(6, $orden);

        if ($query->execute()) {

            $ensayos = $query->fetchAll(PDO::FETCH_ASSOC);

            $SQL2 = "SELECT 
            count(t1.id) as cantidad_total
            
            FROM sgm_ensayo t1 
            LEFT JOIN sgm_plantilla t2 ON t1.id_plantilla = t2.id 
            WHERE 
            IFNULL(t1.descripcion,'') like ? and 
            IFNULL(t1.precio_real,'') like ? and 
            IFNULL(t1.tiempo,'') like ? and 
            IFNULL(t2.descripcion,'') like ? and  
            IFNULL(t1.codinterno,'') like ? and  
            IFNULL(t1.orden,'') like ? and
            t1.es_paquete = 0 and t1.activo = 1;";

            $query2 = $this->dbClass->getConexion()->prepare($SQL2);
            $query2->bindParam(1, $descripcion);
            $query2->bindParam(2, $precio_real);
            $query2->bindParam(3, $tiempo);
            $query2->bindParam(4, $plantilla);
            $query2->bindParam(5, $codinterno);
            $query2->bindParam(6, $orden);

            if ($query2->execute()) {
                $arr = array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => array(
                        "ensayos" => $ensayos,
                        "cantidad_total" => $query2->fetch(PDO::FETCH_OBJ)->cantidad_total
                    )
                );

                return $arr;
            }
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getPaquetesPaginacion($cantidad, $pagina, $codigo
    , $descripcion) {
        $pagina = $pagina - 1;
        $codigo = "%" . $codigo . "%";
        $descripcion = "%" . $descripcion . "%";

        $registroInicial = $pagina * $cantidad;

        $SQL = "SELECT t1.*, t2.id_area_analisis as id_area 
            FROM sgm_ensayo t1 
            left join sgm_ensayo_area_analisis t2 on t2.id_ensayo = t1.id
            WHERE 
            IFNULL(t1.codigo,'') like ? and 
            IFNULL(t1.descripcion,'') like ? and 
            t1.es_paquete = 1 and t1.activo = 1 
            order by t1.descripcion asc 
            limit $registroInicial, $cantidad ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);

        if ($query->execute()) {

            $paquetes = $query->fetchAll(PDO::FETCH_ASSOC);

            $SQL2 = "SELECT 
            count(t1.id) as cantidad_total
            FROM sgm_ensayo t1  
            WHERE 
            IFNULL(t1.codigo,'') like ? and 
            IFNULL(t1.descripcion,'') like ? and 
            t1.es_paquete = 1 and t1.activo = 1;";

            $query2 = $this->dbClass->getConexion()->prepare($SQL2);
            $query2->bindParam(1, $codigo);
            $query2->bindParam(2, $descripcion);

            if ($query2->execute()) {
                return array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => array(
                        "paquetes" => $paquetes,
                        "cantidad_total" => $query2->fetch(PDO::FETCH_OBJ)->cantidad_total
                    )
                );
            }
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function getEnsayoByIdToAud($idEnsayo) {
        $ensayo = Ensayo::find($idEnsayo);
        $ensayo->plantilla;
        $ensayo->mediosCultivo;
        $ensayo->equipos;
        return $ensayo->toJson();
    }

    function getPaqueteByIdToAud($idPaquete) {
        $paquete = Paquete::find($idPaquete);
        $paquete->ensayos;
        return $paquete->toJson();
    }

    function insertAudEnsayo($old, $new, $idEnsayo, $evento, $razon) {

        $ensayoAud = new EnsayoAud();
        $ensayoAud->fecha = new DateTime("now");
        $ensayoAud->old = $old;
        $ensayoAud->new = $new;
        $ensayoAud->id_usuario = $_SESSION['userId'];
        $ensayoAud->id_ensayo = $idEnsayo;
        $ensayoAud->evento = $evento;
        $ensayoAud->razon = $razon;
        try {
            $ensayoAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertAudPaquete($old, $new, $idPaquete, $evento, $razon) {

        $paqueteAud = new PaqueteAud();
        $paqueteAud->fecha = new DateTime("now");
        $paqueteAud->old = $old;
        $paqueteAud->new = $new;
        $paqueteAud->id_usuario = $_SESSION['userId'];
        $paqueteAud->id_paquete = $idPaquete;
        $paqueteAud->evento = $evento;
        $paqueteAud->razon = $razon;
        try {
            $paqueteAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

}
