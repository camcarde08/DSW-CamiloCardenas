<?php

class MuestraController {

    private $muestraModel;

    public function __construct() {

        $this->muestraModel = new MuestraModelClass();
    }

    public function verificarMuestra($idMuestra, $conclusion, $fechaConclusion, $usuarioConclusion, $observacion) {
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->verificarMuestra($idMuestra, $conclusion, $fechaConclusion, $usuarioConclusion, $observacion);
        if ($result["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("verificarMuestra", $idMuestra);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al verificar muestra",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }

    public function anularMuestra2($customIdMuestra, $motivoAnulacion) {
        $modelMuestra = new TablaMuestraDbModelClass();
        if ($_SESSION["systemsParameters"]["customIdMuestra"] = "true") {
            $customIdMuestra = strtoupper($customIdMuestra);
            $parameters = explode("-", $customIdMuestra);
            $data = $modelMuestra->getRealIdMuestra($parameters[0], $parameters[1]);
            $realIdMuestra = $data[0]["id"];
        } else {
            $realIdMuestra = $customIdMuestra;
        }

        $modelTablaMuestra = new TablaMuestraDbModelClass();
        $resultAnulacion = $modelTablaMuestra->anularMuestra2($realIdMuestra, $motivoAnulacion);
        if ($resultAnulacion) {
            $generalController = new GeneralController();
            $generalController->updateEstadoByIdMuestra($realIdMuestra, 11, $motivoAnulacion, null);

            $response = array('result' => 0, 'message' => 'Se anulo la muestra exitosamente');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la anulación de la muestra');
        }

        echo json_encode($response);
    }

    public function anularMuestra($idMuestra) {
        $modelTablaMuestra = new TablaMuestraDbModelClass();
        $anulacion = $modelTablaMuestra->anularMuestra($idMuestra);
        if ($anulacion) {
            $generalController = new GeneralController();
            $generalController->updateEstadoByIdMuestra($idMuestra, 11, "", null);

            $response = array('result' => 0, 'message' => 'Se anulo la muestra exitosamente');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la anulación de la muestra');
        }

        echo json_encode($response);
    }

    public function getHistoricoEstadosSubMuestra($idMuestra) {
        $modelTablaHistoricoEstadoSubMuestra = new TablaHistoricoEstadoSubMuestraDbModelClass();
        $historicoData = $modelTablaHistoricoEstadoSubMuestra->getHistoricoEstadoSubmuestraByIdMuestra($idMuestra);
        if ($historicoData != false && count($historicoData) > 0) {
            foreach ($historicoData as $historico) {
                $historicos[] = array(
                    "id" => $historico["id"],
                    "duracion" => $historico["duracion"],
                    "estado" => $historico["estado"],
                    "fecha" => $historico["fecha"],
                    "usuario" => $historico["usuario"]
                );
            }
            $response = array('result' => 0, 'historicos' => $historicos);
        } else {
            $response = array('result' => 1, 'message' => 'No se encontraron sub muestras registradas');
        }
        echo json_encode($response);
    }

    public function getEstadoMuestraByIdMuestra($idMuestra) {
        $modelTablaMuestra = new TablaMuestraDbModelClass();
        $muestra = $modelTablaMuestra->getMuestraReferenciasById($idMuestra);
        $estado = $muestra[0]["id_estado_muestra"];
        echo json_encode($estado);
    }

    public function updateFaturacionMuestra($idMuestra, $cantidad, $numFactura, $anticipo, $descuento, $saldo) {
        $modelTablaMuestra = new TablaMuestraDbModelClass();
        $data = $modelTablaMuestra->updateFaturacionMuestra($idMuestra, $cantidad, $numFactura, $anticipo, $descuento, $saldo);
        if ($data == true) {
            $response = array('result' => 0, 'message' => 'Se registro con exito los datos de facturación para el analisis');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo el registro de los datos de facturación');
        }
        echo json_encode($response);
    }

    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                $this->delTree($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }
        return rmdir($dir);
    }

    public function eliminarFileRepoDocsById($idFile) {
        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $file = $modelTablaRepositorio->getitemById($idFile);
        if ($file != false) {
            $file = $file[0];
            if ($file["es_carpeta"] == 1) {
                $fullPath = $file["path"] . DIRECTORY_SEPARATOR . $file["nombre"];
                if ($this->delTree($fullPath)) {
                    if ($modelTablaRepositorio->deleteItemById($idFile)) {
                        $response = array('idEliminado' => $idFile, 'result' => 0, 'message' => 'Se ha eliminado la carpeta "' . $file["nombre"] . '" exitosamente.');
                    }
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo al borrar la carpeta del sistema de archivos');
                }
            } else {
                $fullPath = $file["path"] . DIRECTORY_SEPARATOR . $file["nombre"] . "." . $file["extension"];
                if (unlink($fullPath)) {
                    if ($modelTablaRepositorio->deleteItemById($idFile)) {
                        $response = array('idEliminado' => $idFile, 'result' => 0, 'message' => 'Se ha eliminado el archivo "' . $file["nombre"] . "." . $file["extension"] . '" exitosamente.');
                    }
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo al borrar el archivo del sistema de archivos');
                }
            }
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la consulta de los detalles en la base de datos');
        }
        echo json_encode($response);
    }

    public function getRepoFileDownloadLinkById($idFile) {
        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $file = $modelTablaRepositorio->getitemById($idFile);
        if ($file != false) {
            $file = $file[0];
            $fullPath = $file["path"] . DIRECTORY_SEPARATOR . $file["nombre"] . "." . $file["extension"];
            $link = str_replace(DIRECTORY_SEPARATOR, "/", $fullPath);
            $response = array('result' => 0, 'message' => $link);
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la consulta del link de descarga');
        }
        echo json_encode($response);
    }

    public function uploadFileRepoDocs($idParenFolder) {

        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $parentFolder = $modelTablaRepositorio->getitemById($idParenFolder);
        if ($parentFolder != false) {
            $parentFolder = $parentFolder[0];
            $targetFile = $parentFolder["path"] . DIRECTORY_SEPARATOR . $parentFolder["nombre"] . DIRECTORY_SEPARATOR . basename($_FILES["fileToUpload"]["name"]);
            $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
            $uploadOk = 1;
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if (!(file_exists($targetFile))) {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                    $path_parts = pathinfo($targetFile);
                    $idNewFile = $modelTablaRepositorio->insertField($path_parts["filename"], $path_parts["extension"], 0, $path_parts["dirname"], $idParenFolder, "");
                    if ($idNewFile != false) {
                        $response = array('idArchivo' => $idNewFile, 'nomeArchivo' => $path_parts["filename"], 'result' => 0, 'message' => 'Se ha subido el archivo exitosamente');
                    } else {
                        unlink($targetFile);
                        $response = array('result' => 1, 'message' => 'Fallo el registro del archivo en la base de datos');
                    }
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo al subir el archivo al servidor');
                }
            } else {
                $response = array('result' => 1, 'message' => 'Fallo ya existe un archivo con este nombre en la ubicacion seleccionada.');
            }
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la consulta de las propiedades de la carpeta contenedoraen la base de datos');
        }

        echo json_encode($response);
    }

