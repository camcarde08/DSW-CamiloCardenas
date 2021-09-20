<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProgramacionController
 *
 * @author andres
 */
class CotizacionController {
    
    private $cotizacion;
    
    public function __construct() {
        $this->cotizacion = new CotizacionModelClass();
    }
    
    public function rechazarCotizacion($idCotizacion, $motivo){
        $modelTablaCotizacion = new TablaCotizacionDbModelClass();
        $data = $modelTablaCotizacion->rechazarCotizacionByIdCotizacion($idCotizacion, $motivo);
        if($data == true){
            $response = array('result' => 0, 'message' => 'Se registro exitosamente el rechazo de la cotización');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo el rechazo de la cotización');
        }
         echo json_encode($response);
    }
    
    public function paintConsultaCotizacion(){
        $this->cotizacion->paintConsultaCotizacion();
    }
    
    public function paintRegistrarCotizacion(){
        $this->cotizacion->paintRegistrarCotizacion();
    }
    
    public function updateCotizacion($idCotizacion, $estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion,$observacionFin, $dataGrid, $aplicaIva, $aplicaRetencion){
        $updateBasicCotizacion = $this->updateBasicCotizacion($idCotizacion, $estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion,$observacionFin, $aplicaIva, $aplicaRetencion);
        
        if($updateBasicCotizacion == true ){
            
            $this->updateEnsayosCotizacion($idCotizacion, $dataGrid);
            $response = array('result' => '1', 'message' => 'se ha actualizado exitosamente la cotizacion con Número: '.$idCotizacion);
            echo json_encode($response);
            
        } else {
            
            $response = array('result' => '0', 'message' => 'Fallo la actualización de la cotización');
            echo json_encode($response);
            
            
        }
    }
    
    public function updateBasicCotizacion($idCotizacion, $estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion,$observacionFin,$aplicaIva, $aplicaRetencion){
        $tablaCotizacion = new TablaCotizacionDbModelClass();
        if($aplicaIva == "true"){
            $aplicaIva = 1;
        } else {
            $aplicaIva = 0;
        }
        
        if($aplicaRetencion == "true"){
            $aplicaRetencion = 1;
        } else {
            $aplicaRetencion = 0;
        }
        return $tablaCotizacion->updateCotizacionById($idCotizacion,$estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion,$observacionFin,$aplicaIva, $aplicaRetencion);
    }
    
    public function updateEnsayosCotizacion($idCotizacion,$dataGrid){
        $tablaCotizacionProducto = new TablaCotizacionProductoDbModelClass();
        $tablaCotProEnsayo = new TablaCotProEnsayoDbModelClass();
        
        $CotizacionProducto = $tablaCotizacionProducto->getIdCotizacionProductoByIdCotizacion($idCotizacion);
        for($i = 0; $i < count($CotizacionProducto); $i++){
            $tablaCotProEnsayo->deleteByIdCotizacionProducto($CotizacionProducto[$i]['id']);
        }
        $tablaCotizacionProducto->deleteCotizacionProductoByIdCotizacion($idCotizacion);
        $ensayos = json_decode($dataGrid, true);
        
        
        $currentProducto = 0;
        $idCotPro = 0;
        
        
        for($i = 0; $i < count($ensayos); $i++){
            $elProducto = $ensayos[$i][idProducto];
            if($elProducto == $currentProducto){
                $idPaquete = $ensayos[$i][idPaquete];
                $idEnsayo = $ensayos[$i][idEnsayo];
                $idAreaAnalisis = $ensayos[$i][idAreaAnalisis];
                $duracion = $ensayos[$i][Duracion];
                $seleccion = $ensayos[$i][Seleccione];
                $valor = $ensayos[$i][Valor];
                $aprobado = $ensayos[$i][Aprobado];
                $tablaCotProEnsayo->insertCotizacionProducto($idCotPro, $idPaquete, $idEnsayo, $idAreaAnalisis, $duracion, $seleccion, $valor, $aprobado);
            } else {
                $currentProducto = $ensayos[$i][idProducto];
                $idCotPro = $tablaCotizacionProducto->insertCotizacionProducto($idCotizacion, $currentProducto);
                if($idCotPro != false){
                    $idPaquete = $ensayos[$i][idPaquete];
                    $idEnsayo = $ensayos[$i][idEnsayo];
                    $idAreaAnalisis = $ensayos[$i][idAreaAnalisis];
                    $duracion = $ensayos[$i][Duracion];
                    $seleccion = $ensayos[$i][Seleccione];
                    $valor = $ensayos[$i][Valor];
                    $aprobado = $ensayos[$i][Aprobado];
                    $tablaCotProEnsayo->insertCotizacionProducto($idCotPro, $idPaquete, $idEnsayo, $idAreaAnalisis, $duracion, $seleccion, $valor, $aprobado);
                }
            }
            
        }
    }
    
