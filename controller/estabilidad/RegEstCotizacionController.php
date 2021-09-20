<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegEstCotizacionController
 *
 * @author andres
 */
class RegEstCotizacionController {
    
    public function rechazarCotizacion($idCotizacion, $motivo){
        $modelTablaEstCotizacion = new TablaEstCotizacionDbModel();
        $data = $modelTablaEstCotizacion->rechazarEstCotizacion($idCotizacion, $motivo);
        if ($data == true) {
            $response = array('result' => 0, 'message' => 'Se registro exitosamente el rechazo de la cotización');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo el rechazo de la cotización');
        }
        echo json_encode($response);
    }
    
    public Function updateEstCotizacion($infoCotizacion){
        $cotizacion = json_decode($infoCotizacion, true);
        $modelTableEstCotizacion = new TablaEstCotizacionDbModel();
        $updateBasicCotizacion = $modelTableEstCotizacion->updateCotizacionById($cotizacion['fechaSolicitud'], $cotizacion['fechaCompromiso'], $cotizacion['idtercero'], $cotizacion['nomContacto'], $cotizacion['telContacto'], $cotizacion['idProducto'], $cotizacion['tipoEstabilidadValue'], $cotizacion['observacion1'], $cotizacion['observacion2'], $cotizacion['observacion3'], $cotizacion['tiemposEstabilidadValue'], (int)$cotizacion['aplicaIva'], (int)$cotizacion['aplicaRetencion'], $cotizacion['idCotizacion']);
        if($updateBasicCotizacion == true){
            //borrar ensayos antiguos de la cotizacion
            $borradoEnsayosAntiguos = $this->borrarEnsayosByIdCotizacion($cotizacion['idCotizacion']);
            if($borradoEnsayosAntiguos == true){
                // insertar nuevos ensayos
                $data = $this->insertEnsayosEstCotizacion($cotizacion['idCotizacion'], $cotizacion['tiemposEstabilidadValue'], $cotizacion['ensayos'] );
                if($data == true){
                    $response = array('result' => 0, 'message' => 'Se ha actualizado la cotización exitosamente');
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo al registrar los nuevos ensayos de la cotización');
                }
            } else {
                $response = array('result' => 1, 'message' => 'Fallo al borrar los ensayo antiguos de la cotizacion');
            }
        } else {
            $response = array('result' => 1, 'message' => 'Fallo al actualizar la informacion basica de la cotizacion');
        }
        echo json_encode($response);
    }
    
    public function insertEnsayosEstCotizacion($idCotizacion, $meses, $ensayos){
        $modelTablaEstCotEnsayos = new TablaEstCotEnsDbModelClass();
        for($i = 0; $i < count($ensayos); $i++){
            $insertEstCotEnsayo = $modelTablaEstCotEnsayos->insertEstCotEns($idCotizacion, $ensayos[$i]["idPaquete"], $ensayos[$i]["nomPaquete"], $ensayos[$i]["idEnsayo"], $ensayos[$i]["nomEnsayo"], $ensayos[$i]["valor"]);
            if($insertEstCotEnsayo != false){
                // insertar tiempos del ensayo
                $response = $this->insertTiemposEnsayoEstCot($insertEstCotEnsayo,$ensayos[$i],$meses);
            } else {
                $response = false;
                break;
            }
        }
        return $response;
    }
    
    public function insertTiemposEnsayoEstCot($idEstCotEns,$fullEnsayo,$mesesEnsayo){
        $modelTablaTiemposEnsayosEstCot = new TablaEstTiemposCotEnsDbModelClass();
        for($i = 0; $i < $mesesEnsayo; $i++){
            for($j = 0; $j < 4; $j++){
                $insertTiempoEnsayoEstCot = $modelTablaTiemposEnsayosEstCot->insertEstTiemposCotEns($idEstCotEns, $i."t".$j, $fullEnsayo[$i."t".$j]);
                if($insertTiempoEnsayoEstCot != false){
                    $response = true;
                } else {
                    $response = false;
                    break;
                }
            }
        }
        return $response;
    }
    
    public function borrarEnsayosByIdCotizacion($idCotizacion){
        //obetener id ensayo de la cotizacion
        $modelTablaEstCotEnsayos =  new TablaEstCotEnsDbModelClass();
        $ensayos = $modelTablaEstCotEnsayos->selectEstCotEnsByIdCotizacion($idCotizacion);
        if($ensayos != flase){
            for($i = 0; $i< count($ensayos); $i++){
                $idEstCotEnsayo = $ensayos[$i]["id"];
                if($this->borrarTiemposByIdEstCotEnsayo($idEstCotEnsayo) != false){
                    if($modelTablaEstCotEnsayos->deleteEstCotEnsById($idEstCotEnsayo) != false){
                        
                    } else {
                        $response = false;
                        break;
                    }
                } else {
                    $response = false;
                    break;
                }
                
            }
            $response = true;
        } else {
            $response = false;
        }
        
        return $response;
    }
    