    public function scanChargeDirRepoDocs($dir, $idParent) {
        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $dirContent = scandir($dir);
        foreach ($dirContent as $file) {
            $currentFullPath = $dir . DIRECTORY_SEPARATOR . $file;
            $infoCurrentFullPath = pathinfo($currentFullPath);
            if ($file != "." && $file != "..") {
                if (is_dir($currentFullPath)) {

                    $idCurrentFile = $modelTablaRepositorio->insertField($infoCurrentFullPath["filename"], "", 1, $dir, $idParent, "");
                    if ($idCurrentFile != false) {
                        $chargeCurrentDir = $this->scanChargeDirRepoDocs($currentFullPath, $idCurrentFile);
                        if ($chargeCurrentDir == false) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {

                    $idCurrentFile = $modelTablaRepositorio->insertField($infoCurrentFullPath["filename"], $infoCurrentFullPath["extension"], 0, $dir, $idParent, "");
                    if ($idCurrentFile == false) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function chargeNewRootPathRepoDocs($newRootPath) {
        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        if ($modelTablaRepositorio->cleanTable()) {
            $idRoot = $modelTablaRepositorio->insertField("/", "", 1, $newRootPath, -1, "Carpeta root del repositorio");
            if ($idRoot != false) {
                if ($this->scanChargeDirRepoDocs($newRootPath, $idRoot)) {
                    $response = array('result' => 0, 'message' => 'Se asigno correctamente el nuevo repositorio.');
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo la asignacion del nuevo repositorio al cargar el contenido en la base de datos');
                }
            } else {
                $response = array('result' => 1, 'message' => 'Fallo la asignacion del nuevo repositorio al crear la capeta root en la base de datos');
            }
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la asignacion del nuevo repositorio al limpiar la base de datos');
        }

        echo json_encode($response);
    }

    public function scanRepoFolder() {
        $repoFolder = scandir("docs/repositorio");
        echo json_encode($repoFolder);
    }

    public function getRootsRepoDocs() {
        $roots = scandir("./docs" . DIRECTORY_SEPARATOR . "repositorio");
        $cont = 1;
        foreach ($roots as $root) {
            if ($root != "." && $root != "..") {
                $nombre = $root;
                $path = "./docs" . DIRECTORY_SEPARATOR . "repositorio" . DIRECTORY_SEPARATOR . $root;
                $cont++;
                $editedRoots[] = array(
                    "nombre" => $nombre,
                    "path" => $path,
                    "icon" => "views/images/folder.png",
                    "parent" => 1,
                    "id" => $cont
                );
            }
        }
        $editedRoots[] = array(
            "nombre" => "/",
            "path" => "./docs" . DIRECTORY_SEPARATOR . "repositorio",
            "icon" => "views/images/folder.png",
            "parent" => -1,
            "id" => 1
        );
        echo json_encode($editedRoots);
    }

    public function getEnsayosMuestraEstabilidad($idMuestra) {

        $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $basicEnsayos = $modelEnsayoMuestra->getBasicEnsayoMuestraEstabilidad($idMuestra);
        if ($basicEnsayos != false) {
            $modelTiemposEnsayoMuestra = new TablaEstTiemposEnsMueDbModelClass();
            for ($i = 0; $i < count($basicEnsayos); $i++) {
                $ensayos[$i]["id"] = $i + 1;
                $ensayos[$i]["idPaquete"] = $basicEnsayos[$i]["id_paquete"];
                $ensayos[$i]["nomPaquete"] = $basicEnsayos[$i]["nom_paquete"];
                $ensayos[$i]["idEnsayo"] = $basicEnsayos[$i]["id_ensayo"];
                $ensayos[$i]["nomEnsayo"] = $basicEnsayos[$i]["nom_ensayo"];
                $ensayos[$i]["duracion"] = $basicEnsayos[$i]["duracion"];
                $ensayos[$i]["nomAreaAnalisis"] = $basicEnsayos[$i]["area_analisis"];
                $tiempos = $modelTiemposEnsayoMuestra->getTiemposToEnsayoMuestra($idMuestra, $ensayos[$i]["idPaquete"], $ensayos[$i]["idEnsayo"]);
                if ($tiempos != false) {
                    for ($j = 0; $j < count($tiempos); $j++) {
                        $ensayos[$i][$tiempos[$j]["tiempo"]] = $tiempos[$j]["is_check"];
                    }
                }
            }
        }
        $aux = json_encode($ensayos);
        echo json_encode($ensayos);
    }

    public function crearCarpetaRepoDocs($nombre, $parentId) {



        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $parent = $modelTablaRepositorio->getitemById($parentId);
        if ($parent != false) {
            if (!file_exists($parent[0]["path"] . DIRECTORY_SEPARATOR . $parent[0]["nombre"] . DIRECTORY_SEPARATOR . $nombre)) {
                if (mkdir($parent[0]["path"] . DIRECTORY_SEPARATOR . $parent[0]["nombre"] . DIRECTORY_SEPARATOR . $nombre, 0777)) {
                    $insertField = $modelTablaRepositorio->insertField($nombre, "", 1, $parent[0]["path"] . DIRECTORY_SEPARATOR . $parent[0]["nombre"], $parentId, "N/A");
                    if ($insertField != false) {
                        $response = array('idCarpeta' => $insertField, 'result' => 0, 'message' => "se ha creado la carpeta " . $nombre . " en la ruta solicitada");
                    } else {
                        rmdir($parent[0]["path"] . DIRECTORY_SEPARATOR . $parent[0]["nombre"] . DIRECTORY_SEPARATOR . $nombre);
                        $response = array('result' => '1', 'message' => 'Error al crear la carpeta ' . $nombre . ' en la base de datos');
                    }
                } else {
                    $response = array('result' => '1', 'message' => 'Error al crear la carpeta ' . $nombre . ' en el sistema de archivos');
                }
            } else {
                $response = array('result' => '1', 'message' => 'Ya existe la carpeta solicitada');
            }
        } else {
            $response = array('result' => '1', 'message' => 'Fallo al consultar la informacion de la carpeta contenedora');
        }

        echo json_encode($response);
    }

    public function getEsCarpetaById($id) {
        $modelTablaRepositorio = new TablaRepositorioDbModelClass();
        $item = $modelTablaRepositorio->getitemById($id);
        if ($item[0]["es_carpeta"] == 1) {
            $response = array('esCarpeta' => true);
        } else {
            $response = array('esCarpeta' => false);
        }
        echo json_encode($response);
    }

    public function paintRepoDocs() {
        $this->muestraModel->paintRepoDocs();
    }

    function regMuestraPaint() {


        $this->muestraModel->paintRegMuestra();
    }

    function almacenMuestraPaint() {
        $this->muestraModel->paintAlamacenMuestra();
    }

    function historicoEstadosMuestraPaint() {
        $this->muestraModel->paintHistoricoEstadosMuestra();
    }

    function consultaMuestrasPaint() {
        $this->muestraModel->paintConsultaMuestras();
    }

    function consultaMuestrasEstPaint() {
        $this->muestraModel->paintConsultaMuestrasEst();
    }

    function docsMuestraPaint() {
        $this->muestraModel->paintDocsMuestra();
    }

    function insertMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio) {
        $tablaMuestra = new TablaMuestraDbModelClass();
        return $tablaMuestra->insertMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio);
    }

    function insertMuestra2($muestraData) {

        $tablaMuestra = new TablaMuestraDbModelClass();
        return $tablaMuestra->insertMuestra2($muestraData["idEstadoMuestra"], $muestraData["activa"], $muestraData["prioridad"], $muestraData["cotizacion"], $muestraData["remision"], $muestraData["fechaLlegada"], $muestraData["fechaCompromiso"], $muestraData["idTercero"], $muestraData["idContacto"], $muestraData["areaContacto"], $muestraData["fabricante"], $muestraData["procedencia"], "", $muestraData["observaciones"], $muestraData["idAreaAnalisis"], $muestraData["idTipoEstabilidad"], null, $muestraData["duracionEstabilidad"], $muestraData["idProducto"], $muestraData["idEmpaque"], $muestraData["idEnvase"], $muestraData["fechaFabricacion"], $muestraData["fechaVencimiento"], 1, 0, 1, null, 0, 0, 0, date("Y-m-d"), $muestraData["prefijo"], $muestraData["identificadorCliente"], $muestraData["condicionesGenerales"]);
    }

    function insertLote($idMuestra, $index, $tamano, $numero, $cantidad, $estado) {
        $tablaLoteModel = new TablaLoteDbModelClass();
        return $tablaLoteModel->insertLote($idMuestra, $index, $tamano, $numero, $cantidad, $estado);
    }

    function insertEnsayos($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $especificacion, $descripcionEspecifica, $idHojaCalculo, $valor) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        if($idHojaCalculo == '0'){
            $idHojaCalculo = null;
        }
        if ($validacion === "true") {
            $validacion = 1;
        } else {
            $validacion = 0;
        }
        $resultInsertEnsayomuestra = $tablaEnsayoMuestra->insertEnsayoMuestra($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $especificacion, $descripcionEspecifica, $idHojaCalculo, $valor);
        $this->insertEnsayoMuestraMedioCultivo($id_Ensayo, $resultInsertEnsayomuestra);
        return $resultInsertEnsayomuestra;
    }

    function insertEnsayoMuestraMedioCultivo($idEnsayo, $idEnsayoMuestra) {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->getMediosCultivoAndActiveLoteByIdEnsayo($idEnsayo);
        $mediosCultivo = $result["data"];
        foreach ($mediosCultivo as $claveMedio => $valorMedio) {
            $a = $valorMedio->{"id_medio_cultivo"};
            $result2 = $tablaMedioCultivo->insertEnsayoMuestraMedioCultivoLote($idEnsayoMuestra, $valorMedio->{"id_medio_cultivo"}, $valorMedio->{"id_lote_activo"});
            $this->insertEnsayoMuestraMedioCultivoCepa($result2["data"], $valorMedio->{"id_medio_cultivo"});
        }
    }

    function insertEnsayoMuestraMedioCultivoCepa($idEnsayoMuestraMedioCultivo, $idMedioCultivo) {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->getActiveCepasAndLoteByIdMEdioCultivo($idMedioCultivo);
        $cepas = $result["data"];
        foreach ($cepas as $claveMedio => $cepa) {
            //$a = $valorMedio->{"id_medio_cultivo"};
            $result2 = $tablaCepa->insertEnsayoMuestraMedioCultivoCepaLote($idEnsayoMuestraMedioCultivo, $cepa->{"id_cepa"}, $cepa->{"id_lote_activo"});
        }
    }

    function insertEnsayosEst($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $fechaProgramacion) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        return $tablaEnsayoMuestra->insertEnsayoMuestraEst($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $fechaProgramacion);
    }

    function deleteLotesByIdMuestra($idMuestra) {
        $tablaLoteModel = new TablaLoteDbModelClass();
        return $tablaLoteModel->deleteLtesByIdMuestra($idMuestra);
    }

    function deleteEnsayosByIdMuestra($idMuestra, $areaAnalisis) {
        if ($areaAnalisis != 4) {
            $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
            $response = $tablaEnsayoMuestra->deleteEnsayosByIdMuestra($idMuestra);
        } else {
            //boorar los tiempos de los ensayos
            $modelTablaEstTiemposEnsMue = new TablaEstTiemposEnsMueDbModelClass();
            $borradotiempos = $modelTablaEstTiemposEnsMue->deleteTiemposByIdMuestra($idMuestra);
            if ($borradotiempos = true) {
                $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                $response = $tablaEnsayoMuestra->deleteEnsayosByIdMuestra($idMuestra);
            } else {
                $response = false;
            }
        }
        return $response;
    }

    function updateLotesByIdMuestra($idMuestra, $infoLotes) {
        if ($this->deleteLotesByIdMuestra($idMuestra)) {
            $lotes = json_decode($infoLotes, true);
            if (count($lotes) > 0) {
                $lot = true;
                for ($i = 0; $i < count($lotes); $i++) {
                    $tamanoLote = $lotes[$i]['Tamaño de lote'];
                    $numeroLote = $lotes[$i]['Número de lote'];
                    $cantidadLote = $lotes[$i]['Cantidad enviada por lotes'];
                    $idLote = $this->insertLote($idMuestra, $i, $tamanoLote, $numeroLote, $cantidadLote, 1);
                    if ($idLote === false) {
                        $lot = false;
                        break;
                    }
                }
                return $lot;
            } else {
                $lot = true;
            }
        } else {
            $lot = false;
        }
        return $lot;
    }

    function updateEnsayosByIdMuestra($idMuestra, $areaAnalisis, $infoEnsayos, $tipoEstabilidad, $duracion) {

        if ($this->deleteEnsayosByIdMuestra($idMuestra, $areaAnalisis)) {
            $ensayos = json_decode($infoEnsayos, true);
            if (count($ensayos) > 0) {
                $ens = true;
                if ($areaAnalisis != 4) {
                    for ($i = 0; $i < count($ensayos); $i++) {
//                        $idPaqueteEnsayo = $ensayos[$i]['Cod. Paquete'];
//                        $idEnsayoEnsayo = $ensayos[$i]['idEnsayo'];
//                        $validacionEnsayo = $ensayos[$i]['Seleccione'];
//                        $areaEnsayo = $ensayos[$i]['Área de análisis'];
//                        $tiempoEnsayo = $ensayos[$i]['Tiempo'];
//                        $duracionEnsayo = $ensayos[$i]['Duración'];
//                        $metodo = $ensayos[$i]['idMetodo'];
                        $idPaqueteEnsayo = $ensayos[$i]['idEnsayoPaquete'];
                        $idEnsayoEnsayo = $ensayos[$i]['idEnsayo'];
                        $validacionEnsayo = $ensayos[$i]['validacion'];
                        $areaEnsayo = $ensayos[$i]['areaAnalisis'];
                        $tiempoEnsayo = $ensayos[$i]['tiempo'];
                        $duracionEnsayo = $ensayos[$i]['duracion'];
                        $metodo = $ensayos[$i]['idMetodo'];

                        $idEnsayo = $this->insertEnsayos($idMuestra, $idPaqueteEnsayo, $idEnsayoEnsayo, $validacionEnsayo, $areaEnsayo, 10, $duracionEnsayo, 1, $metodo);
                        if ($idEnsayo === false) {
                            $ens = false;
                            break;
                        }
                    }
                } else {
                    $ens = $this->insertEnsayosMuestraEst($idMuestra, $ensayos, $tipoEstabilidad, $duracion);
                }
            } else {
                $ens = true;
            }
        } else {
            $ens = false;
        }
        return $ens;
    }

    function insertEnsayosMuestraEst($idMuestra, $ensayos, $tipoEstabilidad, $duracion) {
        $modelEstTiemposEnsMue = new TablaEstTiemposEnsMueDbModelClass();
        $modelTablaSubMuestraEst = new TablaSubMuestraEstDbModelClass();
        if ($tipoEstabilidad == 1) {
            $str = file_get_contents('./config/tiemposEstabilidadNatural.json');
        } else if ($tipoEstabilidad == 2) {
            $str = file_get_contents('./config/tiemposEstabilidadAcelerada.json');
        } else if ($tipoEstabilidad == 3) {
            $str = file_get_contents('./config/tiemposEstabilidadOnGoing.json');
        }

        $meses = json_decode($str, true);
        $currentDate = new DateTime();

        $contador = 0;
        $modelMuestra = new TablaMuestraDbModelClass();
        $modelProductoEnsayo = new TablaProductoEnsayoDbModelClass();
        $data = $modelMuestra->getMuestraReferenciasById($idMuestra);
        $idProducto = $data[0]["id_producto"];

        $insertEnsayos = true;
        $currentDuracion = null;
        for ($i = 0; $i < count($ensayos); $i++) {
            $data2 = $modelProductoEnsayo->getProductoEnsayoByProductoPaqueteEnsayo($idProducto, $ensayos[$i]["idPaquete"], $ensayos[$i]["idEnsayo"]);

            $idMetodo = $data2[0]["id_metodo"];
            for ($j = 1; $j < ($duracion + 1); $j++) {
                for ($k = 0; $k < count($meses); $k++) {
                    if ($meses[$k]["value"] == $j) {
                        $mes = " " . $meses[$k]["name"];
                        $intervalo = "P" . $meses[$k]["cantidadMes"] . "M";

                        $fechaProgramacion = new DateTime();
                        $fechaProgramacion = $fechaProgramacion->add(new DateInterval($intervalo));
                        break;
                    }
                }

                for ($h = 0; $h < 4; $h++) {
                    if ($h == 0) {
                        $temperatura = "30ºC-65%HR";
                    } else if ($h == 1) {
                        $temperatura = "30ºC-75%HR";
                    } else if ($h == 2) {
                        $temperatura = "40ºC-75%HR";
                    } else if ($h == 3) {
                        $temperatura = "50°C-80%HR";
                    }

                    $indexTiempoTemp = ($j - 1) . "t" . $h;

                    $nomEnsayo = $ensayos[$i]["nomEnsayo"] . $mes . $temperatura;
                    $idPaquete = $ensayos[$i]["idPaquete"];
                    $idEnsayo = $ensayos[$i]["idEnsayo"];
                    $validacion = $ensayos[$i][$indexTiempoTemp];
                    $area = $ensayos[$i]["nomAreaAnalisis"];
                    $duracionEns = $ensayos[$i]["duracion"];


                    $ensayosFinal[$contador]["nomEnsayo"] = $nomEnsayo;
                    $ensayosFinal[$contador]["idPaquete"] = $idPaquete;
                    $ensayosFinal[$contador]["idEnsayo"] = $idEnsayo;
                    $ensayosFinal[$contador]["validacion"] = $validacion;
                    $ensayosFinal[$contador]["area"] = $area;
                    $ensayosFinal[$contador]["duracion"] = $duracionEns;


                    $contador++;
                    $idEnsMue = $this->insertEnsayosEst($idMuestra, $idPaquete, $idEnsayo, $validacion, $area, $duracionEns, $duracionEns, 1, $idMetodo, $fechaProgramacion->format('Y-m-d'));
                    if ($idEnsayo != false) {
                        $idSubMuestra = $this->getSubMuestraByIdMuestraAndMes($idMuestra, $mes, $fechaProgramacion);

                        $modelEstTiemposEnsMue->insertEstTiemposEnsMue($idEnsMue, $indexTiempoTemp, $validacion, $nomEnsayo, $idSubMuestra);
                    } else {
                        $insertEnsayos = false;
                    }
                }
            }
        }
        return $insertEnsayos;
    }

    function getSubMuestraByIdMuestraAndMes($idMuestra, $mes, $fechaProgramacion) {
        $modelTablaSubMuestra = new TablaSubMuestraEstDbModelClass();
        $subMuestraData = $modelTablaSubMuestra->getSubMuestraByIdMuestraAndMes($idMuestra, $mes);
        if ($subMuestraData !== false) {
            if (count($subMuestraData) > 0) {
                $idSubMuestra = $subMuestraData[0]["id"];
            } else {
                $fechaReferencia = $fechaProgramacion->format('Y-m-d');
                $idSubMuestra = $modelTablaSubMuestra->insertSubMuestraEst($idMuestra, $mes, 1, $fechaReferencia);
                $modelTablahistoricoSubMuestra = new TablaHistoricoEstadoSubMuestraDbModelClass();
                $fecha = date("Y-m-d");
                $modelTablahistoricoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 1, $_SESSION['userId'], "");
            }
        }
        return $idSubMuestra;
    }

    function updateEstadoCotizacion($idCotizacion, $idAreaAnalisis) {
        if ($idCotizacion != "") {
            switch ($idAreaAnalisis) {
                case 4 :
                    $modelTablaEstCotizacion = new TablaEstCotizacionDbModel();
                    $modelTablaEstCotizacion->updateEstadoCotizacionById($idCotizacion, 3);
                    break;
                default :
                    $modelTablaCotizacion = new TablaCotizacionDbModelClass();
                    $modelTablaCotizacion->updateEstadoCotizacionByIdCotizacion($idCotizacion, 3);
            }
        }
    }

    function saveMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $ensayos, $lotes) {
        if ($idAreaAnalisis != 4) {
            $fechaInicio = date("Y-m-d");
            $idMuestra = $this->insertMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio);
            if ($idMuestra != false) {
                $this->updateEstadoCotizacion($idCotizacion, $idAreaAnalisis);
                mkdir("docs/muestra/" . $idMuestra, 0777);
                if ($idAreaAnalisis == 4) {
                    mkdir("docs/muestra/" . $idMuestra . "/Estandares", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Informe Final", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Informes Tiempos", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Procotolos", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Solicitud", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Validacion", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Solicitud Analisis", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/OC", 0777);
                } else {
                    mkdir("docs/muestra/" . $idMuestra . "/Informes Cliente", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Soportes", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/Solicitud Analisis", 0777);
                    mkdir("docs/muestra/" . $idMuestra . "/OC", 0777);
                }
                $mue = true;
                if ($lotes != "0") {
                    $lotes = json_decode($lotes, true);
                    $lot = false;
                    ;
                    for ($i = 0; $i < count($lotes); $i++) {
                        $idLote = $this->insertLote($idMuestra, $i, $lotes[$i]['Tamaño de lote'], $lotes[$i]['Número de lote'], $lotes[$i]['Cantidad enviada por lotes'], 1);
                        if ($idLote != false) {
                            $lot = true;
                        } else {
                            $lot = false;
                            break;
                        }
                    }
                } else {
                    $lot = true;
                }

                if ($ensayos != "0") {
                    $ensayos = json_decode($ensayos, true);
                    $ens = false;
                    for ($i = 0; $i < count($ensayos); $i++) {
                        $idEnsayo = $this->insertEnsayos($idMuestra, $ensayos[$i]['Cod. Paquete'], $ensayos[$i]['idEnsayo'], $ensayos[$i]['Seleccione'], $ensayos[$i]['Área de análisis'], $ensayos[$i]['Tiempo'], $ensayos[$i]['Duración'], 1, $ensayos[$i]['idMetodo']);

                        if ($idEnsayo != false) {
                            $ens = true;
                        } else {
                            $ens = false;
                            break;
                        }
                    }
                } else {
                    $ens = true;
                }
            } else {
                $mue = false;
            }
            if ($mue == true && $lot == treu && $ens == true) {
                //aca se borran los registros que se hallan creado asociados a la tarea.
                $tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                $tablaHistoricoEstadoMuestraModel->insertHistoricoEstadoMuestra($idMuestra, 1, $_SESSION['userId']);
                $response = array('result' => '1', 'message' => 'se ha registrado la muestra exitosamente con Número: ' . $idMuestra);
                echo json_encode($response);
            } else {

                $response = array('result' => '0', 'message' => 'El registro de muestra ha fallado verifique los datos dilengenciados e intentelo nuevamente');
                echo json_encode($response);
            }
        } else {
            $fechaInicio = date("Y-m-d");
            $idMuestra = $this->insertMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio);
            if ($idMuestra != false) {
                $this->updateEstadoCotizacion($idCotizacion, $idAreaAnalisis);
                mkdir("docs/muestra/" . $idMuestra, 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Estandares", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Informe Final", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Informes Tiempos", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Procotolos", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Solicitud", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Validacion", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/Solicitud Analisis", 0777);
                mkdir("docs/muestra/" . $idMuestra . "/OC", 0777);

                $ensayos = json_decode($ensayos, true);
                $insertEnsayos = $this->insertEnsayosMuestraEst($idMuestra, $ensayos, $tipoEstabilidad, $duracion);
                if ($insertEnsayos == true) {
                    if ($lotes != "0") {
                        $lotes = json_decode($lotes, true);
                        $lot = false;

                        for ($i = 0; $i < count($lotes); $i++) {
                            $idLote = $this->insertLote($idMuestra, $i, $lotes[$i]['Tamaño de lote'], $lotes[$i]['Número de lote'], $lotes[$i]['Cantidad enviada por lotes'], 1);
                            if ($idLote != false) {
                                $lot = true;
                            } else {
                                $lot = false;
                                break;
                            }
                        }
                    } else {
                        $lot = true;
                    }
                    if ($lot == true) {
                        $tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                        $tablaHistoricoEstadoMuestraModel->insertHistoricoEstadoMuestra($idMuestra, 1, $_SESSION['userId']);
                        $response = array('result' => '1', 'message' => 'se ha registrado la muestra exitosamente con Número: ' . $idMuestra);
                        echo json_encode($response);
                    } else {
                        //Fallo insertar lotes
                    }
                } else {
                    //fallo insertar Ensayos
                }
            } else {
                // Fallo insertar la muestra basica
            }
        }
    }

