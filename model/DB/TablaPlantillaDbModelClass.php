<?php
class TablaPlantillaDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function getAllPlantillas(){
        $SQL = "SELECT * FROM sgm_plantilla ORDER BY descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function getAllPlantillas2(){
        $SQL = "SELECT * FROM sgm_plantilla ORDER BY descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        if($query->execute()){
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
    
    public function insertPlantilla ($descripcion){
        $SQL = "INSERT INTO sgm. Estructurasgm_plantilla (descripcion) VALUES (?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $descripcion);
        
        
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    public function updatePlantilla($idForma, $descripcionForma){
        $SQL = "UPDATE sgm. Estructurasgm_plantilla SET descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $descripcionForma);
        $query->bindParam(2, $idForma);
        
        if($query->execute()){
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
}
