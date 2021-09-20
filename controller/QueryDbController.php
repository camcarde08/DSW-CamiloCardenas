<?php

use Illuminate\Database\Capsule\Manager as Capsule;

class QueryDBController
{

    function executeGetQuery($query)
    {
        if ($query == "getMuestrasRefrencias") {
            $viewMuestraReferenciasModel = new ViewMuestraReferenciasDbModel();
            $data = $viewMuestraReferenciasModel->getAllMuestras();
            if ($data != false) {
                $utilController = new UtilsController();

                foreach ($data as $muestra) {
                    $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra["prefijo"], $muestra["custom_id"]);
                    $response[] = array(
                        'idMuestra' => $muestra['id'],
                        'activa' => $muestra['activa'],
                        'prioridad' => $muestra['prioridad'],
                        'cotizacion' => $muestra['id_cotizacion'],
                        'remision' => $muestra['numero_remision'],
                        'producto' => $muestra['nombre_producto'],
                        'tercero' => $muestra['nombre_tercero'],
                        'contacto' => $muestra['nombre_contacto'],
                        'informe' => $muestra['num_informe'],
                        'estado' => $muestra['descripcion_estado_muestra'],
                        'factura' => $muestra['num_factura'],
                        'fechaLlegada' => $muestra['fecha_llegada'],
                        'fechaCompromiso' => $muestra['fecha_compromiso'],
                        'areaAnalisis' => $muestra['des_area_analisis'],
                        'coordinador' => $muestra['des_area_analisis'],
                        'lote' => $muestra['lote'],
                        'fechaAlmacenamiento' => $muestra['fecha_almacenamiento'],
                        'observacion' => $muestra['observacion'],
                        'complexId' => $auxIdMuestra
                    );
                }
                echo json_encode($response);
            } else {
                echo json_encode(NULL);
            }
        } elseif ($query == "getEstadoMuestrasReferencia") {
            $viewMuestraReferenciasModel = new ViewMuestraReferenciasDbModel();
            $data = $viewMuestraReferenciasModel->getAllEstadoMuestras();
            if ($data != false) {
                $utilController = new UtilsController();

                foreach ($data as $muestra) {
                    $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra["prefijo"], $muestra["custom_id"]);
                    $response[] = array(
                        'idMuestra' => $muestra['id'],
                        'activa' => $muestra['activa'],
                        'prioridad' => $muestra['prioridad'],
                        'cotizacion' => $muestra['id_cotizacion'],
                        'remision' => $muestra['numero_remision'],
                        'producto' => $muestra['nombre_producto'],
                        'tercero' => $muestra['nombre_tercero'],
                        'contacto' => $muestra['nombre_contacto'],
                        'informe' => $muestra['num_informe'],
                        'estado' => $muestra['descripcion_estado_muestra'],
                        'factura' => $muestra['num_factura'],
                        'fechaLlegada' => $muestra['fecha_llegada'],
                        'fechaCompromiso' => $muestra['fecha_compromiso'],
                        'areaAnalisis' => $muestra['des_area_analisis'],
                        'coordinador' => $muestra['des_area_analisis'],
                        'lote' => $muestra['lote'],
                        'fechaAlmacenamiento' => $muestra['fecha_almacenamiento'],
                        'observacion' => $muestra['observacion'],
                        'nombre_analista' => $muestra['nombre_analista'],
                        'fecha_programada' => $muestra['fecha_programada'],
                        'fecha_analisis' => $muestra['fecha_analisis'],
                        'fecha_resultado' => $muestra['fecha_resultado'],
                        'fecha_fabricacion' => $muestra['fecha_fabricacion'],
                        'fecha_vencimiento' => $muestra['fecha_vencimiento'],
                        'fecha_pre_conclusion' => $muestra['fecha_pre_conclusion'],
                        'propietario' => $muestra['propietario'],
                        'proveedor' => $muestra['proveedor'],
                        'envase' => $muestra['envase'],
                        'forma_farmaceutica' => $muestra['forma_farmaceutica'],
                        'fecha_muestreo' => $muestra['fecha_muestreo'],
                        'ensayos' => $muestra['ensayos'],
                        'fecha_conclusion' => $muestra['fecha_conclusion'],
                        'complexId' => $auxIdMuestra
                    );
                }
                echo json_encode($response);
            } else {
                echo json_encode(NULL);
            }
        } elseif ($query == "getResultadoReferenciasByIdResultado") {
            $tablaResultado = new TablaResultadoDbModelClass();
            $resultResultado = $tablaResultado->getResultadoById($_GET["idResultado"]);
            if ($resultResultado["code"] == "00000") {
                $tablaResultadoCepas = new TablaResultadoCepasDbModelClass();
                $tablaResultadoMedios = new TablaResultadoMediosCultivoDbModelClass();
                foreach ($resultResultado["data"] as $resultado) {
                    $resultCepas = $tablaResultadoCepas->getCepasByIdResultado($resultado["id"]);
                    if ($resultCepas["code"] == "00000") {
                        foreach ($resultCepas["data"] as $cepa) {
                            $cepas[] = array(
                                "id_resultado" => $cepa["id_resultado"],
                                "id_reactivo" => $cepa["id_reactivo"],
                            );
                        }
                        $resultResultado["data"][0]["cepas"] = $cepas;
                    }
                    $resultMedios = $tablaResultadoMedios->getMediosByIdResultado($resultado["id"]);
                    if ($resultMedios["code"] == "00000") {
                        foreach ($resultMedios["data"] as $estandar) {
                            $medios[] = array(
                                "id_resultado" => $estandar["id_resultado"],
                                "id_estandar" => $estandar["id_estandar"],
                            );
                        }
                        $resultResultado["data"][0]["medios"] = $medios;
                    }
                }
            }
            $response = json_encode($resultResultado);
            echo $response;
        } elseif ($query == "getAreasActivasReferencias") {

            $tablaAreaAnalisis = new TablaAreaAnalisisDbModel();
            $queryResult = $tablaAreaAnalisis->getAreasActivas2();
            if ($queryResult["code"] === "00000") {

                foreach ($queryResult["data"] as $key => $value) {
                    $tablaTipoMuestra = new TablaTipoMuestraDbModelClass();
                    $resultTipoMuesta = $tablaTipoMuestra->getActiveTipoMuestraByIdArea($value["id"]);
                    if ($resultTipoMuesta["code"] == "00000") {
                        $queryResult["data"][$key]["tiposMuestra"] = $resultTipoMuesta["data"];
                    } else {
                        $response = json_encode($resultTipoMuesta);
                    }
                    $response = json_encode($queryResult);
                }
            } else {
                $response = json_encode($queryResult);
            }
            echo $response;
        } elseif ($query == "getActiveAreasMicrobiologicas") {

            $tablaAreaMicrobiologica = new TablaAreaMicrobiologicaMedooDbModelClass();
            $queryResult = $tablaAreaMicrobiologica->getActiveAreasMicrobiologicas();
            if ($queryResult["query"] === true) {
                foreach ($queryResult["data"] as $area) {
                    $areas[] = array(
                        "id" => (int)$area["id"],
                        "descripcion" => $area["descripcion"]
                    );
                }
                $response = array(
                    "code" => 0,
                    "message" => "OK",
                    "data" => $areas
                );
            } else {
                $response = array(
                    "code" => 1,
                    "message" => "Error DB",
                    "data" => $queryResult
                );
            }
            $response = json_encode($response);
            echo $response;
        } elseif ($query == "GetMuestraReferenciasById") {
            $modelMuestra = new TablaMuestraDbModelClass();
            $utilController = new UtilsController();
            $realIdMuestra = $utilController->getRealIdMuestra($_GET["idMuestra"]);


            $data = $modelMuestra->getMuestraReferenciasById($realIdMuestra);
            if ($data != false && count($data) > 0) {
                $response[] = array(
                    'idConsultado' => $_GET['idMuestra'],
                    'response' => 1,
                    'muestra' => $data[0]
                );

                echo json_encode($response);
            } else {
                $response[] = array(
                    'idConsultado' => $_GET['idMuestra'],
                    'response' => 0
                );
                echo json_encode($response);
            }
        } elseif ($query == "GetMuestraReferenciasDetalleById") {
            $modelMuestra = new TablaMuestraDbModelClass();
            $utilController = new UtilsController();
            $realIdMuestra = $utilController->getRealIdMuestra($_GET["idMuestra"]);
// if ($_SESSION["systemsParameters"]["customIdMuestra"] = "true") {
//     $customIdMuestra = strtoupper($_GET["idMuestra"]);
//     $parameters = explode("-", $customIdMuestra);
//     $data = $modelMuestra->getRealIdMuestra($parameters[0], $parameters[1]);
//     $realIdMuestra = $data[0]["id"];
// } else {
//     $realIdMuestra = $_GET["idMuestra"];
// }


            $data = $modelMuestra->getMuestraReferenciasDetalleById($realIdMuestra);


            if ($data != false && count($data) > 0) {
                $muestra = $data[0];
                $muestra["activa"] = (boolean)$muestra["activa"];
                $muestra["prioridad"] = (int)$muestra["prioridad"];

                switch ($muestra["id_area_analisis"]) {
                    case "1":
                        $tablaMuestraDetalleMic = new TablaMuestraDetalleMicDbModelClass();
                        $resultMuestraDetalleMic = $tablaMuestraDetalleMic->getMuestraDetalleMicByIdMuestra($muestra["id"]);
                        if ($resultMuestraDetalleMic["code"] == "00000") {
                            $muestra["detalleMic"] = $resultMuestraDetalleMic["data"][0];
                            if (true) {
                                $tablaEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
                                $resultEnsayoMuestra = $tablaEnsayoMuestra->getEnsayoMuestraByIdMuestraFQ($muestra["id"]);
                                if ($resultEnsayoMuestra["code"] === "00000") {
                                    foreach ($resultEnsayoMuestra["data"] as $key => $value) {
                                        $resultEnsayoMuestra["data"][$key]["validacion"] = (boolean)(int)$value["validacion"];
                                    }

                                    $muestra["ensayos"] = $resultEnsayoMuestra["data"];
                                    $tablaLote = new TablaLoteDbModelClass();
                                    $resultLote = $tablaLote->getLotesByidMuestra2($muestra["id"]);
                                    if ($resultLote["code"] == "00000") {
                                        $muestra["lote"] = $resultLote["data"][0];
                                        $tablaAlmacenamientoMuestra = new TablaAlmacenamientoDbModelClass();
                                        $resultAlmacenamientoMuestra = $tablaAlmacenamientoMuestra->getAlmacenamientosByIdMuestra2($muestra["id"]);
                                        if ($resultAlmacenamientoMuestra["code"] == "00000") {
                                            $muestra["almacenamiento"] = $resultAlmacenamientoMuestra["data"];
                                            $response[] = array(
                                                "code" => "00000",
                                                "message" => "OK",
                                                "data" => array(
                                                    'idConsultado' => $_GET['idMuestra'],
                                                    'muestra' => $muestra
                                                )
                                            );
                                        } else {
                                            $response[] = array(
                                                "code" => "00006",
                                                "message" => "Fallo al consultar los almacenamientos de la muestra",
                                                "data" => array(
                                                    'idConsultado' => $_GET['idMuestra'],
                                                    'muestra' => $resultAlmacenamientoMuestra
                                                )
                                            );
                                        }
                                    } else {
                                        $response[] = array(
                                            "code" => "00005",
                                            "message" => "Fallo al consultar los lotes de la muestra",
                                            "data" => array(
                                                'idConsultado' => $_GET['idMuestra'],
                                                'muestra' => $resultLote
                                            )
                                        );
                                    }
                                } else {
                                    $response[] = array(
                                        "code" => "00004",
                                        "message" => "Fallo al consultar los ensayos de la muestra",
                                        "data" => array(
                                            'idConsultado' => $_GET['idMuestra'],
                                            'muestra' => $resultEnsayoMuestra
                                        )
                                    );
                                }
                            } else {
                                $response[] = array(
                                    "code" => "00003",
                                    "message" => "Fallo al consultar tecnicas usadas en el detalle microbiologico de la muestra",
                                    "data" => array(
                                        'idConsultado' => $_GET['idMuestra'],
                                        'muestra' => "a"
                                    )
                                );
                            }
                        } else {
                            $response[] = array(
                                "code" => "00002",
                                "message" => "Fallo al consultar el detalle microbiollgico de la muestra",
                                "data" => array(
                                    'idConsultado' => $_GET['idMuestra'],
                                    'muestra' => "a"
                                )
                            );
                        }
                        break;
                    case "2":
                        $tablaMuestraDetalleMic = new TablaMuestraDetalleMicDbModelClass();
                        $resultMuestraDetalleMic = $tablaMuestraDetalleMic->getMuestraDetalleMicByIdMuestra($muestra["id"]);
                        if ($resultMuestraDetalleMic["code"] == "00000") {
                            $muestra["detalleMic"] = $resultMuestraDetalleMic["data"][0];
                            $tblTecnicaUsadaMuestraMic = new TablaTecnicaUsadaMuestraMicDbModelClass();
                            $resultTecnicaUsada = $tblTecnicaUsadaMuestraMic->getTecnicaUsadaByIdMuestraDetalleMic($muestra["detalleMic"]["id"]);
                            if ($resultTecnicaUsada["code"] == "00000") {
                                $muestra["detalleMic"]["tecnicaUsada"] = $resultTecnicaUsada["data"];
                                $tablaEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
                                $resultEnsayoMuestra = $tablaEnsayoMuestra->getEnsayoMuestraByIdMuestra2($muestra["id"]);
                                if ($resultEnsayoMuestra["code"] === "00000") {
                                    foreach ($resultEnsayoMuestra["data"] as $key => $value) {
                                        $resultEnsayoMuestra["data"][$key]["validacion"] = (boolean)(int)$value["validacion"];
                                    }

                                    $muestra["ensayos"] = $resultEnsayoMuestra["data"];
                                    $tablaLote = new TablaLoteDbModelClass();
                                    $resultLote = $tablaLote->getLotesByidMuestra2($muestra["id"]);
                                    if ($resultLote["code"] == "00000") {
                                        $muestra["lote"] = $resultLote["data"][0];
                                        $tablaAlmacenamientoMuestra = new TablaAlmacenamientoDbModelClass();
                                        $resultAlmacenamientoMuestra = $tablaAlmacenamientoMuestra->getAlmacenamientosByIdMuestra2($muestra["id"]);
                                        if ($resultAlmacenamientoMuestra["code"] == "00000") {
                                            $muestra["almacenamiento"] = $resultAlmacenamientoMuestra["data"];
                                            $response[] = array(
                                                "code" => "00000",
                                                "message" => "OK",
                                                "data" => array(
                                                    'idConsultado' => $_GET['idMuestra'],
                                                    'muestra' => $muestra
                                                )
                                            );
                                        } else {
                                            $response[] = array(
                                                "code" => "00006",
                                                "message" => "Fallo al consultar los almacenamientos de la muestra",
                                                "data" => array(
                                                    'idConsultado' => $_GET['idMuestra'],
                                                    'muestra' => $resultAlmacenamientoMuestra
                                                )
                                            );
                                        }
                                    } else {
                                        $response[] = array(
                                            "code" => "00005",
                                            "message" => "Fallo al consultar los lotes de la muestra",
                                            "data" => array(
                                                'idConsultado' => $_GET['idMuestra'],
                                                'muestra' => $resultLote
                                            )
                                        );
                                    }
                                } else {
                                    $response[] = array(
                                        "code" => "00004",
                                        "message" => "Fallo al consultar los ensayos de la muestra",
                                        "data" => array(
                                            'idConsultado' => $_GET['idMuestra'],
                                            'muestra' => $resultEnsayoMuestra
                                        )
                                    );
                                }
                            } else {
                                $response[] = array(
                                    "code" => "00003",
                                    "message" => "Fallo al consultar tecnicas usadas en el detalle microbiologico de la muestra",
                                    "data" => array(
                                        'idConsultado' => $_GET['idMuestra'],
                                        'muestra' => $resultTecnicaUsada
                                    )
                                );
                            }
                        } else {
                            $response[] = array(
                                "code" => "00002",
                                "message" => "Fallo al consultar el detalle microbiollgico de la muestra",
                                "data" => array(
                                    'idConsultado' => $_GET['idMuestra'],
                                    'muestra' => $resultMuestraDetalleMic
                                )
                            );
                        }
                        break;
                    case 4:


                        if ($muestra["tipo_estabilidad"] == 1) {
                            $str = file_get_contents('./config/tiemposEstabilidadNatural.json');
                        } else if ($muestra["tipo_estabilidad"] == 2) {
                            $str = file_get_contents('./config/tiemposEstabilidadAcelerada.json');
                        } else if ($muestra["tipo_estabilidad"] == 3) {
                            $str = file_get_contents('./config/tiemposEstabilidadOnGoing.json');
                        }

                        $totalDuraciones = json_decode($str, true);
                        $duraciones = array();
                        foreach ($totalDuraciones as $keyTotalDuraciones => $valueTotalDuraciones) {
                            array_push($duraciones, $valueTotalDuraciones);
                            if ($valueTotalDuraciones[id] == $muestra["duracion"]) {
                                break;
                            }
                        }


                        $tablaEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
                        $resultEnsayoMuestra = $tablaEnsayoMuestra->getEnsayoMuestraByIdMuestra2($muestra["id"]);
                        if ($resultEnsayoMuestra["code"] === "00000") {
                            foreach ($resultEnsayoMuestra["data"] as $key => $value) {
                                $resultEnsayoMuestra["data"][$key]["validacion"] = (boolean)(int)$value["validacion"];
                            }

                            $muestra["ensayos"] = $duraciones;
                            $tablaLote = new TablaLoteDbModelClass();
                            $resultLote = $tablaLote->getLotesByidMuestra2($muestra["id"]);
                            if ($resultLote["code"] == "00000") {
                                $muestra["lote"] = $resultLote["data"][0];
                                $tablaAlmacenamientoMuestra = new TablaAlmacenamientoDbModelClass();
                                $resultAlmacenamientoMuestra = $tablaAlmacenamientoMuestra->getAlmacenamientosByIdMuestra2($muestra["id"]);
                                if ($resultAlmacenamientoMuestra["code"] == "00000") {
                                    $muestra["almacenamiento"] = $resultAlmacenamientoMuestra["data"];
                                    $response[] = array(
                                        "code" => "00000",
                                        "message" => "OK",
                                        "data" => array(
                                            'idConsultado' => $_GET['idMuestra'],
                                            'muestra' => $muestra
                                        )
                                    );
                                } else {
                                    $response[] = array(
                                        "code" => "00006",
                                        "message" => "Fallo al consultar los almacenamientos de la muestra",
                                        "data" => array(
                                            'idConsultado' => $_GET['idMuestra'],
                                            'muestra' => $resultAlmacenamientoMuestra
                                        )
                                    );
                                }
                            } else {
                                $response[] = array(
                                    "code" => "00005",
                                    "message" => "Fallo al consultar los lotes de la muestra",
                                    "data" => array(
                                        'idConsultado' => $_GET['idMuestra'],
                                        'muestra' => $resultLote
                                    )
                                );
                            }
                        } else {
                            $response[] = array(
                                "code" => "00004",
                                "message" => "Fallo al consultar los ensayos de la muestra",
                                "data" => array(
                                    'idConsultado' => $_GET['idMuestra'],
                                    'muestra' => $resultEnsayoMuestra
                                )
                            );
                        }


                        break;
                    default:
                        break;
                }
            } else {
                $response[] = array(
                    "code" => "00001",
                    "message" => "Fallo al consultar la muestra",
                    "data" => array(
                        'idConsultado' => $_GET['idMuestra'],
                        'realIdMuestra' => $realIdMuestra,
                        'muestra' => $data
                    )
                );
            }
            $tablaResultado = new TablaResultadoDbModelClass();
            $tablaProgramacion = new TablaProgramacionAnalistasDbModelClass();
            foreach ($response[0]["data"]["muestra"]["ensayos"] as $key => $value) {
                $resultado = $tablaResultado->getResultadoByIdEnsayoMuestra2($value["id"]);
                $response[0]["data"]["muestra"]["ensayos"][$key]["resultados"] = $resultado;
                $programacion = $tablaProgramacion->getUniqueProgramacionByIdEnsayoMuestra($value["id"]);
                $response[0]["data"]["muestra"]["ensayos"][$key]["programacion"] = $programacion["data"][0];
            }

            echo json_encode($response);
        } elseif ($query == "getEstandaresMediosCultivo") {
            $tablaEstandares = new TablaEstandarDbModelClass();


            $data = $tablaEstandares->getAllEstandares();
            if ($data != false) {
                foreach ($data as $estandar) {
                    $estandares[] = array(
                        "id" => $estandar["id"],
                        "descripcion" => $estandar["nombre"] . " Lote: " . $estandar["lote"]
                    );
                }
                $response = json_encode($estandares);
                echo $response;
            }
        } elseif ($query == "getReactivos") {
            $tablaReactivo = new TablaReactivoDbModelClass();
            $data = $tablaReactivo->getAllReactivo();
            if ($data != false) {
                foreach ($data as $reactivo) {
                    $reactivos[] = array(
                        'id' => $reactivo["id"],
                        'nombre' => $reactivo["nombre"],
                        'lote' => $reactivo["lote"],
                        'cantidad' => $reactivo["cantidad"],
                        'f_vencimiento' => substr($reactivo["fecha_vencimiento"], 0, 10),
                        'activo' => $reactivo["activo"],
                        'cant_actual' => $reactivo["cantidad_actual"],
                        'stock' => $reactivo["stock"],
                        'f_ingreso' => $reactivo["fecha_ingreso"],
                        'f_apertura' => $reactivo["fecha_apertura"],
                        'f_terminacion' => $reactivo["fecha_terminacion"],
                        'lote_interno' => $reactivo["lote_interno"],
                        'f_pase' => $reactivo["fecha_pase"]);
                }

                $response = array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => $reactivos
                );
            } else {
                $response = array(
                    "code" => "00001",
                    "message" => "Fallo al consultar los reactivos");
            }
            echo json_encode($response);
        } // PENDIENTE MIGRAR A MEDOO
        elseif ($query == "getActiveProductoJoinTipoProducto") {

            $tablaproducto = new TablaProductoDBModelClass();
            $data = $tablaproducto->getAllProducto();
            foreach ($data as $producto) {
                $productos[] = array(
                    "id" => (int)$producto["idProducto"],
                    "nombreProducto" => $producto["nombreProducto"],
                    "tecnicaProducto" => $producto["tecnicaProducto"],
                    "tiempoEntregaProducto" => $producto["tiemppoEntregaProducto"],
                    "idFormulaFarmaceutica" => $producto["idFormulaFarmaceutica"],
                    "descripcionFormula" => $producto["descripcionFormula"],
                    "tipoProducto" => $producto["tipoProducto"]
                );
            }
            $response = json_encode($productos);
            echo $response;
        } // PENDIENTE MIGRAR A MEDOO
        elseif ($query == "getAllEmpaque") {

            $tablaEmpaque = new TablaEmpaqueDbModelClass();
            $data = $tablaEmpaque->getAllEmpaques();
            foreach ($data as $empaque) {
                $empaques[] = array(
                    "id" => (int)$empaque["id"],
                    "descripcion" => $empaque["descripcion"]
                );
            }
            $response = json_encode($empaques);
            echo $response;
        } // PENDIENTE MIGRAR A MEDOO
        elseif ($query == "getAllEnvase") {

            $tablaEnvase = new TablaEnvaseDbModelClass();
            $data = $tablaEnvase->getAllEnvase();
            foreach ($data as $envase) {
                $envases[] = array(
                    "id" => (int)$envase["id"],
                    "descripcion" => $envase["descripcion"]
                );
            }
            $response = json_encode($envases);
            echo $response;
        } //PENDIENTE MIGRAR A MEDOO
        elseif ($query == "getPrincipiosActivosByIdProducto") {

            $viewProductoPrincipioActivo = new ViewProductoPrincipioActivoDbModelClass();
            $data = $viewProductoPrincipioActivo->getPrincipioActivoByIdProducto($_GET["idProducto"]);
            foreach ($data as $principio) {
                $principios[] = array(
                    "idProducto" => (int)$principio["id_producto"],
                    "idPrincipioActivo" => (int)$principio["id_principio_activo"],
                    "nombrePrincipioActivo" => $principio["nombre"],
                    "principal" => (bool)$principio["principal"],
                    "trazador" => (bool)$principio["trasador"]
                );
            }
            $response = json_encode($principios);
            echo $response;
        } // PENDIENTE MIGRAR A MEDOO
        elseif ($query == "getProductoPaqueteEnsayoByidProdidAreaA") {

            $viewProductoPaqueteEnsayo = new ViewProductoPaquetesEnsayosDbModelClass();
            $data = $viewProductoPaqueteEnsayo->getPaquetesEnsayosByProductos($_GET["idProducto"], $_GET["idAreaA"]);
            if ($data != false) {
                if (count($data > 0)) {
                    foreach ($data as $ensayo) {
                        $ensayos[] = array(
                            "idProductoPaquete" => (int)$ensayo["idProductoPaquete"],
                            "idProducto" => (int)$ensayo["idProducto"],
                            "idPaquete" => (int)$ensayo["idEnsayoPaquete"],
                            "nomPaquete" => $ensayo["descripcionPaquete"],
                            "idAreaAnalisis" => (int)$ensayo["idAreaAnalisis"],
                            "nomAreaAnalisis" => $ensayo["descripcionAreaAnalisis"],
                            "idEnsayo" => (int)$ensayo["idEnsayo"],
                            "nomEnsayo" => $ensayo["descripcionEnsayo"],
                            "tiempo" => (int)$ensayo["tiempo"],
                            "duracion" => (int)$ensayo["duracion"],
                            "validacion" => false,
                            "idMetodo" => (int)$ensayo["id_metodo"],
                            "especificacion" => (string)$ensayo["especificacion"],
                            "idProductoEnsayo" => (int)$ensayo["idProductoEnsayo"],
                            "valor" => (double)$ensayo["valor"],
                            "idHojaCalculo" => (int)$ensayo["id_hoja_calculo"]
                        );
                    }

                    $response = array(
                        "code" => 0,
                        "message" => "OK",
                        "data" => $ensayos
                    );
                } else {
                    $response = array(
                        "code" => 2,
                        "message" => "No se encontraron registros"
                    );
                }
            } else {
                $response = array(
                    "code" => 1,
                    "message" => "ERROR: fallo la consulta a la base dedatos",
                );
            }

            echo json_encode($response);
        } elseif ($query == "getActiveMetodo") {

            $tablametodo = new TablaMetodoMedooDbModelClass();
            $queryResult = $tablametodo->getActiveMetodo();
            if ($queryResult["query"] === true) {
                foreach ($queryResult["data"] as $area) {
                    $areas[] = array(
                        "id" => (int)$area["id"],
                        "descripcion" => $area["descripcion"]
                    );
                }
                $response = array(
                    "code" => 0,
                    "message" => "OK",
                    "data" => $areas
                );
            } else {
                $response = array(
                    "code" => 1,
                    "message" => "Error DB",
                    "data" => $queryResult
                );
            }
            $response = json_encode($response);
            echo $response;
        } elseif ($query == "getActiveTipoMuestra") {

            $tablaTipoMuestra = new TablaTipoMuestraMedooDbModelClass();
            $queryResult = $tablaTipoMuestra->getActiveTipoMuestra();
            if ($queryResult["query"] === true) {
                foreach ($queryResult["data"] as $tipoMuestra) {
                    $tiposMuestra[] = array(
                        "id" => (int)$tipoMuestra["id"],
                        "descripcion" => $tipoMuestra["descripcion"],
                        "prefijo" => $tipoMuestra["prefijo"],
                        "activo" => $tipoMuestra["activo"],
                        "idAreaAnalisis" => $tipoMuestra["id_area_analisis"],
                    );
                }
                $response = array(
                    "code" => 0,
                    "message" => "OK",
                    "data" => $tiposMuestra
                );
            } else {
                $response = array(
                    "code" => 1,
                    "message" => "Error DB",
                    "data" => $queryResult
                );
            }
            $response = json_encode($response);
            echo $response;
        } elseif ($query == "getHistoricostadoMuestra") {

            if ($_SESSION["systemsParameters"]["customIdMuestra"] = "true") {
                $modelMuestra = new TablaMuestraDbModelClass();
                $customIdMuestra = strtoupper($_GET["idMuestra"]);
                $parameters = explode("-", $customIdMuestra);
                $data = $modelMuestra->getRealIdMuestra($parameters[0], $parameters[1]);
                $realIdMuestra = $data[0]["id"];
            } else {
                $realIdMuestra = $_GET["idMuestra"];
            }

            $tablaHistorico = new TablaHistoricoEstadoMuestraDbModelClass();
            $resultHistorico = $tablaHistorico->getHistoricoEstadosMuestraByIdMuestra2($realIdMuestra);
            foreach ($resultHistorico["data"] as $historico) {
                $response[] = array(
                    "id" => $historico["id"],
                    "idMuestra" => $historico["id_muestra"],
                    "fecha" => $historico["fecha"],
                    "idEstado" => $historico["id_estado"],
                    "idUsuario" => $historico["id_usuario"],
                    "observaciones" => $historico["observaciones"],
                    "desEstado" => $historico["des_estado"],
                    "nombreUsuario" => $historico["nombre_usuario"],
                    "nombreProducto" => $historico["nombre_producto"]
                );
            }

            $response = json_encode($response);
            echo $response;
        } elseif ($query == "getCepasDisponiblesByIdMedioCultivo") {
            $this->getCepasDisponiblesByIdMedioCultivo($_GET["idMedioCultivo"]);
        } elseif ($query == "getActiveCepasByIdMedioCultivo") {
            $this->getActiveCepasByIdMedioCultivo($_GET["idMedioCultivo"]);
        } elseif ($query == "getAllMedioCultivo") {
            $this->getAllMedioCultivo();
        } elseif ($query == "getEquiposActivos") {
            $this->getEquiposActivos();
        } elseif ($query == "getLotesByIdMedioCultivo") {
            $this->getLotesByIdMedioCultivo($_GET["idMedioCultivo"]);
        } elseif ($query == "getAllActiveEnsayo") {
            $this->getAllActiveEnsayo();
        } elseif ($query == "getMediosCultivoByIdEnsayo") {
            $this->getMediosCultivoByIdEnsayo($_GET["idEnsayo"]);
        } elseif ($query == "getMediosCultivoDisponiblesByIdEnsayo") {
            $this->getMediosCultivoDisponiblesByIdEnsayo($_GET["idEnsayo"]);
        } elseif ($query == "getSessionUserData") {
            $this->getSessionUserData();
        } elseif ($query == "getEnsayosPorProgramarMicrobiologicos") {
            $this->getEnsayosPorProgramarMicrobiologicos();
        } elseif ($query == "getEnsayosPorProgramarFisicoquimicos") {
            $this->getEnsayosPorProgramarFisicoquimicos();
        } elseif ($query == "getPlantillas") {
            $this->getPlantillas();
        } elseif ($query == "getAllActiveCepas") {
            $this->getAllActiveCepas();
        } elseif ($query == "getLotesByIdCepa") {
            $this->getLotesByIdCepa($_GET["idCepa"]);
        } elseif ($query == "getAllReactivos2") {
            $this->getAllReactivos2();
        } elseif ($query == "getAllReactivosPorMuestra") {
            $this->getAllReactivosPorMuestra();
        } elseif ($query == "getAllEstandares2") {
            $this->getAllEstandares2();
        } elseif ($query == 'getProgramacionByIdMuestraAndIdAnalista') {
            $this->getProgramacionByIdMuestraAndIdAnalista($_GET['idMuestra'], $_GET['idAnalista']);
        } elseif ($query == 'getProgramacionByIdAnalistaAndRangeTime') {
            $this->getProgramacionByIdAnalistaAndRangeTime($_GET['idAnalista'], $_GET['stratDate'], $_GET['endDate']);
        } elseif ($query == 'getProgramacionByIdAnalistaOnDate') {
            $this->getProgramacionByIdAnalistaOnDate($_GET['idAnalista'], $_GET['onDate']);
        } elseif ($query == 'getProgramacionAnalista') {
            $this->getProgramacionAnalista($_GET['idAnalista']);
        } elseif ($query == 'getEnsayosParaTranscripcion') {
            $this->getEnsayosParaTranscripcion();
        } elseif ($query == 'getEnsayosParaRevisionFQ') {
            $this->getEnsayosParaRevisionFQ();
        } elseif ($query == 'getEnsayosParaRevisionMB') {
            $this->getEnsayosParaRevisionMB();
        } elseif ($query == "updateDetalleEnsayoMuestraFromProgAnalistas") {
            $this->updateDetalleEnsayoMuestraFromProgAnalistas($_GET['idEnsayoMuestra'], $_GET['duracion'], $_GET['equipo'], $_GET['turno'], $_GET['fechaProg'], $_GET['fechaCompInterno'], $_GET['observaciones']);
        } elseif ($query == "getMuestrasVerificadas") {
            $this->getMuestrasVerificadas();
        } elseif ($query == "getMuestrasParaVerificar") {
            $this->getMuestrasParaVerificar();
        } elseif ($query == "getEnsayosCountAprobacionAndResultadosGroupByMuestra") {
            $this->getEnsayosCountAprobacionAndResultadosGroupByMuestra();
        } elseif ($query == 'getAllMuestraReferenciasData') {
            $this->getAllMuestraReferenciasData();
        } elseif ($query == "GetMuestraReferenciasDetalleById2") {
            $this->getMuestraReferenciasDetalleById2($_GET["idMuestra"]);
        } elseif ($query == 'getLotesByIdReactivo') {
            $this->getLotesByIdReactivo($_GET["idReactivo"]);
        } elseif ($query == 'getLotesByIdEstandar') {
            $this->getLotesByIdEstandar($_GET["idEstandar"]);
        } elseif ($query == 'getAllPerfil') {
            $this->getAllPerfil();
        } elseif ($query == 'getAllPermisosBandejaEntrada') {
            $this->getAllPermisosBandejaEntrada();
        } elseif ($query == 'getPerfilPermisosBandejaEntrada') {
            $this->getPerfilPermisosBandejaEntrada($_GET["idPerfil"]);
        } elseif ($query == 'eliminarPerfilPermisoBandejaEntrada') {
            $this->eliminarPerfilPermisoBandejaEntrada($_GET["idPerfil"], $_GET["idPermiso"]);
        } elseif ($query == 'getEnsayoEquipoByIdEnsayo') {
            $this->getEnsayoEquipoByIdEnsayo($_GET["idEnsayo"]);
        } elseif ($query == 'getEnsayoEquipoDisponibleByIdEnsayo') {
            $this->getEnsayoEquipoDisponibleByIdEnsayo($_GET["idEnsayo"]);
        } elseif ($query == 'getAllPrincipioActivo') {
            $this->getAllPrincipioActivo();
        } elseif ($query == 'getPaquetes') {
            $this->getPaquetes();
        } elseif ($query == 'getEnsayosByIdPaquete') {
            $this->getEnsayosByIdPaquete($_GET["idPaquete"]);
        } elseif ($query == 'getEnsayosDisponiblesByIdPaquete') {
            $this->getEnsayosDisponiblesByIdPaquete($_GET["idPaquete"]);
        } elseif ($query == 'getProductosActivos') {
            $this->getProductosActivos();
        } elseif ($query == 'getEnsayosPaquetesProducto') {
            $this->getEnsayosPaquetesProducto($_GET["idProducto"]);
        } elseif ($query == 'getReactivosAsociadosByIdEnsayoProd') {
            $this->getReactivosAsociadosByIdEnsayoProd($_GET["idEnsayoProducto"]);
        } elseif ($query == 'getReactivosDisponiblesByIdEnsayoProd') {
            $this->getReactivosDisponiblesByIdEnsayoProd($_GET["idEnsayoProducto"]);
        } elseif ($query == 'getEstandaresAsociadosByIdEnsayoProd') {
            $this->getEstandaresAsociadosByIdEnsayoProd($_GET["idEnsayoProducto"]);
        } elseif ($query == 'getEstandaresDisponiblesByIdEnsayoProd') {
            $this->getEstandaresDisponiblesByIdEnsayoProd($_GET["idEnsayoProducto"]);
        } elseif ($query == 'getAllColumnas') {
            $this->getAllColumnas();
        } elseif ($query == 'getPrincipiosActivosDisponibles') {
            $this->getPrincipiosActivosDisponibles($_GET["idColumna"]);
        } elseif ($query == 'getAllCondicionCromatografica') {
            $this->getAllCondicionCromatografica();
        } elseif ($query == 'getAllFormaFarmaceutica') {
            $this->getAllFormaFarmaceutica();
        } elseif ($query == 'getPaquetesAsociadosByIdProd') {
            $this->getPaquetesAsociadosByIdProd($_GET["idProducto"]);
        } elseif ($query == 'getPaquetesDisponiblesByIdProd') {
            $this->getPaquetesDisponiblesByIdProd($_GET["idProducto"]);
        } elseif ($query == 'getPrincipiosAsociadosByIdProd') {
            $this->getPrincipiosAsociadosByIdProd($_GET["idProducto"]);
        } elseif ($query == 'getPrincipiosDisponiblesByIdProd') {
            $this->getPrincipiosDisponiblesByIdProd($_GET["idProducto"]);
        } elseif ($query == 'getMuestrasSalida') {
            $this->getMuestrasSalida();
        } elseif ($query == 'getClientesActivos') {
            $this->getClientesActivos();
        } elseif ($query == 'getUsuariosCliente') {
            $this->getUsuariosCliente($_GET["idCliente"]);
        } elseif ($query == 'getAllPermisosUsuarioCliente') {
            $this->getAllPermisosUsuarioCliente();
        } elseif ($query == 'getPermisosUsuarioCliente') {
            $this->getPermisosUsuarioCliente($_GET["idUsuario"]);
        } elseif ($query == 'getFestivos') {
            $this->getFestivos();
        } elseif ($query == 'getMesesSalida') {
            $this->getMesesSalida();
        } elseif ($query == 'getPerfiles') {
            $this->getPerfiles();
        } elseif ($query == 'getPermisos') {
            $this->getPermisos();
        } elseif ($query == 'getInformeTendenciaData') {
            $this->getInformeTendenciaData($_GET["fechaInicial"], $_GET["fechaFinal"], $_GET["idCliente"], $_GET["idProducto"]);
        } elseif ($query == 'getSubMuestrasEstabilidadAprobadas') {
            $this->getSubMuestrasEstabilidadAprobadas();
        } elseif ($query == 'getMuestraEstabilidadParaProgramacion') {
            $this->getMuestraEstabilidadParaProgramacion();
        } elseif ($query == 'getSubMuestraEstabilidadParaAnalisis') {
            $this->getSubMuestraEstabilidadParaAnalisis();
        } elseif ($query == 'getSubMuestraEstabilidadParaTranscripcion') {
            $this->getSubMuestraEstabilidadParaTranscripcion();
        } elseif ($query == 'getSubMuestraEstabilidadParaRevision') {
            $this->getSubMuestraEstabilidadParaRevision();
        } elseif ($query == 'getMuestrasToConsultaMuetras') {
            $this->getMuestrasToConsultaMuetras($_GET["cantidad"], $_GET["pagina"], $_GET["prefijo"], $_GET["customId"], $_GET["producto"], $_GET["tercero"], $_GET["lote"], $_GET["estadoMuestra"], $_GET["fechaLlegada"], $_GET["fechaCompromiso"], $_GET["observacion"], $_GET["contacto"], $_GET["numFatura"], $_GET["fechaEntrega"]);
        } elseif ($query == 'getSubMuestraEstabilidadParaRevision2') {
            $this->getSubMuestraEstabilidadParaRevision2();
        } elseif ($query == 'getEnsayosPaginacion') {
            $this->getEnsayosPaginacion($_GET["cantidad"], $_GET["pagina"], $_GET["descripcion"]
                , $_GET["precio_real"], $_GET["tiempo"], $_GET["plantilla"], $_GET["codinterno"]
                , $_GET["orden"]);
        } elseif ($query == 'getPaquetesPaginacion') {
            $this->getPaquetesPaginacion($_GET["cantidad"], $_GET["pagina"], $_GET["codigo"]
                , $_GET["descripcion"]);
        } elseif ($query == 'getProductosPaginacion') {
            $this->getProductosPaginacion($_GET["cantidad"], $_GET["pagina"], $_GET["nombre"]
                , $_GET["forma"]);
        } elseif ($query == "getMuestrasEstados") {
            $this->getMuestrasEstados($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getDatosGraficaMuestrasPorTipoProducto") {
            $this->getDatosGraficaMuestrasPorTipoProducto($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getEstEnsayosProgramados") {
            $this->getEstEnsayosProgramados();
        } elseif ($query == "getEstEnsayosAnalizados") {
            $this->getEstEnsayosAnalizados($_GET["consultaTodos"], $_GET["idUsuario"], $_GET["pagina"], $_GET["cantidad"], $_GET["showIdMuestra"], $_GET["duracion"], $_GET["temperatura"], $_GET["fechaAnalisis"], $_GET["cliente"], $_GET["producto"], $_GET["numeroLote"], $_GET["analista"], $_GET["ensayo"]);
        } elseif ($query == "getEstEnsayosTranscritos") {
            $this->getEstEnsayosTranscritos($_GET["consultaTodos"], $_GET["idUsuario"], $_GET["pagina"], $_GET["cantidad"], $_GET["showIdMuestra"], $_GET["duracion"], $_GET["temperatura"], $_GET["fechaAnalisis"], $_GET["cliente"], $_GET["producto"], $_GET["numeroLote"], $_GET["ensayo"], $_GET["analista"]);
        } elseif ($query == "getEstMuestrasTerminadas") {
            $this->getEstMuestrasTerminadas($_GET["pagina"], $_GET["cantidad"], $_GET["show_id_muestra"], $_GET["duracion"], $_GET["temperatura"], $_GET["fecha_analisis"]);
        } elseif ($query == "getMuestrasTerminadas") {
            $this->getMuestrasTerminadas($_GET["pagina"], $_GET["cantidad"], $_GET["show_id_muestra"], $_GET["producto"], $_GET["cliente"], $_GET["lote"], $_GET["fecha_llegada"], $_GET["fecha_conclusion"], $_GET["fecha_entrega"]);
        } elseif ($query == "getMuestrasGrillaGerencia") {
            $this->getMuestrasGrillaGerencia($_GET["pagina"], $_GET["cantidad"], $_GET["show_id_muestra"], $_GET["estado_muestra"], $_GET["fecha_llegada_inicio"], $_GET["fecha_llegada_fin"], $_GET["cliente"], $_GET["producto"], $_GET["lote"], $_GET["fecha_pre_conclusion_inicio"], $_GET["fecha_pre_conclusion_fin"], $_GET["fecha_conclusion_inicio"], $_GET["fecha_conclusion_fin"], $_GET["responsable_muestra"], $_GET["ensayo"], $_GET["responsable_ensayo"], $_GET["fecha_programacion_inicio"], $_GET["fecha_programacion_fin"], $_GET["fecha_analisis_inicio"], $_GET["fecha_analisis_fin"], $_GET["estado_ensayo"], $_GET["especificacion"], $_GET["resultado"]);
        } elseif ($query == "getEstMuestrasGrillaGerencia") {
            $this->getEstMuestrasGrillaGerencia($_GET["pagina"], $_GET["cantidad"], $_GET["show_id_muestra"], $_GET["fecha_llegada_inicio"], $_GET["fecha_llegada_fin"], $_GET["tiempo"], $_GET["temperatura"], $_GET["fecha_analisis_sub_muestra_inicio"], $_GET["fecha_analisis_sub_muestra_fin"], $_GET["cliente"], $_GET["producto"], $_GET["lote"], $_GET["estado_sub_muestra"], $_GET["fecha_pre_conclusion_inicio"], $_GET["fecha_pre_conclusion_fin"], $_GET["fecha_conclusion_inicio"], $_GET["fecha_conclusion_fin"], $_GET["responsable_sub_muestra"], $_GET["ensayo"], $_GET["estado_ensayo"], $_GET["especificacion"], $_GET["resultado"], $_GET["fecha_programacion_inicio"], $_GET["fecha_programacion_fin"], $_GET["fecha_analisis_inicio"], $_GET["fecha_analisis_fin"], $_GET["responsable_ensayo"]);
        } elseif ($query == "getUsoReactivos") {
            $this->getUsoReactivos($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getDetalleUsoReactivos") {
            $this->getDetalleUsoReactivos($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_reactivo"]);
        } elseif ($query == "getUsoEstandares") {
            $this->getUsoEstandares($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getDetalleUsoEstandares") {
            $this->getDetalleUsoEstandares($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_estandar"]);
        } elseif ($query == "getMuestrasParaFacturacion") {
            $this->getMuestrasParaFacturacion($_GET["pagina"], $_GET["cantidad"], $_GET["complex_id"]
                , $_GET["producto"], $_GET["tercero"], $_GET["lote"]);
        } elseif ($query == "getMuestrasParaEntrega") {
            $this->getMuestrasParaEntrega($_GET["pagina"], $_GET["cantidad"], $_GET["complex_id"]
                , $_GET["producto"], $_GET["tercero"], $_GET["lote"]);
        } else if ($query == "getTipoIdentificaciones") {
            $this->getTipoIdentificaciones();
        } else if ($query == "getCiudades") {
            $this->getCiudades();
        } else if ($query == "consultarContactosCliente") {
            $this->consultarContactosCliente($_GET["idCliente"]);
        } elseif ($query == "getDatosGraficaParticipacionClientes") {
            $this->getDatosGraficaParticipacionClientes($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getDatosGraficaParticipacionClientesEst") {
            $this->getDatosGraficaParticipacionClientesEst($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == 'getMuestrasProgramadasTercero') {
            $this->getMuestrasProgramadasTercero($_GET["pagina"], $_GET["cantidad"], $_GET["muestra"], $_GET["fechaLlegada"], $_GET["nombreCliente"], $_GET["producto"], $_GET["lote"], $_GET["ensayo"], $_GET["fechaCompromiso"]);
        } elseif ($query == 'getMuestrasEstProgramadasTercero') {
            $this->getMuestrasEstProgramadasTercero($_GET["pagina"], $_GET["cantidad"], $_GET["muestra"], $_GET["duracion"], $_GET["temperatura"], $_GET["nombreCliente"], $_GET["producto"], $_GET["lote"], $_GET["ensayo"]);
        } else if ($query == "getTiposEstandar") {
            $this->getTiposEstandar();
        } else if ($query == "getAllMetodo") {
            $this->getAllMetodo();
        } else if ($query == "getAllFormasFarmaceuticasAsociadas") {
            $this->getAllFormasFarmaceuticasAsociadas();
        } elseif ($query == "getAllEmpaqueAsociado") {
            $this->getAllEmpaqueAsociado($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } else if ($query == "getAllUsuarios") {
            $this->getAllUsuarios();
        } else if ($query == "getAllJefes") {
            $this->getAllJefes();
        } else if ($query == "getAllCargos") {
            $this->getAllCargos();
        } else if ($query == "getAllPerfiles") {
            $this->getAllPerfiles();
        } else if ($query == "getAllTipoProducto") {
            $this->getAllTipoProducto();
        } elseif ($query == 'consultaAuditoriaMuestra') {
            $this->consultaAuditoriaMuestra($_GET["idMuestra"]);
        } elseif ($query == 'consultaAuditoriaMuestraDetallada') {
            $this->consultaAuditoriaMuestraDetallada($_GET["idMuestra"]);
        } else if ($query == "getMuestraEstabilidadDetalle") {
            $this->getMuestraEstabilidadDetalle($_GET["muestra"]);
        } else if ($query == "getAllActiveAnalistas") {
            $this->getAllActiveAnalistas();
        } elseif ($query == "getDatosGraficaDesempenoAnalistas") {
            $this->getDatosGraficaDesempenoAnalistas($_GET["fecha_inicial"], $_GET["fecha_final"]);
        } elseif ($query == "getDatosGraficaDesempenoByIdAnalista") {
            $this->getDatosGraficaDesempenoByIdAnalista($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_analista"]);
        } elseif ($query == 'getResumenMuestras') {
            $this->getResumenMuestras($_GET["cantidad"], $_GET["pagina"], $_GET["muestra"], $_GET["producto"], $_GET["analista"], $_GET["ensayos"], $_GET["estadoMuestra"], $_GET["cliente"]);
        } elseif ($query == "consultarAnalistasProgramadosMuestra") {
            $this->consultarAnalistasProgramadosMuestra($_GET["idMuestra"]);
        } elseif ($query == "getDetalleParticipacionCliente") {
            $this->getDetalleParticipacionCliente($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_cliente"]);
        } elseif ($query == "getDetalleParticipacionClienteEst") {
            $this->getDetalleParticipacionClienteEst($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_cliente"]);
        } elseif ($query == "getDetalleEstadoMuestras") {
            $this->getDetalleEstadoMuestras($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_estado"]);
        } elseif ($query == "getDetalleTipoProducto") {
            $this->getDetalleTipoProducto($_GET["fecha_inicial"], $_GET["fecha_final"], $_GET["id_tipo_producto"]);
        } elseif ($query == 'consultaMuestraAuditoria') {
            $this->consultaMuestraAuditoria($_GET["muestra"]);
        } elseif ($query == 'getPermisosModulo') {
            $this->getPermisosModulo();
        } elseif ($query == 'getEnsayoMuestraInformacionGeneralHojaCalculo') {
            $this->getEnsayoMuestraInformacionGeneralHojaCalculo($_GET["idEnsayoMuestra"]);
        } elseif ($query == 'getAllHojasCalculo') {
            $this->getAllHojasCalculo();
        } elseif ($query == 'consultaInfoIdHojaCalculo') {
            $this->consultaInfoIdHojaCalculo($_GET["idEnsayoMuestra"]);
        } elseif ($query == 'getHojaCalculoEnsayoMuestra') {
            $this->getHojaCalculoEnsayoMuestra($_GET["idEnsayoMuestra"]);
        } elseif ($query == 'getFuncionesHojaCalculo') {
            $this->getFuncionesHojaCalculo($_GET["idEnsayoMuestra"]);
        }
    }

    function executePOSTQuery($query)
    {
        if ($query == "createNewEmpaque") {
            $this->createNewEmpaque($_POST["newEmpaque"]);
        } elseif ($query == "saveNewMedioCultivo") {
            $this->saveNewMedioCultivo($_POST["medioCultivoData"]);
        } elseif ($query == "saveNewLoteMedioCultivo") {
            $this->saveNewLoteMedioCultivo($_POST["loteMedioCultivoData"]);
        } elseif ($query == "activateLoteMedioCultivo") {
            $this->activateLoteMedioCultivo($_POST["idLote"], $_POST["idMedioCultivo"]);
        } elseif ($query == "createNewEnvase") {
            $this->createNewEnvase($_POST["newEnvase"]);
        } elseif ($query == "desasociarCepas") {
            $this->desasociarCepas($_POST["cepasData"]);
        } elseif ($query == "asociarCepas") {
            $this->asociarCepas($_POST["idMedioCultivo"], $_POST["cepasData"]);
        } elseif ($query == "updateEnsayo") {
            $this->updateEnsayo($_POST["ensayoData"]);
        } elseif ($query == "deleteEnsayo") {
            $this->deleteEnsayo($_POST["idEnsayo"]);
        } elseif ($query == "insertEnsayo") {
            $this->insertEnsayo($_POST["ensayoData"]);
        } elseif ($query == "desasociarMediosCultivo") {
            $this->desasociarMediosCultivo($_POST["asociacionesData"]);
        } elseif ($query == "asociarMediosCultivo") {
            $this->asociarMediosCultivo($_POST["idEnsayo"], $_POST["meiosCultivoData"]);
        } elseif ($query == "createNewCepa") {
            $this->createNewCepa($_POST["cepaData"]);
        } elseif ($query == "updateCepa") {
            $this->updateCepa($_POST["cepaData"]);
        } elseif ($query == "activarLoteCepa") {
            $this->activarLoteCepa($_POST["loteCepaData"]);
        } elseif ($query == "createNewLoteCepa") {
            $this->createNewLoteCepa($_POST["newLoteData"], $_POST["idCepa"]);
        } elseif ($query == "alamacenarMuestra") {
            $this->alamacenarMuestra($_POST["almacenData"], $_POST["idMuestra"]);
        }/*
         * Se adiciona query reactivo
         */ elseif ($query == "updateReactivo") {
            $this->updateReactivo($_POST["reactivoData"]);
        } elseif ($query == "deleteReactivo") {
            $this->deleteReactivo($_POST["idReactivo"], $_POST["razon"]);
        } elseif ($query == "insertReactivo") {
            $this->insertReactivo($_POST["reactivoData"]);
        } elseif ($query == "insertReactivo2") {
            $this->insertReactivo2($_POST["reactivoData"]);
        }/*
         * Se adiciona query reactivo
         */ elseif ($query == "deleteEstandar") {
            $this->deleteEstandar($_POST["idEstandar"], $_POST["razon"]);
        } elseif ($query == "updateEstandar") {
            $this->updateEstandar($_POST["estandarData"]);
        } elseif ($query == "insertEstandar") {
            $this->insertEstandar($_POST["estandarData"]);
        } elseif ($query == "analizarEnsayoMuestra") {
            $this->analizarEnsayoMuestra($_POST["muestra"], $_POST["ensayos"], $_POST["fechaAnalisis"]);
        } elseif ($query == "insertResultado") {
            $this->insertResultado($_POST["muestra"], $_POST["ensayo"]);
        } elseif ($query == "updateResultado") {
            $this->updateResultado($_POST["resultado"], $_POST["muestra"], $_POST["ensayo"]);
        }/*
         * Query Lote Reactivo
         */ elseif ($query == "activarLoteReactivo") {
            $this->activarLoteReactivo($_POST["loteReactivoData"]);
        } elseif ($query == "createNewLoteReactivo") {
            $this->createNewLoteReactivo($_POST["newLoteData"], $_POST["idReactivo"]);
        } elseif ($query == 'updateLoteReactivo') {
            $this->updateLoteReactivo($_POST["loteReactivoData"]);
        }/*
         * Query Lote Estandar
         */ elseif ($query == "activarLoteEstandar") {
            $this->activarLoteEstandar($_POST["loteEstandarData"]);
        } elseif ($query == "createNewLoteEstandar") {
            $this->createNewLoteEstandar($_POST["newLoteData"], $_POST["idEstandar"]);
        } elseif ($query == 'updateLoteEstandar') {
            $this->updateLoteEstandar($_POST["loteEstandarData"]);
        } elseif ($query == 'aprobarEnsayoMuestra') {
            $this->aprobarEnsayoMuestra($_POST["ensayo"]);
        } elseif ($query == 'rechazarEnsayoMuestra') {
            $this->rechazarEnsayoMuestra($_POST["ensayo"]);
        } elseif ($query == 'reprogramarEnsayoMuestra') {
            $this->reprogramarEnsayoMuestra($_POST["ensayo"]);
        } elseif ($query == 'rfeEnsayoMuestra') {
            $this->rfeEnsayoMuestra($_POST["ensayo"]);
        } elseif ($query == 'verificarMuestra') {
            $this->verificarMuestra($_POST["muestra"], $_POST["conclusion"], $_POST["fecha_conclusion"], $_POST['observacion']);
        } elseif ($query == 'asignarPerfilPermisoBandejaEntrada') {
            $this->asignarPerfilPermisoBandejaEntrada($_POST["idPerfil"], $_POST["idPermiso"]);
        } elseif ($query == 'createEnsayoEquipos') {
            $this->createEnsayoEquipos($_POST["ensayo"], $_POST["equipos"]);
        } elseif ($query == 'deleteEnsayoEquipos') {
            $this->deleteEnsayoEquipos($_POST["ensayoEquipos"]);
        } elseif ($query == 'updateMedioCultivo') {
            $this->updateMedioCultivo($_POST['medioCultivoData']);
        } elseif ($query == 'deleteMedioCultivo') {
            $this->deleteMedioCultivo($_POST['idMedioCultivo']);
        } elseif ($query == 'updateLoteMedioCultivo') {
            $this->updateLoteMedioCultivo($_POST['loteMedioCultivoData']);
        } elseif ($query == 'revisarMuestra') {
            $this->revisarMuestra($_POST['muestra'], $_POST['conclusion'], $_POST['fecha_pre_conclusion'], $_POST['observacion']);
        } elseif ($query == 'updatePrincipioActivo') {
            $this->updatePrincipioActivo($_POST['principioActivoData']);
        } elseif ($query == 'deletePrincipioActivo') {
            $this->deletePrincipioActivo($_POST['idPrincipioActivo']);
        } elseif ($query == 'insertPrincipioActivo') {
            $this->insertPrincipioActivo($_POST['principioActivoData']);
        } elseif ($query == 'createPaqueteEnsayos') {
            $this->createPaqueteEnsayos($_POST['paquete'], $_POST['ensayos']);
        } elseif ($query == 'deletePaqueteEnsayos') {
            $this->deletePaqueteEnsayos($_POST['paqueteEnsayos']);
        } elseif ($query == 'deletePaquete') {
            $this->deletePaquete($_POST["idPaquete"]);
        } elseif ($query == "updatePaquete") {
            $this->updatePaquete($_POST["paqueteData"]);
        } elseif ($query == "insertPaquete") {
            $this->insertPaquete($_POST["paqueteData"]);
        } elseif ($query == "createProductoEnsayoReactivos") {
            $this->createProductoEnsayoReactivos($_POST["ensayoProducto"], $_POST["reactivos"]);
        } elseif ($query == "deleteProductoEnsayoReactivos") {
            $this->deleteProductoEnsayoReactivos($_POST["reactivos"], $_POST["ensayoProductoReactivos"]);
        } elseif ($query == "createProductoEnsayoEstandares") {
            $this->createProductoEnsayoEstandares($_POST["ensayoProducto"], $_POST["estandares"]);
        } elseif ($query == "deleteProductoEnsayoEstandares") {
            $this->deleteProductoEnsayoEstandares($_POST["estandares"], $_POST["ensayoProductoEstandares"]);
        } elseif ($query == "updateColumna") {
            $this->updateColumna($_POST["columnaData"]);
        } elseif ($query == "deleteColumna") {
            $this->deleteColumna($_POST["idColumna"]);
        } elseif ($query == "insertColumna") {
            $this->insertColumna($_POST["columnaData"]);
        } elseif ($query == "updateCondicionCromatografica") {
            $this->updateCondicionCromatografica($_POST['condicionCromatograficaData']);
        } elseif ($query == "insertCondicionCromatografica") {
            $this->insertCondicionCromatografica($_POST['condicionCromatograficaData']);
        } elseif ($query == "deleteCondicionCromatografica") {
            $this->deleteCondicionCromatografica($_POST['idCondicionCromatografica']);
        } elseif ($query == "updateCondicionCromatograficaProdEnsayo") {
            $this->updateCondicionCromatograficaProdEnsayo($_POST['productoEnsayoData']);
        } elseif ($query == "updateColumnaProdEnsayo") {
            $this->updateColumnaProdEnsayo($_POST['productoEnsayoData']);
        } elseif ($query == "desactivarLoteReactivo") {
            $this->desactivarLoteReactivo($_POST["loteReactivoData"]);
        } elseif ($query == "desactivarLoteEstandar") {
            $this->desactivarLoteEstandar($_POST["loteEstandarData"]);
        } elseif ($query == "obtenerEnsayosAsignados") {
            $this->obtenerEnsayosAsignados($_POST["idUsuario"], $_POST["idMuestra"]);
        } elseif ($query == "updateProducto") {
            $this->updateProducto($_POST["productoData"]);
        } elseif ($query == "deleteProducto") {
            $this->deleteProducto($_POST["idProducto"]);
        } elseif ($query == "insertProducto") {
            $this->insertProducto($_POST["productoData"]);
        } elseif ($query == "createProductoPaquetes") {
            $this->createProductoPaquetes($_POST["producto"], $_POST["paquetes"]);
        } elseif ($query == "deleteProductoPaquetes") {
            $this->deleteProductoPaquetes($_POST["productoPaquetes"]);
        } elseif ($query == "editarProductoEnsayo") {
            $this->editarProductoEnsayo($_POST["productoEnsayoData"]);
        } elseif ($query == "createProductoPrincipios") {
            $this->createProductoPrincipios($_POST["producto"], $_POST["principios"]);
        } elseif ($query == "deleteProductoPrincipios") {
            $this->deleteProductoPrincipios($_POST["productoPrincipios"]);
        } elseif ($query == "actualizarEstadoSalidaMuestra") {
            $this->actualizarEstadoSalidaMuestra($_POST["idAlmacenamiento"]);
        } elseif ($query == "insertUsuarioCliente") {
            $this->insertUsuarioCliente($_POST["usuarioData"]);
        } elseif ($query == "updateUsuarioClienteInfo") {
            $this->updateUsuarioClienteInfo($_POST["usuarioData"]);
        } elseif ($query == "updateUsuarioClienteContrasena") {
            $this->updateUsuarioClienteContrasena($_POST["usuarioData"]);
        } elseif ($query == "eliminarUsuarioCliente") {
            $this->eliminarUsuarioCliente($_POST["idUsuario"]);
        } elseif ($query == "actualizarPermisosUsuarioCliente") {
            $this->actualizarPermisosUsuarioCliente($_POST["permisosData"], $_POST["idUsuario"]);
        } elseif ($query == "insertEquipo") {
            $this->insertEquipo($_POST["equipoData"]);
        } elseif ($query == "updateEquipo") {
            $this->updateEquipo($_POST["equipoData"]);
        } elseif ($query == "deleteEquipo") {
            $this->deleteEquipo($_POST["idEquipo"]);
        } elseif ($query == "createPerfilPermiso") {
            $this->createPerfilPermiso($_POST["idPerfil"], $_POST["idPermiso"]);
        } elseif ($query == "removePerfilPermiso") {
            $this->removePerfilPermiso($_POST["idPerfil"], $_POST["idPermiso"]);
        } elseif ($query == 'updateAlmacenamiento') {
            $this->updateAlmacenamiento($_POST["idMuestra"], $_POST["fecha"], $_POST["idUbicacion"]
                , $_POST["idTipoAlmacenamiento"], $_POST["nivel"], $_POST["caja"]
                , $_POST["tiempo"], $_POST["fechaSalida"], $_POST["peso"], $_POST["observaciones"], $_POST["id"]);
        } elseif ($query == "anularMuestra") {
            $this->anularMuestra($_POST["idMuestra"], $_POST["motivoAnulacion"], $_POST["usuario"]);
        } elseif ($query == "anularMuestra") {
            $this->anularMuestra($_POST["idMuestra"], $_POST["motivoAnulacion"], $_POST["usuario"]);
        } elseif ($query == "actualizarNumeroFactura") {
            $this->actualizarNumeroFactura($_POST["muestra"]);
        } elseif ($query == "actualizarFechaEntrega") {
            $this->actualizarFechaEntrega($_POST["muestra"]);
        } else if ($query == "actualizarCliente") {
            $this->actualizarCliente($_POST["cliente"]);
        } else if ($query == "insertarCliente") {
            $this->insertarCliente($_POST["cliente"]);
        } elseif ($query == "actualizarCrearContactos") {
            $this->actualizarCrearContactos($_POST["contactos"], $_POST["idTercero"]);
        } elseif ($query == "createNewMetodo") {
            $this->createNewMetodo($_POST["metodo"]);
        } elseif ($query == "desactivarMetodo") {
            $this->desactivarMetodo($_POST["metodo"]);
        } elseif ($query == "actualizarFormaFarmaceutica") {
            $this->actualizarFormaFarmaceutica($_POST["forma"]);
        } elseif ($query == "borrarFormaFarmaceutica") {
            $this->borrarFormaFarmaceutica($_POST["forma"]);
        } elseif ($query == "actualizarEnvase") {
            $this->actualizarEnvase($_POST["envase"]);
        } elseif ($query == "borrarEnvase") {
            $this->borrarEnvase($_POST["envase"]);
        } elseif ($query == "createNewUsuario") {
            $this->createNewUsuario($_POST["nombre"], $_POST["idCargo"], $_POST["email"], $_POST["idJefe"], $_POST["login"], $_POST["idPerfil"], $_POST["password"]);
        } elseif ($query == "borrarUsuario") {
            $this->borrarUsuario($_POST["usuario"]);
        } elseif ($query == "updateUsuario1") {
            $this->updateUsuario1($_POST["idUsuario"], $_POST["data"]);
        } elseif ($query == "updatePasswordUsuario") {
            $this->updatePasswordUsuario($_POST["idUsuario"], $_POST["password"]);
        } elseif ($query == "actualizarTipoProducto") {
            $this->actualizarTipoProducto($_POST["tipo"]);
        } elseif ($query == "createNewTipoProducto") {
            $this->createNewTipoProducto($_POST["codigo"], $_POST["nombre"]);
        } elseif ($query == "exportExcelUsoReactivosMuestra") {
            $this->exportExcelUsoReactivosMuestra($_POST["idReactivos"], $_POST["fechaInicial"], $_POST["fechaFin"]);
        } elseif ($query == "exportExcelResumenMuestra") {
            $this->exportExcelResumenMuestra($_POST["muestra"], $_POST["producto"], $_POST["analista"], $_POST["ensayos"],
                $_POST["estadoMuestra"], $_POST["cliente"]);
        } elseif ($query == "saveEnsayoMuestraHojaCalculo") {
            $this->saveEnsayoMuestraHojaCalculo($_POST["idEnsayoMuestra"], $_POST["data"]);
        } elseif ($query == "updateEnsayoMuestraHojaCalculo") {
            $this->updateEnsayoMuestraHojaCalculo($_POST["idEnsayoMuestra"], $_POST["data"], $_POST["idHojaCalculoEnsayoMuestra"]);
        } elseif ($query == "updateHojaCalculoProdEnsayo") {
            $this->updateHojaCalculoProdEnsayo($_POST['productoEnsayoData']);
        }
    }

    function getAllActiveAnalistas()
    {
        $tabla = new TablaUsuariosDbModelClass();
        $result = $tabla->getAllActiveAnalistas();
        $response = json_encode($result);
        echo $response;
    }

    function consultaAuditoriaMuestraDetallada($idMuestra)
    {
        $tabla = new TablaMuestraDbModelClass();
        $result = $tabla->consultaAuditoriaMuestraDetallada($idMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function consultaAuditoriaMuestra($idMuestra)
    {
        $tabla = new TablaMuestraDbModelClass();
        $result = $tabla->consultaAuditoriaMuestra($idMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function getAllMetodo()
    {
        $tabla = new TablaMetodoDbModelClass();
        $result = $tabla->getAllMetodo();
        $response = json_encode($result);
        echo $response;
    }

    function getAllFormasFarmaceuticasAsociadas()
    {
        $tabla = new TablaEnvaseDbModelClass();
        $result = $tabla->getAllFormasFarmaceuticasAsociadas();
        $response = json_encode($result);
        echo $response;
    }

    function getAllEmpaqueAsociado()
    {
        $tabla = new TablaEmpaqueDbModelClass();
        $result = $tabla->getAllEmpaqueAsociado();
        $response = json_encode($result);
        echo $response;
    }

    function getAllJefes()
    {
        $tabla = new TablaUsuariosDbModelClass();
        $result = $tabla->getAllJefes();
        $response = json_encode($result);
        echo $response;
    }

    function getAllCargos()
    {
        $tabla = new TablaCargoDbModelClass();
        $result = $tabla->getAllCargos();
        $response = json_encode($result);
        echo $response;
    }

    function getAllPerfiles()
    {
        $tabla = new TablaPerfilDbModelClass();
        $result = $tabla->getAllPerfiles();
        $response = json_encode($result);
        echo $response;
    }

    function getAllUsuarios()
    {
        $tabla = new TablaUsuariosDbModelClass();
        $result = $tabla->getAllUsuario2();
        $response = json_encode($result);
        echo $response;
    }

    function getAllTipoProducto()
    {
        $tabla = new TablaTipoProductoDbModelClass();
        $result = $tabla->getAllTipoProducto();
        $response = json_encode($result);
        echo $response;
    }

    function getDetalleUsoEstandares($fechaInicial, $fechaFinal, $idEstandar)
    {
        $resultFQ = Capsule::select("
            SELECT 
            t3.id as id_muestra,
            CONCAT(t3.prefijo,'-',t3.custom_id) as show_id_muestra,
            count(t2.id) as cantidad_ensayos,
            t4.nombre as producto

            FROM 
            sgm_ensayo_muestra_estandar_lote t1
            JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id
            JOIN sgm_muestra t3 ON t2.id_muestra = t3.id
            JOIN sgm_producto t4 ON t4.id = t3.id_producto

            WHERE 
            t1.id_estandar = ? AND
            t2.fecha_analisis > ? AND
            t2.fecha_analisis < ?

            GROUP BY t3.id", [$idEstandar, $fechaInicial, $fechaFinal]);

        $resultMuestrasEst = Capsule::select("
            SELECT 
            t4.id as id,
            concat(t5.prefijo,'-',t4.custom_id) as show_id_muestra,
            t6.nombre as producto

            FROM 
            sgm_est_ensayo_submuestra_estandar_lote t1
            JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id_ensayo_submuestra = t2.id
            JOIN sgm_est_sub_muestra t3 ON t2.id_sub_muestra = t3.id
            JOIN sgm_est_muestra t4 ON t3.id_muestra = t4.id
            JOIN sgm_tipo_muestra t5 ON t4.id_tipo_muestra = t5.id
            JOIN sgm_producto t6 ON t6.id = t4.id_producto

            WHERE 
            t1.id_estandar = ? AND
            t2.fecha_analisis > ? AND
            t2.fecha_analisis < ?

            GROUP BY t4.id", [$idEstandar, $fechaInicial, $fechaFinal]);

        foreach ($resultMuestrasEst as $muestra) {
            $muestra->sub_muestras = Capsule::select("
                SELECT 
                t3.id,
                t6.label as duracion,
                t7.label as temperatura,
                count(t2.id) as cantidad_ensayos


                FROM 
                sgm_est_ensayo_submuestra_estandar_lote t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id_ensayo_submuestra = t2.id
                JOIN sgm_est_sub_muestra t3 ON t2.id_sub_muestra = t3.id
                JOIN sgm_est_muestra t4 ON t3.id_muestra = t4.id
                JOIN sgm_tipo_muestra t5 ON t4.id_tipo_muestra = t5.id
                JOIN sgm_est_duracion_estabilidad t6 ON t3.id_duracion = t6.id
                JOIN sgm_est_temperatura t7 ON t3.id_temperatura = t7.id

                WHERE 
                t1.id_estandar = ? AND
                t2.fecha_analisis > ? AND
		t2.fecha_analisis < ? AND
                t4.id = ?

                GROUP BY t3.id", [$idEstandar, $fechaInicial, $fechaFinal, $muestra->id]);
        }

        $auxResponse = array(
            "fq" => $resultFQ,
            "est" => $resultMuestrasEst
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getUsoEstandares($fechaInicial, $fechaFinal)
    {

        $result = Capsule::select("
            SELECT sel1.id_estandar, sel1.nombre, sum(sel1.cantidad_usada) as cantidad_usada 
            FROM (
            SELECT 

            t2.id_estandar,
            t3.nombre,
            count(t2.id) as cantidad_usada
            FROM
            sgm_ensayo_muestra t1
            JOIN sgm_ensayo_muestra_estandar_lote t2 ON t1.id = t2.id_ensayo_muestra
            JOIN sgm_estandar t3 ON t2.id_estandar = t3.id

            WHERE

            t1.estado_ensayo in (2,3,4,5) AND
            t1.fecha_analisis > ? AND
            t1.fecha_analisis < ?

            GROUP BY t2.id_estandar

            UNION

            SELECT 

            t2.id_estandar,
            t3.nombre,
            count(t2.id) as cantidad_usada
            FROM
            sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_ensayo_submuestra_estandar_lote t2 ON t1.id = t2.id_ensayo_submuestra
            JOIN sgm_estandar t3 ON t2.id_estandar = t3.id

            WHERE

            t1.estado_ensayo in (2,3,4,5) AND
            t1.fecha_analisis > ? AND
            t1.fecha_analisis < ?

            GROUP BY t2.id_estandar) sel1

            GROUP BY sel1.id_estandar", [$fechaInicial, $fechaFinal, $fechaInicial, $fechaFinal]);

        $auxResponse = array(
            "estandares" => $result
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getDetalleUsoReactivos($fechaInicial, $fechaFinal, $idReactivo)
    {
        $resultFQ = Capsule::select("
            SELECT 
            t3.id as id_muestra,
            CONCAT(t3.prefijo,'-',t3.custom_id) as show_id_muestra,
            count(t2.id) as cantidad_ensayos,
            t4.nombre as producto

            FROM 
            sgm_ensayo_muestra_reactivo_lote t1
            JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id
            JOIN sgm_muestra t3 ON t2.id_muestra = t3.id
            JOIN sgm_producto t4 ON t4.id = t3.id_producto

            WHERE 
            t1.id_reactivo = ? AND
            t2.fecha_analisis > ? AND
            t2.fecha_analisis < ?

            GROUP BY t3.id", [$idReactivo, $fechaInicial, $fechaFinal]);

        $resultMuestrasEst = Capsule::select("
            SELECT 
            t4.id as id,
            concat(t5.prefijo,'-',t4.custom_id) as show_id_muestra,
            t6.nombre as producto


            FROM 
            sgm_est_ensayo_submuestra_reactivo_lote t1
            JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id_ensayo_submuestra = t2.id
            JOIN sgm_est_sub_muestra t3 ON t2.id_sub_muestra = t3.id
            JOIN sgm_est_muestra t4 ON t3.id_muestra = t4.id
            JOIN sgm_tipo_muestra t5 ON t4.id_tipo_muestra = t5.id
            JOIN sgm_producto t6 ON t6.id = t4.id_producto

            WHERE 
            t1.id_reactivo = ? AND
            t2.fecha_analisis > ? AND
            t2.fecha_analisis < ?

            GROUP BY t4.id", [$idReactivo, $fechaInicial, $fechaFinal]);

        foreach ($resultMuestrasEst as $muestra) {
            $muestra->sub_muestras = Capsule::select("
                SELECT 
                t3.id,
                t6.label as duracion,
                t7.label as temperatura,
                count(t2.id) as cantidad_ensayos


                FROM 
                sgm_est_ensayo_submuestra_reactivo_lote t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id_ensayo_submuestra = t2.id
                JOIN sgm_est_sub_muestra t3 ON t2.id_sub_muestra = t3.id
                JOIN sgm_est_muestra t4 ON t3.id_muestra = t4.id
                JOIN sgm_tipo_muestra t5 ON t4.id_tipo_muestra = t5.id
                JOIN sgm_est_duracion_estabilidad t6 ON t3.id_duracion = t6.id
                JOIN sgm_est_temperatura t7 ON t3.id_temperatura = t7.id

                WHERE 
                t1.id_reactivo = ? AND
                t2.fecha_analisis > ? AND
                t2.fecha_analisis < ? AND
                t4.id = ?

                GROUP BY t3.id", [$idReactivo, $fechaInicial, $fechaFinal, $muestra->id]);
        }

        $auxResponse = array(
            "fq" => $resultFQ,
            "est" => $resultMuestrasEst
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getUsoReactivos($fechaInicial, $fechaFinal)
    {

        $result = Capsule::select("
            SELECT sel1.id_reactivo, sel1.nombre, sum(sel1.cantidad_usada) as cantidad_usada 
            FROM (
            SELECT 

            t2.id_reactivo,
            t3.nombre,
            count(t2.id) as cantidad_usada
            FROM
            sgm_ensayo_muestra t1
            JOIN sgm_ensayo_muestra_reactivo_lote t2 ON t1.id = t2.id_ensayo_muestra
            JOIN sgm_reactivo t3 ON t2.id_reactivo = t3.id

            WHERE

            t1.estado_ensayo in (2,3,4,5) AND
            t1.fecha_analisis > ? AND
            t1.fecha_analisis < ?

            GROUP BY t2.id_reactivo

            UNION

            SELECT 

            t2.id_reactivo,
            t3.nombre,
            count(t2.id) as cantidad_usada
            FROM
            sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_ensayo_submuestra_reactivo_lote t2 ON t1.id = t2.id_ensayo_submuestra
            JOIN sgm_reactivo t3 ON t2.id_reactivo = t3.id

            WHERE

            t1.estado_ensayo in (2,3,4,5) AND
            t1.fecha_analisis > ? AND
            t1.fecha_analisis < ?

            GROUP BY t2.id_reactivo) sel1

            GROUP BY sel1.id_reactivo", [$fechaInicial, $fechaFinal, $fechaInicial, $fechaFinal]);

        $auxResponse = array(
            "reactivos" => $result
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getEstMuestrasGrillaGerencia($pagina, $cantidad, $showIdMuestra, $fechaLlegadaInicio, $fechaLlegadaFin
        , $tiempo, $temperatura, $fechaAnalisisSubmuestraInicio, $fechaAnalisisSubmuestraFin
        , $cliente, $producto, $lote, $estadoSubmuestra, $fechaPreConclusionInicio, $fechaPreConclusionFin
        , $fechaConclusionInicio, $fechaConclusionFin, $responsableSubmuestra, $ensayo
        , $estadoEnsayo, $especificacion, $resultado, $fechaProgramacionInicio, $fechaProgramacionFin
        , $fechaAnalisisInicio, $fechaAnalisisFin, $responsableEnsayo)
    {

        $finicio = '1900-01-01';
        $ffin = new DateTime();
        $ffin->add(new DateInterval('P20Y'));
        $ffin = $ffin->format('Y-m-d');

        $showIdMuestra = "%" . $showIdMuestra . "%";

        $fechaLlegadaInicio = $fechaLlegadaInicio == "" || $fechaLlegadaInicio == NULL ? $finicio : $fechaLlegadaInicio;
        $fechaLlegadaFin = $fechaLlegadaFin == "" || $fechaLlegadaFin == NULL ? $ffin : $fechaLlegadaFin;
        if ($fechaLlegadaInicio == $finicio && $fechaLlegadaFin == $ffin) {
            $fechaPreconclusionTemp = NULL;
        } else {
            $fechaPreconclusionTemp = '';
        }

        $tiempo = "%" . $tiempo . "%";
        $temperatura = "%" . $temperatura . "%";

        $fechaAnalisisSubmuestraInicio = $fechaAnalisisSubmuestraInicio == "" || $fechaAnalisisSubmuestraInicio == NULL ? $finicio : $fechaAnalisisSubmuestraInicio;
        $fechaAnalisisSubmuestraFin = $fechaAnalisisSubmuestraFin == "" || $fechaAnalisisSubmuestraFin == NULL ? $ffin : $fechaAnalisisSubmuestraFin;
        if ($fechaAnalisisSubmuestraInicio == $finicio && $fechaAnalisisSubmuestraFin == $ffin) {
            $fechaAnalisisSubmuestraTemp = NULL;
        } else {
            $fechaAnalisisSubmuestraTemp = '';
        }

        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $lote = "%" . $lote . "%";
        $estadoSubmuestra = "%" . $estadoSubmuestra . "%";

        $fechaPreConclusionInicio = $fechaPreConclusionInicio == "" || $fechaPreConclusionInicio == NULL ? $finicio : $fechaPreConclusionInicio;
        $fechaPreConclusionFin = $fechaPreConclusionFin == "" || $fechaPreConclusionFin == NULL ? $ffin : $fechaPreConclusionFin;
        if ($fechaPreConclusionInicio == $finicio && $fechaPreConclusionFin == $ffin) {
            $fechaPreConclusionTemp = NULL;
        } else {
            $fechaPreConclusionTemp = '';
        }

        $fechaConclusionInicio = $fechaConclusionInicio == "" || $fechaConclusionInicio == NULL ? $finicio : $fechaConclusionInicio;
        $fechaConclusionFin = $fechaConclusionFin == "" || $fechaConclusionFin == NULL ? $ffin : $fechaConclusionFin;
        if ($fechaConclusionInicio == $finicio && $fechaConclusionFin == $ffin) {
            $fechaConclusionTemp = NULL;
        } else {
            $fechaConclusionTemp = '';
        }

        $responsableSubmuestra = "%" . $responsableSubmuestra . "%";
        $ensayo = "%" . $ensayo . "%";
        $estadoEnsayo = "%" . $estadoEnsayo . "%";
        $especificacion = "%" . $especificacion . "%";
        $resultado = "%" . $resultado . "%";

        $fechaProgramacionInicio = $fechaProgramacionInicio == "" || $fechaProgramacionInicio == NULL ? $finicio : $fechaProgramacionInicio;
        $fechaProgramacionFin = $fechaProgramacionFin == "" || $fechaProgramacionFin == NULL ? $ffin : $fechaProgramacionFin;
        if ($fechaProgramacionInicio == $finicio && $fechaProgramacionFin == $ffin) {
            $fechaProgramacionTemp = NULL;
        } else {
            $fechaProgramacionTemp = '';
        }

        $fechaAnalisisInicio = $fechaAnalisisInicio == "" || $fechaAnalisisInicio == NULL ? $finicio : $fechaAnalisisInicio;
        $fechaAnalisisFin = $fechaAnalisisFin == "" || $fechaAnalisisFin == NULL ? $ffin : $fechaAnalisisFin;
        if ($fechaAnalisisInicio == $finicio && $fechaAnalisisFin == $ffin) {
            $fechaAnalisisTemp = NULL;
        } else {
            $fechaAnalisisTemp = '';
        }

        $responsableEnsayo = "%" . $responsableEnsayo . "%";

        $pagina--;

        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        $auxMuestrasTotal = Capsule::select("
            SELECT count(id) as cantidad FROM 
            (SELECT 
            t1.id 


            FROM
            sgm_est_muestra t1
            LEFT JOIN sgm_tipo_muestra t2 ON t1.id_tipo_muestra = t2.id
            LEFT JOIN sgm_est_sub_muestra t3 ON t1.id = t3.id_muestra
            LEFT JOIN sgm_est_duracion_estabilidad t4 ON t3.id_duracion = t4.id
            LEFT JOIN sgm_est_temperatura t5 ON t3.id_temperatura = t5.id
            LEFT JOIN sgm_estado t6 ON t3.id_estado = t6.id
            LEFT JOIN sgm_terceros t7 ON t1.id_tercero = t7.id
            LEFT JOIN sgm_producto t8 ON t1.id_producto = t8.id
            LEFT JOIN sgm_est_ensayo_sub_muestra t9 ON t3.id = t9.id_sub_muestra 
            LEFT JOIN sgm_estado_ensayo_muestra t10 ON t9.estado_ensayo = t10.id 
            LEFT JOIN sgm_usuario t11 ON t9.id_analista = t11.id


            WHERE
            ifnull(CONCAT(t2.prefijo,'" . $separatorParameter->valor . "',t1.custom_id), '') LIKE ? AND
            ifnull(DATE_FORMAT(t1.fecha_llegada, '%Y-%m-%d'),'') >= CAST(? AS DATE) AND ifnull(t1.fecha_llegada,'') <= CAST(? AS DATE) AND
            ifnull(t4.label, '') LIKE ? AND
            ifnull(t5.label, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_analisis <= CAST(? AS DATE) OR t3.fecha_analisis <=> ?) AND
            ifnull(t7.nombre, '') LIKE ? AND
            ifnull(t8.nombre, '') LIKE ? AND
            ifnull(t1.numero_lote, '') LIKE ? AND 
            ifnull(t6.descripcion, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_pre_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_pre_conclusion <= CAST(? AS DATE) OR t3.fecha_pre_conclusion <=> ?) AND
            (DATE_FORMAT(t3.fecha_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_conclusion <= CAST(? AS DATE) OR t3.fecha_conclusion <=> ?) AND
            ifnull(t6.perfil_responsable, '') LIKE ? AND
            ifnull(t9.descripcion_especifica, '') LIKE ? AND
            ifnull(t10.descripcion, '') LIKE ? AND
            ifnull(t9.especificacion, '') LIKE ? AND
            ifnull(t9.resultado, '') LIKE ? AND
            (DATE_FORMAT(t9.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_programacion <= CAST(? AS DATE) OR t9.fecha_programacion <=> ?) AND
            (DATE_FORMAT(t9.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_analisis <= CAST(? AS DATE) OR t9.fecha_analisis <=> ?) AND
            ifnull(t11.nombre, '') LIKE ? 
            group by t1.id) sel1", [$showIdMuestra, $fechaLlegadaInicio, $fechaLlegadaFin, $tiempo, $temperatura,
            $fechaAnalisisSubmuestraInicio, $fechaAnalisisSubmuestraFin, $fechaAnalisisSubmuestraTemp, $cliente, $producto,
            $lote, $estadoSubmuestra, $fechaPreConclusionInicio, $fechaPreConclusionFin, $fechaPreConclusionTemp,
            $fechaConclusionInicio, $fechaConclusionFin, $fechaConclusionTemp, $responsableSubmuestra, $ensayo,
            $estadoEnsayo, $especificacion, $resultado, $fechaProgramacionInicio,
            $fechaProgramacionFin, $fechaProgramacionTemp, $fechaAnalisisInicio,
            $fechaAnalisisFin, $fechaAnalisisTemp, $responsableEnsayo]);


        $totalMuestras = $auxMuestrasTotal[0]->cantidad;

        $resultMuestras = Capsule::select("
            SELECT 
            t1.id as id


            FROM
            sgm_est_muestra t1
            LEFT JOIN sgm_tipo_muestra t2 ON t1.id_tipo_muestra = t2.id
            LEFT JOIN sgm_est_sub_muestra t3 ON t1.id = t3.id_muestra
            LEFT JOIN sgm_est_duracion_estabilidad t4 ON t3.id_duracion = t4.id
            LEFT JOIN sgm_est_temperatura t5 ON t3.id_temperatura = t5.id
            LEFT JOIN sgm_estado t6 ON t3.id_estado = t6.id
            LEFT JOIN sgm_terceros t7 ON t1.id_tercero = t7.id
            LEFT JOIN sgm_producto t8 ON t1.id_producto = t8.id
            LEFT JOIN sgm_est_ensayo_sub_muestra t9 ON t3.id = t9.id_sub_muestra 
            LEFT JOIN sgm_estado_ensayo_muestra t10 ON t9.estado_ensayo = t10.id 
            LEFT JOIN sgm_usuario t11 ON t9.id_analista = t11.id


            WHERE
            ifnull(CONCAT(t2.prefijo,'" . $separatorParameter->valor . "',t1.custom_id), '') LIKE ? AND
            ifnull(DATE_FORMAT(t1.fecha_llegada, '%Y-%m-%d'),'') >= CAST(? AS DATE) AND ifnull(t1.fecha_llegada,'') <= CAST(? AS DATE) AND
            ifnull(t4.label, '') LIKE ? AND
            ifnull(t5.label, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_analisis <= CAST(? AS DATE) OR t3.fecha_analisis <=> ?) AND
            ifnull(t7.nombre, '') LIKE ? AND
            ifnull(t8.nombre, '') LIKE ? AND
            ifnull(t1.numero_lote, '') LIKE ? AND 
            ifnull(t6.descripcion, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_pre_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_pre_conclusion <= CAST(? AS DATE) OR t3.fecha_pre_conclusion <=> ?) AND
            (DATE_FORMAT(t3.fecha_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_conclusion <= CAST(? AS DATE) OR t3.fecha_conclusion <=> ?) AND
            ifnull(t6.perfil_responsable, '') LIKE ? AND
            ifnull(t9.descripcion_especifica, '') LIKE ? AND
            ifnull(t10.descripcion, '') LIKE ? AND
            ifnull(t9.especificacion, '') LIKE ? AND
            ifnull(t9.resultado, '') LIKE ? AND
            (DATE_FORMAT(t9.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_programacion <= CAST(? AS DATE) OR t9.fecha_programacion <=> ?) AND
            (DATE_FORMAT(t9.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_analisis <= CAST(? AS DATE) OR t9.fecha_analisis <=> ?) AND
            ifnull(t11.nombre, '') LIKE ? 
            group by t1.id
            ORDER BY t1.fecha_llegada DESC
            LIMIT ?, ?", [$showIdMuestra, $fechaLlegadaInicio, $fechaLlegadaFin, $tiempo, $temperatura,
            $fechaAnalisisSubmuestraInicio, $fechaAnalisisSubmuestraFin, $fechaAnalisisSubmuestraTemp, $cliente, $producto,
            $lote, $estadoSubmuestra, $fechaPreConclusionInicio, $fechaPreConclusionFin, $fechaPreConclusionTemp,
            $fechaConclusionInicio, $fechaConclusionFin, $fechaConclusionTemp, $responsableSubmuestra, $ensayo,
            $estadoEnsayo, $especificacion, $resultado, $fechaProgramacionInicio,
            $fechaProgramacionFin, $fechaProgramacionTemp, $fechaAnalisisInicio,
            $fechaAnalisisFin, $fechaAnalisisTemp, $responsableEnsayo,
            $pagina * $cantidad, $cantidad]);

        $muestras = [];

        foreach ($resultMuestras as $muestra) {
            array_push($muestras, EstMuestra::find($muestra->id));
        }


        foreach ($muestras as $muestra) {

            $muestra->tipoMuestra;
            $muestra->show_id_muestra = $muestra->tipoMuestra->prefijo . "-" . $muestra->custom_id;
            $muestra->tercero;
            $muestra->producto;

            if ($muestra->fecha_llegada != NULL) {
                $auxFechaLlegada = new DateTime($muestra->fecha_llegada);
                $muestra->label_fecha_llegada = $auxFechaLlegada->format("Y-m-d");
            } else {
                $muestra->label_fecha_llegada = NULL;
            }


            $resultSubMuestas = Capsule::select("
            SELECT 
            t3.id as id


            FROM
            
            sgm_est_sub_muestra t3 
            LEFT JOIN sgm_est_duracion_estabilidad t4 ON t3.id_duracion = t4.id
            LEFT JOIN sgm_est_temperatura t5 ON t3.id_temperatura = t5.id
            LEFT JOIN sgm_estado t6 ON t3.id_estado = t6.id
            
            LEFT JOIN sgm_est_ensayo_sub_muestra t9 ON t3.id = t9.id_sub_muestra 
            LEFT JOIN sgm_estado_ensayo_muestra t10 ON t9.estado_ensayo = t10.id 
            LEFT JOIN sgm_usuario t11 ON t9.id_analista = t11.id


            WHERE
            t3.id_muestra = ? AND
            ifnull(t4.label, '') LIKE ? AND
            ifnull(t5.label, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_analisis <= CAST(? AS DATE) OR t3.fecha_analisis <=> ?) AND
            
            
            ifnull(t6.descripcion, '') LIKE ? AND
            (DATE_FORMAT(t3.fecha_pre_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_pre_conclusion <= CAST(? AS DATE) OR t3.fecha_pre_conclusion <=> ?) AND
            (DATE_FORMAT(t3.fecha_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t3.fecha_conclusion <= CAST(? AS DATE) OR t3.fecha_conclusion <=> ?) AND
            ifnull(t6.perfil_responsable, '') LIKE ? AND
            ifnull(t9.descripcion_especifica, '') LIKE ? AND
            ifnull(t10.descripcion, '') LIKE ? AND
            ifnull(t9.especificacion, '') LIKE ? AND
            ifnull(t9.resultado, '') LIKE ? AND
            (DATE_FORMAT(t9.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_programacion <= CAST(? AS DATE) OR t9.fecha_programacion <=> ?) AND
            (DATE_FORMAT(t9.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND t9.fecha_analisis <= CAST(? AS DATE) OR t9.fecha_analisis <=> ?) AND
            ifnull(t11.nombre, '') LIKE ? 
            group by t3.id; ", [$muestra->id, $tiempo, $temperatura, $fechaAnalisisSubmuestraInicio,
                $fechaAnalisisSubmuestraFin, $fechaAnalisisSubmuestraTemp, $estadoSubmuestra, $fechaPreConclusionInicio,
                $fechaPreConclusionFin, $fechaPreConclusionTemp, $fechaConclusionInicio, $fechaConclusionFin, $fechaConclusionTemp,
                $responsableSubmuestra, $ensayo, $estadoEnsayo, $especificacion, $resultado,
                $fechaProgramacionInicio, $fechaProgramacionFin, $fechaProgramacionTemp,
                $fechaAnalisisInicio, $fechaAnalisisFin, $fechaAnalisisTemp, $responsableEnsayo]);

            $auxSubMuestras = [];

            foreach ($resultSubMuestas as $resultSubmuestra) {
                array_push($auxSubMuestras, EstSubMuestra::find($resultSubmuestra->id));
            }

            $muestra->sub_muestras = $auxSubMuestras;

            foreach ($muestra->sub_muestras as $subMuestra) {

                $subMuestra->duracion;
                $subMuestra->temperatura;
                $subMuestra->estado;

                if ($subMuestra->fecha_pre_conclusion != NULL) {
                    $auxFechaPreConclusion = new DateTime($subMuestra->fecha_pre_conclusion);
                    $subMuestra->label_fecha_pre_conclusion = $auxFechaPreConclusion->format("Y-m-d");
                } else {
                    $subMuestra->label_fecha_pre_conclusion = NULL;
                }

                if ($subMuestra->fecha_conclusion != NULL) {
                    $auxFechaConclusion = new DateTime($subMuestra->fecha_conclusion);
                    $subMuestra->label_fecha_conclusion = $auxFechaConclusion->format("Y-m-d");
                } else {
                    $subMuestra->label_fecha_conclusion = NULL;
                }


                $resultEnsayosSubMuestra = Capsule::select("
                    SELECT 
                    t9.id as id


                    FROM



                    sgm_est_ensayo_sub_muestra t9 
                    LEFT JOIN sgm_estado_ensayo_muestra t10 ON t9.estado_ensayo = t10.id 
                    LEFT JOIN sgm_usuario t11 ON t9.id_analista = t11.id


                    WHERE
                    t9.id_sub_muestra = ? AND




                    ifnull(t9.descripcion_especifica, '') LIKE ? AND
                    ifnull(t10.descripcion, '') LIKE ? AND
                    ifnull(t9.especificacion, '') LIKE ? AND
                    ifnull(t9.resultado, '') LIKE ? AND
                    (DATE_FORMAT(t9.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE) 
                        AND t9.fecha_programacion <= CAST(? AS DATE) OR t9.fecha_programacion <=> ?) AND
                    (DATE_FORMAT(t9.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE) 
                        AND t9.fecha_analisis <= CAST(? AS DATE) OR t9.fecha_analisis <=> ?) AND
                    ifnull(t11.nombre, '') LIKE ? ; ", [$subMuestra->id, $ensayo, $estadoEnsayo,
                    $especificacion, $resultado, $fechaProgramacionInicio, $fechaProgramacionFin, $fechaProgramacionTemp,
                    $fechaAnalisisInicio, $fechaAnalisisFin, $fechaAnalisisTemp, $responsableEnsayo]);

                $auxEnsayosSubMuestra = [];

                foreach ($resultEnsayosSubMuestra as $resultEnsayoSubMuestra) {
                    array_push($auxEnsayosSubMuestra, EstEnsayoSubMuestra::find($resultEnsayoSubMuestra->id));
                }

                $subMuestra->ensayos_sub_muestra = $auxEnsayosSubMuestra;

                foreach ($subMuestra->ensayos_sub_muestra as $ensayoSubMuestra) {
                    $ensayoSubMuestra->estado;
                    $ensayoSubMuestra->usuarioProgramado;

                    if ($ensayoSubMuestra->fecha_programacion != NULL) {
                        $auxFechaProgramacion = new DateTime($ensayoSubMuestra->fecha_programacion);
                        $ensayoSubMuestra->label_fecha_programacion = $auxFechaProgramacion->format("Y-m-d");
                    } else {
                        $ensayoSubMuestra->label_fecha_programacion = NULL;
                    }

                    if ($ensayoSubMuestra->fecha_analisis != NULL) {
                        $auxFechaAnalisis = new DateTime($ensayoSubMuestra->fecha_analisis);
                        $ensayoSubMuestra->label_fecha_analisis = $auxFechaAnalisis->format("Y-m-d");
                    } else {
                        $ensayoSubMuestra->label_fecha_analisis = NULL;
                    }
                }
            }
        }


        $auxResponse = array(
            "cantidad_total" => $totalMuestras,
            "muestras" => $muestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getMuestrasGrillaGerencia($pagina, $cantidad, $showIdMuestra, $estadoMuestra
        , $fechaLlegadaInicio, $fechaLlegadaFin, $cliente, $producto, $lote
        , $fechaPreConclusionInicio, $fechaPreConclusionFin, $fechaConclusionInicio
        , $fechaConclusionFin, $responsableMuestra, $ensayo, $responsableEnsayo
        , $fechaProgramacionInicio, $fechaProgramacionFin, $fechaAnalisisInicio
        , $fechaAnalisisFin, $estadoEnsayo, $especificacion, $resultado)
    {

        $finicio = '1900-01-01';
        $ffin = (new DateTime())->format('Y-m-d');

        $showIdMuestra = "%" . $showIdMuestra . "%";
        $estadoMuestra = "%" . $estadoMuestra . "%";

        $fechaLlegadaInicio = $fechaLlegadaInicio == "" || $fechaLlegadaInicio == NULL ? $finicio : $fechaLlegadaInicio;
        $fechaLlegadaFin = $fechaLlegadaFin == "" || $fechaLlegadaFin == NULL ? $ffin : $fechaLlegadaFin;

        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $lote = "%" . $lote . "%";

        $fechaPreConclusionInicio = $fechaPreConclusionInicio == "" || $fechaPreConclusionInicio == NULL ? $finicio : $fechaPreConclusionInicio;
        $fechaPreConclusionFin = $fechaPreConclusionFin == "" || $fechaPreConclusionFin == NULL ? $ffin : $fechaPreConclusionFin;
        if ($fechaPreConclusionInicio == $finicio && $fechaPreConclusionFin == $ffin) {
            $fechaPreconclusionTemp = NULL;
        } else {
            $fechaPreconclusionTemp = '';
        }

        $fechaConclusionInicio = $fechaConclusionInicio == "" || $fechaConclusionInicio == NULL ? $finicio : $fechaConclusionInicio;
        $fechaConclusionFin = $fechaConclusionFin == "" || $fechaConclusionFin == NULL ? $ffin : $fechaConclusionFin;
        if ($fechaConclusionInicio == $finicio && $fechaConclusionFin == $ffin) {
            $fechaConclusionTemp = NULL;
        } else {
            $fechaConclusionTemp = '';
        }

        $responsableMuestra = "%" . $responsableMuestra . "%";
        $ensayo = "%" . $ensayo . "%";
        $responsableEnsayo = "%" . $responsableEnsayo . "%";

        $fechaProgramacionInicio = $fechaProgramacionInicio == "" || $fechaProgramacionInicio == NULL ? $finicio : $fechaProgramacionInicio;
        $fechaProgramacionFin = $fechaProgramacionFin == "" || $fechaProgramacionFin == NULL ? $ffin : $fechaProgramacionFin;
        if ($fechaProgramacionInicio == $finicio && $fechaProgramacionFin == $ffin) {
            $fechaProgramacionTemp = NULL;
        } else {
            $fechaProgramacionTemp = '';
        }

        $fechaAnalisisInicio = $fechaAnalisisInicio == "" || $fechaAnalisisInicio == NULL ? $finicio : $fechaAnalisisInicio;
        $fechaAnalisisFin = $fechaAnalisisFin == "" || $fechaAnalisisFin == NULL ? $ffin : $fechaAnalisisFin;
        if ($fechaAnalisisInicio == $finicio && $fechaAnalisisFin == $ffin) {
            $fechaAnalisisTemp = NULL;
        } else {
            $fechaAnalisisTemp = '';
        }

        $estadoEnsayo = "%" . $estadoEnsayo . "%";
        $especificacion = "%" . $especificacion . "%";
        $resultado = "%" . $resultado . "%";

        $pagina--;

        $auxMuestrasTotal = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as show_id_muestra,
            t1.id,
            t1.prefijo,
            t1.custom_id,
            t5.descripcion as estado_muestra,
            t1.fecha_llegada,
            t2.nombre as cliente,
            t3.nombre as producto,
            t4.numero as lote,
            DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') as fecha_pre_conclusion,
            DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') as fecha_conclusion,
            t5.perfil_responsable as responsable_muestra,
            t6.descripcion_especifica,
            t8.nombre as responsable_ensayo,
            DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') as fecha_programacion,
            DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') as fecha_analisis,
            t9.descripcion as estado_ensayo,
            t6.especificacion,
            t10.resultado
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            JOIN sgm_estado t5 ON t1.id_estado_muestra = t5.id
            JOIN sgm_ensayo_muestra t6 ON t1.id = t6.id_muestra
            LEFT JOIN sgm_programacion_analistas t7 ON t6.id = t7.id_ensayo_muestra
            LEFT JOIN sgm_usuario t8 ON t7.id_analista = t8.id 
            JOIN sgm_estado_ensayo_muestra t9 ON t6.estado_ensayo = t9.id
            LEFT JOIN sgm_resultados t10 ON t6.id = t10.id_ensayo_muestra
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t5.descripcion,'') LIKE ? AND
            ifnull(t1.fecha_llegada,'') >= CAST(? AS DATE) AND ifnull(t1.fecha_llegada,'') <= CAST(? AS DATE) AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            (DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') <= CAST(? AS DATE) OR t1.fecha_pre_conclusion <=> ?) AND
            (DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') <= CAST(? AS DATE) OR t1.fecha_conclusion <=> ?) AND
            ifnull(t5.perfil_responsable,'') LIKE ? AND
            ifnull(t6.descripcion_especifica,'') LIKE ? AND
            ifnull(t8.nombre,'') LIKE ? AND
            (DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE)
                AND DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_programacion <=> ?) AND
            (DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE)
                AND DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_analisis <=> ?) AND
            ifnull(t9.descripcion,'') LIKE ? AND
            ifnull(t6.especificacion,'') LIKE ? AND
            ifnull(t10.resultado,'') LIKE ?
            
            GROUP BY t1.id
            ORDER BY t1.id desc ; ", [$showIdMuestra, $estadoMuestra, $fechaLlegadaInicio
            , $fechaLlegadaFin, $cliente, $producto, $lote, $fechaPreConclusionInicio, $fechaPreConclusionFin
            , $fechaPreconclusionTemp, $fechaConclusionInicio, $fechaConclusionFin, $fechaConclusionTemp, $responsableMuestra
            , $ensayo, $responsableEnsayo, $fechaProgramacionInicio, $fechaProgramacionFin, $fechaProgramacionTemp
            , $fechaAnalisisInicio, $fechaAnalisisFin, $fechaAnalisisTemp, $estadoEnsayo, $especificacion
            , $resultado]);

        $resultAuxMuestras = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as show_id_muestra,
            t1.id,
            t1.prefijo,
            t1.custom_id,
            t5.descripcion as estado_muestra,
            t1.fecha_llegada,
            t2.nombre as cliente,
            t3.nombre as producto,
            t4.numero as lote,
            DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') as fecha_pre_conclusion,
            DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') as fecha_conclusion,
            t5.perfil_responsable as responsable_muestra,
            t6.descripcion_especifica,
            t8.nombre as responsable_ensayo,
            DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') as fecha_programacion,
            DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') as fecha_analisis,
            t9.descripcion as estado_ensayo,
            t6.especificacion,
            t10.resultado
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            JOIN sgm_estado t5 ON t1.id_estado_muestra = t5.id
            JOIN sgm_ensayo_muestra t6 ON t1.id = t6.id_muestra
            LEFT JOIN sgm_programacion_analistas t7 ON t6.id = t7.id_ensayo_muestra
            LEFT JOIN sgm_usuario t8 ON t7.id_analista = t8.id 
            JOIN sgm_estado_ensayo_muestra t9 ON t6.estado_ensayo = t9.id
            LEFT JOIN sgm_resultados t10 ON t6.id = t10.id_ensayo_muestra
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t5.descripcion,'') LIKE ? AND
            ifnull(t1.fecha_llegada,'') >= CAST(? AS DATE) AND ifnull(t1.fecha_llegada,'') <= CAST(? AS DATE) AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            (DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND DATE_FORMAT(t1.fecha_pre_conclusion, '%Y-%m-%d') <= CAST(? AS DATE) OR t1.fecha_pre_conclusion <=> ?) AND
            (DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') >= CAST(? AS DATE) 
                AND DATE_FORMAT(t1.fecha_conclusion, '%Y-%m-%d') <= CAST(? AS DATE) OR t1.fecha_conclusion <=> ?) AND
            ifnull(t5.perfil_responsable,'') LIKE ? AND
            ifnull(t6.descripcion_especifica,'') LIKE ? AND
            ifnull(t8.nombre,'') LIKE ? AND
            (DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE)
                AND DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_programacion <=> ?) AND
            (DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE)
                AND DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_analisis <=> ?) AND
            ifnull(t9.descripcion,'') LIKE ? AND
            ifnull(t6.especificacion,'') LIKE ? AND
            ifnull(t10.resultado,'') LIKE ?
            
            GROUP BY t1.id
            ORDER BY t1.id desc
            LIMIT ? , ? ; ", [$showIdMuestra, $estadoMuestra, $fechaLlegadaInicio
            , $fechaLlegadaFin, $cliente, $producto, $lote, $fechaPreConclusionInicio, $fechaPreConclusionFin
            , $fechaPreconclusionTemp, $fechaConclusionInicio, $fechaConclusionFin, $fechaConclusionTemp, $responsableMuestra
            , $ensayo, $responsableEnsayo, $fechaProgramacionInicio, $fechaProgramacionFin, $fechaProgramacionTemp
            , $fechaAnalisisInicio, $fechaAnalisisFin, $fechaAnalisisTemp, $estadoEnsayo, $especificacion
            , $resultado, $pagina * $cantidad, $cantidad]);

        $auxMuestras = [];

        foreach ($resultAuxMuestras as $value) {
            array_push($auxMuestras, $value->id);
        }

        $muestras = Muestra::whereIn("id", $auxMuestras)->get();


        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        foreach ($muestras as $muestra) {
            $muestra->show_id_muestra = $muestra->prefijo . $separatorParameter->valor . $muestra->custom_id;
            $muestra->estado;
            $muestra->tercero;
            $muestra->producto;
            $muestra->lote;

            $auxFechaLlegada = new DateTime($muestra->fecha_llegada);
            $muestra->label_fecha_llegada = $auxFechaLlegada->format("Y-m-d");

            $auxFechaPreConclusion = new DateTime($muestra->fecha_pre_conclusion);
            $muestra->label_fecha_pre_conclusion = $muestra->fecha_pre_conclusion !== NULL ? $auxFechaPreConclusion->format("Y-m-d") : NULL;

            $auxFechaConclusion = new DateTime($muestra->fecha_conclusion);
            $muestra->label_fecha_conclusion = $muestra->fecha_conclusion !== NULL ? $auxFechaConclusion->format("Y-m-d") : NULL;


            $resultAuxEnsayos = Capsule::select("
                SELECT 
                t6.id,
                t6.descripcion_especifica,
                t8.nombre as responsable_ensayo,
                DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') as fecha_programacion,
                DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') as fecha_analisis,
                t9.descripcion as estado_ensayo,
                t6.especificacion,
                t10.resultado   
                FROM
                sgm_ensayo_muestra t6 
                LEFT JOIN sgm_programacion_analistas t7 ON t6.id = t7.id_ensayo_muestra
                LEFT JOIN sgm_usuario t8 ON t7.id_analista = t8.id 
                LEFT JOIN sgm_estado_ensayo_muestra t9 ON t6.estado_ensayo = t9.id
                LEFT JOIN sgm_resultados t10 ON t6.id = t10.id_ensayo_muestra
                WHERE 
                t6.id_muestra = ? AND
                ifnull(t6.descripcion_especifica,'') LIKE ? AND
                ifnull(t8.nombre,'') LIKE ? AND
                (DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') >= CAST(? AS DATE)
                    AND DATE_FORMAT(t6.fecha_programacion, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_programacion <=> ?) AND
                (DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') >= CAST(? AS DATE)
                    AND DATE_FORMAT(t6.fecha_analisis, '%Y-%m-%d') <= CAST(? AS DATE) OR t6.fecha_analisis <=> ?) AND
                ifnull(t9.descripcion,'') LIKE ? AND
                ifnull(t6.especificacion,'') LIKE ? AND
                ifnull(t10.resultado,'') LIKE ?;", [$muestra->id, $ensayo, $responsableEnsayo
                , $fechaProgramacionInicio, $fechaProgramacionFin, $fechaProgramacionTemp, $fechaAnalisisInicio
                , $fechaAnalisisFin, $fechaAnalisisTemp, $estadoEnsayo, $especificacion,
                $resultado]);

            $auxEnsayos = [];

            foreach ($resultAuxEnsayos as $auxEnsayo) {
                array_push($auxEnsayos, $auxEnsayo->id);
            }


            $muestra->ensayos_muestra = EnsayoMuestra::whereIn("id", $auxEnsayos)->get();

            foreach ($muestra->ensayos_muestra as $ensayoMuestra) {

                $programacion = ProgramacionAnalistas::where("id_ensayo_muestra", $ensayoMuestra->id)->first();
                $ensayoMuestra->analista_programado = Usuario::find($programacion->id_analista);

                $ensayoMuestra->estado;
                $ensayoMuestra->resultados;

                $auxFechaProgramacion = new DateTime($ensayoMuestra->fecha_programacion);
                $ensayoMuestra->label_fecha_programacion = $ensayoMuestra->fecha_programacion !== NULL ? $auxFechaProgramacion->format("Y-m-d") : NULL;

                $auxFechaAnalisis = new DateTime($ensayoMuestra->fecha_analisis);
                $ensayoMuestra->label_fecha_analisis = $ensayoMuestra->fecha_analisis !== NULL ? $auxFechaAnalisis->format("Y-m-d") : NULL;
            }
        }

        $auxMuestrasResponse = [];
        $flag = 0;

        for ($i = count($muestras); $i > 0; $i--) {
            $auxMuestrasResponse[$flag] = $muestras[$i - 1];
            $flag++;
        }

        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $auxMuestrasResponse
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getMuestrasTerminadas($pagina, $cantidad, $showIdMuestra, $producto, $cliente, $lote, $fecha_llegada, $fecha_conclusion, $fecha_entrega)
    {

        $showIdMuestra = "%" . $showIdMuestra . "%";
        $producto = "%" . $producto . "%";
        $cliente = "%" . $cliente . "%";
        $lote = "%" . $lote . "%";
        $fecha_llegada = "%" . $fecha_llegada . "%";
        $fecha_conclusion = "%" . $fecha_conclusion . "%";
        $fecha_entrega = "%" . $fecha_entrega . "%";

        $pagina--;

        $auxMuestrasTotal = Capsule::select("SELECT * FROM
            (
            SELECT 
            t1.id,
            concat(t1.prefijo, '-', t1.custom_id) as show_id_muestra,
            t2.nombre as producto, t3.nombre as cliente, t4.numero as lote, 
            t1.fecha_llegada, t1.fecha_conclusion, t1.fecha_entrega 
            FROM 
            sgm_muestra t1 
            join sgm_producto t2 on t2.id = t1.id_producto 
            join sgm_terceros t3 on t3.id = t1.id_tercero 
            join sgm_lote t4 on t4.id_muestra = t1.id 
            WHERE 
            t1.id_estado_muestra = 17 OR t1.id_estado_muestra = 10
            ORDER BY t1.id desc) sel1

            WHERE sel1.show_id_muestra like ? 
            AND ifnull(sel1.producto,'') like ? 
            AND ifnull(sel1.cliente,'') like ? 
            AND ifnull(sel1.lote,'') like ? 
            AND ifnull(sel1.fecha_llegada,'') like ? 
            AND ifnull(sel1.fecha_conclusion,'') like ? 
            AND ifnull(sel1.fecha_entrega,'') like ?  ;", [$showIdMuestra, $producto, $cliente, $lote, $fecha_llegada, $fecha_conclusion, $fecha_entrega]);

        $resultMuestras = Capsule::select("SELECT * FROM
            (
            SELECT 
            t1.id,
            concat(t1.prefijo, '-', t1.custom_id) as show_id_muestra,
            t2.nombre as producto, t3.nombre as cliente, t4.numero as lote, 
            t1.fecha_llegada, t1.fecha_conclusion, t1.fecha_entrega 
            FROM 
            sgm_muestra t1 
            join sgm_producto t2 on t2.id = t1.id_producto 
            join sgm_terceros t3 on t3.id = t1.id_tercero 
            join sgm_lote t4 on t4.id_muestra = t1.id 
            WHERE 
            t1.id_estado_muestra = 17 OR t1.id_estado_muestra = 10
            ORDER BY t1.id desc) sel1

            WHERE sel1.show_id_muestra like ? 
            AND ifnull(sel1.producto,'') like ? 
            AND ifnull(sel1.cliente,'') like ? 
            AND ifnull(sel1.lote,'') like ? 
            AND ifnull(sel1.fecha_llegada,'') like ? 
            AND ifnull(sel1.fecha_conclusion,'') like ? 
            AND ifnull(sel1.fecha_entrega,'') like ? 
            limit ?, ?;", [$showIdMuestra, $producto, $cliente, $lote, $fecha_llegada, $fecha_conclusion, $fecha_entrega, $pagina * $cantidad, $cantidad]);

        $auxMuestras = [];

        foreach ($resultMuestras as $value) {
            array_push($auxMuestras, $value->id);
        }


        $muestras = Muestra::whereIN("id", $auxMuestras)->get();

        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        foreach ($muestras as $muestra) {
            $muestra->fecha_llegada = (new DateTime($muestra->fecha_llegada))->format('Y-m-d');
            $muestra->show_id_muestra = $muestra->prefijo . $separatorParameter->valor . $muestra->custom_id;
            $muestra->producto_nombre = $muestra->producto->nombre;
            $muestra->cliente = $muestra->tercero->nombre;
            $muestra->lote_numero = $muestra->lote->numero;
        }


        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $muestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getEstMuestrasTerminadas($pagina, $cantidad, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis)
    {

        $showIdMuestra = "%" . $showIdMuestra . "%";
        $duracion = "%" . $duracion . "%";
        $temperatura = "%" . $temperatura . "%";
        $fechaAnalisis = "%" . $fechaAnalisis . "%";

        $pagina--;

        $auxSubMuestrasTotal = Capsule::select("SELECT * FROM
            (
            SELECT 
            t1.id,
            concat(t5.prefijo, '-', t2.custom_id) as show_id_muestra,
            t3.label as duracion,
            t4.label as temperatura,
            t1.fecha_analisis
            FROM 
            sgm_est_sub_muestra t1 
            JOIN sgm_est_muestra t2 ON t1.id_muestra = t2.id
            JOIN sgm_est_duracion_estabilidad t3 ON t1.id_duracion = t3.id
            JOIN sgm_est_temperatura t4 ON t1.id_temperatura = t4.id
            JOIN sgm_tipo_muestra t5 ON t2.id_tipo_muestra = t5.id
            WHERE 
            t1.id_estado = 17 OR t1.id_estado = 10
            ORDER BY t1.id desc) sel1

            WHERE sel1.show_id_muestra like ? AND
            sel1.duracion like ? AND
            sel1.temperatura like ? AND
            sel1.fecha_analisis like ? ;", [$showIdMuestra, $duracion, $temperatura, $fechaAnalisis]);

        $resultSubMuestras = Capsule::select("SELECT * FROM
            (
            SELECT 
            t1.id,
            concat(t5.prefijo, '-', t2.custom_id) as show_id_muestra,
            t3.label as duracion,
            t4.label as temperatura,
            t1.fecha_analisis
            FROM 
            sgm_est_sub_muestra t1 
            JOIN sgm_est_muestra t2 ON t1.id_muestra = t2.id
            JOIN sgm_est_duracion_estabilidad t3 ON t1.id_duracion = t3.id
            JOIN sgm_est_temperatura t4 ON t1.id_temperatura = t4.id
            JOIN sgm_tipo_muestra t5 ON t2.id_tipo_muestra = t5.id
            WHERE 
            t1.id_estado = 17 OR t1.id_estado = 10
            ORDER BY t1.id desc) sel1

            WHERE sel1.show_id_muestra like ? AND
            sel1.duracion like ? AND
            sel1.temperatura like ? AND
            sel1.fecha_analisis like ?
            limit ?, ?;", [$showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $pagina * $cantidad, $cantidad]);

        $auxSubMuestras = [];

        foreach ($resultSubMuestras as $value) {
            array_push($auxSubMuestras, $value->id);
        }


        $subMuestras = EstSubMuestra::whereIN("id", $auxSubMuestras)
            ->get();

        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        foreach ($subMuestras as $subMuestra) {
            $subMuestra->muestra->tipoMuestra;
            $subMuestra->duracion;
            $subMuestra->temperatura;
            $subMuestra->muestra->show_id_muestra = $subMuestra->muestra->tipoMuestra->prefijo . $separatorParameter->valor . $subMuestra->muestra->custom_id;
        }


        $auxResponse = array(
            "cantidad_total" => count($auxSubMuestrasTotal),
            "subMuestras" => $subMuestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getEstEnsayosTranscritos($consultaTodos, $idUsuario, $pagina, $cantidad, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $ensayo, $analista)
    {

        $diasAnticipacionEstabilidad = SystemParameters::where("propiedad", "diasAnticipacionBeEstabilidad")->first();

        $fechaLimite = new DateTime("now");
        $fechaLimite->add(new DateInterval("P" . $diasAnticipacionEstabilidad->valor . "D"));

        $showIdMuestra = "%" . $showIdMuestra . "%";
        $duracion = "%" . $duracion . "%";
        $temperatura = "%" . $temperatura . "%";
        $fechaAnalisis = "%" . $fechaAnalisis . "%";
        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $numeroLote = "%" . $numeroLote . "%";
        $analista = "%" . $analista . "%";
        $ensayo = "%" . $ensayo . "%";

        $pagina = $pagina - 1;

        if ($consultaTodos == 1) {

            $auxTotal = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 5 and t2.fecha_analisis <= ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.id", [$fechaLimite->format("Y-m-d"), $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo]);

            $aux = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 5 and t2.fecha_analisis <= ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.show_id_muestra
                limit ?,?", [$fechaLimite->format("Y-m-d"), $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo, $pagina * $cantidad, $cantidad]);

            $auxSubMuestras = [];

//$aux2 = $aux->toArray();

            foreach ($aux as $key => $value) {
                array_push($auxSubMuestras, $value->id);
            }

            $cantidadTotal = count($auxTotal);

            $subMuestras = EstSubMuestra::whereIn("id", $auxSubMuestras)
                ->get();

            $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

            foreach ($subMuestras as $key => $value) {

                $value->duracion = EstDuracionEstabilidad::find($value->id_duracion);
                $value->temperatura = EstTemperatura::find($value->id_temperatura);

                $value->muestra = EstMuestra::find($value->id_muestra);
                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);
                $value->muestra->tercero = Tercero::find($value->muestra->id_tercero);
                $value->muestra->producto = Producto::find($value->muestra->id_producto);

                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);

                $value->muestra->show_id_muestra = $value->muestra->tipo_muestra->prefijo . $separatorParameter->valor . $value->muestra->custom_id;


                $auxEnsayo = Capsule::select("
                    SELECT t2.nombre, t1.* FROM
                    sgm_est_ensayo_sub_muestra t1
                    JOIN sgm_usuario t2 ON t1.id_analista = t2.id
                    where
                    t1.estado_ensayo = 5 and 
                    t1.descripcion_especifica like ? and 
                    t2.nombre like ? and 
                    t1.id_sub_muestra = ?;", [$ensayo, $analista, $value->id]);

                foreach ($auxEnsayo as $ensayoSubMuestra) {
                    $ensayoSubMuestra->usuario_programado = Usuario::find($ensayoSubMuestra->id_analista);
                }

                $value->ensayos_sub_muestra = $auxEnsayo;
            }
        } else {

            $auxTotal = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 5 and t2.fecha_analisis <= ? and t2.id_analista = ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.id", [$fechaLimite->format("Y-m-d"), $idUsuario, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo]);

            $aux = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 5 and t2.fecha_analisis <= ? and t2.id_analista = ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.show_id_muestra
                limit ?,?", [$fechaLimite->format("Y-m-d"), $idUsuario, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo, $pagina * $cantidad, $cantidad]);

            $auxSubMuestras = [];

//$aux2 = $aux->toArray();

            foreach ($aux as $key => $value) {
                array_push($auxSubMuestras, $value->id);
            }

            $cantidadTotal = count($auxTotal);

            $subMuestras = EstSubMuestra::whereIn("id", $auxSubMuestras)
                ->get();

            $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

            foreach ($subMuestras as $key => $value) {

                $value->duracion = EstDuracionEstabilidad::find($value->id_duracion);
                $value->temperatura = EstTemperatura::find($value->id_temperatura);

                $value->muestra = EstMuestra::find($value->id_muestra);
                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);
                $value->muestra->tercero = Tercero::find($value->muestra->id_tercero);
                $value->muestra->producto = Producto::find($value->muestra->id_producto);

                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);

                $value->muestra->show_id_muestra = $value->muestra->tipo_muestra->prefijo . $separatorParameter->valor . $value->muestra->custom_id;


                $auxEnsayo = Capsule::select("
                    SELECT t2.nombre, t1.* FROM
                    sgm_est_ensayo_sub_muestra t1
                    JOIN sgm_usuario t2 ON t1.id_analista = t2.id
                    where
                    t1.estado_ensayo = 5 and 
                    t1.descripcion_especifica like ? and 
                    t2.nombre like ? and 
                    t1.id_sub_muestra = ? and
                    t1.id_analista = ? ;", [$ensayo, $analista, $value->id, $idUsuario]);

                foreach ($auxEnsayo as $ensayoSubMuestra) {
                    $ensayoSubMuestra->usuario_programado = Usuario::find($ensayoSubMuestra->id_analista);
                }

                $value->ensayos_sub_muestra = $auxEnsayo;
            }
        }

        $auxResponse = array(
            "cantidad_total" => $cantidadTotal,
            "subMuestras" => $subMuestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getEstEnsayosAnalizados($consultaTodos, $idUsuario, $pagina, $cantidad, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo)
    {

        $diasAnticipacionEstabilidad = SystemParameters::where("propiedad", "diasAnticipacionBeEstabilidad")->first();

        $fechaLimite = new DateTime("now");
        $fechaLimite->add(new DateInterval("P" . $diasAnticipacionEstabilidad->valor . "D"));

        $showIdMuestra = "%" . $showIdMuestra . "%";
        $duracion = "%" . $duracion . "%";
        $temperatura = "%" . $temperatura . "%";
        $fechaAnalisis = "%" . $fechaAnalisis . "%";
        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $numeroLote = "%" . $numeroLote . "%";
        $analista = "%" . $analista . "%";
        $ensayo = "%" . $ensayo . "%";

        $pagina = $pagina - 1;

        if ($consultaTodos == 1) {

            $auxTotal = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 4 and t2.fecha_analisis <= ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.id", [$fechaLimite->format("Y-m-d"), $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo]);

            $aux = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 4 and t2.fecha_analisis <= ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.show_id_muestra
                limit ?,?", [$fechaLimite->format("Y-m-d"), $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo, $pagina * $cantidad, $cantidad]);

            $auxSubMuestras = [];

//$aux2 = $aux->toArray();

            foreach ($aux as $key => $value) {
                array_push($auxSubMuestras, $value->id);
            }

            $cantidadTotal = count($auxTotal);

            $subMuestras = EstSubMuestra::whereIn("id", $auxSubMuestras)
                ->get();

            $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

            foreach ($subMuestras as $key => $value) {

                $value->duracion = EstDuracionEstabilidad::find($value->id_duracion);
                $value->temperatura = EstTemperatura::find($value->id_temperatura);

                $value->muestra = EstMuestra::find($value->id_muestra);
                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);
                $value->muestra->tercero = Tercero::find($value->muestra->id_tercero);
                $value->muestra->producto = Producto::find($value->muestra->id_producto);

                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);

                $value->muestra->show_id_muestra = $value->muestra->tipo_muestra->prefijo . $separatorParameter->valor . $value->muestra->custom_id;


                $auxEnsayo = Capsule::select("
                    SELECT t2.nombre, t1.* FROM
                    sgm_est_ensayo_sub_muestra t1
                    JOIN sgm_usuario t2 ON t1.id_analista = t2.id
                    where
                    t1.estado_ensayo = 4 and 
                    t1.descripcion_especifica like ? and 
                    t2.nombre like ? and 
                    t1.id_sub_muestra = ?;", [$ensayo, $analista, $value->id]);

                foreach ($auxEnsayo as $ensayoSubMuestra) {
                    $ensayoSubMuestra->usuario_programado = Usuario::find($ensayoSubMuestra->id_analista);
                }

                $value->ensayos_sub_muestra = $auxEnsayo;
            }
        } else {

            $auxTotal = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 4 and t2.fecha_analisis <= ? and t2.id_analista = ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.id", [$fechaLimite->format("Y-m-d"), $idUsuario, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo]);

            $aux = Capsule::select("select sel1.id from (
                select 
                concat(t4.prefijo, '-', t3.custom_id) as show_id_muestra,
                t1.id,
                t4.prefijo, 
                t3.custom_id, 
                t7.label as duracion, 
                t8.label as temperatura,
                t1.fecha_analisis,
                t5.nombre as cliente, 
                t6.nombre as producto, 
                t3.numero_lote, 
                t2.descripcion_especifica as ensayo,
                t9.nombre as analista
                from sgm_est_sub_muestra t1
                JOIN sgm_est_ensayo_sub_muestra t2 ON t1.id = t2.id_sub_muestra
                JOIN sgm_est_muestra t3 ON t1.id_muestra = t3.id
                JOIN sgm_tipo_muestra t4 ON t3.id_tipo_muestra = t4.id
                JOIN sgm_terceros t5 ON t3.id_tercero = t5.id
                JOIN sgm_producto t6 ON t3.id_producto = t6.id
                JOIN sgm_est_duracion_estabilidad t7 ON t1.id_duracion = t7.id
                JOIN sgm_est_temperatura t8 ON t1.id_temperatura = t8.id
                JOIN sgm_usuario t9 ON t2.id_analista = t9.id
                where t2.estado_ensayo = 4 and t2.fecha_analisis <= ? and t2.id_analista = ? ) sel1 

                where 
                
                sel1.show_id_muestra like ? and 
                sel1.duracion like ? and
                sel1.temperatura like ? and 
                sel1.fecha_analisis like ? and
                sel1.cliente like ? and
                sel1.producto like ? and
                sel1.numero_lote like ? and
                sel1.analista like ? and
                sel1.ensayo like ?

                group by sel1.show_id_muestra
                limit ?,?", [$fechaLimite->format("Y-m-d"), $idUsuario, $showIdMuestra, $duracion, $temperatura, $fechaAnalisis, $cliente, $producto, $numeroLote, $analista, $ensayo, $pagina * $cantidad, $cantidad]);

            $auxSubMuestras = [];

//$aux2 = $aux->toArray();

            foreach ($aux as $key => $value) {
                array_push($auxSubMuestras, $value->id);
            }

            $cantidadTotal = count($auxTotal);

            $subMuestras = EstSubMuestra::whereIn("id", $auxSubMuestras)
                ->get();

            $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

            foreach ($subMuestras as $key => $value) {

                $value->duracion = EstDuracionEstabilidad::find($value->id_duracion);
                $value->temperatura = EstTemperatura::find($value->id_temperatura);

                $value->muestra = EstMuestra::find($value->id_muestra);
                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);
                $value->muestra->tercero = Tercero::find($value->muestra->id_tercero);
                $value->muestra->producto = Producto::find($value->muestra->id_producto);

                $value->muestra->tipo_muestra = TipoMuestra::find($value->muestra->id_tipo_muestra);

                $value->muestra->show_id_muestra = $value->muestra->tipo_muestra->prefijo . $separatorParameter->valor . $value->muestra->custom_id;


                $auxEnsayo = Capsule::select("
                    SELECT t2.nombre, t1.* FROM
                    sgm_est_ensayo_sub_muestra t1
                    JOIN sgm_usuario t2 ON t1.id_analista = t2.id
                    where
                    t1.estado_ensayo = 4 and 
                    t1.descripcion_especifica like ? and 
                    t2.nombre like ? and 
                    t1.id_sub_muestra = ? and
                    t1.id_analista = ? ;", [$ensayo, $analista, $value->id, $idUsuario]);

                foreach ($auxEnsayo as $ensayoSubMuestra) {
                    $ensayoSubMuestra->usuario_programado = Usuario::find($ensayoSubMuestra->id_analista);
                }

                $value->ensayos_sub_muestra = $auxEnsayo;
            }
        }


        $auxResponse = array(
            "cantidad_total" => $cantidadTotal,
            "subMuestras" => $subMuestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getEstEnsayosProgramados()
    {


        $diasAnticipacionEstabilidad = SystemParameters::where("propiedad", "diasAnticipacionBeEstabilidad")->first();

        $now = new DateTime("now");
        $now->add(new DateInterval("P" . $diasAnticipacionEstabilidad->valor . "D"));


        $aux = Capsule::select("SELECT id_sub_muestra FROM sgm_est_ensayo_sub_muestra where estado_ensayo = 1 group by id_sub_muestra;");
        $auxArray = [];
        foreach ($aux as $key => $value) {
            array_push($auxArray, $value->id_sub_muestra);
        }


        $submuestras = EstSubMuestra::whereDate("fecha_analisis", "<", $now)
            ->whereIn("id", $auxArray)->get();


        $prefixMuestraSeparator = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        foreach ($submuestras as $key => $value) {

            $value->ensayos_sub_muestra = $value->ensayosSubMuestra()->where("estado_ensayo", 1)->get();
            foreach ($value->ensayos_sub_muestra as $ensayo) {
                $ensayo->usuarioProgramado;
            }
            $value->muestra;
            $value->duracion;
            $value->temperatura;
            $value->muestra->tipoMuestra;
            $value->muestra->tercero;
            $value->muestra->producto;
            $value->muestra->show_id_muestra = $value->muestra->tipoMuestra->prefijo . $prefixMuestraSeparator->valor . $value->muestra->custom_id;
        }


        $response = json_encode($submuestras);

        echo $response;
    }

    function getDatosGraficaMuestrasPorTipoProducto($fechaInicial, $fechaFinal)
    {


        $tablaMuestras = new TablaMuestraDbModelClass();

        $result = $tablaMuestras->getDatosGraficaMuestrasPorTipoProdcuto($fechaInicial, $fechaFinal);


//$response = array("code" => "00000", "message" => "OKr");
        $response = json_encode($result);

        echo $response;
    }

    function getMuestrasEstados($fechaInicial, $fechaFinal)
    {

        $SQL = Capsule::select("SELECT t2.id, t2.descripcion as estado,
                count(t1.id) as muestras
                FROM sgm_muestra t1 
                JOIN sgm_estado t2 ON t2.id = t1.id_estado_muestra 
                where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? 
                GROUP BY t2.id;",[$fechaInicial,$fechaFinal]);

        $response = array(
            "code" => "00000",
            "message" => "OKr",
            "data" => $SQL
        );

        $response = json_encode($response);

        echo $response;
    }

    function getSubMuestraEstabilidadParaRevision2()
    {
        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $subMuestras = EstSubMuestra::where("id_estado", 16)->whereDate("fecha_analisis", "<", $auxFecha)->get();

        foreach ($subMuestras as $value) {
            $value->duracion;
            $value->temperatura;
            $value->muestra->tercero;
            $value->muestra->producto;
            $value->muestra->tipoMuestra;
        }

        $response = array("code" => "00000", "message" => "OK", "data" => $subMuestras->toArray());
        $response = json_encode($response);
        echo $response;
    }

    function getSubMuestraEstabilidadParaRevision()
    {
        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $tablaEnsayoSubmuestra = new TablaEstEnsayoSubMuestraDbModel();

        $result = $tablaEnsayoSubmuestra->getEnsayosSubMuestraParaRevisionBe($auxFecha->format("Y-m-d"));

        $response = json_encode($result);
        echo $response;
    }

    function getMuestrasToConsultaMuetras($cantidad, $pagina, $prefijo, $customId, $producto, $tercero, $lote, $estadoMuestra, $fechaLlegada, $fechaCompromiso, $observacion, $contacto, $numFatura, $fechaEntrega)
    {
        $tablaMuestra = new TablaMuestraDbModelClass();

        $result = $tablaMuestra->getMuestrasToConsultaMuetras($cantidad, $pagina, $prefijo, $customId, $producto, $tercero, $lote, $estadoMuestra, $fechaLlegada, $fechaCompromiso, $observacion, $contacto, $numFatura, $fechaEntrega);

        $response = json_encode($result);
        echo $response;
    }

    function getSubMuestraEstabilidadParaTranscripcion()
    {
        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $tablaEnsayoSubmuestra = new TablaEstEnsayoSubMuestraDbModel();

        $result = $tablaEnsayoSubmuestra->getEnsayosSubMuestraParaTranscripcionBe($auxFecha->format("Y-m-d"));

        $response = json_encode($result);
        echo $response;
    }

    function getSubMuestraEstabilidadParaAnalisis()
    {
        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $tablaEnsayoSubmuestra = new TablaEstEnsayoSubMuestraDbModel();

        $result = $tablaEnsayoSubmuestra->getEnsayosSubMuestraParaAalisisBe($auxFecha->format("Y-m-d"));

        $response = json_encode($result);
        echo $response;
    }

    function getMuestraEstabilidadParaProgramacion()
    {

        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $subMuestras = EstSubMuestra::whereDate("fecha_analisis", "<", $auxFecha)->where(function ($query) {
            $query->where("id_estado", 1)
                ->orWhere("id_estado", 2);
        })->get();
        foreach ($subMuestras as $key => $value) {
            $value->muestra->producto;
            $value->muestra->tipoMuestra;
            $value->muestra->tercero;
            $value->duracion;
            $value->temperatura;

            $value->muestra->personal_id = $value->muestra->tipoMuestra->prefijo . "-" . $value->muestra->custom_id;
        }


        $response = array("code" => "00000", "message" => "OK", "data" => $subMuestras);
        $response = json_encode($response);
        echo $response;
    }

    function getSubMuestrasEstabilidadAprobadas()
    {

        $subMuestras = EstSubMuestra::where("id_estado", 17)->get();

        foreach ($subMuestras as $subMuestra) {
            $subMuestra->muestra->producto;
            $subMuestra->muestra->tercero;
            $subMuestra->muestra->tipoMuestra;
            $subMuestra->duracionEstabilidad;
            $subMuestra->temperatura;
        }


        $response = array(
            "code" => "00000",
            "message" => "OK",
            "data" => $subMuestras->toArray()
        );
        $response = json_encode($response);
        echo $response;
    }

    function getInformeTendenciaData($fechaInicial, $fechaFinal, $idCliente, $idProducto)
    {

        $fechaInicial = new DateTime($fechaInicial);
        $stringFechaInicial = $fechaInicial->format("Y-m-d");

        $fechaFinal = new DateTime($fechaFinal);
        $stringFechaFinal = $fechaFinal->format("Y-m-d");

        $data = Muestra::where('id_tercero', $idCliente)->where("id_producto", $idProducto)->where("fecha_llegada", ">", $fechaInicial)->where("fecha_llegada", "<", $fechaFinal)->get();

        foreach ($data as $muestra) {
            foreach ($muestra->ensayosMuestra as $ensayoMuestra) {
                $ensayoMuestra->ensayo;
                $ensayoMuestra->resultados;
            }
        }

        $response = array(
            "code" => "00000",
            "message" => "OK",
            "data" => $data->toArray()
        );
        $response = json_encode($response);
        echo $response;
    }

    function removePerfilPermiso($idPerfil, $idPermiso)
    {
        $tablaPerfil = new TablaPerfilDbModelClass();
        $old = $tablaPerfil->getPerfilByIdToAud($idPerfil);

        $item = PerfilPermiso::where("id_perfil", $idPerfil)
            ->where("id_permiso", $idPermiso)
            ->delete();
        $response = array(
            "code" => "00000",
            "message" => "OK"
        );

        $new = $tablaPerfil->getPerfilByIdToAud($idPerfil);
        $this->insertPerfilAud($old, $new, $idPerfil, "update", "Remove permiso a perfil usuario");

        $response = json_encode($response);
        echo $response;
    }

    function createPerfilPermiso($idPerfil, $idPermiso)
    {
        $tablaPerfil = new TablaPerfilDbModelClass();
        $old = $tablaPerfil->getPerfilByIdToAud($idPerfil);

        $item = new PerfilPermiso();
        $item->id_perfil = $idPerfil;
        $item->id_permiso = $idPermiso;
        $item->save();
        $response = array(
            "code" => "00000",
            "message" => "OK"
        );

        $new = $tablaPerfil->getPerfilByIdToAud($idPerfil);
        $this->insertPerfilAud($old, $new, $idPerfil, "update", "Asignación permiso a perfil usuario");

        $response = json_encode($response);
        echo $response;
    }

    function getPermisos()
    {
        $permisos = Permiso::where("nivel", "!=", 0)->orderBy("orden", "asc")->get();

        $response = array(
            "code" => "00000",
            "message" => "OK",
            "data" => $permisos->toArray()
        );
        $response = json_encode($response);
        echo $response;
    }

    function getPerfiles()
    {
        $perfiles = Perfil::all();
        foreach ($perfiles as $perfil) {
            $perfil->permisos;
        }
        $response = array(
            "code" => "00000",
            "message" => "OK",
            "data" => $perfiles->toArray()
        );
        $response = json_encode($response);
        echo $response;
    }

    function verificarMuestra($muestraData, $conclusion, $fechaConclusion, $observacion)
    {

        $old = AuditoriaController::getFullMuestraToAud($muestraData["id"]);

        $muestraController = new MuestraController();
        $response = $muestraController->verificarMuestra($muestraData["id"], $conclusion, $fechaConclusion, $_SESSION['userId'], $observacion);
        $response = json_encode($response);

        $new = AuditoriaController::getFullMuestraToAud($muestraData["id"]);
        AuditoriaController::insertMuestraAud($old, $new, $muestraData["id"], "update", "Aprobación de muestra");

        echo $response;
    }

    function reprogramarEnsayoMuestra($ensayo)
    {

        $old = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);

        $tablaProgramacionAnalistas = new TablaProgramacionAnalistasDbModelClass();
        $eliminarProgramacion = $tablaProgramacionAnalistas->deleteProgramacionByIdEnsayoMuestra($ensayo["id"]);

        $fechaReprogracion = (new DateTime($ensayo["fecha_reprogramacion"]))->format('Y-m-d');
        $ensayoMuestraController = new EnsayoMuestraController();
        $response = $ensayoMuestraController->reprogramarEnsayoMuestra($ensayo["id_muestra"]
            , $ensayo["id"], $ensayo["motivo"], $fechaReprogracion);
        $response = json_encode($response);

        $new = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);
        AuditoriaController::insertMuestraAud($old, $new, $ensayo["id_muestra"], "update", "Reprogramación de ensayo muestra");

        echo $response;
    }

    function rfeEnsayoMuestra($ensayo)
    {

        $old = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);

        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $infoEnsayoMuestra = $tablaEnsayoMuestra->getEnsayoMuestraById($ensayo["id"]);

        $insertEnsayoMuestraRfe = $tablaEnsayoMuestra->insertEnsayoMuestra($ensayo["id_muestra"], $infoEnsayoMuestra[0]["id_paquete"], $infoEnsayoMuestra[0]["id_ensayo"]
            , $infoEnsayoMuestra[0]["validacion"], $infoEnsayoMuestra[0]["area_analisis"], $infoEnsayoMuestra[0]["tiempo"], $infoEnsayoMuestra[0]["duracion"]
            , $infoEnsayoMuestra[0]["equipo"], $infoEnsayoMuestra[0]["id_metodo"], $infoEnsayoMuestra[0]["especificacion"], $infoEnsayoMuestra[0]["descripcion_especifica"], $infoEnsayoMuestra[0]["valor"]);

        $ensayoMuestraController = new EnsayoMuestraController();
        $response = $ensayoMuestraController->rechazarEnsayoMuestraRfe($ensayo["id_muestra"]
            , $ensayo["id"], $ensayo["motivo"], 1);
        $response = json_encode($response);

        $new = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);
        AuditoriaController::insertMuestraAud($old, $new, $ensayo["id_muestra"], "update", "RFE de ensayo muestra");

        echo $response;
    }

    function rechazarEnsayoMuestra($ensayo)
    {

        $old = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);

        $ensayoMuestraController = new EnsayoMuestraController();
        $response = $ensayoMuestraController->rechazarEnsayoMuestra($ensayo["id_muestra"], $ensayo["id"]);
        $response = json_encode($response);

        $new = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);
        AuditoriaController::insertMuestraAud($old, $new, $ensayo["id_muestra"], "update", "Rechazo de ensayo");

        echo $response;
    }

    function aprobarEnsayoMuestra($ensayo)
    {

        $old = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);

        $ensayoMuestraController = new EnsayoMuestraController();
        $response = $ensayoMuestraController->aprobarEnsayoMuestra($ensayo["id_muestra"], $ensayo["id"]);
        $response = json_encode($response);

        $new = AuditoriaController::getFullMuestraToAud($ensayo["id_muestra"]);
        AuditoriaController::insertMuestraAud($old, $new, $ensayo["id_muestra"], "update", "Revisión de ensayo");

        echo $response;
    }

    function updateResultado($resultado, $muestraData, $ensayoData)
    {

        $old = AuditoriaController::getFullMuestraToAud($muestraData["id"]);

        $tablaResultado = new TablaResultadoDbModelClass();
        $idResultado = $resultado["id"];
        $idLote = $resultado["id_lote"];
        $resultadot = $resultado["resultado"];
        $observaciones = $resultado["observaciones"];
        $idUsuario = $_SESSION['userId'];
        $observaciones = $resultado["observaciones"];
        $fechaRegistro = $resultado["fecha_registro"];
        $resultado1 = $resultado["resultado_1"];
        $resultado2 = $resultado["resultado_2"];
        $resultadoNumerico = $resultado["resultado_numerico"];

        $result = $tablaResultado->updateResultadoById2($idResultado, $idLote, $resultadot, $observaciones, $idUsuario, $fechaRegistro, $resultado1, $resultado2, $resultadoNumerico);
        if ($result) {
            $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
            $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestra2($ensayoData["id"], 5);
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("guardarResultado", $muestraData);
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "Error",
                "data" => false
            );
        }

        $new = AuditoriaController::getFullMuestraToAud($muestraData["id"]);
        AuditoriaController::insertMuestraAud($old, $new, $muestraData["id"], "update", "actualizacion resultado");

        $response = json_encode($response);
        echo $response;
    }

    function insertResultado($muestra, $ensayo)
    {

        $old = AuditoriaController::getFullMuestraToAud($muestra["id"]);

        $resultadoController = new ResultadoController();
        $idLote = $muestra["lote"]["id"];
        $resultado = $ensayo["resultados"][0]["resultado"];
        $observaciones = $ensayo["resultados"][0]["observaciones"];
        $usuarioRegistro = $_SESSION['userId'];
        $fechaRegistro = $ensayo["resultados"][0]["fecha_registro"];
        $resultadoNumerico = $ensayo["resultados"][0]["resultado_numerico"];
        $resultado1 = $ensayo["resultados"][0]["resultado_1"];
        $resultado2 = $ensayo["resultados"][0]["resultado_2"];
        $response = $resultadoController->guardarResultado($muestra, $muestra["id"], $ensayo["id"], $idLote, $resultado, $observaciones, $usuarioRegistro, $fechaRegistro, $resultadoNumerico, $resultado1, $resultado2);

        $new = AuditoriaController::getFullMuestraToAud($muestra["id"]);
        AuditoriaController::insertMuestraAud($old, $new, $muestra["id"], "update", "Registro de resultado");

        $response = json_encode($response);
        echo $response;
    }

    function analizarEnsayoMuestra($muestraData, $ensayosData, $fechaAnalisisEnsayo)
    {
        $ensayoMuestraController = new EnsayoMuestraController();
        $old = AuditoriaController::getFullMuestraToAud($muestraData["id"]);
        foreach ($ensayosData as $ensayo) {
            $response = $ensayoMuestraController->analizarEnsayoMuestra($muestraData, $ensayo, $fechaAnalisisEnsayo);
        }
        $new = AuditoriaController::getFullMuestraToAud($muestraData["id"]);
        AuditoriaController::insertMuestraAud($old, $new, $muestraData["id"], "update", "Analisis de ensayo");
        $response = json_encode($response);
        echo $response;
    }

    function alamacenarMuestra($almacenData, $idMuestra)
    {
        $tabla = new TablaAlmacenamientoDbModelClass();
        $result = $tabla->insertAlamacenamiento2($idMuestra, $almacenData["fecha"], $almacenData["idUbicacion"], $almacenData["idTIpoAlmacenamineto"], $almacenData["nivel"], $almacenData["caja"], $almacenData["tiempo"]);
        if ($result["code"] == "00000") {
            $generalCOntroller = new GeneralController();
            $generalCOntroller->updateEstadoByIdMuestra($idMuestra, 10, null, null);
        }
        $response = json_encode($result);
        echo $response;
    }

    function createNewLoteCepa($newLoteData, $idCepa)
    {
        $tabla = new TablaLoteCepaDbModelClass();
        $result = $tabla->insertNewLote($newLoteData["codigo"], $newLoteData["descripcion"], $newLoteData["fecha_vencimiento"], 0, $newLoteData["tipo"]
            , $newLoteData["cantidad_actual"], $newLoteData["fecha_ingreso"], $newLoteData["fecha_apertura"], $newLoteData["fecha_terminacion"]
            , $newLoteData["fecha_preparacion"], $newLoteData["fecha_promocion"], $newLoteData["cantidad_preparada"], $idCepa
            , $newLoteData["lote_interno"]);
        $response = json_encode($result);
        echo $response;
    }

    function activarLoteCepa($loteCepaData)
    {
        $tabla = new TablaLoteCepaDbModelClass();
        $resultDeactivate = $tabla->deactivateLotesByIdCepa($loteCepaData["id_cepa"]);
        if ($resultDeactivate["code"] == "00000") {
            $resultActivate = $tabla->activateLoteById($loteCepaData["id"]);
            $response = json_encode($resultActivate);
        } else {
            $response = json_encode($resultDeactivate);
        }
        echo $response;
    }

    function getLotesByIdCepa($idCepa)
    {
        $tabla = new TablaLoteCepaDbModelClass();
        $result = $tabla->getLotesByIdCepa($idCepa);
        $response = json_encode($result);
        echo $response;
    }

    function updateCepa($cepaData)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->updateCepaById($cepaData["id"], $cepaData["codigo"], $cepaData["nombre"], $cepaData["tipo"], $cepaData["activo"]);
        $response = json_encode($result);
        echo $response;
    }

    function createNewCepa($cepaData)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->insertNewCepa($cepaData["codigo"], $cepaData["nombre"], $cepaData["tipo"], 1);
        $response = json_encode($result);
        echo $response;
    }

    function getAllActiveCepas()
    {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->getAllActiveCepas();
        $response = json_encode($result);
        echo $response;
    }

    function getPlantillas()
    {
        $tablaPlantilla = new TablaPlantillaDbModelClass();
        $result = $tablaPlantilla->getAllPlantillas2();
        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosWithOutProgramacionByidAreaAnalisis($idAreAnalisis)
    {
        $EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getEnsayosWithOutProgramacionByidAreaAnalisis2($idAreAnalisis);
        if ($data != false) {
            $utilController = new UtilsController();
            foreach ($data as $ensayo) {
                $fechaLlegada = new DateTime($ensayo['fecha_llegada']);
                $fechaLlegada = $fechaLlegada->format("d/m/Y");
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["customId"]);

                $ensayos[] = array(
                    'customId' => $auxIdMuestra,
                    'idMuestra' => $ensayo['id_muestra'],
                    'estadoMuestra' => $ensayo['estado_muestra'],
                    'fechaLlegada' => $fechaLlegada,
                    'nombreTercero' => $ensayo['nombre_tercero'],
                    'producto' => $ensayo['producto'],
                    'lote' => $ensayo['lote']
                );
            }
            echo json_encode($ensayos);
        } else {
            echo json_encode(NULL);
        }
    }

    function getSessionUserData()
    {
        $result = array(
            "code" => "00000",
            "message" => "OK",
            "data" => array(
                "usernombre" => $_SESSION['user_nombre'],
                "userLogin" => $_SESSION['user_login'],
                "userIdPerfil" => $_SESSION['user_id_perfil'],
                "userIdJefe" => $_SESSION['user_id_jefe'],
                "userIdCargo" => $_SESSION['user_id_cargo'],
                "userEsJefe" => $_SESSION['user_es_jefe'],
                "userEmail" => $_SESSION['user_email'],
                "userId" => $_SESSION['userId'],
                "permisos" => array(
                    "checkAnalisisRealizadoHojaTrabajo" => (boolean)$_SESSION['checkAnalisisRealizadoHojaTrabajo'],
                    "revisionEnsayoHojaTrabajo" => (boolean)$_SESSION['revisionEnsayoHojaTrabajo'],
                    "consultaResultadoHojaTrabajo" => (boolean)$_SESSION['consultaResultadoHojaTrabajo'],
                    "registroResultadoHojaTrabajo" => (boolean)$_SESSION['registroResultadoHojaTrabajo'],
                    "reprogramacionEnsayoHojaTrabajo" => (boolean)$_SESSION['reprogramacionEnsayoHojaTrabajo'],
                    "aprobarMuestraHojaTrabajo" => (boolean)$_SESSION['aprobarMuestraHojaTrabajo'],
                    "revisarMuestraHojaTrabajo" => (boolean)$_SESSION['revisarMuestraHojaTrabajo'],
                    "163" => (boolean)$_SESSION['permiso-163'],
                ),
                "permisosBandejaEntrada" => array(
                    "muestrasVerificadas" => $_SESSION['muestrasVerificadas'],
                    "muestrasXProgramarFQ" => $_SESSION['muestrasXProgramarFQ'],
                    "muestrasXProgramarMB" => $_SESSION['muestrasXProgramarMB'],
                    "EnsayosEstadoProgramado" => $_SESSION['EnsayosEstadoProgramado'],
                    "EnsayosEstadoParaTranscrip" => $_SESSION['EnsayosEstadoParaTranscrip'],
                    "ensayosParaRevisionFQ" => $_SESSION['ensayosParaRevisionFQ'],
                    "ensayosParaRevisionMB" => $_SESSION['ensayosParaRevisionMB'],
                    "muestrasParaVerificar" => $_SESSION['muestrasParaVerificar'],
                    "subMuestrasEstabilidadParaProgramar" => $_SESSION['subMuestrasEstabilidadParaProgramar'],
                    "subMuestrasEstabilidadParaAnalisis" => $_SESSION['subMuestrasEstabilidadParaAnalisis'],
                    "subMuestrasEstabilidadParaTrancripcion" => $_SESSION['subMuestrasEstabilidadParaTrancripcion'],
                    "subMuestrasEstabilidadParaRevision" => $_SESSION['subMuestrasEstabilidadParaRevision'],
                    "muestrasParaFacturacion" => $_SESSION['muestrasParaFacturacion'],
                    "muestrasParaEntrega" => $_SESSION['muestrasParaEntrega'],
                    "muestrasSalida" => $_SESSION['muestrasSalida'],
                    "solicitudesParaRecoleccion" => $_SESSION['solicitudesParaRecoleccion'],
                    "solicitudesProgramadas" => $_SESSION['solicitudesProgramadas'],
                    "19" => (boolean)$_SESSION['subMuestrasEstabilidadAprobadas'],
                    "20" => (boolean)$_SESSION['subMuestrasEstabilidadRevisionSinEnsayos'],
                    "21" => (boolean)$_SESSION['graficaMuestrasPorEstado'],
                    "22" => (boolean)$_SESSION['graficaMuestrasPorTipoProducto'],
                    "23" => (boolean)$_SESSION['subMuestrasEstabilidadTerminadas'],
                    "24" => (boolean)$_SESSION['muestrasTerminadas'],
                    "25" => (boolean)$_SESSION['muestrasGrillaGerencial'],
                    "26" => (boolean)$_SESSION['muestrasEstabilidadGrillaGerencial'],
                    "27" => (boolean)$_SESSION['graficaUsoReactivos'],
                    "28" => (boolean)$_SESSION['graficaUsoEstandares'],
                    "29" => (boolean)$_SESSION['graficaParticipacionClientes'],
                    "30" => (boolean)$_SESSION['graficaParticipacionClientesEst'],
                    "31" => (boolean)$_SESSION['muestrasProgramadasTercero'],
                    "32" => (boolean)$_SESSION['muestrasEstProgramadasTercero'],
                    "33" => (boolean)$_SESSION['graficaDesempenoAnalistas'],
                ),
                "session" => $_SESSION
            )
        );

        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosPorProgramarMicrobiologicos()
    {
        $EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getEnsayosPorProgramar(2);
        if ($data["code"] == "00000") {
            $utilController = new UtilsController();
            foreach ($data["data"] as $muestra) {
                $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra->prefijo, $muestra->customId);
                $fechaLlegada = new DateTime($muestra->fecha_llegada);
                $fechaLlegada = $fechaLlegada->format("d/m/Y");
                $muestras[] = array(
                    'custom_id' => $auxIdMuestra,
                    'id_muestra' => $muestra->id_muestra,
                    'estado_muestra' => $muestra->estado_muestra,
                    'fecha_llegada' => $fechaLlegada,
                    'nombre_tercero' => $muestra->nombre_tercero,
                    'producto' => $muestra->producto,
                    'lote' => $muestra->lote
                );
            }
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
            echo json_encode($response);
        } else {
            echo json_encode(NULL);
        }
    }

    function getEnsayosPorProgramarFisicoquimicos()
    {
        $EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getEnsayosPorProgramar(1);
        if ($data["code"] == "00000") {
            $utilController = new UtilsController();
            foreach ($data["data"] as $muestra) {
                $fechaLlegada = new DateTime($muestra->fecha_llegada);
                $fechaLlegada = $fechaLlegada->format("d/m/Y");

                $fechaCompromiso = new DateTime($muestra->fecha_compromiso);
                $fechaCompromiso = $fechaCompromiso->format("d/m/Y");
                $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra->prefijo, $muestra->customId);

                $muestras[] = array(
                    'custom_id' => $auxIdMuestra,
                    'id_muestra' => $muestra->id_muestra,
                    'estado_muestra' => $muestra->estado_muestra,
                    'fecha_llegada' => $fechaLlegada,
                    'nombre_tercero' => $muestra->nombre_tercero,
                    'producto' => $muestra->producto,
                    'lote' => $muestra->lote,
                    'fecha_compromiso' => $fechaCompromiso
                );
            }
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
            echo json_encode($response);
        } else {
            echo json_encode(NULL);
        }
    }

    function asociarMediosCultivo($idEnsayo, $mediosCultivoData)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        foreach ($mediosCultivoData as $medio) {
            $result = $tablaMedioCultivo->insertAsociacionEnsayoMedioCultivo($idEnsayo, $medio["id"]);
            if ($result["code"] != "00000") {
                break;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function desasociarMediosCultivo($asociacionesData)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        foreach ($asociacionesData as $asociacion) {
            $result = $tablaMedioCultivo->deleteAsociacionEnsayoMedioCultivoById($asociacion["id_asociacion"]);
            if ($result["code"] != "00000") {
                break;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function getMediosCultivoDisponiblesByIdEnsayo($idEnsayo)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->getMediosCultivoDisponiblesByIdEnsayo($idEnsayo);
        $response = json_encode($result);
        echo $response;
    }

    function getMediosCultivoByIdEnsayo($idEnsayo)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->getMediosCultivoByIdEnsayo($idEnsayo);
        $response = json_encode($result);
        echo $response;
    }

    function insertEnsayo($ensayoData)
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $result = $tablaEnsayo->insertEnsayo2($ensayoData["precio"], $ensayoData["duracion"], $ensayoData["id_plantilla"], 0, $ensayoData["descripcion"], $ensayoData["codinterno"], $ensayoData["prog_automatica"]);

        $new = $tablaEnsayo->getEnsayoByIdToAud($result["data"]);
        $tablaEnsayo->insertAudEnsayo(NULL, $new, $result["data"], "create", "creación nuevo ensayo");

        $response = json_encode($result);
        echo $response;
    }

    function deleteEnsayo($idEnsayo)
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $old = $tablaEnsayo->getEnsayoByIdToAud($idEnsayo);

        $result = $tablaEnsayo->deleteEnsayoById($idEnsayo);

        $new = $tablaEnsayo->getEnsayoByIdToAud($idEnsayo);
        $tablaEnsayo->insertAudEnsayo($old, $new, $idEnsayo, "delete", "Borrado de ensayo");

        $response = json_encode($result);
        echo $response;
    }

    function updateEnsayo($ensayoData)
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $old = $tablaEnsayo->getEnsayoByIdToAud($ensayoData["id"]);

        $result = $tablaEnsayo->updateEnsayoById2($ensayoData["id"], $ensayoData["precio_real"], $ensayoData["tiempo"], $ensayoData["id_plantilla"]
            , $ensayoData["descripcion"], $ensayoData["codinterno"], $ensayoData["orden"], $ensayoData["prog_automatica"]);

        $new = $tablaEnsayo->getEnsayoByIdToAud($ensayoData["id"]);
        $tablaEnsayo->insertAudEnsayo($old, $new, $ensayoData["id"], "update", "Actualización de ensayo");

        $response = json_encode($result);
        echo $response;
    }

    function getAllActiveEnsayo()
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $result = $tablaEnsayo->getAllActiveEnsayo();
        $response = json_encode($result);
        echo $response;
    }

    function getEquiposActivos()
    {
        $tablaEquipos = new TablaEquiposDbModelClass();
        $resultEquipos = $tablaEquipos->getAllEquiposActivos2();
        $response = json_encode($resultEquipos);
        echo $response;
    }

    function getEnsayosMic()
    {
        $tablaEnsayos = new TablaEnsayoDbModelClass();
        $resulEnsayos = $tablaEnsayos->getEnsayosMic();
        $response = json_encode($resulEnsayos);
        echo $response;
    }

    function getAllMedioCultivo()
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->getAllMedioCultivo();
        $response = json_encode($result);
        echo $response;
    }

    function saveNewMedioCultivo($newMedioCutlivoData)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->insertMedioCultivo($newMedioCutlivoData["codigo"], $newMedioCutlivoData["nombre"], $newMedioCutlivoData["tipo"], $newMedioCutlivoData["temperatura"], 1);
        $response = json_encode($result);
        echo $response;
    }

    function getLotesByIdMedioCultivo($idMedioCultivo)
    {
        $tablaLoteMedioCultivo = new TablaLoteMedioCultivoDbModelClass();
        $result = $tablaLoteMedioCultivo->getLotesByIdMedioCultivo($idMedioCultivo);
        $response = json_encode($result);
        echo $response;
    }

    function saveNewLoteMedioCultivo($loteMedioCultivoData)
    {
        $tablaLoteMedioCultivo = new TablaLoteMedioCultivoDbModelClass();
        $result = $tablaLoteMedioCultivo->insertNewLoteMc($loteMedioCultivoData["codigo"], $loteMedioCultivoData["descripcion"], $loteMedioCultivoData["fecha_vencimiento"], $loteMedioCultivoData["activo"], $loteMedioCultivoData["tipo"], $loteMedioCultivoData["cantidad_actual"], $loteMedioCultivoData["fecha_ingreso"], $loteMedioCultivoData["fecha_apertura"], $loteMedioCultivoData["fecha_terminacion"], $loteMedioCultivoData["fecha_preparacion"], $loteMedioCultivoData["fecha_promocion"], $loteMedioCultivoData["cantidad_preparada"], $loteMedioCultivoData["id_medio_cultivo"], $loteMedioCultivoData["lote_interno"]);
        $response = json_encode($result);
        echo $response;
    }

    function activateLoteMedioCultivo($idLote, $idMedioCultivo)
    {
        $tablaLoteMedioCultivo = new TablaLoteMedioCultivoDbModelClass();
        $resultDeactivateLotes = $tablaLoteMedioCultivo->deactivateAllLotesByIdMedioCultivo($idMedioCultivo);
        if ($resultDeactivateLotes["code"] == "00000") {
            $resultActivateLote = $tablaLoteMedioCultivo->activateLoteById($idLote);
            $response = json_encode($resultActivateLote);
        } else {
            $response = json_encode($resultDeactivateLotes);
        }
        echo $response;
    }

    function getActiveCepasByIdMedioCultivo($idMedioCultivo)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->getActiveCepasByIdMediCultivo($idMedioCultivo);
        $response = json_encode($result);
        echo $response;
    }

    function getCepasDisponiblesByIdMedioCultivo($idMedioCultivo)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        $result = $tablaCepa->getCepasDisponiblesByIdMedioCultivo($idMedioCultivo);
        $response = json_encode($result);
        echo $response;
    }

    function desasociarCepas($cepasData)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        foreach ($cepasData as $cepa) {
            $result = $tablaCepa->deleteCepaAsocidadById($cepa["id"]);
            if ($result["code"] != "00000") {
                break;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function asociarCepas($idMedioCOnsulta, $cepasData)
    {
        $tablaCepa = new TablaCepaDbModelClass();
        foreach ($cepasData as $cepa) {
            $result = $tablaCepa->insertCepaAsociacion($idMedioCOnsulta, $cepa["id"]);
            if ($result["code"] != "00000") {
                break;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    /*
     * Se adicionan funciones post para Reactivos
     */

    function insertReactivo($reactivoData)
    {
        $tablaReactivo = new TablaReactivoDbModelClass();
        $result = $tablaReactivo->insertReactivo($reactivoData["nombre"], $reactivoData["lote"], $reactivoData["cantidad"], $reactivoData["fechaencimiento"], $reactivoData["tipo"], $reactivoData["cantidadActual"], $reactivoData["stock"], $reactivoData["fechaIngreso"], $reactivoData["fechaApertura"], $reactivoData["fechaTerminacion"], $reactivoData["loteIterno"], $reactivoData["fechaPase"]);
        $response = json_encode($result);
        echo $response;
    }

    /*
     * CRUD módulo reactivos
     */

    function getAllReactivos2()
    {
        $tabla = new TablaReactivoDbModelClass();
        $result = $tabla->getAllReactivo2();
        $response = json_encode($result);
        echo $response;
    }

    function getAllReactivosPorMuestra()
    {
        $tabla = new TablaReactivoDbModelClass();
        $result = $tabla->getAllReactivosPorMuestra();
        $response = json_encode($result);
        echo $response;
    }

    function insertReactivo2($reactivoData)
    {
        $tablaReactivo = new TablaReactivoDbModelClass();

        $old = NULL;

        $result = $tablaReactivo->insertReactivo2($reactivoData["codigo"]
            , $reactivoData["nombre"], $reactivoData["grado"], $reactivoData["ubicacion"]
            , $reactivoData["clasificacion"], $reactivoData["controlado"], $reactivoData["stock_minimo"], $reactivoData["condicion_almacenamiento"]);

        $new = $tablaReactivo->getReactivoByIdToAud($result["data"]);
        $this->insertReactivoAud($old, $new, $result["data"], "create", "Creación nuevo reactivo");

        if ($result["code"] == "00000") {
            $f = mkdir("docs/reactivo/" . $result["data"], 0777);
            if ($f) {
                $return = true;
            } else {
                $return = false;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function insertReactivoAud($old, $new, $idReactivo, $evento, $razon)
    {

        $reactivoAud = new ReactivoAud();
        $reactivoAud->fecha = new DateTime("now");
        $reactivoAud->old = $old;
        $reactivoAud->new = $new;
        $reactivoAud->id_usuario = $_SESSION['userId'];
        $reactivoAud->id_reactivo = $idReactivo;
        $reactivoAud->evento = $evento;
        $reactivoAud->razon = $razon;
        try {
            $reactivoAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function deleteReactivo($idReactivo, $razon)
    {
        $tablaReactivo = new TablaReactivoDbModelClass();
        $old = $tablaReactivo->getReactivoByIdToAud($idReactivo);

        $result = $tablaReactivo->deleteReactivoById($idReactivo);

        $new = $tablaReactivo->getReactivoByIdToAud($idReactivo);
        $this->insertReactivoAud($old, $new, $idReactivo, "update", "Borrado de reactivo" . ", " . $razon);

        $response = json_encode($result);
        echo $response;
    }

    function updateReactivo($reactivoData)
    {
        $tablaReactivo = new TablaReactivoDbModelClass();

        $old = $tablaReactivo->getReactivoByIdToAud($reactivoData["id"]);

        $result = $tablaReactivo->updateReactivoById($reactivoData["codigo"], $reactivoData["nombre"], $reactivoData["grado"], $reactivoData["ubicacion"], $reactivoData["clasificacion"], $reactivoData["controlado"], $reactivoData["stock_minimo"], $reactivoData["id"], $reactivoData["condicion_almacenamiento"]);

        $new = $tablaReactivo->getReactivoByIdToAud($reactivoData["id"]);
        $this->insertReactivoAud($old, $new, $reactivoData["id"], "update", "Actualización datos basicos del reactivo");

        $response = json_encode($result);
        echo $response;
    }

    /*
     * CRUD módulo Estándares
     */

    function getAllEstandares2()
    {
        $tabla = new TablaEstandarDbModelClass();
        $result = $tabla->getAllEstandares2();
        $response = json_encode($result);
        echo $response;
    }

    function deleteEstandar($idEstandar, $razon)
    {
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = $tablaEstandar->getEstandarByIdToAud($idEstandar);

        $result = $tablaEstandar->deleteEstandarById($idEstandar);

        $new = $tablaEstandar->getEstandarByIdToAud($idEstandar);
        $this->insertEstandarAud($old, $new, $idEstandar, "update", "Borrado de estandar" . ", " . $razon);

        $response = json_encode($result);
        echo $response;
    }

    function updateEstandar($estandarData)
    {
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = $tablaEstandar->getEstandarByIdToAud($estandarData["id"]);

        $result = $tablaEstandar->updateEstandarById2($estandarData["codigo"]
            , $estandarData["nombre"], $estandarData["tipo"], $estandarData["origen"]
            , $estandarData["almacenamiento"], $estandarData["uso_previsto"]
            , $estandarData["propiedades"]
            , $estandarData["ubicacion"], $estandarData["id"]);

        $new = $tablaEstandar->getEstandarByIdToAud($estandarData["id"]);
        $this->insertEstandarAud($old, $new, $estandarData["id"], "update", "Actualización datos basicos estandar");

        $response = json_encode($result);
        echo $response;
    }

    function insertEstandar($estandarData)
    {
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = NULL;

        $result = $tablaEstandar->insertEstandar2($estandarData["codigo"]
            , $estandarData["nombre"], $estandarData["tipo"], $estandarData["origen"]
            , $estandarData["almacenamiento"], $estandarData["uso_previsto"]
            , $estandarData["propiedades"], $estandarData["ubicacion"]);

        if ($result["code"] == "00000") {
            $f = mkdir("docs/estandar/" . $result["data"], 0777);
            if ($f) {
                $return = true;
            } else {
                $return = false;
            }
        }

        $new = $tablaEstandar->getEstandarByIdToAud($result["data"]);
        $this->insertEstandarAud($old, $new, $result["data"], "create", "Creación nuevo estandar");

        $response = json_encode($result);
        echo $response;
    }

//Ajuste API programacionAnalistasData.php
    function getProgramacionByIdMuestraAndIdAnalista($idMuestra, $idAnalista)
    {
        $tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdMuestraAndIdAnalista($idMuestra, $idAnalista);
        if ($response != false) {
            foreach ($response as $ensayoMuestra) {
                if ($ensayoMuestra['des_ensayo_est'] != "") {
                    $descripcionEnsayo = $ensayoMuestra['des_ensayo_est'];
                } else {
                    $descripcionEnsayo = $ensayoMuestra['desEspecifica'];
                }
                $ensayos[] = array(
                    'idEnsayoMuestra' => $ensayoMuestra['id_ensayo_muestra'],
                    'idAnalista' => $ensayoMuestra['id_analista'],
                    'idEnsayo' => $ensayoMuestra['id_ensayo'],
                    'desEnsayo' => $descripcionEnsayo,
                    'duracion' => $ensayoMuestra['duracion'],
                    'equipo' => $ensayoMuestra['equipo'],
                    'turno' => $ensayoMuestra['turno'],
                    'fechaProg' => $ensayoMuestra['fecha_programacion'],
                    'fechaCompInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                    'observaciones' => $ensayoMuestra['observaciones'],
                    'idPaquete' => $ensayoMuestra['id_paquete'],
                    'desPaquete' => $ensayoMuestra['descripcion_paquete'],
                    'idMuestra' => $ensayoMuestra['id_muestra'],
                    'desEquipo' => $ensayoMuestra['descripcion_equipo'],
                    'refEquipo' => $ensayoMuestra['referencia_equipo'],
                    'aprobado' => $ensayoMuestra['aprobado']
                );
            }
        } else {
            $ensayos = NULL;
        }
        echo json_encode($ensayos);
    }

    function getProgramacionByIdAnalistaAndRangeTime($idAnalista, $startDate, $endDate)
    {
        $tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdAnalistaAndRangeTime($idAnalista, $startDate, $endDate);
        if ($response != false) {
            foreach ($response as $fecha) {
                $fechas[] = array(
                    'fecha' => $fecha['fecha'],
                    'tiempoProgramado' => $fecha['tiempo_programado']
                );
            }
        } else {
            $fechas = NULL;
        }
        echo json_encode($fechas);
    }

    function getProgramacionByIdAnalistaOnDate($idAnalista, $endDate)
    {
        $tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdAnalistaOnDate($idAnalista, $endDate);
        if ($response != false) {
            foreach ($response as $programacion) {
                $fechaProgramada = new DateTime($programacion['fecha_programada']);
                $fechaProgramada = $fechaProgramada->format("d/m/Y");

                $fechaProgEnsayo = new DateTime($programacion['fecha_programacion']);
                $fechaProgEnsayo = $fechaProgEnsayo->format("d/m/Y");

                $fechaCompInterno = new DateTime($programacion['fecha_compromiso_interno']);
                $fechaCompInterno = $fechaCompInterno->format("d/m/Y");
                $programaciones[] = array(
                    'id' => $programacion['idProgramacion'],
                    'fechaProgramada' => $fechaProgramada,
                    'duracionActividad' => $programacion['duracion_programada'],
                    'idMuestra' => $programacion['id_muestra'],
                    'idEnsayo' => $programacion['id_ensayo'],
                    'desEnsayo' => $programacion['desEnsayo'],
                    'idPaquete' => $programacion['id_paquete'],
                    'desPaquete' => $programacion['desPaquete'],
                    'fechaProgramacionEnsayo' => $fechaProgEnsayo,
                    'fechaCompInternoEnsayo' => $fechaCompInterno,
                    'duracion' => $programacion['duracion'],
                    'idEquipo' => $programacion['idEquipo'],
                    'desEquipo' => $programacion['desEquipo'],
                    'idAreaAnalisis' => $programacion['idAreaAnalisis'],
                    'desAreaAnalisis' => $programacion['desAreaAnalisis'],
                    'tipoEstabilidad' => $programacion['tipo_estabilidad'],
                    'idProgramador' => $programacion['idProgramador'],
                    'nomProgramador' => $programacion['nomProgramador'],
                    'aprobadoEnsMue' => $programacion['aprobadoEnsMue'],
                    'idEnsayoMuestra' => $programacion['id_ensayo_muestra']
                );
            }
        } else {
            $programaciones = NULL;
        }
        echo json_encode($programaciones);
    }

    function getEnsayosParaRevisionFQ()
    {
        $tablaProgramacionAnalistasDbModel = new TablaEnsayoMuestraDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getEnsayosParaRevisar(1);

        if ($response['code'] == "00000") {

            $utilController = new UtilsController();
            $response = $response['data'];
            foreach ($response as $ensayo) {
                $ensayos = NULL;
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["custom_id"]);

                $fechaProgramacion = new DateTime($ensayo['fecha_programacion']);
                $fechaProgramacion = $fechaProgramacion->format("d/m/Y");

                $fechaCompInterno = new DateTime($ensayo['fecha_compromiso_interno']);
                $fechaCompInterno = $fechaCompInterno->format("d/m/Y");

                $ensayos[] = array(
                    'id_paquete' => $ensayo['id_paquete'],
                    'des_paquete' => $ensayo['des_paquete'],
                    'id_ensayo' => $ensayo['id_ensayo'],
                    'des_ensayo' => $ensayo['des_ensayo'],
                    'des_especifica' => $ensayo['desEspecifica'],
                    'fecha_programada' => $fechaProgramacion,
                    'fecha_comp_internoEnsayo' => $fechaCompInterno,
                    'tipo_estabilidad' => $ensayo['tipo_estabilidad'],
                    'id_equipo' => $ensayo['equipo'],
                    'des_equipo' => $ensayo['des_equipo'],
                    'analista' => $ensayo['analista'],
                    'duracion' => $ensayo['duracion'],
                    'observaciones' => $ensayo['observaciones'],
                    'especificacion_ensayo_muestra' => $ensayo['especificacion_ensayo_muestra'],
                );

                foreach ($muestras as &$muestra) {
                    if ($auxIdMuestra == $muestra['custom_id']) {
                        $existe = true;
                        $arrayTemp = $muestra['ensayos'];
//$arrayTemp[] = $ensayos;
                        array_push($arrayTemp, $ensayos[0]);
                        $muestra['ensayos'] = $arrayTemp;
                        break;
                    } else {
                        $existe = false;
                    }
                }
                if (!$existe || empty($muestras)) {
                    $muestras[] = array('custom_id' => $auxIdMuestra,
                        'id_tercero' => $ensayo['id_tercero'],
                        'nom_tercero' => $ensayo['nombre'],
                        'des_area_analisis' => $ensayo['des_area'],
                        'nombre_producto' => $ensayo['nombre_producto'],
                        'numero_lote' => $ensayo['numero_lote'],
                        'ensayos' => $ensayos);
                }
            }
            $result = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
        } else {
            $ensayos = NULL;
        }
        echo json_encode($result);
    }

    function getEnsayosParaRevisionMB()
    {
        $tablaProgramacionAnalistasDbModel = new TablaEnsayoMuestraDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getEnsayosParaRevisar(2);

        if ($response['code'] == "00000") {

            $utilController = new UtilsController();
            $response = $response['data'];
            foreach ($response as $ensayo) {
                $ensayos = NULL;
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["custom_id"]);

                $fechaProgramacion = new DateTime($ensayo['fecha_programacion']);
                $fechaProgramacion = $fechaProgramacion->format("d/m/Y");

                $fechaCompInterno = new DateTime($ensayo['fecha_compromiso_interno']);
                $fechaCompInterno = $fechaCompInterno->format("d/m/Y");

                $ensayos[] = array(
                    'id_paquete' => $ensayo['id_paquete'],
                    'des_paquete' => $ensayo['des_paquete'],
                    'id_ensayo' => $ensayo['id_ensayo'],
                    'des_ensayo' => $ensayo['des_ensayo'],
                    'des_especifica' => $ensayo['desEspecifica'],
                    'fecha_programada' => $fechaProgramacion,
                    'fecha_comp_internoEnsayo' => $fechaCompInterno,
                    'tipo_estabilidad' => $ensayo['tipo_estabilidad'],
                    'id_equipo' => $ensayo['equipo'],
                    'des_equipo' => $ensayo['des_equipo'],
                    'analista' => $ensayo['analista'],
                    'duracion' => $ensayo['duracion'],
                    'observaciones' => $ensayo['observaciones'],
                    'especificacion_ensayo_muestra' => $ensayo['especificacion_ensayo_muestra'],
                );

                foreach ($muestras as &$muestra) {
                    if ($auxIdMuestra == $muestra['custom_id']) {
                        $existe = true;
                        $arrayTemp = $muestra['ensayos'];
//$arrayTemp[] = $ensayos;
                        array_push($arrayTemp, $ensayos[0]);
                        $muestra['ensayos'] = $arrayTemp;
                        break;
                    } else {
                        $existe = false;
                    }
                }
                if (!$existe || empty($muestras)) {
                    $muestras[] = array('custom_id' => $auxIdMuestra,
                        'id_tercero' => $ensayo['id_tercero'],
                        'nom_tercero' => $ensayo['nombre'],
                        'des_area_analisis' => $ensayo['des_area'],
                        'nombre_producto' => $ensayo['nombre_producto'],
                        'numero_lote' => $ensayo['numero_lote'],
                        'ensayos' => $ensayos);
                }
            }
            $result = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
        } else {
            $ensayos = NULL;
        }
        echo json_encode($result);
    }

    function getEnsayosParaTranscripcion()
    {
        $tablaProgramacionAnalistasDbModel = new TablaEnsayoMuestraDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getEnsayosParaTranscripcion();

        if ($response['code'] == "00000") {

            $utilController = new UtilsController();
            $response = $response['data'];
            foreach ($response as $ensayo) {
                $ensayos = NULL;
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["custom_id"]);

                $fechaProgramacion = new DateTime($ensayo['fecha_programacion']);
                $fechaProgramacion = $fechaProgramacion->format("d/m/Y");

                $fechaCompInterno = new DateTime($ensayo['fecha_compromiso_interno']);
                $fechaCompInterno = $fechaCompInterno->format("d/m/Y");

                $ensayos[] = array(
                    'id_paquete' => $ensayo['id_paquete'],
                    'des_paquete' => $ensayo['des_paquete'],
                    'id_ensayo' => $ensayo['id_ensayo'],
                    'des_ensayo' => $ensayo['des_ensayo'],
                    'des_especifica' => $ensayo['desEspecifica'],
                    'fecha_programada' => $fechaProgramacion,
                    'fecha_comp_internoEnsayo' => $fechaCompInterno,
                    'tipo_estabilidad' => $ensayo['tipo_estabilidad'],
                    'id_equipo' => $ensayo['equipo'],
                    'des_equipo' => $ensayo['des_equipo'],
                    'analista' => $ensayo['analista'],
                    'duracion' => $ensayo['duracion'],
                    'observaciones' => $ensayo['observaciones'],
                    'especificacion_ensayo_muestra' => $ensayo['especificacion_ensayo_muestra'],
                );

                foreach ($muestras as $muestra) {
                    if ($auxIdMuestra == $muestra['custom_id']) {
                        $existe = true;
                        $arrayTemp = $muestra['ensayos'];
//$arrayTemp[] = $ensayos;
                        array_push($arrayTemp, $ensayos[0]);
                        $muestra['ensayos'] = $arrayTemp;
                        break;
                    } else {
                        $existe = false;
                    }
                }
                if (!$existe || empty($muestras)) {
                    $muestras[] = array('custom_id' => $auxIdMuestra,
                        'id_tercero' => $ensayo['id_tercero'],
                        'nom_tercero' => $ensayo['nombre'],
                        'des_area_analisis' => $ensayo['des_area'],
                        'nombre_producto' => $ensayo['nombre_producto'],
                        'numero_lote' => $ensayo['numero_lote'],
                        'ensayos' => $ensayos);
                }
            }
            $result = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
        } else {
            $ensayos = NULL;
        }
        echo json_encode($result);
    }

    function getProgramacionAnalista($idAnalista)
    {
        $tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();
        $response = $tablaProgramacionAnalistasDbModel->getProgramacionAnalista($idAnalista);

        if ($response['code'] == "00000") {

            $utilController = new UtilsController();
            $response = $response['data'];
            foreach ($response as $ensayo) {
                $ensayos = NULL;
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["custom_id"]);

                $fechaProgramacion = new DateTime($ensayo['fecha_programacion']);
                $fechaProgramacion = $fechaProgramacion->format("d/m/Y");

                $fechaCompInterno = new DateTime($ensayo['fecha_compromiso_interno']);
                $fechaCompInterno = $fechaCompInterno->format("d/m/Y");

                $ensayos[] = array(
                    'id_paquete' => $ensayo['id_paquete'],
                    'des_paquete' => $ensayo['des_paquete'],
                    'id_ensayo' => $ensayo['id_ensayo'],
                    'des_ensayo' => $ensayo['des_ensayo'],
                    'des_especifica' => $ensayo['desEspecifica'],
                    'fecha_programada' => $fechaProgramacion,
                    'fecha_comp_internoEnsayo' => $fechaCompInterno,
                    'tipo_estabilidad' => $ensayo['tipo_estabilidad'],
                    'id_equipo' => $ensayo['equipo'],
                    'des_equipo' => $ensayo['des_equipo'],
                    'turno' => $ensayo['turno'],
                    'duracion' => $ensayo['duracion'],
                    'observaciones' => $ensayo['observaciones'],
                    'especificacion_ensayo_muestra' => $ensayo['especificacion_ensayo_muestra'],
                    'nombre_analista' => $ensayo['nombre_analista']
                );

                foreach ($muestras as &$muestra) {
                    if ($auxIdMuestra == $muestra['custom_id']) {
                        $existe = true;
                        $arrayTemp = $muestra['ensayos'];
//$arrayTemp[] = $ensayos;
                        array_push($arrayTemp, $ensayos[0]);
                        $muestra['ensayos'] = $arrayTemp;
                        break;
                    } else {
                        $existe = false;
                    }
                }
                if (!$existe || empty($muestras)) {
                    $muestras[] = array('custom_id' => $auxIdMuestra,
                        'id_tercero' => $ensayo['id_tercero'],
                        'nom_tercero' => $ensayo['nombre'],
                        'des_area_analisis' => $ensayo['des_area'],
                        'nombre_producto' => $ensayo['nombre_producto'],
                        'numero_lote' => $ensayo['numero_lote'],
                        'ensayos' => $ensayos);
                }
            }
            $result = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
        } else {
            $ensayos = NULL;
        }
        echo json_encode($result);
    }

//Ajuste API EnsayoMuestraData.php
    function updateDetalleEnsayoMuestraFromProgAnalistas($idEnsayoMuestra, $duracion, $equipo, $turno, $fechaProg, $fechaCompInterno, $observaciones)
    {
        $EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        echo $EnsayoMuestraModel->updateDetalleEnsayoMuestraFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones);
    }

    function getMuestrasParaVerificar()
    {
        $EnsayoMuestraModel = new TablaMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getMuestrasParaVerificar();
        if ($data['code'] == '00000') {
            $utilController = new UtilsController();

            foreach ($data['data'] as $muestra) {
                $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra->prefijo, $muestra->custom_id);
                if ($muestra->aprobados == null) {
                    $cantidadAprobado = 0;
                    $porcentajeAprobacion = 0;
                } else {
                    $cantidadAprobado = $muestra->aprobados;
                }

                if ($muestra->rechazados == null) {
                    $cantidadNoAprobado = 0;
                } else {
                    $cantidadNoAprobado = $muestra->rechazados;
                }
                $porcentajeAprobacion = ($cantidadAprobado * 100) / ($cantidadAprobado + $cantidadNoAprobado);
                $porcentajeAprobacion = number_format($porcentajeAprobacion, 2) . "%";

                $fechaCompromiso = new DateTime($muestra->fecha_compromiso);
                $fechaCompromiso = $fechaCompromiso->format("d/m/Y");

                $muestras[] = array(
                    'custom_id' => $auxIdMuestra,
                    'idMuestra' => $muestra->id,
                    'id_tercero' => $muestra->id_tercero,
                    'nom_tercero' => $muestra->nombre,
                    'area' => $muestra->des_area,
                    'nombre_estabilidad' => $muestra->nombre_estabilidad,
                    'lote' => $muestra->numero_lote,
                    'aprobados' => $cantidadAprobado,
                    'rechazados' => $cantidadNoAprobado,
                    'porcentaje_aprobacion' => $porcentajeAprobacion,
                    'id_producto' => $muestra->id_producto,
                    'nom_producto' => $muestra->nom_producto,
                    'fecha_compromiso' => $fechaCompromiso
                );
            }
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
            echo json_encode($response);
        } else {
            echo json_encode(NULL);
        }
    }

    function getMuestrasVerificadas()
    {
        $EnsayoMuestraModel = new TablaMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getMuestrasVerificadas();
        if ($data['code'] == '00000') {
            $utilController = new UtilsController();

            foreach ($data['data'] as $muestra) {
                $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra->prefijo, $muestra->custom_id);
                if ($muestra->aprobados == null) {
                    $cantidadAprobado = 0;
                    $porcentajeAprobacion = 0;
                } else {
                    $cantidadAprobado = $muestra->aprobados;
                }

                if ($muestra->rechazados == null) {
                    $cantidadNoAprobado = 0;
                } else {
                    $cantidadNoAprobado = $muestra->rechazados;
                }
                $porcentajeAprobacion = ($cantidadAprobado * 100) / ($cantidadAprobado + $cantidadNoAprobado);
                $porcentajeAprobacion = number_format($porcentajeAprobacion, 2) . "%";
                $muestras[] = array(
                    'custom_id' => $auxIdMuestra,
                    'idMuestra' => $muestra->id,
                    'id_tercero' => $muestra->id_tercero,
                    'nom_tercero' => $muestra->nombre,
                    'area' => $muestra->des_area,
                    'nombre_estabilidad' => $muestra->nombre_estabilidad,
                    'lote' => $muestra->numero_lote,
                    'aprobados' => $cantidadAprobado,
                    'rechazados' => $cantidadNoAprobado,
                    'porcentaje_aprobacion' => $porcentajeAprobacion,
                    'id_producto' => $muestra->id_producto,
                    'nom_producto' => $muestra->nom_producto
                );
            }
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $muestras);
            echo json_encode($response);
        } else {
            echo json_encode(NULL);
        }
    }

    function getEnsayosCountAprobacionAndResultadosGroupByMuestra()
    {
        $EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        $data = $EnsayoMuestraModel->getEnsayosCountAprobacionAndResultadosGroupByMuestra();
        if ($data != false) {

            $utilController = new UtilsController();
            foreach ($data as $ensayo) {
                $auxIdMuestra = $utilController->constructComplexIdMuestra($ensayo["prefijo"], $ensayo["custom_id"]);
                if ($ensayo['cant_aprobado'] == null) {
                    $cantidadAprobado = 0;
                    $porcentajeAprobacion = 0;
                } else {
                    $cantidadAprobado = $ensayo['cant_aprobado'];
                    $porcentajeAprobacion = ($cantidadAprobado * 100) / $ensayo['cantidad_total'];
                }
                $porcentajeAprobacion = number_format($porcentajeAprobacion, 2) . "%";
                if ($ensayo['cant_no_aprobado'] == null) {
                    $cantidadNoAprobado = 0;
                } else {
                    $cantidadNoAprobado = $ensayo['cant_no_aprobado'];
                }

                $ensayos[] = array(
                    'customId' => $auxIdMuestra,
                    'idMuestra' => $ensayo['id_muestra'],
                    'cantidadTotal' => $ensayo['cantidad_total'],
                    'cantidadAprobado' => $cantidadAprobado,
                    'cantidadNoAprobado' => $cantidadNoAprobado,
                    'porcentajeAprobacion' => $porcentajeAprobacion,
                    'nomProducto' => $ensayo['nom_producto'],
                    'nomTercero' => $ensayo['nom_tercero'],
                    'lote' => $ensayo['lote']
                );
            }
            echo json_encode($ensayos);
        } else {
            echo json_encode(NULL);
        }
    }

//Ajuste API
    function getAllMuestraReferenciasData()
    {
        $viewMuestraReferenciasModel = new ViewMuestraReferenciasDbModel();
        $data = $viewMuestraReferenciasModel->getAllMuestras();
        if ($data != false) {
            $utilController = new UtilsController();

            foreach ($data as $muestra) {
                $auxIdMuestra = $utilController->constructComplexIdMuestra($muestra["prefijo"], $muestra["custom_id"]);
                $auxId = $utilController->contructCerosIdMuestra() . $muestra['id'];
                $response[] = array(
                    'idMuestra' => $auxId,
                    'activa' => $muestra['activa'],
                    'prioridad' => $muestra['prioridad'],
                    'cotizacion' => $muestra['id_cotizacion'],
                    'remision' => $muestra['numero_remision'],
                    'producto' => $muestra['nombre_producto'],
                    'tercero' => $muestra['nombre_tercero'],
                    'contacto' => $muestra['nombre_contacto'],
                    'informe' => $muestra['num_informe'],
                    'estado' => $muestra['descripcion_estado_muestra'],
                    'factura' => $muestra['num_factura'],
                    'fechaLlegada' => $muestra['fecha_llegada'],
                    'fechaCompromiso' => $muestra['fecha_compromiso'],
                    'areaAnalisis' => $muestra['des_area_analisis'],
                    'coordinador' => $muestra['des_area_analisis'],
                    'lote' => $muestra['lote'],
                    'complexId' => $auxIdMuestra
                );
            }
            echo json_encode($response);
        } else {
            echo json_encode(NULL);
        }
    }

//Lotes reactivos
    function getLotesByIdReactivo($idReactivo)
    {
        $tabla = new TablaLoteReactivoDbModelClass();

        $result = $tabla->getLotesByIdReactivo($idReactivo);
        $response = json_encode($result);
        echo $response;
    }

    function createNewLoteReactivo($newLoteData, $idReactivo)
    {
        $tabla = new TablaLoteReactivoDbModelClass();
        $tablaReactivo = new TablaReactivoDbModelClass();
        $old = $tablaReactivo->getReactivoByIdToAud($idReactivo);

        $result = $tabla->insertNewLote($newLoteData["numero"], $newLoteData["fecha_vencimiento"]
            , $newLoteData["fecha_recibido"], $newLoteData["fecha_apertura"]
            , $newLoteData["cantidad"], $newLoteData["unidad"], $idReactivo, $newLoteData["observaciones"]
            , $newLoteData["cantidad_inicial"], $newLoteData["cantidad_final"], $newLoteData["fabricante"], $newLoteData["concentracion"]);

        $new = $tablaReactivo->getReactivoByIdToAud($idReactivo);
        $this->insertReactivoAud($old, $new, $idReactivo, "update", "Creación nuevo lote de reactivo");

        if ($result["code"] == "00000") {
            $f = mkdir("docs/reactivo/" . $idReactivo . "/" . $result["data"], 0777);
            if ($f) {
                $return = true;
            } else {
                $return = false;
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function activarLoteReactivo($loteReactivoData)
    {
        $tabla = new TablaLoteReactivoDbModelClass();
        $tablaReactivo = new TablaReactivoDbModelClass();
        $old = $tablaReactivo->getReactivoByIdToAud($loteReactivoData["id_reactivo"]);

        $resultDeactivate = $tabla->deactivateLotesByIdReactivo($loteReactivoData["id_reactivo"]);
        if ($resultDeactivate["code"] == "00000") {
            $resultActivate = $tabla->activateLoteById($loteReactivoData["id"]);
            $response = json_encode($resultActivate);
        } else {
            $response = json_encode($resultDeactivate);
        }

        $new = $tablaReactivo->getReactivoByIdToAud($loteReactivoData["id_reactivo"]);
        $this->insertReactivoAud($old, $new, $loteReactivoData["id_reactivo"], "update", "Activación lote reactivo");

        echo $response;
    }

    function updateLoteReactivo($loteReactivoData)
    {
        $tabla = new TablaLoteReactivoDbModelClass();
        $tablaReactivo = new TablaReactivoDbModelClass();
        $old = $tablaReactivo->getReactivoByIdToAud($loteReactivoData["id_reactivo"]);

        $result = $tabla->updateLoteReactivo($loteReactivoData["numero"], $loteReactivoData["fecha_vencimiento"]
            , $loteReactivoData["fecha_recibido"], $loteReactivoData["fecha_apertura"]
            , $loteReactivoData["cantidad"], $loteReactivoData["unidad"], $loteReactivoData["observaciones"]
            , $loteReactivoData["cantidad_inicial"], $loteReactivoData["cantidad_final"]
            , $loteReactivoData["fabricante"], $loteReactivoData["concentracion"]
            , $loteReactivoData["id"]);
        $response = json_encode($result);

        $new = $tablaReactivo->getReactivoByIdToAud($loteReactivoData["id_reactivo"]);
        $this->insertReactivoAud($old, $new, $loteReactivoData["id_reactivo"], "update", "Actualización datos basicos de lote de reactivo");

        echo $response;
    }

//Lotes Estándar
    function getLotesByIdEstandar($idEstandar)
    {
        $tabla = new TablaLoteEstandarDbModelClass();
        $result = $tabla->getLotesByIdEstandar($idEstandar);
        $response = json_encode($result);
        echo $response;
    }

    function createNewLoteEstandar($newLoteData, $idEstandar)
    {
        $tabla = new TablaLoteEstandarDbModelClass();
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = $tablaEstandar->getEstandarByIdToAud($idEstandar);

        $result = $tabla->insertNewLote($newLoteData["codigo"], $newLoteData["descripcion"]
            , $newLoteData["cantidad"], $newLoteData["fecha_vencimiento"], 0, $newLoteData["tipo"]
            , $newLoteData["cantidad_actual"], $newLoteData["stock"]
            , $newLoteData["fecha_ingreso"], $newLoteData["fecha_apertura"], $newLoteData["fecha_terminacion"]
            , $newLoteData["lote_interno"], $newLoteData["fecha_preparacion"], $newLoteData["fecha_promocion"]
            , $idEstandar, $newLoteData["cantidad_preparada"], $newLoteData["observaciones"]
            , $newLoteData["num_cas"]
            , $newLoteData["humedad"], $newLoteData["base_potencia"]
            , $newLoteData["cantidad_inicial"], $newLoteData["cantidad_final"]);


        if ($result["code"] == "00000") {
            $f = mkdir("docs/estandar/" . $idEstandar . "/" . $result["data"], 0777);
            if ($f) {
                $return = true;
            } else {
                $return = false;
            }
        }

        $new = $tablaEstandar->getEstandarByIdToAud($idEstandar);
        $this->insertEstandarAud($old, $new, $idEstandar, "update", "Creación nuevo lote e estandar");

        $response = json_encode($result);
        echo $response;
    }

    function activarLoteEstandar($loteEstandarData)
    {
        $tabla = new TablaLoteEstandarDbModelClass();
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = $tablaEstandar->getEstandarByIdToAud($loteEstandarData["id_estandar"]);

        $resultDeactivate = $tabla->deactivateLotesByIdEstandar($loteEstandarData["id_estandar"]);
        if ($resultDeactivate["code"] == "00000") {
            $resultActivate = $tabla->activateLoteById($loteEstandarData["id"]);
            $response = json_encode($resultActivate);
        } else {
            $response = json_encode($resultDeactivate);
        }

        $new = $tablaEstandar->getEstandarByIdToAud($loteEstandarData["id_estandar"]);
        $this->insertEstandarAud($old, $new, $loteEstandarData["id_estandar"], "update", "Activación de lote de estandar");

        echo $response;
    }

    function updateLoteEstandar($loteEstandarData)
    {
        $tabla = new TablaLoteEstandarDbModelClass();
        $tablaEstandar = new TablaEstandarDbModelClass();
        $old = $tablaEstandar->getEstandarByIdToAud($loteEstandarData["id_estandar"]);

        $result = $tabla->updateLoteEstandar($loteEstandarData["codigo"], $loteEstandarData["descripcion"]
            , $loteEstandarData["cantidad"], $loteEstandarData["fecha_ingreso"], $loteEstandarData["fecha_apertura"]
            , $loteEstandarData["fecha_terminacion"], $loteEstandarData["fecha_vencimiento"], $loteEstandarData["cantidad_actual"]
            , $loteEstandarData["stock"], $loteEstandarData["lote_interno"], $loteEstandarData["fecha_preparacion"]
            , $loteEstandarData["fecha_promocion"], $loteEstandarData["idEstandar"]
            , $loteEstandarData["tipo"], $loteEstandarData["cantidad_preparada"], $loteEstandarData["observaciones"]
            , $loteEstandarData["num_cas"]
            , $loteEstandarData["humedad"], $loteEstandarData["base_potencia"]
            , $loteEstandarData["cantidad_inicial"], $loteEstandarData["cantidad_final"], $loteEstandarData["id"]);

        $new = $tablaEstandar->getEstandarByIdToAud($loteEstandarData["id_estandar"]);
        $this->insertEstandarAud($old, $new, $loteEstandarData["id_estandar"], "update", "Actualización datos basicos de lote de estandar");

        $response = json_encode($result);
        echo $response;
    }

    function getAllPerfil()
    {
        $tabla = new TablaPerfilDbModelClass();
        $result = $tabla->getAllPerfil2();
        $response = json_encode($result);
        echo $response;
    }

    function getAllPermisosBandejaEntrada()
    {
        $tabla = new TablaPermisoBandejaEntradaDbModelClass();
        $result = $tabla->getAllPermisosBandejaEntrada();
        $response = json_encode($result);
        echo $response;
    }

    function getPerfilPermisosBandejaEntrada($idPerfil)
    {
        $tabla = new TablaPerfilPermisoBandejaEntradaDbModelClass();
        $result = $tabla->getPerfilPermisosBandejaEntrada($idPerfil);
        $response = json_encode($result);
        echo $response;
    }

    function asignarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso)
    {
        $tabla = new TablaPerfilPermisoBandejaEntradaDbModelClass();
        $tablaPerfil = new TablaPerfilDbModelClass();
        $old = $tablaPerfil->getPerfilByIdToAud($idPerfil);

        $result = $tabla->asignarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso);

        $new = $tablaPerfil->getPerfilByIdToAud($idPerfil);
        $this->insertPerfilAud($old, $new, $idPerfil, "update", "Asignación permiso a bandeja de entrada");

        $response = json_encode($result);
        echo $response;
    }

    function eliminarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso)
    {
        $tabla = new TablaPerfilPermisoBandejaEntradaDbModelClass();
        $tablaPerfil = new TablaPerfilDbModelClass();
        $old = $tablaPerfil->getPerfilByIdToAud($idPerfil);

        $result = $tabla->eliminarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso);

        $new = $tablaPerfil->getPerfilByIdToAud($idPerfil);
        $this->insertPerfilAud($old, $new, $idPerfil, "update", "Eliminar permiso a bandeja de entrada");

        $response = json_encode($result);
        echo $response;
    }

    function getEnsayoEquipoDisponibleByIdEnsayo($idEnsayo)
    {
        $tablaEnsayoEquipo = new TablaEnsayoEquipoDbModelClass();
        $result = $tablaEnsayoEquipo->getEquiposDisponiblesByIdEnsayo($idEnsayo);
        $response = json_encode($result);
        echo $response;
    }

    function getEnsayoEquipoByIdEnsayo($idEnsayo)
    {
        $tablaEnsayoEquipo = new TablaEnsayoEquipoDbModelClass();
        $result = $tablaEnsayoEquipo->getEquiposByIdEnsayo($idEnsayo);
        $response = json_encode($result);
        echo $response;
    }

    function deleteEnsayoEquipos($equipos)
    {
        $tablaEnsayoEquipo = new TablaEnsayoEquipoDbModelClass();

        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $idEnsayo = EnsayoEquipo::find($equipos[0]["id_ensayo_equipo"])->id_ensayo;
        $old = $tablaEnsayo->getEnsayoByIdToAud($idEnsayo);

        foreach ($equipos as $keyEquipo => $valueEquipo) {
            $result = $tablaEnsayoEquipo->deleteEnsayoEquipo($valueEquipo["id_ensayo_equipo"]);
            if ($result["code"] != "00000") {
                break;
            }
        }

        $new = $tablaEnsayo->getEnsayoByIdToAud($idEnsayo);
        $tablaEnsayo->insertAudEnsayo($old, $new, $idEnsayo, "update", "Desasignación de equipo ensayo");

        $response = json_encode($result);
        echo $response;
    }

    function createEnsayoEquipos($ensayo, $equipos)
    {
        $tablaEnsayoEquipo = new TablaEnsayoEquipoDbModelClass();

        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $old = $tablaEnsayo->getEnsayoByIdToAud($ensayo["id"]);

        foreach ($equipos as $keyEquipo => $valueEquipo) {
            $result = $tablaEnsayoEquipo->insertEnsayoEquipo($ensayo["id"], $valueEquipo["id"]);
            if ($result["code"] != "00000") {
                break;
            }
        }

        $new = $tablaEnsayo->getEnsayoByIdToAud($ensayo["id"]);
        $tablaEnsayo->insertAudEnsayo($old, $new, $ensayo["id"], "update", "Asignación de equipo a ensayo");

        $response = json_encode($result);
        echo $response;
    }

    function updateMedioCultivo($medioCultivoData)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->updateMedioCultivoById($medioCultivoData["codigo"], $medioCultivoData["nombre"]
            , $medioCultivoData["tipo"], $medioCultivoData["temperatura"], $medioCultivoData["id"]);
        $response = json_encode($result);
        echo $response;
    }

    function deleteMedioCultivo($idMedioCultivo)
    {
        $tablaMedioCultivo = new TablaMedioCultivoDbModelClass();
        $result = $tablaMedioCultivo->deleteMedioCultivoById($idMedioCultivo);
        $response = json_encode($result);
        echo $response;
    }

    function updateLoteMedioCultivo($loteData)
    {
        $tabla = new TablaLoteMedioCultivoDbModelClass();
        $result = $tabla->updateLoteMedioCultivo($loteData["codigo"], $loteData["descripcion"], $loteData["fecha_vencimiento"]
            , $loteData["tipo"], $loteData["cantidad_actual"], $loteData["fecha_ingreso"], $loteData["fecha_apertura"]
            , $loteData["fecha_terminacion"], $loteData["fecha_preparacion"], $loteData["fecha_promocion"]
            , $loteData["cantidad_preparada"], $loteData["lote_interno"], $loteData["id"]);
        $response = json_encode($result);
        echo $response;
    }

    function revisarMuestra($muestraData, $conclusion, $fechaPreConclusion, $observacion)
    {

        $old = AuditoriaController::getFullMuestraToAud($muestraData["id"]);

        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->revisarMuestra($muestraData["id"], $conclusion, $fechaPreConclusion, $_SESSION['userId'], $observacion);
        $response = json_encode($result);

        $new = AuditoriaController::getFullMuestraToAud($muestraData["id"]);
        AuditoriaController::insertMuestraAud($old, $new, $muestraData["id"], "update", "Pre aprobación de muestra");

        echo $response;
    }

    function getAllPrincipioActivo()
    {
        $tabla = new TablaPrincipioActivoDbModelClass();
        $result = $tabla->getAllPrincipioActivo();
        $response = json_encode($result);
        echo $response;
    }

    function updatePrincipioActivo($principioActivoData)
    {
        $tabla = new TablaPrincipioActivoDbModelClass();
        $old = $tabla->getPrincipioActivoByIdToAud($principioActivoData["id"]);

        $result = $tabla->updatePrincipioActivo($principioActivoData["id"], $principioActivoData["nombre"], $principioActivoData["valor_tr"]
            , $principioActivoData["valor_stop_time"], $principioActivoData["valor_sol_fase"], $principioActivoData["por_sol_fase"], $principioActivoData["valor_sol_disolucion"]
            , $principioActivoData["por_sol_disolucion"], $principioActivoData["valor_flujo"], $principioActivoData["cantidad_muestra"]
            , $principioActivoData["cantidad_x_estandar"], $principioActivoData["cantidad_estandar"]);

        $new = $tabla->getPrincipioActivoByIdToAud($principioActivoData["id"]);
        $this->insertPrincipioActivoAud($old, $new, $principioActivoData["id"], "update", "Actualización principio activo");

        $response = json_encode($result);
        echo $response;
    }

    function deletePrincipioActivo($idPrincipioActivo)
    {
        $tabla = new TablaPrincipioActivoDbModelClass();
        $old = $tabla->getPrincipioActivoByIdToAud($idPrincipioActivo);

        $result = $tabla->deletePrincioActivo($idPrincipioActivo);

        $new = $tabla->getPrincipioActivoByIdToAud($idPrincipioActivo);
        $this->insertPrincipioActivoAud($old, $new, $idPrincipioActivo, "update", "Eliminación de principio activo");

        $response = json_encode($result);
        echo $response;
    }

    function insertPrincipioActivo($principioActivoData)
    {
        $tabla = new TablaPrincipioActivoDbModelClass();
        $result = $tabla->insertPrincioActivo($principioActivoData["nombre"], $principioActivoData["valor_tr"]
            , $principioActivoData["valor_stop_time"], $principioActivoData["valor_sol_fase"], $principioActivoData["por_sol_fase"], $principioActivoData["valor_sol_disolucion"]
            , $principioActivoData["por_sol_disolucion"], $principioActivoData["valor_flujo"], $principioActivoData["cantidad_muestra"]
            , $principioActivoData["cantidad_x_estandar"], $principioActivoData["cantidad_estandar"]);

        $new = $tabla->getPrincipioActivoByIdToAud($result["data"]);
        $this->insertPrincipioActivoAud(NULL, $new, $result["data"], "create", "Creación principio activo");

        $response = json_encode($result);
        echo $response;
    }

    function getPaquetes()
    {
        $tabla = new TablaEnsayoDbModelClass();
        $result = $tabla->getPaquetes();
        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosByIdPaquete($idPaquete)
    {
        $tablaEnsayoEquipo = new TablaEnsayoPaqueteDbModelClass();
        $result = $tablaEnsayoEquipo->getEnsayosPaquetesByIdPaquete2($idPaquete);
        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosDisponiblesByIdPaquete($idPaquete)
    {
        $tablaEnsayoEquipo = new TablaEnsayoPaqueteDbModelClass();
        $result = $tablaEnsayoEquipo->getEnsayosDisponiblesByIdPaquete($idPaquete);
        $response = json_encode($result);
        echo $response;
    }

    function createPaqueteEnsayos($paquete, $ensayos)
    {
        $tabla = new TablaEnsayoPaqueteDbModelClass();
        $tabla2 = new TablaProductoPaqueteDBModelClass();
        $tabla3 = new TablaProductoEnsayoDbModelClass();

        $modelEnsayo = new TablaEnsayoDbModelClass();
        $old = $modelEnsayo->getPaqueteByIdToAud($paquete["id"]);

        foreach ($ensayos as $keyEnsayo => $valueEnsayo) {
            $result = $tabla->insertEnsayoPaquete($paquete["id"], $valueEnsayo["id"]);
            if ($result["code"] != "00000") {
                break;
            } else {
                $result1 = $tabla2->getAllProductoPaqueteByPaquete($paquete["id"]);
                $dataRta = $result1["data"];
                foreach ($dataRta as $keyData => $valueData) {
                    $result2 = $tabla3->insertProductoEnsayo($valueEnsayo["id"], $valueData->id_producto
                        , $valueEnsayo["tiempo"], 1, $valueEnsayo["precio_real"], $valueEnsayo["descripcion"]
                        , "", $valueData->id, 0, "");
                }
            }
        }

        $new = $modelEnsayo->getPaqueteByIdToAud($paquete["id"]);
        $modelEnsayo->insertAudPaquete($old, $new, $paquete["id"], "update", "Asociar ensayo a paquete");

        $response = json_encode($result);
        echo $response;
    }

    function deletePaqueteEnsayos($ensayos)
    {
        $tabla = new TablaEnsayoPaqueteDbModelClass();
        $tabla2 = new TablaProductoEnsayoDbModelClass();

        $idPaquete = EnsayoPaquete::find($ensayos[0]["id"])->id_paquete;
        $modelEnsayo = new TablaEnsayoDbModelClass();
        $old = $modelEnsayo->getPaqueteByIdToAud($idPaquete);

        foreach ($ensayos as $keyEnsayo => $valueEnsayo) {
            $result1 = $tabla->selectProductoPaqueteByIdEnsPaq($valueEnsayo["id"]);
            $result = $tabla->deleteEnsayoPaqueteById($valueEnsayo["id"]);
            if ($result["code"] != "00000") {
                break;
            } else {
                foreach ($result1["data"] as $keyProdEns => $valueProdEns) {
                    $idProdEnsayo = $valueProdEns->id_producto_ensayo;
                    $result = $tabla2->deleteProductoEnsayoById($idProdEnsayo);
                    if ($result["code"] != "00000") {
                        break;
                    }
                }
            }
        }

        $new = $modelEnsayo->getPaqueteByIdToAud($idPaquete);
        $modelEnsayo->insertAudPaquete($old, $new, $idPaquete, "update", "Desasociar ensayo a paquete");
        $response = json_encode($result);
        echo $response;
    }

    function deletePaquete($idPaquete)
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $old = $tablaEnsayo->getPaqueteByIdToAud($idPaquete);

        $result = $tablaEnsayo->deletePaqueteById($idPaquete);

        $tabla3 = new TablaProductoPaqueteDBModelClass();
        $result = $tabla3->deleteProductoPaqueteByIdPaquete($idPaquete);

        $new = $tablaEnsayo->getPaqueteByIdToAud($idPaquete);
        $tablaEnsayo->insertAudPaquete($old, $new, $idPaquete, "update", "Eliminación paquete");

        $response = json_encode($result);
        echo $response;
    }

    function updatePaquete($paqueteData)
    {
        $tabla = new TablaEnsayoDbModelClass();
        $old = $tabla->getPaqueteByIdToAud($paqueteData["id"]);

        $result = $tabla->updatePaqueteById($paqueteData["codigo"], $paqueteData["descripcion"], $paqueteData["id"]);
        $areaEnsayoModel = new TablaAreaAnalisisEnsayoDbModelClass();
        $resultArea = $areaEnsayoModel->getAreaAnalisisEnsayoByIdEnsayo($paqueteData["id"]);
        $existeArea = $resultArea["data"][0];
        if ($result["code"] == '00000') {
            if ($existeArea != NULL) {
                $areaEnsayoModel->updateAreaAnalisisEnsayo($paqueteData["id_area"], $paqueteData["id"]);
            } else {
                $areaEnsayoModel->insertAreaAnalisisEnsayo($paqueteData["id_area"], $paqueteData["id"]);
            }
        }

        $new = $tabla->getPaqueteByIdToAud($paqueteData["id"]);
        $tabla->insertAudPaquete($old, $new, $paqueteData["id"], "update", "Actualización paquete");

        $response = json_encode($result);
        echo $response;
    }

    function insertPaquete($paqueteData)
    {
        $tablaEnsayo = new TablaEnsayoDbModelClass();
        $result = $tablaEnsayo->insertPaquete($paqueteData["codigo"], $paqueteData["descripcion"]);
        $id = $result["data"];
        $areaEnsayoModel = new TablaAreaAnalisisEnsayoDbModelClass();
        if ($result["code"] == '00000') {
            $areaEnsayoModel->insertAreaAnalisisEnsayo($paqueteData["id_area"], $id);
        }

        $new = $tablaEnsayo->getPaqueteByIdToAud($id);
        $tablaEnsayo->insertAudPaquete(NULL, $new, $id, "create", "Creación de paquete");

        $response = json_encode($result);
        echo $response;
    }

    function getProductosActivos()
    {
        $tabla = new TablaProductoDbModelClass();
        $result = $tabla->getAllProducto2();
        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosPaquetesProducto($idProducto)
    {
        $tabla = new TablaProductoPaqueteDbModelClass();
        $result = $tabla->getAllProductoPaquete2($idProducto);

        foreach ($result as $item) {
            $tablaProdEnsy = new TablaProductoEnsayoDbModelClass();
            $rtaProdEnsayo = $tablaProdEnsy->getProductoEnsayoByProductoPaquete($idProducto, $item->id_producto_paquete);

            $item->ensayos = $rtaProdEnsayo;
        }
        $response = json_encode($result);
        echo $response;
    }

    function getReactivosAsociadosByIdEnsayoProd($idEnsayoProducto)
    {
        $tabla = new TablaReactivoDbModelClass();
        $result = $tabla->getReactivosAsociadosByIdEnsayoProd($idEnsayoProducto);
        $response = json_encode($result);
        echo $response;
    }

    function getReactivosDisponiblesByIdEnsayoProd($idEnsayoProducto)
    {
        $tabla = new TablaReactivoDbModelClass();
        $result = $tabla->getReactivosDisponiblesByIdEnsayoProd($idEnsayoProducto);
        $response = json_encode($result);
        echo $response;
    }

    function deleteProductoEnsayoReactivos($reactivos, $productoEnsayoReactivos)
    {
        $idProducto = ProductoEnsayo::find($productoEnsayoReactivos[0]["id"])->id_producto;

        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($idProducto);
        foreach ($productoEnsayoReactivos as $productoEnsayoReactivo) {
            $tabla = new TablaProductoEnsayoReactivoDbModelClass();
            foreach ($reactivos as $keyReactivo => $valueReactivo) {
                $result = $tabla->deleteProductoEnsayoReactivo($valueReactivo["id"], $productoEnsayoReactivo["id"]);
                if ($result["code"] != "00000") {
                    break;
                }
            }
        }
        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "Desasignación de reactivo al producto");
        $response = json_encode($result);
        echo $response;
    }

    function createProductoEnsayoReactivos($ensayosProducto, $reactivos)
    {
        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($ensayosProducto[0]["id_producto"]);
        foreach ($ensayosProducto as $ensayoProducto) {
            $tabla = new TablaProductoEnsayoReactivoDbModelClass();
            foreach ($reactivos as $keyReactivo => $valueReactivo) {
                $result = $tabla->insertProductoEnsayoReactivo($ensayoProducto['id'], $valueReactivo['id']);
                if ($result["code"] != "00000") {
                    break;
                }
            }
        }
        $new = $tablaProducto->getProductoByIdToAud($ensayosProducto[0]["id_producto"]);
        $tablaProducto->insertProductoAud($old, $new, $ensayosProducto[0]["id_producto"], "update", "Asignación reactivo al producto");

        $response = json_encode($result);
        echo $response;
    }

    function getEstandaresAsociadosByIdEnsayoProd($idEnsayoProducto)
    {
        $tabla = new TablaEstandarDbModelClass();
        $result = $tabla->getEstandaresAsociadosByIdEnsayoProd($idEnsayoProducto);
        $response = json_encode($result);
        echo $response;
    }

    function getEstandaresDisponiblesByIdEnsayoProd($idEnsayoProducto)
    {
        $tabla = new TablaEstandarDbModelClass();
        $result = $tabla->getEstandaresDisponiblesByIdEnsayoProd($idEnsayoProducto);
        $response = json_encode($result);
        echo $response;
    }

    function deleteProductoEnsayoEstandares($estandares, $productoEnsayoEstandares)
    {

        $idProducto = ProductoEnsayo::find($productoEnsayoEstandares[0]["id"])->id_producto;
        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($idProducto);

        $tabla = new TablaProductoEnsayoEstandarDbModelClass();
        foreach ($productoEnsayoEstandares as $productoEnsayoEstandar) {
            foreach ($estandares as $keyEstandar => $valueEstandar) {
                $result = $tabla->deleteProductoEnsayoEstandar($valueEstandar["id"], $productoEnsayoEstandar["id"]);
                if ($result["code"] != "00000") {
                    break;
                }
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "Desasignación de estandar al producto");

        $response = json_encode($result);
        echo $response;
    }

    function createProductoEnsayoEstandares($ensayosProducto, $estandares)
    {

        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($ensayosProducto[0]["id_producto"]);

        foreach ($ensayosProducto as $ensayoProducto) {
            $tabla = new TablaProductoEnsayoEstandarDbModelClass();
            foreach ($estandares as $keyEstandar => $valueEstandar) {
                $result = $tabla->insertProductoEnsayoEstandar($ensayoProducto['id'], $valueEstandar['id']);
                if ($result["code"] != "00000") {
                    break;
                }
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($ensayosProducto[0]["id_producto"]);
        $tablaProducto->insertProductoAud($old, $new, $ensayosProducto[0]["id_producto"], "update", "Asignacion de estandar al producto");

        $response = json_encode($result);
        echo $response;
    }

    function getAllColumnas()
    {
        $tabla = new TablaColumnaDbModelClass();
        $result = $tabla->getAllColumnas();
        foreach ($result["data"] as $key => $value) {
            $tablaColPrincAct = new TablaColumnaPrincipioActivoDbModelClass();
            $resultadoCPA = $tablaColPrincAct->getAllPrincipioActivoByIdColumnas($value->id);
            if ($resultadoCPA["code"] != "00000") {
                break;
            } else {
                $value->principios_activos = $resultadoCPA["data"];
            }
        }
        $response = json_encode($result);
        echo $response;
    }

    function getPrincipiosActivosDisponibles($idColumna)
    {
        $tabla = new TablaColumnaPrincipioActivoDbModelClass();
        $result = $tabla->getPrincipiosActivosDisponibles($idColumna);
        $response = json_encode($result);
        echo $response;
    }

    function updateColumna($columnaData)
    {
        $tabla = new TablaColumnaDbModelClass();
        $old = $tabla->getColumnaByIdToAud($columnaData["id"]);

        $respuesta1 = $tabla->updateColumnaById($columnaData["numero"], $columnaData["tipo"], $columnaData["marca"], $columnaData["dimensiones"], $columnaData["serial"], $columnaData["uso"], $columnaData["fecha_inicio_uso"], $columnaData["id"]);

        if ($respuesta1["code"] == "00000") {
            $respuesta2 = $this->eliminarColumnasPrincipioActivo($columnaData["id"]);
            if ($respuesta2["code"] == "00000") {
                $respuesta3 = $this->insertarColumnasPrincipioActivo($columnaData["principios_activos"], $columnaData["id"]);
                $response = json_encode($respuesta3);

                $new = $tabla->getColumnaByIdToAud($columnaData["id"]);
                $this->insertColumnaAud($old, $new, $columnaData["id"], "update", "Actualización de columna");
            } else {
                $response = array(
                    "code" => "00002",
                    "message" => "Error eliminando columnas principio activo",
                    "data" => ""
                );
            }
        } else {
            $response = array(
                "code" => "00003",
                "message" => "Error actualizando columna",
                "data" => ""
            );
        }

        echo $response;
    }

    function insertarColumnasPrincipioActivo($principiosActivos, $idColumna)
    {
        $tabla2 = new TablaColumnaPrincipioActivoDbModelClass();
        $response = array(
            "code" => "00000",
            "message" => "OK",
            "data" => ""
        );
        foreach ($principiosActivos as $key => $value) {
            $respuesta3 = $tabla2->insertColumnaPrincipioActivo($idColumna, $value["id"]);
            if ($respuesta3["code"] != "00000") {
                $response = array(
                    "code" => "00001",
                    "message" => "Error insertando columnas principio activo",
                    "data" => ""
                );
                break;
            } else {
                $response = array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => ""
                );
            }
        }
        return $response;
    }

    function eliminarColumnasPrincipioActivo($idColumna)
    {
        $tabla2 = new TablaColumnaPrincipioActivoDbModelClass();
        $respuesta = $tabla2->deleteColumnaPrincipioActivoByColumna($idColumna);
        return $respuesta;
    }

    function deleteColumna($idColumna)
    {
        $tablaEnsayo = new TablaColumnaDbModelClass();
        $old = $tablaEnsayo->getColumnaByIdToAud($idColumna);

        $result = $tablaEnsayo->deleteColumnaById($idColumna);

        $new = $tablaEnsayo->getColumnaByIdToAud($idColumna);
        $this->insertColumnaAud($old, $new, $idColumna, "update", "Eliminacion de columna");

        $response = json_encode($result);
        echo $response;
    }

    function insertColumna($columnaData)
    {
        $tabla = new TablaColumnaDbModelClass();
        $old = NULL;

        $result = $tabla->insertColumna($columnaData["numero"], $columnaData["tipo"]
            , $columnaData["marca"], $columnaData["dimensiones"], $columnaData["serial"], $columnaData["uso"]
            , $columnaData["fecha_inicio_uso"]);

        $new = $tabla->getColumnaByIdToAud($result["data"]);
        $this->insertColumnaAud($old, $new, $result["data"], "create", "Creación columna");

        if ($result["code"] == "00000") {
            $resultado = $this->insertarColumnasPrincipioActivo($columnaData["principios_activos"], $result["data"]);

            $f = mkdir("docs/columna/" . $result["data"], 0777);
            if ($f) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            $resultado = array(
                "code" => "00002",
                "message" => "Error eliminando columnas principio activo",
                "data" => ""
            );
        }
        $response = json_encode($resultado);
        echo $response;
    }

    function getAllCondicionCromatografica()
    {
        $tabla = new TablaCondicionCromatograficaDbModelClass();
        $result = $tabla->getAllCondicionCromatografica();
        $response = json_encode($result);
        echo $response;
    }

    function updateCondicionCromatografica($condicionCromatograficaData)
    {
        $tabla = new TablaCondicionCromatograficaDbModelClass();
        $old = $tabla->getCondicionCromatograficaByIdToAud($condicionCromatograficaData["id"]);

        $result = $tabla->updateCondicionCromatografica($condicionCromatograficaData["id"]
            , $condicionCromatograficaData["codigo"]
            , $condicionCromatograficaData["nombre"], $condicionCromatograficaData["longitud_onda"]
            , $condicionCromatograficaData["diluyente_valoracion"], $condicionCromatograficaData["diluyente_disolucion"]
            , $condicionCromatograficaData["fase_movil"], $condicionCromatograficaData["concentracion"]
            , $condicionCromatograficaData["flujo"], $condicionCromatograficaData["volumen_inyeccion"]
            , $condicionCromatograficaData["temperatura"], $condicionCromatograficaData["aptitud_sistema"], $condicionCromatograficaData["tr"]
            , $condicionCromatograficaData["observaciones"], $condicionCromatograficaData["disolucion_condiciones"]
            , $condicionCromatograficaData["disolucion_medio"]
            , $condicionCromatograficaData["disolucion_longitud_onda"]
            , $condicionCromatograficaData["disolucion_observaciones"]
            , $condicionCromatograficaData["ecuacion_calculo"], $condicionCromatograficaData["disolucion_flujo"], $condicionCromatograficaData["disolucion_volumen_inyeccion"]
            , $condicionCromatograficaData["disolucion_tr"], $condicionCromatograficaData["disolucion_temperatura"], $condicionCromatograficaData["disolucion_aptitud_sistema"]
            , $condicionCromatograficaData["disolucion_fase_movil"], $condicionCromatograficaData["disolucion_ecuacion_calculo"]
            , $condicionCromatograficaData["referencia"], $condicionCromatograficaData["disolucion_referencia"]
            , $condicionCromatograficaData["disolucion_concentracion"]
            , $condicionCromatograficaData["elaborado_por"], $condicionCromatograficaData["revisado_por"]
            , $condicionCromatograficaData["aprobado_por"]);

        $new = $tabla->getCondicionCromatograficaByIdToAud($condicionCromatograficaData["id"]);
        $this->insertCondicionCromatograficaAud($old, $new, $condicionCromatograficaData["id"], "update", "Actualizacion condicion cromatografica");

        $response = json_encode($result);
        echo $response;
    }

    function insertCondicionCromatografica($condicionCromatograficaData)
    {
        $tabla = new TablaCondicionCromatograficaDbModelClass();
        $old = NULL;

        $result = $tabla->insertCondicionCromatografica($condicionCromatograficaData["codigo"], $condicionCromatograficaData["nombre"], $condicionCromatograficaData["longitud_onda"]
            , $condicionCromatograficaData["diluyente_valoracion"], $condicionCromatograficaData["diluyente_disolucion"]
            , $condicionCromatograficaData["fase_movil"], $condicionCromatograficaData["concentracion"]
            , $condicionCromatograficaData["flujo"], $condicionCromatograficaData["volumen_inyeccion"]
            , $condicionCromatograficaData["temperatura"], $condicionCromatograficaData["aptitud_sistema"], $condicionCromatograficaData["tr"]
            , $condicionCromatograficaData["observaciones"], $condicionCromatograficaData["disolucion_condiciones"]
            , $condicionCromatograficaData["disolucion_medio"], $condicionCromatograficaData["disolucion_longitud_onda"], $condicionCromatograficaData["disolucion_observaciones"]
            , $condicionCromatograficaData["ecuacion_calculo"], $condicionCromatograficaData["disolucion_flujo"], $condicionCromatograficaData["disolucion_volumen_inyeccion"]
            , $condicionCromatograficaData["disolucion_tr"], $condicionCromatograficaData["disolucion_temperatura"], $condicionCromatograficaData["disolucion_aptitud_sistema"]
            , $condicionCromatograficaData["disolucion_fase_movil"], $condicionCromatograficaData["disolucion_ecuacion_calculo"]
            , $condicionCromatograficaData["referencia"], $condicionCromatograficaData["disolucion_referencia"]
            , $condicionCromatograficaData["disolucion_concentracion"]
            , $condicionCromatograficaData["elaborado_por"], $condicionCromatograficaData["revisado_por"]
            , $condicionCromatograficaData["aprobado_por"]);

        $new = $tabla->getCondicionCromatograficaByIdToAud($result["data"]);
        $this->insertCondicionCromatograficaAud($old, $new, $result["data"], "create", "Crear condicion cromatografica");

        $response = json_encode($result);
        echo $response;
    }

    function deleteCondicionCromatografica($idCondicionCromatografica)
    {
        $tabla = new TablaCondicionCromatograficaDbModelClass();
        $old = $tabla->getCondicionCromatograficaByIdToAud($idCondicionCromatografica);

        $result = $tabla->deleteCondicionCromatografica($idCondicionCromatografica);

        $new = $tabla->getCondicionCromatograficaByIdToAud($idCondicionCromatografica);
        $this->insertCondicionCromatograficaAud($old, $new, $idCondicionCromatografica, "update", "Eliminacion condicion cromatografica");

        $response = json_encode($result);
        echo $response;
    }

    function updateCondicionCromatograficaProdEnsayo($productoEnsayosData)
    {
        $tabla = new TablaProductoEnsayoDbModelClass();
        $tablaProducto = new TablaProductoDBModelClass();
        $idProducto = $productoEnsayosData[0]["id_producto"];
        $old = $tablaProducto->getProductoByIdToAud($idProducto);

        foreach ($productoEnsayosData as $productoEnsayoData) {
            $result = $tabla->updateCondicionCromatograficaProdEnsayo($productoEnsayoData["id"]
                , $productoEnsayoData["id_condicion_cromatografica"]);
        }
        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "Edición condicion cromatografica producto");

        $response = json_encode($result);
        echo $response;
    }

    function updateColumnaProdEnsayo($productoEnsayosData)
    {
        $tabla = new TablaProductoEnsayoDbModelClass();
        $tablaProducto = new TablaProductoDBModelClass();
        $idProducto = $productoEnsayosData[0]["id_producto"];
        $old = $tablaProducto->getProductoByIdToAud($idProducto);

        foreach ($productoEnsayosData as $productoEnsayoData) {
            $result = $tabla->updateColumnaProdEnsayo($productoEnsayoData["id"]
                , $productoEnsayoData["id_columna"]);
        }

        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "Edición columna producto");

        $response = json_encode($result);
        echo $response;
    }

    function desactivarLoteReactivo($loteReactivoData)
    {
        $tabla = new TablaLoteReactivoDbModelClass();
        $resultDeactivate = $tabla->deactivateLoteById($loteReactivoData["id"]);

        $response = json_encode($resultDeactivate);
        echo $response;
    }

    function desactivarLoteEstandar($loteEstandarData)
    {
        $tabla = new TablaLoteEstandarDbModelClass();
        $resultDeactivate = $tabla->deactivateLoteById($loteEstandarData["id"]);

        $response = json_encode($resultDeactivate);
        echo $response;
    }

    function obtenerEnsayosAsignados($idUsuario, $idMuestra)
    {
        $tabla = new TablaEnsayoMuestraDbModelClass();
        $result = $tabla->obtenerEnsayosAsignados($idUsuario, $idMuestra);

        $response = json_encode($result);
        echo $response;
    }

    function getAllFormaFarmaceutica()
    {
        $tabla = new TablaFormaDbModelClass();
        $result = $tabla->getAllFormas2();
        $response = json_encode($result);
        echo $response;
    }

    function updateProducto($productoData)
    {
        $tabla = new TablaProductoDbModelClass();
        $old = $tabla->getProductoByIdToAud($productoData["id"]);

        $result = $tabla->updateProducto2($productoData["id"], $productoData["nombre"], $productoData["id_formula_farma"]);

        $new = $tabla->getProductoByIdToAud($productoData["id"]);
        $tabla->insertProductoAud($old, $new, $productoData["id"], "update", "Actualización datos basicos producto");
        $response = json_encode($result);
        echo $response;
    }

    function insertProducto($productoData)
    {
        $tablaEnsayo = new TablaProductoDbModelClass();
        $result = $tablaEnsayo->insertProducto2($productoData["nombre"], $productoData["id_formula_farma"], 1, 1, 1);

        if ($result["code"] == "00000") {
            $new = $tablaEnsayo->getProductoByIdToAud($result["data"]);
            $tablaEnsayo->insertProductoAud(NULL, $new, $result["data"], "create", "Creación nuevo producto");
        }

        $response = json_encode($result);
        echo $response;
    }

    function deleteProducto($idProducto)
    {
        $tablaEnsayo = new TablaProductoDbModelClass();
        $old = $tablaEnsayo->getProductoByIdToAud($idProducto);

        $result = $tablaEnsayo->deleteProductoById($idProducto);

        $new = $tablaEnsayo->getProductoByIdToAud($idProducto);
        $tablaEnsayo->insertProductoAud($old, $new, $idProducto, "update", "Eliminación producto");
        $response = json_encode($result);
        echo $response;
    }

    function getPaquetesAsociadosByIdProd($idProducto)
    {
        $tabla = new TablaEnsayoDbModelClass();
        $tabla2 = new TablaProductoEnsayoDbModelClass();
        $result = $tabla->getPaquetesAsociadosByIdProd($idProducto);
        foreach ($result["data"] as $paquete) {
            $rta = $tabla2->getEnsayosProductoByIdPaqueteIdProducto($paquete->id, $idProducto);
            $paquete->ensayos = $rta["data"];
        }
        $response = json_encode($result);
        echo $response;
    }

    function getPaquetesDisponiblesByIdProd($idProducto)
    {
        $tabla = new TablaEnsayoDbModelClass();
        $result = $tabla->getPaquetesDisponiblesByIdProd($idProducto);
        $response = json_encode($result);
        echo $response;
    }

    function deleteProductoPaquetes($productoPaquete)
    {
        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($productoPaquete[0]["id_producto"]);

        $tabla = new TablaProductoPaqueteDBModelClass();
        $tabla2 = new TablaProductoEnsayoDBModelClass();
        foreach ($productoPaquete as $keyProdPaquete => $valueProdPaquete) {
            $result = $tabla->deleteProductoPaquete2($valueProdPaquete["id_producto_paquete"]);
            if ($result["code"] != "00000") {
                break;
            } else {
                foreach ($valueProdPaquete["ensayos"] as $keyEnsayo => $valueEnsayo) {
                    $result = $tabla2->deleteProductoEnsayo2($valueEnsayo["id"], $valueProdPaquete["id_producto"], $valueProdPaquete["id_producto_paquete"]);
                    if ($result["code"] != "00000") {
                        break;
                    }
                }
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($productoPaquete[0]["id_producto"]);
        $tablaProducto->insertProductoAud($old, $new, $productoPaquete[0]["id_producto"], "update", "Desasignación paquete al producto");

        $response = json_encode($result);
        echo $response;
    }

    function createProductoPaquetes($producto, $paquetes)
    {
        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($producto['id']);

        $tabla = new TablaProductoPaqueteDbModelClass();
        $ensayosPaqueteModel = new TablaEnsayoPaqueteDbModelClass();
        $tabla2 = new TablaProductoEnsayoDbModelClass();
        foreach ($paquetes as $keyPaquete => $valuePaquete) {
            $result = $tabla->insertProductoPaquete2($producto['id'], $valuePaquete['id']);
            if ($result["code"] != "00000") {
                break;
            } else {
                $ensayosPaquete = $ensayosPaqueteModel->getEnsayosPaquetesByIdPaquete2($valuePaquete["id"]);
                foreach ($ensayosPaquete["data"] as $keyEnsayo => $valueEnsayo) {
                    $result2 = $tabla2->insertProductoEnsayo($valueEnsayo->id_ensayo, $producto["id"]
                        , $valueEnsayo->tiempo, 1, $valueEnsayo->precio_real, $valueEnsayo->descripcion
                        , "", $result["data"], 0, "");
                }
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($producto['id']);
        $tablaProducto->insertProductoAud($old, $new, $producto['id'], "update", "Asignación nuevo paquete al producto");

        $response = json_encode($result);
        echo $response;
    }

    function editarProductoEnsayo($productoEnsayoData)
    {
        $tabla = new TablaProductoEnsayoDbModelClass();

        $idProducto = ProductoEnsayo::find($productoEnsayoData["id_producto_ensayo"])->id_producto;
        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($idProducto);

        $result = $tabla->updateProductoEnsayoById2($productoEnsayoData["id_producto_ensayo"]
            , $productoEnsayoData["descripcion_especifica"], $productoEnsayoData["especificacion"]
            , $productoEnsayoData["id_metodo"], $productoEnsayoData["tiempo"]);

        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "actualización de datos de los ensayos asociados al producto (producto-ensayos)");

        $response = json_encode($result);
        echo $response;
    }

    function getPrincipiosAsociadosByIdProd($idProducto)
    {
        $tabla = new TablaProductoDbModelClass();
        $result = $tabla->getPrincipiosAsociadosByIdProd($idProducto);
        $response = json_encode($result);
        echo $response;
    }

    function getPrincipiosDisponiblesByIdProd($idProducto)
    {
        $tabla = new TablaProductoDbModelClass();
        $result = $tabla->getPrincipiosDisponiblesByIdProd($idProducto);
        $response = json_encode($result);
        echo $response;
    }

    function deleteProductoPrincipios($productoPrincipios)
    {
        $tabla = new TablaProductoPrincipioActivoDbModelClass();

        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($productoPrincipios[0]["id_producto"]);

        foreach ($productoPrincipios as $keyProdPrincipios => $valueProdPrincipios) {
            $result = $tabla->deleteProductoPrincipio($valueProdPrincipios["id_producto_principio_activo"]);
            if ($result["code"] != "00000") {
                break;
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($productoPrincipios[0]["id_producto"]);
        $tablaProducto->insertProductoAud($old, $new, $productoPrincipios[0]["id_producto"], "update", "Desasignación de principio activo al producto");

        $response = json_encode($result);
        echo $response;
    }

    function createProductoPrincipios($producto, $principios)
    {
        $tabla = new TablaProductoPrincipioActivoDbModelClass();

        $tablaProducto = new TablaProductoDBModelClass();
        $old = $tablaProducto->getProductoByIdToAud($producto['id']);

        foreach ($principios as $keyPrincipio => $valuePrincipio) {
            $result = $tabla->insertProductoPrincipio($producto['id'], $valuePrincipio['id']);
            if ($result["code"] != "00000") {
                break;
            }
        }

        $new = $tablaProducto->getProductoByIdToAud($producto['id']);
        $tablaProducto->insertProductoAud($old, $new, $producto['id'], "update", "Asignación nuevo principio activo al producto");

        $response = json_encode($result);
        echo $response;
    }

    function getMuestrasSalida()
    {
        $tabla = new TablaMuestraDbModelClass();
        $data = $tabla->getMuestrasSalida($_SESSION['systemsParameters']['diasNotificacionAlmacenamientoSalida']);
        $util = new UtilsController();
        foreach ($data['data'] as $muestra) {
            $result = $util->constructComplexIdMuestra($muestra->prefijo, $muestra->custom_id);
            $muestra->complexId = $result;
        }
        $response = json_encode($data);
        echo $response;
    }

    function actualizarEstadoSalidaMuestra($idAlmacenamiento)
    {
        $tabla = new TablaAlmacenamientoDbModelClass();
        $result = $tabla->actualizarEstadoSalidaMuestra($idAlmacenamiento);
        $response = json_encode($result);
        echo $response;
    }

    function getClientesActivos()
    {
        $tabla = new TablaTerceroDbModelClass();
        $data = $tabla->getClientesActivos();
        $response = json_encode($data);
        echo $response;
    }

    function getUsuariosCliente($idCliente)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $data = $tabla->getUsuariosCliente($idCliente);
        $response = json_encode($data);
        echo $response;
    }

    function insertUsuarioCliente($usuarioData)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $tablaTercero = new TablaTerceroDbModelClass();
        $admController = new AdministracionController();

        $old = $tablaTercero->getTerceroByIdToAud($usuarioData['idCliente']);

        $result = $tabla->insertUsuarioCliente($usuarioData['nombre'], $usuarioData['usuario']
            , $usuarioData['cargo'], $usuarioData['idCliente'], $usuarioData['contrasena']);
        $new = $tablaTercero->getTerceroByIdToAud($usuarioData['idCliente']);
        $admController->insertTerceroAud($old, $new, $usuarioData['idCliente'], "update", "Creación de usuario cliente");
        $response = json_encode($result);
        echo $response;
    }

    function updateUsuarioClienteInfo($usuarioData)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $tablaTercero = new TablaTerceroDbModelClass();
        $admController = new AdministracionController();

        $old = $tablaTercero->getTerceroByIdToAud($usuarioData['idCliente']);

        $result = $tabla->updateUsuarioCliente($usuarioData['nombre'], $usuarioData['usuario']
            , $usuarioData['cargo'], $usuarioData['id']);

        $new = $tablaTercero->getTerceroByIdToAud($usuarioData['idCliente']);
        $admController->insertTerceroAud($old, $new, $usuarioData['idCliente'], "update", "Actualización de usuario cliente");

        $response = json_encode($result);
        echo $response;
    }

    function updateUsuarioClienteContrasena($usuarioData)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $result = $tabla->updateUsuarioClienteContrasena($usuarioData['contrasena'], $usuarioData['id']);
        $response = json_encode($result);
        echo $response;
    }

    function eliminarUsuarioCliente($idUsuario)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $tablaTercero = new TablaTerceroDbModelClass();
        $admController = new AdministracionController();

        $idTercero = ClienteUsuario::find($idUsuario)->cliente;

        $old = $tablaTercero->getTerceroByIdToAud($idTercero);

        $result = $tabla->eliminarUsuarioCliente($idUsuario);

        $new = $tablaTercero->getTerceroByIdToAud($idTercero);
        $admController->insertTerceroAud($old, $new, $idTercero, "update", "Eliminar usuario cliente");

        $response = json_encode($result);
        echo $response;
    }

    function getAllPermisosUsuarioCliente()
    {
        $tabla = new TablaClientePermisoDbModelClass();
        $data = $tabla->getAllPermisosUsuarioCliente();
        $response = json_encode($data);
        echo $response;
    }

    function getPermisosUsuarioCliente($idUsuario)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();
        $data = $tabla->getPermisosUsuarioCliente($idUsuario);
        $response = json_encode($data);
        echo $response;
    }

    function actualizarPermisosUsuarioCliente($permisosData, $idUsuario)
    {
        $tabla = new TablaClienteUsuarioDbModelClass();

        $tablaTercero = new TablaTerceroDbModelClass();
        $admController = new AdministracionController();

        $idTercero = ClienteUsuario::find($idUsuario)->cliente;

        $old = $tablaTercero->getTerceroByIdToAud($idTercero);

        $result = $tabla->deletePermisosUsuarioCliente($idUsuario);
        if ($result["code"] == "00000") {
            foreach ($permisosData as $permiso) {
                $result = $tabla->insertarPermisoUsuarioCliente($idUsuario, $permiso);
                if ($result["code"] != "00000") {
                    break;
                }
            }
        }

        $new = $tablaTercero->getTerceroByIdToAud($idTercero);
        $admController->insertTerceroAud($old, $new, $idTercero, "update", "Editar permisos usuario cliente");

        $response = json_encode($result);
        echo $response;
    }

    function insertEquipo($equipoData)
    {
        $tabla = new TablaEquiposDbModelClass();
        $result = $tabla->insertEquipo2($equipoData["cod_inventario"], $equipoData["modelo"], $equipoData["serie"]
            , $equipoData["descripcion"], $equipoData["marca"]
            , $equipoData["fecha_ult_mant"], $equipoData["fecha_ult_calib"]
            , $equipoData["fecha_prox_calibracion"], $equipoData["fecha_prox_mantenimiento"]
            , $equipoData["fecha_ult_calificacion"], $equipoData["fecha_prox_calificacion"]
            , $equipoData["proveedor_mant"]);

        $new = $tabla->getEquipoByIdToAud($result["data"]);
        $this->insertAudEquipo(NULL, $new, $result["data"], "create", "creación nuevo equipo");

        $response = json_encode($result);
        echo $response;
    }

    function updateEquipo($equipoData)
    {
        $tabla = new TablaEquiposDbModelClass();
        $old = $tabla->getEquipoByIdToAud($equipoData["id"]);

        $result = $tabla->updateEquipo($equipoData["id"], $equipoData["cod_inventario"], $equipoData["modelo"], $equipoData["serie"]
            , $equipoData["descripcion"], $equipoData["marca"]
            , $equipoData["fecha_ult_mant"], $equipoData["fecha_ult_calib"]
            , $equipoData["fecha_prox_calibracion"], $equipoData["fecha_prox_mantenimiento"]
            , $equipoData["fecha_ult_calificacion"], $equipoData["fecha_prox_calificacion"]
            , $equipoData["proveedor_mant"]);

        $new = $tabla->getEquipoByIdToAud($equipoData["id"]);
        $this->insertAudEquipo($old, $new, $equipoData["id"], "update", "Actualización equipo");

        $response = json_encode($result);
        echo $response;
    }

    function deleteEquipo($idEquipo)
    {
        $tabla = new TablaEquiposDbModelClass();
        $old = $tabla->getEquipoByIdToAud($idEquipo);

        $result = $tabla->deleteEquipo($idEquipo);

        $new = $tabla->getEquipoByIdToAud($idEquipo);
        $this->insertAudEquipo($old, $new, $idEquipo, "update", "Borrado equipo");
        $response = json_encode($result);
        echo $response;
    }

    function getFestivos()
    {
        $tabla = new TablaFestivosDbModelClass();
        $result = $tabla->getFestivos();
        $response = json_encode($result);
        echo $response;
    }

    function getMesesSalida()
    {
        $tabla = new TablaSystemParametersDbModelClass();
        $result = $tabla->getSystemParameterByPropiedad('mesesFechaSalidaAlmacenamiento');
        $response = json_encode($result);
        echo $response;
    }

    function updateAlmacenamiento($idMuestra, $fecha, $idUbicacion
        , $idTipoAlmacenamiento, $nivel, $caja
        , $tiempo, $fechaSalida, $peso, $observaciones, $id)
    {

        $old = AuditoriaController::getFullMuestraToAud($idMuestra);

        $tabla = new TablaAlmacenamientoDbModelClass();
        if ($idTipoAlmacenamiento == 'undefined') {
            $result = $tabla->updateAlmacenamiento($idMuestra, $fecha, $idUbicacion
                , $nivel, $caja
                , $tiempo, $fechaSalida, $peso, $observaciones, $id);
        } else {
            $result = $tabla->updateAlmacenamientoConIdTipo($idMuestra, $fecha, $idUbicacion
                , $idTipoAlmacenamiento, $nivel, $caja
                , $tiempo, $fechaSalida, $peso, $observaciones, $id);
        }
        $new = AuditoriaController::getFullMuestraToAud($idMuestra);
        AuditoriaController::insertMuestraAud($old, $new, $idMuestra, "update", "Actualización de almacenamiento");

        $response = json_encode($result);
        echo $response;
    }

    function getEnsayosPaginacion($cantidad, $pagina, $descripcion, $precio_real
        , $tiempo, $plantilla, $codinterno, $orden)
    {
        $tabla = new TablaEnsayoDbModelClass();

        $result = $tabla->getEnsayosPaginacion($cantidad, $pagina
            , $descripcion, $precio_real, $tiempo, $plantilla, $codinterno, $orden);

        $response = json_encode($result);
        echo $response;
    }

    function getPaquetesPaginacion($cantidad, $pagina, $codigo, $descripcion)
    {
        $tabla = new TablaEnsayoDbModelClass();

        $result = $tabla->getPaquetesPaginacion($cantidad, $pagina, $codigo
            , $descripcion);

        $response = json_encode($result);
        echo $response;
    }

    function getProductosPaginacion($cantidad, $pagina, $nombre, $forma)
    {
        $tabla = new TablaProductoDBModelClass();

        $result = $tabla->getProductosPaginacion($cantidad, $pagina, $nombre
            , $forma);

        $response = json_encode($result);
        echo $response;
    }

    function anularMuestra($idMuestra, $motivo, $usuario)
    {
        $tabla = new TablaMuestraDbModelClass();
        $tablaEnsayo = new TablaEnsayoMuestraDbModelClass();
        $result = $tabla->anularMuestra2($idMuestra, $motivo, $usuario);
        $old = AuditoriaController::getFullMuestraToAud($idMuestra);
        if ($result["code"] == "00000") {
            $result = $tablaEnsayo->anularEnsayosMuestra($idMuestra);

            $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
            $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 11, $_SESSION['userId'], "Muestra anulada");

            $new = AuditoriaController::getFullMuestraToAud($idMuestra);
            AuditoriaController::insertMuestraAud($old, $new, $idMuestra, "update", "Muestra anulada");
        }
        $response = json_encode($result);
        echo $response;
    }

    function insertEstandarAud($old, $new, $idEstandar, $evento, $razon)
    {

        $estandarAud = new EstandarAud();
        $estandarAud->fecha = new DateTime("now");
        $estandarAud->old = $old;
        $estandarAud->new = $new;
        $estandarAud->id_usuario = $_SESSION['userId'];
        $estandarAud->id_estandar = $idEstandar;
        $estandarAud->evento = $evento;
        $estandarAud->razon = $razon;
        try {
            $estandarAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertAudEquipo($old, $new, $idEquipo, $evento, $razon)
    {
        $equipoAud = new EquipoAud();
        $equipoAud->fecha = new DateTime("now");
        $equipoAud->old = $old;
        $equipoAud->new = $new;
        $equipoAud->id_usuario = $_SESSION['userId'];
        $equipoAud->id_equipo = $idEquipo;
        $equipoAud->evento = $evento;
        $equipoAud->razon = $razon;
        try {
            $equipoAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insertPrincipioActivoAud($old, $new, $idPrincipioActivo, $evento, $razon)
    {
        $principioActivoAud = new PrincipioActivoAud();
        $principioActivoAud->fecha = new DateTime("now");
        $principioActivoAud->old = $old;
        $principioActivoAud->new = $new;
        $principioActivoAud->id_usuario = $_SESSION['userId'];
        $principioActivoAud->id_principio_activo = $idPrincipioActivo;
        $principioActivoAud->evento = $evento;
        $principioActivoAud->razon = $razon;
        try {
            $principioActivoAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function insertColumnaAud($old, $new, $idColumna, $evento, $razon)
    {

        $colunmaAud = new ColumnaAud();
        $colunmaAud->fecha = new DateTime("now");
        $colunmaAud->old = $old;
        $colunmaAud->new = $new;
        $colunmaAud->id_usuario = $_SESSION['userId'];
        $colunmaAud->id_columna = $idColumna;
        $colunmaAud->evento = $evento;
        $colunmaAud->razon = $razon;
        try {
            $colunmaAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertCondicionCromatograficaAud($old, $new, $idCondicionCromatografica, $evento, $razon)
    {

        $condicioncromatograficaAud = new CondicionCromatograficaAud();
        $condicioncromatograficaAud->fecha = new DateTime("now");
        $condicioncromatograficaAud->old = $old;
        $condicioncromatograficaAud->new = $new;
        $condicioncromatograficaAud->id_usuario = $_SESSION['userId'];
        $condicioncromatograficaAud->id_condicion_cromatografica = $idCondicionCromatografica;
        $condicioncromatograficaAud->evento = $evento;
        $condicioncromatograficaAud->razon = $razon;
        try {
            $condicioncromatograficaAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertPerfilAud($old, $new, $idPerfil, $evento, $razon)
    {
        $perfilAud = new PerfilAud();
        $perfilAud->fecha = new DateTime("now");
        $perfilAud->old = $old;
        $perfilAud->new = $new;
        $perfilAud->id_usuario = $_SESSION['userId'];
        $perfilAud->id_perfil = $idPerfil;
        $perfilAud->evento = $evento;
        $perfilAud->razon = $razon;
        try {
            $perfilAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function getMuestrasParaFacturacion($pagina, $cantidad, $complex_id, $producto, $tercero, $lote)
    {

        $complex_id = "%" . $complex_id . "%";
        $producto = "%" . $producto . "%";
        $tercero = "%" . $tercero . "%";
        $lote = "%" . $lote . "%";

        $pagina--;

        $auxMuestrasTotal = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as complexId,
            t1.id,
            t2.nombre as tercero,
            t3.nombre as producto,
            t4.numero as lote 
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            t1.id_estado_muestra IN (17,10) AND
			ISNULL(t1.num_factura) 
			
            GROUP BY t1.id
            ORDER BY t1.id desc ; ", [$complex_id, $tercero, $producto, $lote]);

        $resultAuxMuestras = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as complexId,
            t1.id,
            t2.nombre as tercero,
            t3.nombre as producto,
            t4.numero as lote 
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            
            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            t1.id_estado_muestra IN (17,10) AND
            ISNULL(t1.num_factura) 
            
            GROUP BY t1.id
            ORDER BY t1.id desc
            LIMIT ? , ? ; ", [$complex_id, $tercero, $producto, $lote, $pagina * $cantidad, $cantidad]);

        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $resultAuxMuestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function actualizarNumeroFactura($muestra)
    {
        $tabla = new TablaMuestraDbModelClass();
        $result = $tabla->actualizarNumeroFactura($muestra);
        $response = json_encode($result);
        echo $response;
    }

    function actualizarFechaEntrega($muestra)
    {
        $tabla = new TablaMuestraDbModelClass();
        $result = $tabla->actualizarFechaEntrega($muestra);
        $response = json_encode($result);
        echo $response;
    }

    function getMuestrasParaEntrega($pagina, $cantidad, $complex_id, $producto, $tercero, $lote)
    {

        $complex_id = "%" . $complex_id . "%";
        $producto = "%" . $producto . "%";
        $tercero = "%" . $tercero . "%";
        $lote = "%" . $lote . "%";

        $pagina--;

        $auxMuestrasTotal = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as complexId,
            t1.id,
            t2.nombre as tercero,
            t3.nombre as producto,
            t4.numero as lote 
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            t1.id_estado_muestra IN (17,10) AND
            ISNULL(t1.fecha_entrega) 
			
            GROUP BY t1.id
            ORDER BY t1.id desc ; ", [$complex_id, $tercero, $producto, $lote]);

        $resultAuxMuestras = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as complexId,
            t1.id,
            t2.nombre as tercero,
            t3.nombre as producto,
            t4.numero as lote 
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            
            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            t1.id_estado_muestra IN (17,10) AND
            ISNULL(t1.fecha_entrega) 
            
            GROUP BY t1.id
            ORDER BY t1.id desc
            LIMIT ? , ? ; ", [$complex_id, $tercero, $producto, $lote, $pagina * $cantidad, $cantidad]);

        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $resultAuxMuestras
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getTipoIdentificaciones()
    {
        $tabla = new TablaTipoIdentificacionDbModelClass();
        $result = $tabla->getTipoIdentificaciones();
        $response = json_encode($result);
        echo $response;
    }

    function getCiudades()
    {
        $tabla = new TablaCiudadDbModelClass();
        $result = $tabla->getCiudades();
        $response = json_encode($result);
        echo $response;
    }

    function actualizarCliente($cliente)
    {
        $tabla = new TablaTerceroDbModelClass();
        $old = $tabla->getTerceroByIdToAud($cliente["id"]);
        $result = $tabla->updateTerceroById2($cliente["id"], $cliente["nombre"], $cliente["tipo_identificacion"], $cliente["numero_identificacion"]
            , $cliente["nombre_representante"], $cliente["direccion"], $cliente["telefono1"]
            , $cliente["telefono2"], $cliente["fax"], $cliente["email"], $cliente["id_ciudad"]
            , $cliente["descuento_pronto_pago"], $cliente["porcent_descuento"]
            , $cliente["tiene_contrato"], $cliente["fecha_contrato_temp"], $cliente["fecha_vencimiento_contrato_temp"]);

        $new = $tabla->getTerceroByIdToAud($cliente["id"]);
        $tabla->insertTerceroAud($old, $new, $cliente["id"], "update", "Actualización datos basicos de tecero");

        $response = json_encode($result);
        echo $response;
    }

    function insertarCliente($cliente)
    {
        $tabla = new TablaTerceroDbModelClass();
        $result = $tabla->insertTercero2($cliente["nombre"], $cliente["tipo_identificacion"], $cliente["numero_identificacion"]
            , $cliente["nombre_representante"], $cliente["direccion"], $cliente["telefono1"]
            , $cliente["telefono2"], $cliente["fax"], $cliente["email"], $cliente["id_ciudad"]
            , $cliente["descuento_pronto_pago"], $cliente["porcent_descuento"]
            , $cliente["tiene_contrato"], $cliente["fecha_contrato_temp"], $cliente["fecha_vencimiento_contrato_temp"]);

        $new = $tabla->getTerceroByIdToAud($result["data"]);
        $tabla->insertTerceroAud(NULL, $new, $result["data"], "update", "Creación nuevo tercero");

        $response = json_encode($result);
        echo $response;
    }

    function consultarContactosCliente($idCliente)
    {
        $tabla = new TablaContactoDbModel();
        $result = $tabla->getContactosByIdCliente($idCliente);
        $response = json_encode($result);
        echo $response;
    }

    function actualizarCrearContactos($contactos, $idTercero)
    {
        $tabla = new TablaContactoDbModel();
        $tablaTercero = new TablaTerceroDbModelClass();
        foreach ($contactos as $contacto) {
            if (array_key_exists('id', $contacto)) {
                $old = $tablaTercero->getTerceroByIdToAud($idTercero);
                $result = $tabla->updateContactoById2($contacto['id'], $contacto['nombre']
                    , $contacto['cargo'], $contacto['area'], $contacto['telefono']
                    , $contacto['movil'], $contacto['extencion'], $contacto['email']
                    , $idTercero, $contacto['preferencias']);
                $razon = "Actualización datos de contacto";
            } else {
                $old = NULL;
                $result = $tabla->insertContacto2($contacto['nombre']
                    , $contacto['cargo'], $contacto['area'], $contacto['telefono']
                    , $contacto['movil'], $contacto['extencion'], $contacto['email']
                    , $idTercero, $contacto['preferencias']);
                $razon = "Creación nuevo contacto";
            }
            $new = $tablaTercero->getTerceroByIdToAud($idTercero);
            $tablaTercero->insertTerceroAud($old, $new, $idTercero, "update", $razon);
        }
        $response = json_encode($result);
        echo $response;
    }

    function getDatosGraficaParticipacionClientes($fechaInicial, $fechaFinal)
    {


        $tablaMuestras = new TablaMuestraDbModelClass();

        $result = $tablaMuestras->getDatosGraficaParticipacionClientes($fechaInicial, $fechaFinal);


//$response = array("code" => "00000", "message" => "OKr");
        $response = json_encode($result);

        echo $response;
    }

    function getDatosGraficaParticipacionClientesEst($fechaInicial, $fechaFinal)
    {


        $tablaMuestras = new TablaEstMuestraDbModelClass();

        $result = $tablaMuestras->getDatosGraficaParticipacionClientesEst($fechaInicial, $fechaFinal);


        //$response = array("code" => "00000", "message" => "OKr");
        $response = json_encode($result);

        echo $response;
    }

    function getMuestrasProgramadasTercero($pagina, $cantidad, $muestra, $fechaLlegada
        , $cliente, $producto, $lote, $ensayo, $fechaCompromiso)
    {

        $muestra = "%" . $muestra . "%";
        $fechaLlegada = "%" . $fechaLlegada . "%";
        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $lote = "%" . $lote . "%";
        $ensayo = "%" . $ensayo . "%";
        $fechaCompromiso = "%" . $fechaCompromiso . "%";

        $pagina--;

        $auxMuestrasTotal = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as custom_id,
            t1.id,
            t1.prefijo,
            t1.fecha_llegada,
            t2.nombre as nom_tercero,
            t3.nombre as nombre_producto,
            t4.numero as numero_lote,
            t6.descripcion_especifica as des_ensayo,
            t1.fecha_compromiso
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            JOIN sgm_ensayo_muestra t6 ON t1.id = t6.id_muestra
            JOIN sgm_ensayo t7 ON t7.id = t6.id_ensayo
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t1.fecha_llegada,'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            ifnull(t6.descripcion_especifica,'') LIKE ? AND
            ifnull(t1.fecha_compromiso,'') LIKE ? AND
            
            t1.activa = 1 AND t6.estado_ensayo = 0 AND t7.prog_automatica = 'Si'

            GROUP BY t1.id
            ORDER BY t1.id desc ; ", [$muestra, $fechaLlegada, $cliente, $producto, $lote, $ensayo, $fechaCompromiso]);

        $resultAuxMuestras = Capsule::select("
            SELECT 
            concat(t1.prefijo, '-', t1.custom_id) as custom_id,
            t1.id,
            t1.prefijo,
            t1.fecha_llegada,
            t2.nombre as nom_tercero,
            t3.nombre as nombre_producto,
            t4.numero as numero_lote,
            t6.descripcion_especifica as des_ensayo,
            t1.fecha_compromiso
            FROM
            sgm_muestra t1
            JOIN sgm_terceros t2 ON t1.id_tercero = t2.id
            JOIN sgm_producto t3 ON t1.id_producto = t3.id
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra
            JOIN sgm_ensayo_muestra t6 ON t1.id = t6.id_muestra
            JOIN sgm_ensayo t7 ON t7.id = t6.id_ensayo
            

            WHERE   
            ifnull(concat(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND
            ifnull(t1.fecha_llegada,'') LIKE ? AND
            ifnull(t2.nombre,'') LIKE ? AND
            ifnull(t3.nombre,'') LIKE ? AND
            ifnull(t4.numero,'') LIKE ? AND
            ifnull(t6.descripcion_especifica,'') LIKE ? AND
            ifnull(t1.fecha_compromiso,'') LIKE ? AND
            
            t1.activa = 1 AND t6.estado_ensayo = 0 AND t7.prog_automatica = 'Si'
            
            GROUP BY t1.id
            ORDER BY t1.id desc
            LIMIT ? , ? ; ", [$muestra, $fechaLlegada, $cliente, $producto, $lote, $ensayo, $fechaCompromiso, $pagina * $cantidad, $cantidad]);

        $auxMuestras = [];

        foreach ($resultAuxMuestras as $value) {
            array_push($auxMuestras, $value->id);
        }

        $muestras = Muestra::whereIn("id", $auxMuestras)->get();


        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        foreach ($muestras as $muestra) {
            $muestra->show_id_muestra = $muestra->prefijo . $separatorParameter->valor . $muestra->custom_id;
            $muestra->tercero;
            $muestra->producto;
            $muestra->lote;

            $auxFechaLlegada = new DateTime($muestra->fecha_llegada);
            $muestra->label_fecha_llegada = $auxFechaLlegada->format("Y-m-d");

            $auxFechaCompromiso = new DateTime($muestra->fecha_compromiso);
            $muestra->label_fecha_compromiso = $auxFechaCompromiso->format("Y-m-d");

            $resultAuxEnsayos = Capsule::select("
                SELECT 
                t6.id,
                t6.descripcion_especifica,
                DATE_FORMAT(t6.fecha_compromiso_interno, '%Y-%m-%d') as fecha_compromiso  
                FROM
                sgm_ensayo_muestra t6 
                LEFT JOIN sgm_ensayo t7 ON t6.id_ensayo = t7.id
                WHERE 
                t6.id_muestra = ? AND
                ifnull(t6.descripcion_especifica,'') LIKE ? AND
                ifnull(t6.fecha_compromiso_interno, '') LIKE ? AND
                t6.estado_ensayo = 0 AND t7.prog_automatica = 'Si';", [$muestra->id, $ensayo, $fechaCompromiso]);

            $auxEnsayos = [];

            foreach ($resultAuxEnsayos as $auxEnsayo) {
                array_push($auxEnsayos, $auxEnsayo->id);
            }


            $muestra->ensayos_muestra = EnsayoMuestra::whereIn("id", $auxEnsayos)->get();

            foreach ($muestra->ensayos_muestra as $ensayoMuestra) {

                $auxFechaCompromiso = new DateTime($ensayoMuestra->fecha_compromiso_interno);
                $ensayoMuestra->label_fecha_compromiso_interno = $ensayoMuestra->fecha_compromiso_interno !== NULL ? $auxFechaCompromiso->format("Y-m-d") : NULL;
            }
        }

        $auxMuestrasResponse = [];
        $flag = 0;

        for ($i = count($muestras); $i > 0; $i--) {
            $auxMuestrasResponse[$flag] = $muestras[$i - 1];
            $flag++;
        }

        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $auxMuestrasResponse
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getMuestrasEstProgramadasTercero($pagina, $cantidad, $muestra, $duracion, $temperatura
        , $cliente, $producto, $lote, $ensayo, $fechaCompromiso)
    {

        $muestra = "%" . $muestra . "%";
        $duracion = "%" . $duracion . "%";
        $temperatura = "%" . $temperatura . "%";
        $cliente = "%" . $cliente . "%";
        $producto = "%" . $producto . "%";
        $lote = "%" . $lote . "%";
        $ensayo = "%" . $ensayo . "%";

        $pagina--;

        $auxFecha = new DateTime("now");
        $auxFecha->add(new DateInterval("P" . $_SESSION["systemsParameters"]["diasAnticipacionBeEstabilidad"] . "D"));

        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();
        $auxMuestrasTotal = Capsule::select("
            SELECT 
            t6.id
            FROM sgm_est_sub_muestra t6 
            JOIN sgm_est_ensayo_sub_muestra t7 ON t6.id = t7.id_sub_muestra
            JOIN sgm_ensayo t8 ON t8.id = t7.id_ensayo 
            JOIN sgm_est_muestra t12 ON t12.id = t6.id_muestra
            JOIN sgm_terceros t13 ON t12.id_tercero = t13.id
            JOIN sgm_producto t14 ON t12.id_producto = t14.id
            LEFT JOIN sgm_tipo_muestra t9 ON t12.id_tipo_muestra = t9.id 
            LEFT JOIN sgm_est_duracion_estabilidad t10 ON t6.id_duracion = t10.id 
            LEFT JOIN sgm_est_temperatura t11 ON t6.id_temperatura = t11.id 
            

            WHERE   
            ifnull(concat(t9.prefijo, '" . $separatorParameter . "', t12.custom_id),'') LIKE ? AND
            ifnull(t10.label,'') LIKE ? AND
            ifnull(t11.label,'') LIKE ? AND
            ifnull(t13.nombre,'') LIKE ? AND
            ifnull(t14.nombre,'') LIKE ? AND
            ifnull(t12.numero_lote,'') LIKE ? AND
            ifnull(t7.descripcion_especifica,'') LIKE ? AND
            
            t6.fecha_analisis < ? AND (t6.id_estado = 1  OR t6.id_estado = 2) AND t8.prog_automatica = 'Si'

            GROUP BY t6.id
            ORDER BY t6.id desc ;", [$muestra, $duracion, $temperatura, $cliente, $producto, $lote, $ensayo, $auxFecha]);

        $resultAuxMuestras = Capsule::select("
            SELECT 
            t6.id
            FROM sgm_est_sub_muestra t6 
            JOIN sgm_est_ensayo_sub_muestra t7 ON t6.id = t7.id_sub_muestra
            JOIN sgm_ensayo t8 ON t8.id = t7.id_ensayo 
            JOIN sgm_est_muestra t12 ON t12.id = t6.id_muestra
            JOIN sgm_terceros t13 ON t12.id_tercero = t13.id
            JOIN sgm_producto t14 ON t12.id_producto = t14.id
            LEFT JOIN sgm_tipo_muestra t9 ON t12.id_tipo_muestra = t9.id 
            LEFT JOIN sgm_est_duracion_estabilidad t10 ON t6.id_duracion = t10.id 
            LEFT JOIN sgm_est_temperatura t11 ON t6.id_temperatura = t11.id 
            

            WHERE   
            ifnull(concat(t9.prefijo, '" . $separatorParameter . "', t12.custom_id),'') LIKE ? AND
            ifnull(t10.label,'') LIKE ? AND
            ifnull(t11.label,'') LIKE ? AND
            ifnull(t13.nombre,'') LIKE ? AND
            ifnull(t14.nombre,'') LIKE ? AND
            ifnull(t12.numero_lote,'') LIKE ? AND
            ifnull(t7.descripcion_especifica,'') LIKE ? AND
            
            t6.fecha_analisis < ? AND (t6.id_estado = 1  OR t6.id_estado = 2) AND t8.prog_automatica = 'Si'
            
            GROUP BY t6.id
            ORDER BY t6.id desc
            LIMIT ? , ? ; ", [$muestra, $duracion, $temperatura, $cliente, $producto, $lote, $ensayo, $auxFecha, $pagina * $cantidad, $cantidad]);

        $muestras = [];

        foreach ($resultAuxMuestras as $muestra) {
            array_push($muestras, EstSubMuestra::find($muestra->id));
        }

        foreach ($muestras as $subMuestra) {

            $subMuestra->duracion;
            $subMuestra->temperatura;
            $subMuestra->estado;
            $subMuestra->muestra->tercero;
            $subMuestra->muestra->producto;

            $subMuestra->show_id_muestra = $subMuestra->muestra->tipoMuestra->prefijo . $separatorParameter->valor . $subMuestra->muestra->custom_id;

            $auxFechaLlegada = new DateTime($subMuestra->muestra->fecha_llegada);
            $subMuestra->label_fecha_llegada = $auxFechaLlegada->format("Y-m-d");

            $resultEnsayosSubMuestra = Capsule::select("
                    SELECT 
                    t7.id,
                    t7.descripcion_especifica as des_ensayo
                    FROM sgm_est_ensayo_sub_muestra t7
                    JOIN sgm_ensayo t8 ON t8.id = t7.id_ensayo             

                    WHERE   
                    t7.id_sub_muestra = ? AND
                    ifnull(t7.descripcion_especifica,'') LIKE ? AND

                    t7.estado_ensayo = 0 AND t8.prog_automatica = 'Si'

                    GROUP BY t7.id
                    ORDER BY t7.id desc ;", [$subMuestra->id, $ensayo]);

            $auxEnsayosSubMuestra = [];

            foreach ($resultEnsayosSubMuestra as $resultEnsayoSubMuestra) {
                array_push($auxEnsayosSubMuestra, EstEnsayoSubMuestra::find($resultEnsayoSubMuestra->id));
            }

            $subMuestra->ensayos_sub_muestra = $auxEnsayosSubMuestra;
        }


        $auxMuestrasResponse = [];
        $flag = 0;

        for ($i = count($muestras); $i > 0; $i--) {
            $auxMuestrasResponse[$flag] = $muestras[$i - 1];
            $flag++;
        }

        $auxResponse = array(
            "cantidad_total" => count($auxMuestrasTotal),
            "muestras" => $auxMuestrasResponse
        );

        $response = json_encode($auxResponse);

        echo $response;
    }

    function getTiposEstandar()
    {
        $tabla = new TablaEstandarDbModelClass();
        $result = $tabla->getTiposEstandar();
        $response = json_encode($result);
        echo $response;
    }

    function createNewMetodo($metodo)
    {
        $tabla = new TablaMetodoDbModelClass();

        $old = null;

        $result = $tabla->insertMetodo($metodo);

        $new = $tabla->getMetodoByIdToAud($result["data"]);
        $this->insertAudMetodo($old, $new, $result["data"], "create", "Creacion metodo");

        $response = json_encode($result);
        echo $response;
    }

    function insertAudMetodo($old, $new, $idMetodo, $evento, $razon)
    {
        $metodoAud = new MetodoAud();
        $metodoAud->fecha = new DateTime("now");
        $metodoAud->old = $old;
        $metodoAud->new = $new;
        $metodoAud->id_usuario = $_SESSION['userId'];
        $metodoAud->id_metodo = $idMetodo;
        $metodoAud->evento = $evento;
        $metodoAud->razon = $razon;
        try {
            $metodoAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function desactivarMetodo($metodo)
    {
        $tabla = new TablaMetodoDbModelClass();

        $old = $tabla->getMetodoByIdToAud($metodo["id"]);

        $result = $tabla->updateActivoById($metodo["id"]);

        $new = $tabla->getMetodoByIdToAud($metodo["id"]);
        $this->insertAudMetodo($old, $new, $metodo["id"], "update", "Desactivación Metodo");

        $response = json_encode($result);
        echo $response;
    }

    function createNewEnvase($newEnvase)
    {
        $tabla = new TablaEnvaseDbModelClass();

        $old = null;

        $result = $tabla->insertEnvase($newEnvase);

        $new = $tabla->getEnvaseByIdToAud($result["data"]);
        $this->insertEnvaseAud($old, $new, $result["data"], "create", "Creacion envase");

        $response = json_encode($result);
        echo $response;
    }

    function insertEnvaseAud($old, $new, $idEnvase, $evento, $razon)
    {
        $envaseAud = new EnvaseAud();
        $envaseAud->fecha = new DateTime("now");
        $envaseAud->old = $old;
        $envaseAud->new = $new;
        $envaseAud->id_usuario = $_SESSION['userId'];
        $envaseAud->id_envase = $idEnvase;
        $envaseAud->evento = $evento;
        $envaseAud->razon = $razon;
        try {
            $envaseAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function actualizarFormaFarmaceutica($forma)
    {
        $tabla = new TablaEnvaseDbModelClass();

        $old = $tabla->getEnvaseByIdToAud($forma["id"]);

        $result = $tabla->actualizarFormaFarmaceutica($forma["descripcion"], $forma["id"]);

        $new = $tabla->getEnvaseByIdToAud($forma["id"]);
        $this->insertEnvaseAud($old, $new, $forma["id"], "update", "Actualización envase");

        $response = json_encode($result);
        echo $response;
    }

    function borrarFormaFarmaceutica($forma)
    {
        $tabla = new TablaEnvaseDbModelClass();

        $old = $tabla->getEnvaseByIdToAud($forma["id"]);

        $result = $tabla->borrarFormaFarmaceutica($forma["id"]);

        $new = null;
        $this->insertEnvaseAud($old, $new, $forma["id"], "delete", "Borrado envase");

        $response = json_encode($result);
        echo $response;
    }

    function createNewUsuario($nombre, $idCargo, $email, $idJefe, $login, $idPerfil, $password)
    {
        $tabla = new TablaUsuariosDbModelClass();

        $old = null;

        $fecha = new DateTime();
        $fecha = $fecha->format('Y-m-d');
        $result = $tabla->createNewUsuario($nombre, $email, $login, $password, $idCargo["id"], $idJefe["id"], $idPerfil["id"], $fecha);

        $new = $tabla->getUsuarioByIdToAud($result["data"]);
        $this->insertAudUsuario($old, $new, $result["data"], "create", "Creación usuario");

        $response = json_encode($result);
        echo $response;
    }

    function insertAudUsuario($old, $new, $idUsuario, $evento, $razon)
    {
        $usuarioAud = new UsuarioAud();
        $usuarioAud->fecha = new DateTime("now");
        $usuarioAud->old = $old;
        $usuarioAud->new = $new;
        $usuarioAud->id_usuario = $_SESSION['userId'];
        $usuarioAud->id_entidad = $idUsuario;
        $usuarioAud->evento = $evento;
        $usuarioAud->razon = $razon;
        try {
            $usuarioAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function updateUsuario1($idUsuario, $data)
    {
        $tabla = new TablaUsuariosDbModelClass();

        $old = $tabla->getUsuarioByIdToAud($idUsuario["id"]);

        $result = $tabla->updateUsuario1($idUsuario["id"], $data["nombre"], $data["email"], $data["login"], $data["cargo"], $data["jefe"], $data["perfil"]);

        $new = $tabla->getUsuarioByIdToAud($idUsuario["id"]);
        $this->insertAudUsuario($old, $new, $idUsuario["id"], "update", "Actualización usuario");

        $response = json_encode($result);
        echo $response;
    }

    function updatePasswordUsuario($idUsuario, $password)
    {
        $tabla = new TablaUsuariosDbModelClass();

        $old = $tabla->getUsuarioByIdToAud($idUsuario["id"]);

        $result = $tabla->updatePasswordUsuario($idUsuario["id"], $password);

        $new = $tabla->getUsuarioByIdToAud($idUsuario["id"]);
        $this->insertAudUsuario($old, $new, $idUsuario["id"], "update", "Actualización password usuario");

        $response = json_encode($result);
        echo $response;
    }

    function borrarUsuario($usuario)
    {
        $tabla = new TablaUsuariosDbModelClass();

        $old = $tabla->getUsuarioByIdToAud($usuario["id"]);

        $estado = 0;
        $result = $tabla->setEstadoUsuario($usuario["id"], $estado);

        $new = $tabla->getUsuarioByIdToAud($usuario["id"]);
        $this->insertAudUsuario($old, $new, $usuario["id"], "update", "Desactivación usuario");

        $response = json_encode($result);
        echo $response;
    }

    function createNewTipoProducto($codigo, $nombre)
    {
        $tabla = new TablaTipoProductoDbModelClass();

        $old = null;

        $result = $tabla->createNewTipoProducto($codigo, $nombre);

        $new = $tabla->getTipoProductoByIdToAud($result["data"]);
        $this->insertTipoProductoAud($old, $new, $result["data"], "create", "Creación tipo producto");

        $response = json_encode($result);
        echo $response;
    }

    function insertTipoProductoAud($old, $new, $idTipoProducto, $evento, $razon)
    {
        $tipoProductoAud = new FormaFarmaceuticaAud();
        $tipoProductoAud->fecha = new DateTime("now");
        $tipoProductoAud->old = $old;
        $tipoProductoAud->new = $new;
        $tipoProductoAud->id_usuario = $_SESSION['userId'];
        $tipoProductoAud->id_forma_farmaceutica = $idTipoProducto;
        $tipoProductoAud->evento = $evento;
        $tipoProductoAud->razon = $razon;
        try {
            $tipoProductoAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function actualizarTipoProducto($tipo)
    {
        $tabla = new TablaTipoProductoDbModelClass();

        $old = $tabla->getTipoProductoByIdToAud($tipo["id"]);

        $result = $tabla->actualizarTipoProducto($tipo["tipo_producto"], $tipo["descripcion"], $tipo["id"]);

        $new = $tabla->getTipoProductoByIdToAud($tipo["id"]);
        $this->insertTipoProductoAud($old, $new, $tipo["id"], "update", "Actualización tipo producto");

        $response = json_encode($result);
        echo $response;
    }

    function createNewEmpaque($newEmpaque)
    {
        $tabla = new TablaEmpaqueDbModelClass();

        $old = null;

        $result = $tabla->insertEmpaque($newEmpaque);

        $new = $tabla->getEmpaqueByIdToAud($result["data"]);
        $this->insertEmpaqueAud($old, $new, $result["data"], "create", "Creacion empaque");

        $response = json_encode($result);
        echo $response;
    }

    function insertEmpaqueAud($old, $new, $idEmpaque, $evento, $razon)
    {
        $empaqueAud = new EmpaqueAud();
        $empaqueAud->fecha = new DateTime("now");
        $empaqueAud->old = $old;
        $empaqueAud->new = $new;
        $empaqueAud->id_usuario = $_SESSION['userId'];
        $empaqueAud->id_empaque = $idEmpaque;
        $empaqueAud->evento = $evento;
        $empaqueAud->razon = $razon;
        try {
            $empaqueAud->save();
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    function actualizarEnvase($envase)
    {
        $tabla = new TablaEmpaqueDbModelClass();

        $old = $tabla->getEmpaqueByIdToAud($envase["id"]);

        $result = $tabla->actualizarEnvase($envase["descripcion"], $envase["id"]);

        $new = $tabla->getEmpaqueByIdToAud($envase["id"]);
        $this->insertEmpaqueAud($old, $new, $envase["id"], "Update", "Actualización empaque");

        $response = json_encode($result);
        echo $response;
    }

    function borrarEnvase($envase)
    {
        $tabla = new TablaEmpaqueDbModelClass();

        $old = $tabla->getEmpaqueByIdToAud($envase["id"]);

        $result = $tabla->borrarEnvase($envase["id"]);

        $new = null;
        $this->insertEmpaqueAud($old, $new, $envase["id"], "Delete", "Borrado empaque");

        $response = json_encode($result);
        echo $response;
    }

    function getMuestraEstabilidadDetalle($searchMuestra)
    {
        //$muestras = Muestra::whereIn("id", $auxMuestras)->get();


        $separatorParameter = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

        $searchData = explode($separatorParameter->valor, $searchMuestra);

        $prefijo = TipoMuestra::where("prefijo", $searchData[0])->first();

        $muestra = EstMuestra::where("id_tipo_muestra", $prefijo->id)->where("custom_id", $searchData[1])->first();


        echo json_encode($muestra->toArray());
    }

    function getDatosGraficaDesempenoAnalistas($fechaInicial, $fechaFinal)
    {
        $tablaMuestras = new TablaMuestraDbModelClass();
        $result = $tablaMuestras->getDatosGraficaDesempenoAnalistas($fechaInicial, $fechaFinal);
        $response = json_encode($result);
        echo $response;
    }

    function getDatosGraficaDesempenoByIdAnalista($fechaInicial, $fechaFinal, $idAnalista)
    {
        $tablaMuestras = new TablaMuestraDbModelClass();
        $result = $tablaMuestras->getDatosGraficaDesempenoByIdAnalista($fechaInicial, $fechaFinal, $idAnalista);
        $response = json_encode($result);
        echo $response;
    }

    function getResumenMuestras($cantidad, $pagina, $muestra, $producto, $analista, $ensayos, $estadoMuestra, $tercero)
    {
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->getResumenMuestras($cantidad, $pagina, $muestra, $producto, $analista, $ensayos, $estadoMuestra, $tercero);

        $response = json_encode($result);
        echo $response;
    }

    function exportExcelUsoReactivosMuestra($idReactivos, $fechaInicial, $fechaFin)
    {
        require_once dirname(__FILE__) . '/../utils/PHPexcel/Classes/PHPExcel.php';
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("user_nombre")
            ->setLastModifiedBy("user_nombre")
            ->setTitle("PHPExcel")
            ->setSubject("PHPExcel Document");

        // Add some data
        $tablaMuestra = new TablaMuestraDbModelClass();
        $titulos = ['REACTIVO', 'MUESTRA', 'PRODUCTO', 'ENSAYO'];
        $infoUsoReactivosMuestra = $tablaMuestra->exportExcelUsoReactivosMuestra($idReactivos, $fechaInicial, $fechaFin);
        $style = array('font' => array('size' => 12, 'bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('1')->applyFromArray($style);
        for ($i = 0; $i < count($titulos); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($i), '1', $titulos[$i]);
        }
        for ($i = 0; $i < count($infoUsoReactivosMuestra); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(0), strval($i + 2), $infoUsoReactivosMuestra[$i]->reactivo);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(1), strval($i + 2), $infoUsoReactivosMuestra[$i]->muestra);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(2), strval($i + 2), $infoUsoReactivosMuestra[$i]->producto);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(3), strval($i + 2), $infoUsoReactivosMuestra[$i]->ensayo);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Uso reactivos por muestra');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $nombreArchivo = 'UsoReactivosMuestra-' . date('Y-m-d') . '.xls';
        $objWriter->save($nombreArchivo);
        $response = array('result' => 0, 'fileName' => $nombreArchivo);


        echo json_encode($response);
    }

    function exportExcelResumenMuestra($muestra, $producto, $analista, $ensayos, $estadoMuestra, $cliente)
    {
        require_once dirname(__FILE__) . '/../utils/PHPexcel/Classes/PHPExcel.php';
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("user_nombre")
            ->setLastModifiedBy("user_nombre")
            ->setTitle("PHPExcel")
            ->setSubject("PHPExcel Document");

        // Add some data
        $tablaMuestra = new TablaMuestraDbModelClass();
        $titulos = ['MUESTRA', 'PRODUCTO', 'NOMBRE ANALISTA', 'ENSAYOS A REALIZAR', 'ESTADO', 'CLIENTE', 'F. LLEGADA', 'F. PROGRAMACIÓN',
            'F. ANÁLISIS', 'F. APROBACIÓN', 'F. COMPROMISO', 'DIAS DE RETRASO', 'LOTE', 'PROPIETARIO', 'PROVEEDOR',
            'ENVASE', 'FORMA FARMACÉUTICA', 'F. ALMACENAMIENTO', 'F. FABRICACIÓN', 'F. VENCIMIENTO', 'F. MUESTREO', 'OBSERVACIONES INTERNAS',
            'CONTACTO', 'No. FACTURA'];
        $infoResumenMuestras = $tablaMuestra->exportExcelResumenMuestras($muestra, $producto, $analista, $ensayos, $estadoMuestra, $cliente);
        $style = array('font' => array('size' => 12, 'bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('1')->applyFromArray($style);
        for ($i = 0; $i < count($titulos); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($i), '1', $titulos[$i]);
        }

        $tablaFestivos = new TablaFestivosDbModelClass();
        $diasFestivos = $tablaFestivos->consultaFestivos();

        $diasFestivos = array_map(function ($element) {
            return $element->fecha;
        }, $diasFestivos);

        $fechaGeneracion = new DateTime();

        for ($i = 0; $i < count($infoResumenMuestras); $i++) {

            $diasRetraso = 0;

            $fechaCompromiso = $infoResumenMuestras[$i]->fecha_compromiso !== NULL ? new DateTime($infoResumenMuestras[$i]->fecha_compromiso) : NULL;

            if ($fechaCompromiso != NULL) {
                while ($fechaCompromiso < $fechaGeneracion) {
                    $diaSemana = $fechaCompromiso->format('w');
                    if ($diaSemana != '6' && $diaSemana != '0') {
                        $validacion = array_search($fechaCompromiso, $diasFestivos);
                        if ($validacion == FALSE) {
                            $diasRetraso++;
                            $fechaCompromiso->add(new DateInterval('P1D'));
                        }
                    } else {
                        $fechaCompromiso->add(new DateInterval('P1D'));
                    }
                }
            }

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(0), strval($i + 2), $infoResumenMuestras[$i]->muestra);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(1), strval($i + 2), $infoResumenMuestras[$i]->producto);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(2), strval($i + 2), $infoResumenMuestras[$i]->analista);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(3), strval($i + 2), $infoResumenMuestras[$i]->ensayos);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(4), strval($i + 2), $infoResumenMuestras[$i]->estadoMuestra);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(5), strval($i + 2), $infoResumenMuestras[$i]->cliente);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(6), strval($i + 2), $infoResumenMuestras[$i]->fecha_llegada);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(7), strval($i + 2), $infoResumenMuestras[$i]->fecha_programacion);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(8), strval($i + 2), $infoResumenMuestras[$i]->fecha_analisis);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(9), strval($i + 2), $infoResumenMuestras[$i]->fecha_aprobacion);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(10), strval($i + 2), $infoResumenMuestras[$i]->fecha_compromiso);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(11), strval($i + 2), $diasRetraso);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(12), strval($i + 2), $infoResumenMuestras[$i]->lote);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(13), strval($i + 2), $infoResumenMuestras[$i]->proveedor);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(14), strval($i + 2), $infoResumenMuestras[$i]->propietario);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(15), strval($i + 2), $infoResumenMuestras[$i]->envase);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(16), strval($i + 2), $infoResumenMuestras[$i]->formaFarma);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(17), strval($i + 2), $infoResumenMuestras[$i]->fecha_almacenamiento);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(18), strval($i + 2), $infoResumenMuestras[$i]->fecha_fabricacion);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(19), strval($i + 2), $infoResumenMuestras[$i]->fecha_vencimiento);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(20), strval($i + 2), $infoResumenMuestras[$i]->fecha_muestreo);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(21), strval($i + 2), $infoResumenMuestras[$i]->observaciones);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(22), strval($i + 2), $infoResumenMuestras[$i]->contacto);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval(23), strval($i + 2), $infoResumenMuestras[$i]->num_factura);
        }

        $objPHPExcel->getActiveSheet()->setTitle('Resumen De Muestras');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $nombreArchivo = 'ResumenMuestras-' . date('Y-m-d') . '.xls';
        $objWriter->save($nombreArchivo);
        $response = array('result' => 0, 'fileName' => $nombreArchivo);


        echo json_encode($response);
    }

    function consultarAnalistasProgramadosMuestra($idMuestra)
    {
        $muestra = new TablaMuestraDbModelClass();
        $result = $muestra->consultarAnalistasProgramadosMuestra($idMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function getDetalleParticipacionCliente($fechaInicial, $fechaFinal, $idCliente)
    {
        $tablaMuestras = new TablaMuestraDbModelClass();
        $result = $tablaMuestras->getDetalleParticipacionCliente($fechaInicial, $fechaFinal, $idCliente);
        $response = json_encode($result);

        echo $response;
    }

    function getDetalleParticipacionClienteEst($fechaInicial, $fechaFinal, $idCliente)
    {
        $tablaMuestras = new TablaEstMuestraDbModelClass();
        $result = $tablaMuestras->getDetalleParticipacionClienteEst($fechaInicial, $fechaFinal, $idCliente);
        $response = json_encode($result);

        echo $response;
    }

    function getDetalleEstadoMuestras($fechaInicial, $fechaFinal, $idEstado)
    {
        $tablaMuestras = new TablaMuestraDbModelClass();
        $result = $tablaMuestras->getDetalleEstadoMuestras($fechaInicial, $fechaFinal, $idEstado);
        $response = json_encode($result);

        echo $response;
    }

    function getDetalleTipoProducto($fechaInicial, $fechaFinal, $idTipoProducto)
    {
        $tablaMuestras = new TablaMuestraDbModelClass();
        if(intval($idTipoProducto) !== 0) {
            $result = $tablaMuestras->getDetalleTipoProducto($fechaInicial, $fechaFinal, $idTipoProducto);
        }else{
            $result = $tablaMuestras->getDetalleTipoProductoEst($fechaInicial, $fechaFinal);
        }
        $response = json_encode($result);

        echo $response;
    }

    function getEnsayoMuestraInformacionGeneralHojaCalculo($idEnsayoMuestra)
    {
        $tabla = new TablaMuestraHojaCalculoDbModelClass();
        $result = $tabla->getEnsayoMuestraInformacionGeneralHojaCalculo($idEnsayoMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function getHojaCalculoEnsayoMuestra($idEnsayoMuestra)
    {
        $tabla = new TablaMuestraHojaCalculoDbModelClass();
        $result = $tabla->getHojaCalculoEnsayoMuestra($idEnsayoMuestra);
        if(count($result["data"] > 0)) {
            foreach ($result["data"] as $keyResult => $resultado) {
                $result["data"][$keyResult]["data"] = json_decode($resultado["data"]);
            }
        } else {
            $result["data"] = null;
        }
        $response = json_encode($result);
        echo $response;
    }

    function consultaMuestraAuditoria($muestra)
    {
        $utilsController = new UtilsController();
        $idMuestra = $utilsController->getRealIdMuestra($muestra);
        $tabla = new TablaMuestraDbModelClass();
        $result = $tabla->consultaAuditoriaMuestra($idMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function getPermisosModulo(){
        $modulos = Modulo::all();

        foreach ($modulos as $modulo){
            $modulo->permisos = $modulo->permisos()->orderBy('orden', 'asc')->get();
        }
        echo $modulos;
    }

    function updateEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data, $idHojaCalculoEnsayoMuestra){
        $tabla = new TablaMuestraHojaCalculoDbModelClass();

        $old = $tabla->getEnsayoMuestraHojaCalculoByIdToAud($idHojaCalculoEnsayoMuestra);

        $data = $this->promediosHojaCalculo($data);
        $data = $this->coeficientesVariacion($data);
        $data["dato"]["factorEquivalenciaConversion"]["factor"] = $data["dato"]["factorEquivalenciaConversion"]["cantidad"]["value"];
        $data["dato"]["factorEquivalenciaPeso"]["factor"] = ($data["dato"]["pesoMolecularBase"]["peso"] / $data["dato"]["pesoMolecularSal"]["peso"]);
        $data = $this->factoresDilucionHojaCalculo($data);
        $data["dato"]["factorDilucion"]["factor"] = ($data["alicuota"]["factorDilucionEstandar"]["factor"] / $data["alicuota"]["factorDilucionMuestra"]["factor"]);
        $data = $this->CalculosHojaCalculo($data);
        $result = $tabla->updateEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data);

        $new = $tabla->getEnsayoMuestraHojaCalculoByIdToAud($idHojaCalculoEnsayoMuestra);
        $tabla->insertEnsayoMuestraHojaCalculoAud($old, $new, $idEnsayoMuestra, $idHojaCalculoEnsayoMuestra, "update", "Actualiza hoja cálculo ensayo muestra");

        $response = json_encode($result);
        echo $response;
    }

    function saveEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data){
        $tabla = new TablaMuestraHojaCalculoDbModelClass();

        $old = null;

        $data = $this->promediosHojaCalculo($data);
        $data = $this->coeficientesVariacion($data);
        $data["dato"]["factorEquivalenciaConversion"]["factor"] = $data["dato"]["factorEquivalenciaConversion"]["cantidad"]["value"];
        $data["dato"]["factorEquivalenciaPeso"]["factor"] = ($data["dato"]["pesoMolecularBase"]["peso"] / $data["dato"]["pesoMolecularSal"]["peso"]);
        $data = $this->factoresDilucionHojaCalculo($data);
        $data["dato"]["factorDilucion"]["factor"] = ($data["alicuota"]["factorDilucionEstandar"]["factor"] / $data["alicuota"]["factorDilucionMuestra"]["factor"]);
        $data = $this->CalculosHojaCalculo($data);
        $usuarioGuardado = $_SESSION['userId'];
        $result = $tabla->saveEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data, $usuarioGuardado);

        $idHojaCalculoEnsayoMuestra = $result["idMuestraHojaCalculo"];

        $new = $tabla->getEnsayoMuestraHojaCalculoByIdToAud($idHojaCalculoEnsayoMuestra);
        $tabla->insertEnsayoMuestraHojaCalculoAud($old, $new, $idEnsayoMuestra, $idHojaCalculoEnsayoMuestra, "create", "Inserta hoja cálculo ensayo muestra");

        $response = json_encode($result);
        echo $response;
    }

    function promediosHojaCalculo($data){
        $controllerEstadistico = new CustomEstadisticaController();
        $data["estandar"]["promedio"] = $controllerEstadistico->promedio($data["estandar"]["areas"]);
        foreach($data["muestra"]["muestras"] AS $keyMuestra => $muestra){
            $data["muestra"]["muestras"][$keyMuestra]["promedio"] = $controllerEstadistico->promedio($muestra["areas"]);
        }
        return $data;
    }

    function coeficientesVariacion($data){
        $controllerEstadistico = new CustomEstadisticaController();
        $desviacionEstandar = $controllerEstadistico->desviacionEstandar($data["estandar"]["areas"], $data["estandar"]["promedio"]);
        $data["estandar"]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionEstandar, $data["estandar"]["promedio"]);
        foreach($data["muestra"]["muestras"] AS $keyMuestra => $muestra){
            $desviacionEstandarMuestra = $controllerEstadistico->desviacionEstandar($muestra["areas"], $muestra["promedio"]);
            $data["muestra"]["muestras"][$keyMuestra]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionEstandarMuestra, $muestra["promedio"]);
        }
        return $data;
    }

    function factoresDilucionHojaCalculo($data){
        $controllerEstadistico = new CustomEstadisticaController();
        $data["alicuota"]["factorDilucionMuestra"]["factor"] = $controllerEstadistico->factorDilucion($data["alicuota"]["muestras"], $data["alicuota"]["aluciotasMuestra"]);
        $data["alicuota"]["factorDilucionEstandar"]["factor"] = $controllerEstadistico->factorDilucion($data["alicuota"]["estandares"], $data["alicuota"]["aluciotasEstandar"]);
        return $data;
    }

    function CalculosHojaCalculo($data){
        $controllerEstadistico = new CustomEstadisticaController();

        $arrayMg = [];
        $arrayPorcentaje = [];
        $arrayPorcentajeBh = [];
        $arrayPorcentajeBs = [];

        foreach($data["muestra"]["muestras"] AS $keyMuestra => $muestra){
            $data["calculo"]["calculos"][$keyMuestra]["mg"] = (($muestra["promedio"]/$data["estandar"]["promedio"])*($data["dato"]["pesoEstandar"]["peso"]/$data["dato"]["muestras"][$keyMuestra]["muestra"])*($data["dato"]["factorDilucion"]["factor"])*($data["dato"]["purezaEstandar"]["pureza"]/100)*($data["dato"]["pesoPromedio"]["peso"])*($data["dato"]["factorEquivalenciaPeso"]["factor"])*($data["dato"]["factorEquivalenciaConversion"]["factor"])*($data["dato"]["humedad"]["humedad"]));
            array_push($arrayMg, $data["calculo"]["calculos"][$keyMuestra]["mg"]);

            $data["calculo"]["calculos"][$keyMuestra]["porcentaje"] = (($data["calculo"]["calculos"][$keyMuestra]["mg"]/$data["dato"]["cantidadTeorica"]["porcentaje"]) * 100);
            array_push($arrayPorcentaje, $data["calculo"]["calculos"][$keyMuestra]["porcentaje"]);

            $data["calculo"]["calculos"][$keyMuestra]["porcentajeBh"] = (($muestra["promedio"]/$data["estandar"]["promedio"])*($data["dato"]["pesoEstandar"]["peso"]/$data["dato"]["muestras"][$keyMuestra]["muestra"])*($data["dato"]["factorDilucion"]["factor"])*($data["dato"]["purezaEstandar"]["pureza"]/100)*($data["dato"]["pesoPromedio"]["peso"])*($data["dato"]["factorEquivalenciaPeso"]["factor"])*($data["dato"]["factorEquivalenciaConversion"]["factor"])*($data["dato"]["cantidadTeorica"]["porcentaje"]));
            array_push($arrayPorcentajeBh, $data["calculo"]["calculos"][$keyMuestra]["porcentajeBh"]);

            $data["calculo"]["calculos"][$keyMuestra]["porcentajeBs"] = (($data["calculo"]["calculos"][$keyMuestra]["mg"] * 100)/(100 - $data["dato"]["humedad"]["humedad"]));
            array_push($arrayPorcentajeBs, $data["calculo"]["calculos"][$keyMuestra]["porcentajeBs"]);
        }

        $data["calculo"]["promedios"][0]["promedio"] = $controllerEstadistico->promedio($arrayMg);
        $desviacionPromedioCalculo1 = $controllerEstadistico->desviacionEstandar($arrayMg, $data["calculo"]["promedios"][0]["promedio"]);
        $data["calculo"]["promedios"][0]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionPromedioCalculo1, $data["calculo"]["promedios"][0]["promedio"]);

        $data["calculo"]["promedios"][1]["promedio"] = $controllerEstadistico->promedio($arrayPorcentaje);
        $desviacionPromedioCalculo2 = $controllerEstadistico->desviacionEstandar($arrayPorcentaje, $data["calculo"]["promedios"][1]["promedio"]);
        $data["calculo"]["promedios"][1]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionPromedioCalculo2, $data["calculo"]["promedios"][1]["promedio"]);

        $data["calculo"]["promedios"][2]["promedio"] = $controllerEstadistico->promedio($arrayPorcentajeBh);
        $desviacionPromedioCalculo3 = $controllerEstadistico->desviacionEstandar($arrayPorcentajeBh, $data["calculo"]["promedios"][2]["promedio"]);
        $data["calculo"]["promedios"][2]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionPromedioCalculo3, $data["calculo"]["promedios"][2]["promedio"]);

        $data["calculo"]["promedios"][3]["promedio"] = $controllerEstadistico->promedio($arrayPorcentajeBs);
        $desviacionPromedioCalculo4 = $controllerEstadistico->desviacionEstandar($arrayPorcentajeBs, $data["calculo"]["promedios"][3]["promedio"]);
        $data["calculo"]["promedios"][3]["cv"] = $controllerEstadistico->coeficienteVariacion($desviacionPromedioCalculo4, $data["calculo"]["promedios"][3]["promedio"]);

        return $data;
    }

    function getAllHojasCalculo(){
        $tabla = new TablaMuestraHojaCalculoDbModelClass();
        $result = $tabla->getAllHojasCalculo();
        $response = json_encode($result);
        echo $response;
    }

    function consultaInfoIdHojaCalculo($idEnsayoMuestra){
        $tabla = new TablaEnsayoMuestraDbModelClass();
        $result = $tabla->consultaInfoIdHojaCalculo($idEnsayoMuestra);
        $response = json_encode($result);
        echo $response;
    }

    function updateHojaCalculoProdEnsayo($productoEnsayosData)
    {
        $tabla = new TablaProductoEnsayoDbModelClass();
        $tablaProducto = new TablaProductoDBModelClass();
        $idProducto = $productoEnsayosData[0]["id_producto"];
        $old = $tablaProducto->getProductoByIdToAud($idProducto);

        foreach ($productoEnsayosData as $productoEnsayoData) {
            $result = $tabla->updateHojaCalculoProdEnsayo($productoEnsayoData["id"]
                , $productoEnsayoData["id_hoja_calculo"]);
        }
        $new = $tablaProducto->getProductoByIdToAud($idProducto);
        $tablaProducto->insertProductoAud($old, $new, $idProducto, "update", "Edición hoja cálculo producto");

        $response = json_encode($result);
        echo $response;
    }

    function getFuncionesHojaCalculo($idEnsayoMuestra){
        $tabla = new TablaMuestraHojaCalculoDbModelClass();
        $result = $tabla->getFuncionesHojaCalculo($idEnsayoMuestra);
        $response = json_encode($result);
        echo $response;
    }

}