    function updateMuestra($idMuestra, $activa, $prioirdad, $cotizacion, $remision, $fechaLlegada, $fechaCompromiso, $idTercero, $idContacto, $areaContacto, $laboratorio, $procedencia, $numeroInfo, $observaciones, $areaAnalisis, $tipoEstabilidad, $coordArea, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $esfacturable, $numFactura, $descuento, $cantidad, $anticipo, $saldo, $infoLotes, $infoEnsayos) {
        $tablaMuestra = new TablaMuestraDbModelClass();
        $update = $tablaMuestra->updateMuestra($idMuestra, $activa, $prioirdad, $cotizacion, $remision, $fechaLlegada, $fechaCompromiso, $idTercero, $idContacto, $areaContacto, $laboratorio, $procedencia, $numeroInfo, $observaciones, $areaAnalisis, $tipoEstabilidad, $coordArea, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $esfacturable, $numFactura, $descuento, $cantidad, $anticipo, $saldo);
        if ($update == true) {
            if ($this->updateLotesByIdMuestra($idMuestra, $infoLotes)) {
                if ($this->updateEnsayosByIdMuestra($idMuestra, $areaAnalisis, $infoEnsayos, $tipoEstabilidad, $duracion)) {
                    $response = array('result' => '1', 'message' => 'la muestra numero ' . $idMuestra . ' se a actualizado correctamente');
                    echo json_encode($response);
                } else {
                    $response = array('result' => '0', 'message' => 'fallo la actualizacion de los ensayos asignados a la muestra');
                    echo json_encode($response);
                }
            } else {
                $response = array('result' => '0', 'message' => 'fallo la actualizacion de los lotes asignados a la muestra');
                echo json_encode($response);
            }
        } else {
            $response = array('result' => '0', 'message' => 'fallo la actualizacion de la muestra');
            echo json_encode($response);
        }
    }