    public function saveCotizacion($estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion, $observacionFin,$aplicaIva,$aplicaRetenciones, $dataGrid){
        $idCotizacion = $this->insertCotizacion($estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion, $observacionFin,$aplicaIva,$aplicaRetenciones);
        $ensayos = json_decode($dataGrid, true);
        
        
        $currentProducto = 0;
        $idCotPro = 0;
        $tablaCotizacionProducto = new TablaCotizacionProductoDbModelClass();
        $tablaCotProEnsayo = new TablaCotProEnsayoDbModelClass();
        
        for($i = 0; $i < count($ensayos); $i++){
            $elProducto = $ensayos[$i][idProducto];
            if($elProducto == $currentProducto){
                $idPaquete = $ensayos[$i][idPaquete];
                $idEnsayo = $ensayos[$i][idEnsayo];
                $idAreaAnalisis = $ensayos[$i][idAreaAnalisis];
                $duracion = $ensayos[$i][Duracion];
                $seleccion = $ensayos[$i][Seleccione];
                $valor = $ensayos[$i][Valor];
                $aprobado = $ensayos[$i][Aprobado];
                $tablaCotProEnsayo->insertCotizacionProducto($idCotPro, $idPaquete, $idEnsayo, $idAreaAnalisis, $duracion, $seleccion, $valor, $aprobado);
            } else {
                $currentProducto = $ensayos[$i][idProducto];
                $idCotPro = $tablaCotizacionProducto->insertCotizacionProducto($idCotizacion, $currentProducto);
                if($idCotPro != false){
                    $idPaquete = $ensayos[$i][idPaquete];
                    $idEnsayo = $ensayos[$i][idEnsayo];
                    $idAreaAnalisis = $ensayos[$i][idAreaAnalisis];
                    $duracion = $ensayos[$i][Duracion];
                    $seleccion = $ensayos[$i][Seleccione];
                    $valor = $ensayos[$i][Valor];
                    $aprobado = $ensayos[$i][Aprobado];
                    $tablaCotProEnsayo->insertCotizacionProducto($idCotPro, $idPaquete, $idEnsayo, $idAreaAnalisis, $duracion, $seleccion, $valor, $aprobado);
                }
            }
            
        }
        
        if($idCotizacion != false){
            $cot = true;
        }
        
        if($cot == true ){
            
            
            $response = array('result' => '1', 'message' => 'se ha registrado la cotizacion exitosamente con Número: '.$idCotizacion);
            echo json_encode($response);
            
        } else {
            
            $response = array('result' => '0', 'message' => 'El registro de muestra ha fallado verifique los datos dilengenciados e intentelo nuevamente');
            echo json_encode($response);
            
            
        }
    }
    
    public function insertCotizacion($estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion, $observacionFin,$aplicaIva,$aplicaRetenciones){
        $tablaCotizacion = new TablaCotizacionDbModelClass();
        if($aplicaIva == "true"){
            $aplicaIva = 1;
        } else {
            $aplicaIva = 0;
        }
        if($aplicaRetenciones == "true"){
            $aplicaRetenciones = 1;
        } else {
            $aplicaRetenciones = 0;
        }
        return $tablaCotizacion->insertCotizacion($estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion, $observacionFin,$aplicaIva,$aplicaRetenciones);
    }
    
   
} 