    public function borrarTiemposByIdEstCotEnsayo($idEstCotEnsayo){
        $modelTiemposEstCotEnsayo = new TablaEstTiemposCotEnsDbModelClass();
        $data = $modelTiemposEstCotEnsayo->deleteEstTiemposCotEnsByIdCotEns($idEstCotEnsayo);
        return $data;
    }
    
    public function guardarEnvioEstCotizacion ($idCotizacion, $destino, $medio, $observaciones){
        $modelTablaEnvioEstCotizacion = new TablaEnvioEstCotizacionDbModelClass();
        $idEnvio = $modelTablaEnvioEstCotizacion->insertEnvioEstCotizacion($idCotizacion, $destino, $medio, $observaciones);
        if($idEnvio != false ){
            $modelTablaEstCotizacion = new TablaEstCotizacionDbModel();
            $cotizacion = $modelTablaEstCotizacion->selectEstCotizacionById($idCotizacion);
            if($cotizacion[0]["estado"] == 1){
                $modelTablaEstCotizacion->updateEstadoCotizacionById($idCotizacion, 2);
            }
            $response = array('result' => 0, 'message' => 'Se registro el envio exitosamente');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo el registro del envio');
        }
        echo json_encode($response);
    }
    
    public function searchEstCotizacionById($id){
        $tablaEstCotizacion = new TablaEstCotizacionDbModel();
        $tablaEstCotizacion->selectEstCotizacionById($id);
    }
    
    public function insertEstCotizacion($fechaSolicitud, $fechaCompromiso, $tercero, $contacto, $telContacto, $producto, $tipoEstabilidad, $tiempos, $observaciones, $observaciones2, $observaciones3,$aplicaIva,$aplicaRetencion, $ensayos){
        $ensayos = json_decode($ensayos, true);
        $modelTablaEstCotizacion = new TablaEstCotizacionDbModel();
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
        $basicInsert =  $modelTablaEstCotizacion->insertEstCotizacion(null,1,$fechaSolicitud, $fechaCompromiso, $tercero, $contacto, $telContacto, $producto, $tipoEstabilidad, $tiempos, $observaciones, $observaciones2, $observaciones3,$aplicaIva,$aplicaRetencion);
        if($basicInsert != false){
            $modeltablaEstCotEns = new TablaEstCotEnsDbModelClass();
            $modelTablaEstTiemposCotEns = new TablaEstTiemposCotEnsDbModelClass();
            for($i = 0; $i < count($ensayos); $i++){
                $aux = $modeltablaEstCotEns->insertEstCotEns($basicInsert, $ensayos[$i]['idPaquete'], $ensayos[$i]['nomPaquete'], $ensayos[$i]['idEnsayo'], $ensayos[$i]['nomEnsayo'], $ensayos[$i]['valor']);
                if($aux != false){
                    for($j = 0; $j < $tiempos; $j++){
                        
                        for($h = 0; $h < 4; $h++){
                            $tiempo = $j."t".$h;
                            $aux2 = $modelTablaEstTiemposCotEns->insertEstTiemposCotEns($aux, $tiempo, $ensayos[$i][$tiempo]);
                            if($aux2 == false){
                                $response = array('result' => '1', 'message' => 'Fallo el registro de temperaturas asociadas al ensayo '.$ensayos[$i]['nomEnsayo']);
                                echo json_encode($response);
                                break;      
                            }
                        }
                    }
                } else {
                    $response = array('result' => '1', 'message' => 'Fallo el registro basico de ensayos');
                    echo json_encode($response);
                    break;
                }
            }
            
            $response = array('result' => '0', 'message' => 'Se registro exitosamente la cotizacion de estabilidades '.$basicInsert);
            
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo el registro basico de la cotización');
            echo json_encode($response);
        }
    }
    
    public function paintRegEstCotizacionModule(){
        $regEstCotizacionModel = new RegEstCotizacionModelClass();
        $regEstCotizacionModel->paintRegEstCotizacion();
    }
        public function paintRegistroEstabilidadModule(){
        $regEstCotizacionModel = new RegEstCotizacionModelClass();
        $regEstCotizacionModel->paintRegistroEstabilidad();
    }
        public function paintConsultaEstabilidadModule(){
        $regEstCotizacionModel = new RegEstCotizacionModelClass();
        $regEstCotizacionModel->paintConsultaEstabilidad();
    }
    public function paintDocumentosEstabilidadModule(){
        $regEstCotizacionModel = new RegEstCotizacionModelClass();
        $regEstCotizacionModel->paintDocumentosEstabilidad();
    }
    
    
}