    function saveAlmacenamiento($idMuestra, $fecha, $idUbicacion, $idTipoAlmacenamiento, $nivel, $caja, $tiempo, $fechaSalida, $peso, $observaciones) {

        $old = AuditoriaController::getFullMuestraToAud($idMuestra);

        $tablaAlmacenamiento = new TablaAlmacenamientoDbModelClass();
        $result = $tablaAlmacenamiento->insertAlamacenamiento($idMuestra, $fecha, $idUbicacion, $idTipoAlmacenamiento, $nivel, $caja, $tiempo, $fechaSalida, $peso, $observaciones);

        if ($result !== false) {
            $generalController = new GeneralController();
            if ($idTipoAlmacenamiento == 2) {
                $generalController->updateEstadoByIdMuestra($idMuestra, 10, null);
            }

            $new = AuditoriaController::getFullMuestraToAud($idMuestra);
            AuditoriaController::insertMuestraAud($old, $new, $idMuestra, "update", "Registro de almacenamiento");

            $response = array('result' => '1', 'message' => 'Se ha creado exitosamente el almacenamiento para la muestra' . $idMuestra);
            echo json_encode($response);
        } else {
            $response = array('result' => '0', 'message' => 'Fallo en la creación del almacenamiento');
            echo json_encode($response);
        }
    }

    function deleteAlmacenamiento($idAlmacenamiento) {
        $tablaAlmacenamiento = new TablaAlmacenamientoDbModelClass();
        $rta = $tablaAlmacenamiento->getMuestraByIdAlmacenamiento($idAlmacenamiento);
        $idMuestra = $rta["data"][0][0];

        $old = AuditoriaController::getFullMuestraToAud($idMuestra);
        $result = $tablaAlmacenamiento->deleteAlmacenamiento($idAlmacenamiento);
        if ($result !== false) {
            $new = AuditoriaController::getFullMuestraToAud($idMuestra);
            AuditoriaController::insertMuestraAud($old, $new, $idMuestra, "delete", "Eliminación de almacenamiento");

            $response = array('result' => '1', 'message' => 'Se ha borrado exitosamente el alamacenamiento ' . $idAlmacenamiento);
            echo json_encode($response);
        } else {
            $response = array('result' => '0', 'message' => 'fallo el borrado del almacenamiento ' . $idAlmacenamiento);
            echo json_encode($response);
        }
    }

    function scanDirByIdMuestra($idMuestra) {

        $utilController = new UtilsController();

        $realIdMuestra = $utilController->getRealIdMuestra($idMuestra);

        $muestra = Muestra::find($realIdMuestra);
        
         if ($realIdMuestra) { 
            $muestra = Muestra::find($realIdMuestra); 
            $auxIdMuestra = $muestra->prefijo . $_SESSION["systemsParameters"]["prefixMuestraSeparator"] . $muestra->custom_id; 
        } else { 
            $realIdMuestra = $utilController->getRealIdMuestraEstabilidad($idMuestra); 
            $muestra = EstMuestra::find($realIdMuestra); 
            $muestra->tipoMuestra; 
            $auxIdMuestra = $muestra->tipoMuestra->prefijo . $_SESSION["systemsParameters"]["prefixMuestraSeparator"] . $muestra->custom_id; 
        } 

        

        $dir = "docs/muestra/" . $auxIdMuestra;
        $dirContent = scandir($dir);

        if ($dirContent) {
            $prinScanDir[] = array(
                "id" => "docs/muestra/" . $auxIdMuestra,
                "parentid" => "-1",
                "text" => "Muestra " . $auxIdMuestra,
                "value" => "docs/muestra/" . $auxIdMuestra,
                "icon" => "views/images/iconMuestra.png"
            );
            foreach ($dirContent as $file) {
                if ($file != "." && $file != "..") {
                    if (is_dir("docs/muestra/" . $auxIdMuestra . "/" . $file)) {
                        $icon = "views/images/folder.png";
                        $sub1 = $this->genericScanDir("docs/muestra/" . $auxIdMuestra . "/" . $file, "docs/muestra/" . $auxIdMuestra . "/" . $file);
                        if ($sub1 != null) {
                            $prinScanDir = array_merge($prinScanDir, $sub1);
                        }
                    } else {
                        $icon = "views/images/file_icon.png";
                    }
                }

                if ($file != "." && $file != "..") {
                    $scanDir[] = array(
                        "id" => "docs/muestra/" . $auxIdMuestra . "/" . $file,
                        "parentid" => "docs/muestra/" . $auxIdMuestra,
                        "text" => $file,
                        "value" => "docs/muestra/" . $auxIdMuestra . "/" . $file,
                        "icon" => $icon
                    );
                    $prinScanDir = array_merge($prinScanDir, $scanDir);
                }
            }

            $data = ($prinScanDir);
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $data
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
            );
        }

        echo json_encode($response);
    }

    function genericScanDir($parent, $location) {
        $subDirContent = scandir($location);
        $array[] = array();
        foreach ($subDirContent as $subFile) {
            if ($subFile != "." && $subFile != "..") {
                $subLocation = $location . "/" . $subFile;
                if (is_dir($subLocation)) {
                    $icon = "views/images/folder.png";
                    $currentClass = new MuestraController();
                    $sub1 = $currentClass->genericScanDir($location . "/" . $subFile, $subLocation);
                    $currentClass = null;
                    if ($sub1 != null) {
                        $array = array_merge($array, $sub1);
                    }
                } else {
                    $icon = "views/images/file_icon.png";
                }
            }

            if ($subFile != "." && $subFile != "..") {
                $array[] = array(
                    "id" => $location . "/" . $subFile,
                    "parentid" => $parent,
                    "text" => $subFile,
                    "value" => $location . "/" . $subFile,
                    "icon" => $icon
                );
            }
        }
        return $array;
    }

    function createNewFolderByLocation($location, $newFolderName) {
        if (mkdir($location . "/" . $newFolderName, 0777)) {
            $response = array('result' => '1', 'message' => 'Se ha creado exitosamente la carpeta ' . $newFolderName);
            echo json_encode($response);
        } else {
            $response = array('result' => '0', 'message' => 'Fallo en la creación de la carpeta ' . $newFolderName);
            echo json_encode($response);
        }
    }

    function deleteFileOrFolder($location) {
        if (is_dir($location)) {
            if (rmdir($location)) {
                $response = array('result' => '1', 'message' => 'Se ha borrado exitosamente la carpeta');
                echo json_encode($response);
            } else {
                $response = array('result' => '0', 'message' => 'Fallo el borrado de la carpeta');
                echo json_encode($response);
            }
        } else {
            if (unlink($location)) {
                $response = array('result' => '1', 'message' => 'Se ha borrado exitosamente el archivo');
                echo json_encode($response);
            } else {
                $response = array('result' => '0', 'message' => 'Fallo el borrado del archivo');
                echo json_encode($response);
            }
        }
    }

    function uploadFile($location) {
        $target_dir = $location . "/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Check file size
//        if ($_FILES["fileToUpload"]["size"] > 500000) {
//            echo "Sorry, your file is too large.";
//            $uploadOk = 0;
//        }
// Allow certain file formats
//        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//            $uploadOk = 0;
//        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    function saveMuestra2($muestraData) {
        switch ($muestraData["idAreaAnalisis"]) {
            case 1:
                $this->saveMuestraFQ($muestraData);
                break;
            case 2:
                $this->saveMuestraMic($muestraData);
                break;
            case 4:
                $this->saveMuestraEst($muestraData);

            default:
                break;
        }
    }

    function saveMuestraEst($muestraData) {
        $insertMuestra = $this->insertMuestra2($muestraData);
        if ($insertMuestra["code"] === "0") {
            if ($this->createMuestraEstFolders($insertMuestra["data"]["prefijo"] . "-" . $insertMuestra["data"]["customIdMuestra"])) {
                if ($this->saveEnsayosEstabilidad($muestraData, $insertMuestra["data"]["idMuestra"])) {

                    $insertLote = $this->insertLote($insertMuestra["data"]["idMuestra"], 1, $muestraData["tamanoLote"], $muestraData["numeroLote"], $muestraData["cantidadLote"], 1);
                    if ($insertLote) {
                        $tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                        $insertHistoricoMuestra = $tablaHistoricoEstadoMuestraModel->insertHistoricoEstadoMuestra($insertMuestra["data"]["idMuestra"], 1, $_SESSION['userId']);
                        if ($insertHistoricoMuestra) {

                            $response = array(
                                "code" => "00000",
                                "message" => "registro exitoso de la muestra",
                                "data" => array(
                                    "idMuestra" => $insertMuestra["data"]
                                )
                            );
                        } else {
                            $response = array(
                                "code" => "RM-ITHM-00001",
                                "message" => "error en insert de la tabla sgm_historico_muestra",
                                "data" => array(
                                    "idMuestra" => $idMuestra["data"]
                                )
                            );
                        }
                    }
                } else {
                    
                }
            } else {
                $response = array(
                    "code" => "1",
                    "message" => "Error al crear las carpetas aosciadas a la muestra " . $insertMuestra["data"]["prefijo"] . "-" . $insertMuestra["data"]["customIdMuestra"],
                    "data" => $insertMuestra
                );
            }
        } else {
            $response = $insertMuestra;
        }
        echo json_encode($response);
    }

    function saveEnsayosEstabilidad($muestraData, $idMuestra) {

        $ensayos = $muestraData["ensayos"];
        $modelProductoEnsayo = new TablaProductoEnsayoDbModelClass();
        $modelEstTiemposEnsMue = new TablaEstTiemposEnsMueDbModelClass();
        foreach ($muestraData["ensayos"] as $keyDuracion => $valueDuracion) {
            foreach ($valueDuracion["paquetes"] as $keyPaquete => $valuePaquete) {
                foreach ($valuePaquete["ensayos"] as $keyEnsayo => $valueEnsayo) {
                    $dataMetodo = $modelProductoEnsayo->getProductoEnsayoByProductoPaqueteEnsayo($valueEnsayo["idProducto"], $valueEnsayo["idPaquete"], $valueEnsayo["idEnsayo"]);
                    $idMetodo = $dataMetodo[0]["id_metodo"];
                    foreach ($valueEnsayo["temperaturas"] as $keyTemperatura => $valueTemperatura) {

                        $intervalo = "P" . $valueDuracion["cantidadMes"] . "M";
                        $fechaProgramacion = new DateTime();
                        $fechaProgramacion = $fechaProgramacion->add(new DateInterval($intervalo));
                        $valueTemperatura == "true" ? $validacion = 1 : $validacion = 0;
                        $idEnsMue = $this->insertEnsayosEst($idMuestra, $valueEnsayo["idPaquete"], $valueEnsayo["idEnsayo"], $validacion, $valueEnsayo["nomAreaAnalisis"], $valueEnsayo["duracion"], $valueEnsayo["duracion"], 1, $idMetodo, $fechaProgramacion->format('Y-m-d'));

                        $idSubMuestra = $this->getSubMuestraByIdMuestraAndMes($idMuestra, $valueDuracion["name"], $fechaProgramacion);

                        if ($keyTemperatura == "t0") {
                            $temperatura = "30ºC-65%HR";
                        } else if ($keyTemperatura == "t1") {
                            $temperatura = "30ºC-75%HR";
                        } else if ($keyTemperatura == "t2") {
                            $temperatura = "40ºC-75%HR";
                        } else if ($keyTemperatura == "t3") {
                            $temperatura = "50°C-80%HR";
                        }
                        $auxDescripcion = $valueEnsayo["nomEnsayo"] . " " . $valueDuracion["name"] . " " . $temperatura;
                        $modelEstTiemposEnsMue->insertEstTiemposEnsMue($idEnsMue, $keyDuracion . $keyTemperatura, $validacion, $auxDescripcion, $idSubMuestra);
                    }
                }
            }
        }
        return true;
    }

    function saveMuestraFQ($muestraData) {
        $custom = new CustomController();
        $muestraData = $custom->generarPrefijo($muestraData);
        
        $insertMuestra = $this->insertMuestra2($muestraData);
        if ($insertMuestra["code"] === "0") {
            // registrar detalle de muestra microbiologica
            $registroDetalleMuestraMic = $this->registrarDetMuestraMic($insertMuestra["data"]["idMuestra"], $muestraData);
            if (true) {
                if ($this->createMuestraMicFolders($insertMuestra["data"]["prefijo"] . "-" . $insertMuestra["data"]["customIdMuestra"]) && $this->createqrCode($insertMuestra["data"]["idMuestra"])) {
                    // registrar lote
                    $insertLote = $this->insertLote($insertMuestra["data"]["idMuestra"], 1, $muestraData["tamanoLote"], $muestraData["numeroLote"], $muestraData["cantidadLote"], 1);
                    if ($insertLote) {
                        // registrar ensayos
                        foreach ($muestraData["ensayos"] as $ensayo) {
                            $insertEnsayo = $this->insertEnsayos($insertMuestra["data"]["idMuestra"], $ensayo["idPaquete"], $ensayo["idEnsayo"], $ensayo["validacion"], $ensayo["nomAreaAnalisis"], $ensayo["tiempo"], $ensayo["duracion"], 1, $ensayo["idMetodo"], $ensayo["especificacion"], $ensayo["nomEnsayo"], $ensayo["idHojaCalculo"], $ensayo["valor"]);
                            //Insertar condiciones cromatográficas, estándares y reactivos
                            $insertCondiciones = $this->insertCondicionesEstandaresReactivos($insertEnsayo, $ensayo["idProductoEnsayo"]);

                            if (!$insertEnsayo) {
                                break;
                            }
                        }
                        if ($insertEnsayo) {
                            // Registrar historico de muestra
                            $tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                            $insertHistoricoMuestra = $tablaHistoricoEstadoMuestraModel->insertHistoricoEstadoMuestra($insertMuestra["data"]["idMuestra"], 1, $_SESSION['userId']);
                            if ($insertHistoricoMuestra) {

                                $old = null;
                                $new = AuditoriaController::getFullMuestraToAud($insertMuestra["data"]["idMuestra"]);
                                AuditoriaController::insertMuestraAud($old, $new, $insertMuestra["data"]["idMuestra"], "create", "Registro de muestra");

                                // Actualizar estado de la cotizacion
                                $response = array(
                                    "code" => "00000",
                                    "message" => "registro exitoso de la muestra",
                                    "data" => array(
                                        "idMuestra" => $insertMuestra["data"]
                                    )
                                );
                            } else {
                                $response = array(
                                    "code" => "RM-ITHM-00001",
                                    "message" => "error en insert de la tabla sgm_historico_muestra",
                                    "data" => array(
                                        "idMuestra" => $idMuestra["data"]
                                    )
                                );
                            }
                        } else {
                            $response = array(
                                "code" => "RM-ITEM-00001",
                                "message" => "error en insert de la tabla sgm_ensayo_muestra",
                                "data" => array(
                                    "idMuestra" => $idMuestra["data"]
                                )
                            );
                        }
                    } else {
                        $response = array(
                            "code" => "RM-ITL-00001",
                            "message" => "Error en insert de la tabla sgm_lote",
                            "data" => array(
                                "idMuestra" => $idMuestra["data"]
                            )
                        );
                    }
                } else {
                    $response = array(
                        "code" => "RM-CMF-00001",
                        "message" => "Error al crear las carpetas asociadas a la muestra",
                        "data" => array(
                            "idMuestra" => $idMuestra["data"]
                        )
                    );
                }
            } else {
                // anular muestra
                $response = array(
                    "code" => "RM-RDMM-00001",
                    "message" => "error al registrar los detalles de muestra microbiologica",
                    "data" => $registroDetalleMuestraMic
                );
            }
        } else {
            $response = $idMuestra;
        }
        echo json_encode($response);
    }

    function saveMuestraMic($muestraData) {
        $insertMuestra = $this->insertMuestra2($muestraData);
        if ($insertMuestra["code"] === "0") {
            // registrar detalle de muestra microbiologica
            $registroDetalleMuestraMic = $this->registrarDetMuestraMic($insertMuestra["data"]["idMuestra"], $muestraData);
            if ($registroDetalleMuestraMic["code"] === "0") {
                if ($this->createMuestraMicFolders($insertMuestra["data"]["prefijo"] . "-" . $insertMuestra["data"]["customIdMuestra"])) {
                    // registrar lote
                    $insertLote = $this->insertLote($insertMuestra["data"]["idMuestra"], 1, $muestraData["tamanoLote"], $muestraData["numeroLote"], $muestraData["cantidadLote"], 1);
                    if ($insertLote) {
                        // registrar ensayos
                        foreach ($muestraData["ensayos"] as $ensayo) {
                            $insertEnsayo = $this->insertEnsayos($insertMuestra["data"]["idMuestra"], $ensayo["idPaquete"], $ensayo["idEnsayo"], $ensayo["validacion"], $ensayo["nomAreaAnalisis"], $ensayo["tiempo"], $ensayo["duracion"], 1, $ensayo["idMetodo"], $ensayo["especificacion"], $ensayo["nomEnsayo"]);
                            if (!$insertEnsayo) {
                                break;
                            }
                        }
                        if ($insertEnsayo) {
                            // Registrar historico de muestra
                            $tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                            $insertHistoricoMuestra = $tablaHistoricoEstadoMuestraModel->insertHistoricoEstadoMuestra($insertMuestra["data"]["idMuestra"], 1, $_SESSION['userId']);
                            if ($insertHistoricoMuestra) {
                                // Actualizar estado de la cotizacion
                                $response = array(
                                    "code" => "00000",
                                    "message" => "registro exitoso de la muestra",
                                    "data" => array(
                                        "idMuestra" => $insertMuestra["data"]
                                    )
                                );
                            } else {
                                $response = array(
                                    "code" => "RM-ITHM-00001",
                                    "message" => "error en insert de la tabla sgm_historico_muestra",
                                    "data" => array(
                                        "idMuestra" => $idMuestra["data"]
                                    )
                                );
                            }
                        } else {
                            $response = array(
                                "code" => "RM-ITEM-00001",
                                "message" => "error en insert de la tabla sgm_ensayo_muestra",
                                "data" => array(
                                    "idMuestra" => $idMuestra["data"]
                                )
                            );
                        }
                    } else {
                        $response = array(
                            "code" => "RM-ITL-00001",
                            "message" => "Error en insert de la tabla sgm_lote",
                            "data" => array(
                                "idMuestra" => $idMuestra["data"]
                            )
                        );
                    }
                } else {
                    $response = array(
                        "code" => "RM-CMF-00001",
                        "message" => "Error al crear las carpetas asociadas a la muestra",
                        "data" => array(
                            "idMuestra" => $idMuestra["data"]
                        )
                    );
                }
            } else {
                // anular muestra
                $response = array(
                    "code" => "RM-RDMM-00001",
                    "message" => "error al registrar los detalles de muestra microbiologica",
                    "data" => $registroDetalleMuestraMic
                );
            }
        } else {
            $response = $idMuestra;
        }
        echo json_encode($response);
    }

    function updateMuestra2($muestraData) {
        switch ($muestraData["idAreaAnalisis"]) {
            case 1:
                $this->updateupdateMuestraFQ($muestraData);
                break;
            case 2:
                $this->updateMuestraMic($muestraData);
                break;

            default:
                break;
        }
    }

    function updateupdateMuestraFQ($muestraData) {
        $modelMuestra = new TablaMuestraDbModelClass();
//        if ($_SESSION["systemsParameters"]["customIdMuestra"] = "true") {
//            $customIdMuestra = strtoupper($muestraData["idMuestra"]);
//            $parameters = explode("-", $customIdMuestra);
//            $data = $modelMuestra->getRealIdMuestra($parameters[0], $parameters[1]);
//            $realIdMuestra = $data[0]["id"];
//        } else {
//            $realIdMuestra = $muestraData["idMuestra"];
//        }
        $utilController = new UtilsController();
        $realIdMuestra = $utilController->getRealIdMuestra($muestraData["idMuestra"]);
        $muestraData["realIdMuestra"] = $realIdMuestra;

        $old = AuditoriaController::getFullMuestraToAud($realIdMuestra);

        $resultUpdateBasicMuestra = $this->updateBasicMuestra2($muestraData);
        if ($resultUpdateBasicMuestra["code"] === "00000") {

            $tablaMuestraDetalleMic = new TablaMuestraDetalleMicDbModelClass();
            $resultMuestraDetalleMic = $tablaMuestraDetalleMic->getMuestraDetalleMicByIdMuestra($muestraData["realIdMuestra"]);
            //$idDetalleMuestraMic = $resultMuestraDetalleMic["data"][0]["id"];
            //$tablaTecnicUsada = new TablaTecnicaUsadaMuestraMicDbModelClass();
            //$resultDeleteTecnicas = $tablaTecnicUsada->deleteTecnicasUsadasByIdDetalleMuestraMic($idDetalleMuestraMic);
            if ($resultMuestraDetalleMic["code"] == "00000") {
                $resultUpdateMuestraDetalleMic = $tablaMuestraDetalleMic->updateMuestraDetalleMicByIdMuestra($muestraData["fechaMuestreo"], $muestraData["idAreaMicrobiologica"], $muestraData["planta"], $muestraData["sanitizante"], $muestraData["frotis"], $muestraData["espAerobiosMesofilos"], $muestraData["espMohosLevaduras"], $muestraData["EstabilidadMic"], $muestraData["plantaArea"], $muestraData["plantaTecnicaUsada"], $muestraData["responsableToma"], $muestraData["superficieEquipo"], $muestraData["espEColi"], $muestraData["puntoToma"], $muestraData["realIdMuestra"]);
                if ($resultUpdateMuestraDetalleMic["code"] == "00000") {
                    // foreach ($muestraData["tecnicaUsada"] as $tecnicaUsada) {
                    //     $insertTecnicaUsada = $this->registrarTecnicasUsadasMuestraMic($idDetalleMuestraMic, $tecnicaUsada);
                    //     if ($insertTecnicaUsada["code"] !== "0") {
                    //         break;
                    //     }
                    // }
                    if (true) {
                        $tablaLote = new TablaLoteDbModelClass();
                        $resultUpdateLote = $tablaLote->updateLoteByIdMuestra(1, $muestraData["tamanoLote"], $muestraData["numeroLote"], $muestraData["cantidadLote"], $muestraData["realIdMuestra"]);
                        if ($resultUpdateLote["code"] == "00000") {
                            $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                            $resultDeleteEnsayoMuestra = $tablaEnsayoMuestra->deleteEnsayosByIdMuestra2($muestraData["realIdMuestra"]);
                            if ($resultDeleteEnsayoMuestra["code"] == "00000") {
                                foreach ($muestraData["ensayos"] as $ensayo) {
                                    $insertEnsayo = $this->insertEnsayos($muestraData["realIdMuestra"], $ensayo["idPaquete"], $ensayo["idEnsayo"], $ensayo["validacion"], $ensayo["nomAreaAnalisis"], $ensayo["tiempo"], $ensayo["duracion"], 1, $ensayo["idMetodo"], $ensayo["especificacion"], $ensayo["nomEnsayo"], $ensayo["idHojaCalculo"], $ensayo["valor"]);
                                    
                                    $productoPaquete = ProductoPaquete::where("id_producto", $muestraData["idProducto"])
                                        ->where("id_ensayo", $ensayo["idPaquete"])->first();

                                    $productoEnsayo = ProductoEnsayo::where("id_producto_paquete", $productoPaquete->id)
                                        ->where("id_ensayo", $ensayo["idEnsayo"])
                                        ->first();
                                    
                                    $insertCondiciones = $this->insertCondicionesEstandaresReactivos($insertEnsayo, $productoEnsayo->id);
                                    if (!$insertEnsayo) {
                                        break;
                                    }
                                }

                                $new = AuditoriaController::getFullMuestraToAud($realIdMuestra);
                                AuditoriaController::insertMuestraAud($old, $new, $realIdMuestra, "update", "Actualización de muestra");

                                if ($insertEnsayo) {
                                    $response = array(
                                        "code" => "00000",
                                        "message" => "OK",
                                    );
                                } else {
                                    $response = array(
                                        "code" => "PEND",
                                        "message" => "Error al insertar ensayos",
                                        "data" => $insertEnsayo
                                    );
                                }
                            } else {
                                $response = array(
                                    "code" => "PEND",
                                    "message" => "Error al eliminar ensayos",
                                    "data" => $resultDeleteEnsayoMuestra
                                );
                            }
                        } else {
                            $response = array(
                                "code" => "PEND",
                                "message" => "Error al actualizar lote",
                                "data" => $resultUpdateLote
                            );
                        }
                    } else {
                        $response = array(
                            "code" => "PEND",
                            "message" => "Error al insertar tenicas usadas",
                            "data" => $insertTecnicaUsada
                        );
                    }
                } else {
                    $response = array(
                        "code" => "PEND",
                        "message" => "Error al eliminar detalle muestra mic",
                        "data" => $resultUpdateBasicMuestra
                    );
                }
            } else {
                $response = array(
                    "code" => "PEND",
                    "message" => "Error al eliminar tecnicas usadas",
                    "data" => $resultUpdateBasicMuestra
                );
            }
        } else {
            $response = array(
                "code" => "PEND",
                "message" => "Error al actualizar los datos bassicos de la muestra",
                "data" => $resultUpdateBasicMuestra
            );
        }

        echo json_encode($response);
    }

    function updateMuestraMic($muestraData) {
        $modelMuestra = new TablaMuestraDbModelClass();
//        if ($_SESSION["systemsParameters"]["customIdMuestra"] = "true") {
//            $customIdMuestra = strtoupper($muestraData["idMuestra"]);
//            $parameters = explode("-", $customIdMuestra);
//            $data = $modelMuestra->getRealIdMuestra($parameters[0], $parameters[1]);
//            $realIdMuestra = $data[0]["id"];
//        } else {
//            $realIdMuestra = $muestraData["idMuestra"];
//        }
//        $muestraData["realIdMuestra"] = $realIdMuestra;

        $utilController = new UtilsController();
        $realIdMuestra = $utilController->getRealIdMuestra($muestraData["idMuestra"]);
        $muestraData["realIdMuestra"] = $realIdMuestra;



        $resultUpdateBasicMuestra = $this->updateBasicMuestra2($muestraData);
        if ($resultUpdateBasicMuestra["code"] === "00000") {

            $tablaMuestraDetalleMic = new TablaMuestraDetalleMicDbModelClass();
            $resultMuestraDetalleMic = $tablaMuestraDetalleMic->getMuestraDetalleMicByIdMuestra($muestraData["realIdMuestra"]);
            $idDetalleMuestraMic = $resultMuestraDetalleMic["data"][0]["id"];
            $tablaTecnicUsada = new TablaTecnicaUsadaMuestraMicDbModelClass();
            $resultDeleteTecnicas = $tablaTecnicUsada->deleteTecnicasUsadasByIdDetalleMuestraMic($idDetalleMuestraMic);
            if ($resultDeleteTecnicas["code"] == "00000") {
                $resultUpdateMuestraDetalleMic = $tablaMuestraDetalleMic->updateMuestraDetalleMicByIdMuestra($muestraData["fechaMuestreo"], $muestraData["idAreaMicrobiologica"], $muestraData["planta"], $muestraData["sanitizante"], $muestraData["frotis"], $muestraData["espAerobiosMesofilos"], $muestraData["espMohosLevaduras"], $muestraData["EstabilidadMic"], $muestraData["plantaArea"], $muestraData["plantaTecnicaUsada"], $muestraData["responsableToma"], $muestraData["superficieEquipo"], $muestraData["espEColi"], $muestraData["puntoToma"], $muestraData["realIdMuestra"]);
                if ($resultUpdateMuestraDetalleMic["code"] == "00000") {
                    foreach ($muestraData["tecnicaUsada"] as $tecnicaUsada) {

                        $insertTecnicaUsada = $this->registrarTecnicasUsadasMuestraMic($idDetalleMuestraMic, $tecnicaUsada);
                        if ($insertTecnicaUsada["code"] !== "0") {
                            break;
                        }
                    }
                    if ($insertTecnicaUsada["code"] == "0") {
                        $tablaLote = new TablaLoteDbModelClass();
                        $resultUpdateLote = $tablaLote->updateLoteByIdMuestra(1, $muestraData["tamanoLote"], $muestraData["numeroLote"], $muestraData["cantidadLote"], $muestraData["realIdMuestra"]);
                        if ($resultUpdateLote["code"] == "00000") {
                            $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                            $resultDeleteEnsayoMuestra = $tablaEnsayoMuestra->deleteEnsayosByIdMuestra2($muestraData["realIdMuestra"]);
                            if ($resultDeleteEnsayoMuestra["code"] == "00000") {
                                foreach ($muestraData["ensayos"] as $ensayo) {
                                    $insertEnsayo = $this->insertEnsayos($muestraData["realIdMuestra"], $ensayo["idPaquete"], $ensayo["idEnsayo"], $ensayo["validacion"], $ensayo["nomAreaAnalisis"], $ensayo["tiempo"], $ensayo["duracion"], 1, $ensayo["idMetodo"], $ensayo["especificacion"], $ensayo["nomEnsayo"]);
                                    if (!$insertEnsayo) {
                                        break;
                                    }
                                }
                                if ($insertEnsayo) {
                                    $response = array(
                                        "code" => "00000",
                                        "message" => "OK",
                                    );
                                } else {
                                    $response = array(
                                        "code" => "PEND",
                                        "message" => "Error al insertar ensayos",
                                        "data" => $insertEnsayo
                                    );
                                }
                            } else {
                                $response = array(
                                    "code" => "PEND",
                                    "message" => "Error al eliminar ensayos",
                                    "data" => $resultDeleteEnsayoMuestra
                                );
                            }
                        } else {
                            $response = array(
                                "code" => "PEND",
                                "message" => "Error al actualizar lote",
                                "data" => $resultUpdateLote
                            );
                        }
                    } else {
                        $response = array(
                            "code" => "PEND",
                            "message" => "Error al insertar tenicas usadas",
                            "data" => $insertTecnicaUsada
                        );
                    }
                } else {
                    $response = array(
                        "code" => "PEND",
                        "message" => "Error al eliminar detalle muestra mic",
                        "data" => $resultUpdateBasicMuestra
                    );
                }
            } else {
                $response = array(
                    "code" => "PEND",
                    "message" => "Error al eliminar tecnicas usadas",
                    "data" => $resultUpdateBasicMuestra
                );
            }
        } else {
            $response = array(
                "code" => "PEND",
                "message" => "Error al actualizar los datos bassicos de la muestra",
                "data" => $resultUpdateBasicMuestra
            );
        }

        echo json_encode($response);
    }

    function updateBasicMuestra2($muestraData) {
        $tablaMuestra = new TablaMuestraDbModelClass();

        return $tablaMuestra->updateMuestra2($muestraData["activa"], $muestraData["prioridad"], $muestraData["cotizacion"], $muestraData["remision"], $muestraData["fechaLlegada"], $muestraData["fechaCompromiso"], $muestraData["idTercero"], $muestraData["idContacto"], $muestraData["areaContacto"], $muestraData["fabricante"], $muestraData["procedencia"], $muestraData["observaciones"], $muestraData["idAreaAnalisis"], 1, 1, $muestraData["idProducto"], $muestraData["idEmpaque"], $muestraData["idEnvase"], $muestraData["fechaFabricacion"], $muestraData["fechaVencimiento"], $muestraData["identificadorCliente"], $muestraData["condicionesGenerales"], $muestraData["realIdMuestra"]);
    }

    function registrarTecnicasUsadasMuestraMic($idMuestraDetalleMic, $tecnicaUsada) {
        $tablaTecnicaUsadaMuestraMic = new TablaTecnicaUsadaMuestraMicDbModelClass();
        $insertTecnicaUsada = $tablaTecnicaUsadaMuestraMic->insertTecnicaUsadaMuestraMic($idMuestraDetalleMic, $tecnicaUsada["id"]);
        return $insertTecnicaUsada;
    }

    function registrarDetMuestraMic($idMuestra, $muestraData) {
        $tablaMuestraDetalleMic = new TablaMuestraDetalleMicDbModelClass();
        $insertMuestraDetalleMic = $tablaMuestraDetalleMic->insertMuestraDetalleMic($idMuestra, $muestraData["fechaMuestreo"], $muestraData["idAreaMicrobiologica"], $muestraData["planta"], $muestraData["sanitizante"], $muestraData["frotis"], $muestraData["espAerobiosMesofilos"], $muestraData["espMohosLevaduras"], $muestraData["EstabilidadMic"], $muestraData["puntoToma"], $muestraData["plantaTecnicaUsada"], $muestraData["responsableToma"], $muestraData["superficieEquipo"], $muestraData["espEColi"], $muestraData["plantaArea"]);
        if ($insertMuestraDetalleMic["code"] === "0") {
            $idMuestraDetalleMic = $insertMuestraDetalleMic["data"]["idMuestraDetalleMic"];
            foreach ($muestraData["tecnicaUsada"] as $tecnicaUsada) {

                $insertTecnicaUsada = $this->registrarTecnicasUsadasMuestraMic($idMuestraDetalleMic, $tecnicaUsada);
                if ($insertTecnicaUsada["code"] !== "0") {
                    return $insertTecnicaUsada;
                }
            }
            $response = array(
                "code" => "0",
                "message" => "Insert muestra detalle mic success",
                "data" => array(
                    "idMuestraDetalleMic" => $idMuestraDetalleMic
                )
            );
        } else {
            $response = $insertMuestraDetalleMic;
        }
        return $response;
    }

    function createqrCode($realIdMuestra) {
        $aux = mkdir("docs/qr/fq/" . $realIdMuestra, 0777);
        if ($aux) {

            $fecha = new DateTime();

            $cliente = SystemParameters::where("propiedad", "cliente")->first();

            $host = SystemParameters::where("propiedad", "urlqr")->first();

            $palabra = $fecha->format('sss') . "-" .$cliente->valor . "-" . $fecha->format('sss') . "-fq-" . $fecha->format('sss') . "-" . $realIdMuestra;

//            $encrypResult = $this->encrypt( $palabra );
            $encrypResult = openssl_encrypt ($palabra, 'aes128', "soulsystem9182");

            $qrString = $host->valor . "?code=" . $encrypResult;


            \PHPQRCode\QRcode::png($qrString, "docs/qr/fq/" . $realIdMuestra . "/qrcode.png", 'L', 4, 2);
        }
        return $aux;
    }

    function encrypt($string) {

        $key = "soulsystem";

        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    function createMuestraMicFolders($idMuestra) {

        $f = mkdir("docs/muestra/" . $idMuestra, 0777);
        $a = mkdir("docs/muestra/" . $idMuestra . "/Informes Cliente", 0777);
        $b = mkdir("docs/muestra/" . $idMuestra . "/Soportes", 0777);
        $c = mkdir("docs/muestra/" . $idMuestra . "/Solicitud", 0777);
        $d = mkdir("docs/muestra/" . $idMuestra . "/OC", 0777);

        if ($a && $b && $c && $d && $f) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function createMuestraEstFolders($idMuestra) {

        $f = mkdir("docs/muestra/" . $idMuestra, 0777);
        $a = mkdir("docs/muestra/" . $idMuestra . "/Informes Cliente", 0777);
        $b = mkdir("docs/muestra/" . $idMuestra . "/Soportes", 0777);
        $c = mkdir("docs/muestra/" . $idMuestra . "/Solicitud Analisis", 0777);
        $d = mkdir("docs/muestra/" . $idMuestra . "/OC", 0777);
        if ($a && $b && $c && $d && $f) {
            $return = true;
        } else {
            $return = false;
        }
        return $return;
    }

    function insertCondicionesEstandaresReactivos($idEnsayoMuestra, $idProductoEnsayo) {
        $resultado = $this->insertEnsayoMuestraEstandarLote($idEnsayoMuestra, $idProductoEnsayo);
        if ($resultado["code"] == "00000") {
            $resultado = $this->insertEnsayoMuestraReactivoLote($idEnsayoMuestra, $idProductoEnsayo);
            if ($resultado["code"] == "00000") {
                $resultado = $this->insertEnsayoMuestraCondicionCromatografica($idEnsayoMuestra, $idProductoEnsayo);
            }
        }
        return $resultado;
    }

    function insertEnsayoMuestraEstandarLote($idEnsayoMuestra, $idProductoEnsayo) {
        $tabla = new TablaProductoEnsayoEstandarDbModelClass();
        $result = $tabla->getEstandarLoteProductoEnsayo($idProductoEnsayo);

        if ($result["code"] == "00000") {
            $tablaEMEstandar = new TablaEnsayoMuestraEstandarLoteDbModelClass();
            foreach ($result["data"] as $estandarLote) {
                $insertEMEstandarLote = $tablaEMEstandar->insertProductoEnsayoEstandar($idEnsayoMuestra
                        , $estandarLote->id_estandar, $estandarLote->id_lote);
                if ($insertEMEstandarLote["code"] !== "00000") {
                    break;
                }
            }
        }
        if ($insertEMEstandarLote) {
            return $insertEMEstandarLote;
        } else {
            return $result;
        }
    }

    function insertEnsayoMuestraReactivoLote($idEnsayoMuestra, $idProductoEnsayo) {
        $tabla = new TablaProductoEnsayoReactivoDbModelClass();
        $result = $tabla->getReactivoLoteProductoEnsayo($idProductoEnsayo);

        if ($result["code"] == "00000") {
            $tablaEMReactivo = new TablaEnsayoMuestraReactivoLoteDbModelClass();
            foreach ($result["data"] as $reactivoLote) {
                $insertEMReactivoLote = $tablaEMReactivo->insertProductoEnsayoReactivo($idEnsayoMuestra
                        , $reactivoLote->id_reactivo, $reactivoLote->id_lote);
                if ($insertEMReactivoLote["code"] !== "00000") {
                    break;
                }
            }
        }
        if ($insertEMReactivoLote) {
            return $insertEMReactivoLote;
        } else {
            return $result;
        }
    }

    function insertEnsayoMuestraCondicionCromatografica($idEnsayoMuestra, $idProductoEnsayo) {
        $tabla = new TablaProductoEnsayoDbModelClass();
        $result = $tabla->getCondicionCromatograficaProductoEnsayo($idProductoEnsayo);

        if ($result["code"] == "00000") {
            $condcromatografica = $result["data"][0]->id_condicion_cromatografica;
            $columna = $result["data"][0]->id_columna;

            if ($condcromatografica !== null || $columna !== null) {
                $tablaEMCondicion = new TablaEnsayoMuestraCondicionCromatograficaDbModelClass();
                $insertEMCondicion = $tablaEMCondicion->insertProductoEnsayoCondicionCromatografica($idEnsayoMuestra
                        , $condcromatografica, $columna);
            }
        }
        if ($insertEMCondicion) {
            return $insertEMCondicion;
        } else {
            return $result;
        }
    }

    function scanDirByIdReactivo($nombreReactivo, $idReactivo) {
        $dir = "docs/reactivo/" . $idReactivo;
        $dirContent = scandir($dir);
        $prinScanDir[] = array(
            "id" => "docs/reactivo/" . $idReactivo,
            "parentid" => "-1",
            "text" => "Reactivo " . $nombreReactivo,
            "value" => "docs/reactivo/" . $idReactivo,
            "icon" => "views/images/iconMuestra.png"
        );
        foreach ($dirContent as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("docs/reactivo/" . $idReactivo . "/" . $file)) {
                    /* $icon = "views/images/folder.png";
                      $sub1 = $this->genericScanDir("docs/reactivo/" . $idReactivo . "/" . $file, "docs/reactivo/" . $idReactivo . "/" . $file);
                      if ($sub1 != null) {
                      $prinScanDir = array_merge($prinScanDir, $sub1);
                      } */
                } else {
                    $icon = "views/images/file_icon.png";
                    $scanDir[] = array(
                        "id" => "docs/reactivo/" . $idReactivo . "/" . $file,
                        "parentid" => "docs/reactivo/" . $idReactivo,
                        "text" => $file,
                        "value" => "docs/reactivo/" . $idReactivo . "/" . $file,
                        "icon" => $icon
                    );
                    $prinScanDir = array_merge($prinScanDir, $scanDir);
                }
            }
        }

        echo json_encode($prinScanDir);
    }

    function uploadFileReactivo($locationReactivo) {
        $target_dir = $locationReactivo;
        $target_file = $target_dir . "/" . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    function deleteFile($location) {
        if (unlink($location)) {
            $response = array('result' => '0', 'message' => 'Se ha borrado exitosamente el archivo');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo el borrado del archivo');
            echo json_encode($response);
        }
    }

    function scanDirByIdLoteReactivo($numeroLote, $idLoteReactivo, $idReactivo) {
        $dir = "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo;
        $dirContent = scandir($dir);
        $prinScanDir[] = array(
            "id" => "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo,
            "parentid" => "-1",
            "text" => "Lote reactivo " . $numeroLote,
            "value" => "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo,
            "icon" => "views/images/iconMuestra.png"
        );
        foreach ($dirContent as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo . "/" . $file)) {
                    $icon = "views/images/folder.png";
                    $sub1 = $this->genericScanDir("docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo . "/" . $file, "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo . "/" . $file);
                    if ($sub1 != null) {
                        $prinScanDir = array_merge($prinScanDir, $sub1);
                    }
                } else {
                    $icon = "views/images/file_icon.png";
                }
            }

            if ($file != "." && $file != "..") {
                $scanDir[] = array(
                    "id" => "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo . "/" . $file,
                    "parentid" => "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo,
                    "text" => $file,
                    "value" => "docs/reactivo/" . $idReactivo . "/" . $idLoteReactivo . "/" . $file,
                    "icon" => $icon
                );
                $prinScanDir = array_merge($prinScanDir, $scanDir);
            }
        }

        echo json_encode($prinScanDir);
    }

    function scanDirByIdEstandar($nombreEstandar, $idEstandar) {
        $dir = "docs/estandar/" . $idEstandar;
        $dirContent = scandir($dir);
        $prinScanDir[] = array(
            "id" => "docs/estandar/" . $idEstandar,
            "parentid" => "-1",
            "text" => "Estandar " . $nombreEstandar,
            "value" => "docs/estandar/" . $idEstandar,
            "icon" => "views/images/iconMuestra.png"
        );
        foreach ($dirContent as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("docs/estandar/" . $idEstandar . "/" . $file)) {
                    /* $icon = "views/images/folder.png";
                      $sub1 = $this->genericScanDir("docs/estandar/" . $idEstandar . "/" . $file, "docs/estandar/" . $idEstandar . "/" . $file);
                      if ($sub1 != null) {
                      $prinScanDir = array_merge($prinScanDir, $sub1);
                      } */
                } else {
                    $icon = "views/images/file_icon.png";
                    $scanDir[] = array(
                        "id" => "docs/estandar/" . $idEstandar . "/" . $file,
                        "parentid" => "docs/estandar/" . $idEstandar,
                        "text" => $file,
                        "value" => "docs/estandar/" . $idEstandar . "/" . $file,
                        "icon" => $icon
                    );
                    $prinScanDir = array_merge($prinScanDir, $scanDir);
                }
            }
        }

        echo json_encode($prinScanDir);
    }

    function scanDirByIdLoteEstandar($numeroLote, $idLoteEstandar, $idEstandar) {
        $dir = "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar;
        $dirContent = scandir($dir);
        $prinScanDir[] = array(
            "id" => "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar,
            "parentid" => "-1",
            "text" => "Lote estandar " . $numeroLote,
            "value" => "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar,
            "icon" => "views/images/iconMuestra.png"
        );
        foreach ($dirContent as $file) {
            if ($file != "." && $file != "..") {
                if (is_dir("docs/estandar/" . $idEstandar . "/" . $idLoteEstandar . "/" . $file)) {
                    $icon = "views/images/folder.png";
                    $sub1 = $this->genericScanDir("docs/estandar/" . $idEstandar . "/" . $idLoteEstandar . "/" . $file, "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar . "/" . $file);
                    if ($sub1 != null) {
                        $prinScanDir = array_merge($prinScanDir, $sub1);
                    }
                } else {
                    $icon = "views/images/file_icon.png";
                }
            }

            if ($file != "." && $file != "..") {
                $scanDir[] = array(
                    "id" => "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar . "/" . $file,
                    "parentid" => "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar,
                    "text" => $file,
                    "value" => "docs/estandar/" . $idEstandar . "/" . $idLoteEstandar . "/" . $file,
                    "icon" => $icon
                );
                $prinScanDir = array_merge($prinScanDir, $scanDir);
            }
        }

        echo json_encode($prinScanDir);
    }

    function scanDirByIdColumna($nombreColumna, $idColumna) {
        $dir = "docs/columna/" . $idColumna;
        $dirContent = scandir($dir);
        $prinScanDir[] = array(
            "id" => "docs/columna/" . $idColumna,
            "parentid" => "-1",
            "text" => "Columna " . $nombreColumna,
            "value" => "docs/columna/" . $idColumna,
            "icon" => "views/images/iconMuestra.png"
        );
        foreach ($dirContent as $file) {
            if ($file != "." && $file != "..") {
                if (!is_dir("docs/columna/" . $idColumna . "/" . $file)) {
                    $icon = "views/images/file_icon.png";
                    $scanDir[] = array(
                        "id" => "docs/columna/" . $idColumna . "/" . $file,
                        "parentid" => "docs/columna/" . $idColumna,
                        "text" => $file,
                        "value" => "docs/columna/" . $idColumna . "/" . $file,
                        "icon" => $icon
                    );
                    $prinScanDir = array_merge($prinScanDir, $scanDir);
                }
            }
        }

        echo json_encode($prinScanDir);
    }

}
