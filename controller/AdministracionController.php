<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdministracionController
 *
 * @author andres
 */
class AdministracionController {

    public function updatePassword($idUser, $newPassword) {
        $modelTablaUsuario = new TablaUsuariosDbModelClass();
        $old = $modelTablaUsuario->getUsuarioByIdToAud($idUser);

        $data = $modelTablaUsuario->updatePasswordByIdUser($idUser, $newPassword);
        if ($data == true) {

            $new = $modelTablaUsuario->getUsuarioByIdToAud($idUser);
            $this->insertUsuarioAud($old, $new, $idUser, "update", "Actualización contraseña");

            $response = array('result' => 0, 'message' => 'Se actualizo correctamente la contraseña');
        } else {
            $response = array('result' => 0, 'message' => 'Fallo al actualizar la contraseña');
        }
        echo json_encode($response);
    }

    public function updateProducto($idProducto, $nombreProducto, $forma) {
        $modelProducto = new TablaProductoDBModelClass();
        $modelProducto->updateProducto($idProducto, $nombreProducto, $forma);
    }

    public function deleteProducto($idProducto, $activo, $nombre) {
        $modelProducto = new TablaProductoDBModelClass();
        $resultado = $modelProducto->deleteProducto($idProducto, $activo);
        if ($resultado) {
            $response = array('result' => '0', 'message' => 'El producto ' . $nombre . 'se borro correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo el borrado del producto' . $nombre);
            echo json_encode($response);
        }
    }

    public function updateForma($idForma, $descripcionForma) {
        $modelForma = new TablaFormaDbModelClass();

        $old = $modelForma->getFormaByIdToAud($idForma);

        $resultado = $modelForma->updateForma($idForma, $descripcionForma);
        if ($resultado) {

            $new = $modelForma->getFormaByIdToAud($idForma);
            $this->insertFormaFarmacuticaAud($old, $new, $idForma, "update", "Actualización de tipo de producto");

            $response = array('result' => '0', 'message' => 'El Forma farmaceutica se ha actualizado correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualizacion de la forma farmaceutica');
            echo json_encode($response);
        }
    }

    public function paintErrorAccess() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintErrorAccess();
    }

    public function deleteProductoPrincipioActivo($productoPrincipioActivoData) {
        $productoPrincipioActivo = json_decode($productoPrincipioActivoData, true);
        $productoPrincipioActivoModel = new TablaPrincipioActivoProductoDbModelClass();

        for ($i = 0; $i < count($productoPrincipioActivo); $i++) {
            $idProductoPrincipioActivo = $productoPrincipioActivo[$i]['idProductoPrincipioActivo'];

            $productoPrincipioActivoModel->deleteProductoPrincipioActivo($idProductoPrincipioActivo);
        }
    }

    public function insertPrincipioActivoProducto($principioActivoProductoData) {
        $principioActivoProducto = json_decode($principioActivoProductoData, true);
        $principioActivoProductoModel = new TablaPrincipioActivoProductoDbModelClass();

        for ($i = 0; $i < count($principioActivoProducto); $i++) {
            $idProducto = $principioActivoProducto[$i]['idProducto'];
            $idPrincipioActivo = $principioActivoProducto[$i]['idPrincipioActivo'];
            $principioActivoProductoModel->insertBasicPrincipioActivoProducto($idProducto, $idPrincipioActivo);
        }
        // $productoPaqueteModel->insertProductoPaquete($idProducto, $idPaquete);
    }

    public function updatePrincipioActivoProducto($principal, $trasador, $cantidad, $unidadCantidad, $cantidadDecimal, $idPrincipioActivoProducto) {
        $modelPrincipioActivoProducto = new TablaPrincipioActivoProductoDbModelClass();
        $modelPrincipioActivoProducto->updatePrincipioActivoProducto($principal, $trasador, $cantidad, $unidadCantidad, $cantidadDecimal, $idPrincipioActivoProducto);
    }

    public function createContacto($nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $modelContacto = new TablaContactoDbModel();

        $tablaTercero = new TablaTerceroDbModelClass();
        $old = $tablaTercero->getTerceroByIdToAud($idTercero);

        $data = $modelContacto->insertContacto($nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias);
        if ($data != false) {
            $new = $tablaTercero->getTerceroByIdToAud($idTercero);
            $this->insertTerceroAud($old, $new, $idTercero, "update", "Creación nuevo contacto");

            $response = array('result' => '0', 'message' => 'El Contacto se ha sido actualizado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualizacion del contacto');
            echo json_encode($response);
        }
    }

    public function updateContacto($id, $nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $modelContacto = new TablaContactoDbModel();

        $tablaTercero = new TablaTerceroDbModelClass();
        $old = $tablaTercero->getTerceroByIdToAud($idTercero);

        $data = $modelContacto->updateContactoById($id, $nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias);
        if ($data) {
            $new = $tablaTercero->getTerceroByIdToAud($idTercero);
            $this->insertTerceroAud($old, $new, $idTercero, "update", "Actualización datos de contacto");

            $response = array('result' => '0', 'message' => 'El Contacto se ha sido actualizado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualizacion del contacto');
            echo json_encode($response);
        }
    }

    public function crearPaquete($codigo, $descripcion, $idAreaAnalisis) {
        $modelEnsayo = new TablaEnsayoDbModelClass();
        $areaEnsayoModel = new TablaAreaAnalisisEnsayoDbModelClass();
        $idPaquete = $modelEnsayo->insertPaquete($codigo, $descripcion);
        if ($idPaquete != false) {
            $areaEnsayoModel->insertAreaAnalisisEnsayo($idAreaAnalisis, $idPaquete);
        }
    }

    public function editarPaqueteNom($codigo, $id, $descripcion) {
        $modelEnsayo = new TablaEnsayoDbModelClass();
        $data = $modelEnsayo->updatePaqueteNom($codigo, $id, $descripcion);
        if ($data) {
            $response = array('result' => '0', 'message' => 'El Paquete ha sido actualizado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualización del Paquete');
            echo json_encode($response);
        }
    }

    public function deletePaqueteNom($id, $activo, $nombre) {
        $modelEnsayo = new TablaEnsayoDbModelClass();
        $data = $modelEnsayo->deletePaqueteNom($id, $activo);
        if ($data) {
            $response = array('result' => '0', 'message' => 'El Paquete ' . $nombre . ' ha sido borrado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo el borrado del Paquete  ' . $nombre);
            echo json_encode($response);
        }
    }

    public function updateEnsayoById($id, $precio, $tiempo, $plantilla, $descripcion) {
        $modelEnsayo = new TablaEnsayoDbModelClass();
        $data = $modelEnsayo->updateEnsayoById($id, $precio, $tiempo, $plantilla, $descripcion);
        if ($data) {
            $response = array('result' => '0', 'message' => 'El Ensayo ha sido actualizado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualización del ensayo');
            echo json_encode($response);
        }
    }

    public function insertTercero($nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {
        $modelTercer = new TablaTerceroDbModelClass();
        $old = NULL;

        $id = $modelTercer->insertTercero($nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato);
        if ($id != false) {

            $new = $modelTercer->getTerceroByIdToAud($id);
            $this->insertTerceroAud($old, $new, $id, "create", "Creación nuevo tercero");

            $response = array('result' => '0', 'message' => 'El Cliente ha sido creado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo en la creación del cliente');
            echo json_encode($response);
        }
    }

    public function updateTerceroById($id, $nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {
        $modelTercero = new TablaTerceroDbModelClass();
        $old = $modelTercero->getTerceroByIdToAud($id);

        $data = $modelTercero->updateTerceroById($id, $nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato);
        if ($data) {

            $new = $modelTercero->getTerceroByIdToAud($id);
            $this->insertTerceroAud($old, $new, $id, "update", "Actualización datos basicos de tecero");

            $response = array('result' => '0', 'message' => 'El Cliente ha sido actualizado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualizacion del cliente');
            echo json_encode($response);
        }
    }

    public function paintTerceroAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionTercero();
    }

    public function paintAdminMedioCultivo() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdminMedioCultivo();
    }

    public function paintAdminCepa() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdminCepa();
    }

    public function paintEquiposEnsayos() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintEquiposEnsayos();
    }

    public function createProducto($nombre, $idFormaFarma, $estado, $tecnica, $timepoEntrega) {
        $productoModel = new TablaProductoDBModelClass();
        if ($productoModel->insertProducto($nombre, $idFormaFarma, $estado, $tecnica, $timepoEntrega) != false) {
            $response = array('result' => '0', 'message' => 'El Producto se ha creado exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la creación del producto');
            echo json_encode($response);
        }
    }

    public function updateProductoEnsayo($idProductoEnsayo, $descripcion, $especificacion, $idMetodo, $tiempo, $valor, $resultado) {
        $productoEnsayoModel = new TablaProductoEnsayoDbModelClass();
        $productoEnsayoModel->updateProductoEnsayoById($idProductoEnsayo, $descripcion, $especificacion, $idMetodo, $tiempo, $valor, $resultado);
    }

    public function deleteProductoPaquete($dataProductoPaquete) {
        $productoPaquete = json_decode($dataProductoPaquete, true);
        $productoPaqueteModel = new TablaProductoPaqueteDBModelClass();
        $productoEnsayoModel = new TablaProductoEnsayoDbModelClass();
        $ensayosPaqueteModel = new TablaEnsayoPaqueteDbModelClass();
        for ($i = 0; $i < count($productoPaquete); $i++) {
            $ensayosPaquete = $ensayosPaqueteModel->getEnsayosPaquetesByIdPaquete($productoPaquete[$i]["idEnsayo"]);
            for ($j = 0; $j < count($ensayosPaquete); $j++) {
                $productoEnsayoModel->deleteProductoEnsayo($ensayosPaquete[$j]["id_ensayo"], $productoPaquete[$i]["idProducto"], $productoPaquete[$i]["idProductoPaquete"]);
            }

            $productoPaqueteModel->deleteProductoPaquete($productoPaquete[$i]["idProductoPaquete"]);
        }
    }

    public function insertProductoPaquete($dataProductoEnsayo) {
        $productoEnsayos = json_decode($dataProductoEnsayo, true);
        $productoPaqueteModel = new TablaProductoPaqueteDBModelClass();
        $ensayosPaqueteModel = new TablaEnsayoPaqueteDbModelClass();
        $productoEnsayosModel = new TablaProductoEnsayoDbModelClass();
        for ($i = 0; $i < count($productoEnsayos); $i++) {
            $idProductoPaquete = $productoPaqueteModel->insertProductoPaquete($productoEnsayos[$i]["idProducto"], $productoEnsayos[$i]["idEnsayo"]);
            $ensayosPaquete = $ensayosPaqueteModel->getEnsayosPaquetesByIdPaquete($productoEnsayos[$i]["idEnsayo"]);
            for ($j = 0; $j < count($ensayosPaquete); $j++) {
                $idProductoEnsayo = $productoEnsayosModel->insertProductoEnsayo($ensayosPaquete[$j]["id_ensayo"], $productoEnsayos[$i]["idProducto"], $ensayosPaquete[$j]["tiempo"], 1, $ensayosPaquete[$j]["precio_real"], $ensayosPaquete[$j]["descripcion"], "", $idProductoPaquete, 0, "");
            }
        }
        // $productoPaqueteModel->insertProductoPaquete($idProducto, $idPaquete);
    }

    public function paintProductoAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionProducto();
    }

    public function crearForma($descripcion) {
        $old = NULL;

        $formaModel = new TablaFormaDbModelClass();
        $idFormaFarmaceutica = $formaModel->insertForma($descripcion);

        $new = $formaModel->getFormaByIdToAud($idFormaFarmaceutica);
        $this->insertFormaFarmacuticaAud($old, $new, $idFormaFarmaceutica, "create", "Creacion nueva tipo de producto");
    }

    public function paintFormaAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionForma();
    }

    //////////Estandares////////////////////
    public function crearEstandar($nombre, $lote, $cantidad, $fechaven, $tipo, $cantidadActual, $stock, $loteInterno, $fechaPreparacion, $fechaPromocion, $cantidad2, $codigo) {
        $estandarModel = new TablaEstandarDbModelClass();
        $estandarModel->insertEstandar($nombre, $lote, $cantidad, $fechaven, $tipo, $cantidadActual, $stock, $loteInterno, $fechaPreparacion, $fechaPromocion, $cantidad2, $codigo, date('Y-m-d'), date('Y-m-d'), date('Y-m-d'));
    }

    public function crearReactivo($nombre, $lote, $cantidad, $fechaven, $tipo, $cantidadActual, $stock, $fechaIngreso, $fechaApertura, $fechaTerminacion, $loteIterno, $fechaPase) {
        $reactivoModel = new TablaReactivoDbModelClass();
        $reactivoModel->insertReactivo($nombre, $lote, $cantidad, $fechaven, $tipo, $cantidadActual, $stock, $fechaIngreso, $fechaApertura, $fechaTerminacion, $loteIterno, $fechaPase);
    }

    public function paintEstandarAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionEstandares();
    }

    public function updateEstandar($nombre, $lote, $cantidad, $fecha, $fechaIngreso, $fechaApertura, $fechaTerminacion, $id, $tipo, $cantidadActual, $stock) {
        $equipoModel = new TablaEstandarDbModelClass();
        if ($equipoModel->updateEstandarById($nombre, $lote, $cantidad, $fecha, $fechaIngreso, $fechaApertura, $fechaTerminacion, $id, $tipo, $cantidadActual, $stock)) {
            $response = array('result' => '0', 'message' => 'Se ha actualizado el estandar  correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de actualizar el estandar ' . $nombre);
            echo json_encode($response);
        }
    }

    public function updateReactivo($nombre, $lote, $cantidad, $fecha, $fechaIngreso, $fechaApertura, $fechaTerminacion, $id, $tipo, $cantidadActual, $stock, $loteInterno, $fechaPase) {
        $equipoModel = new TablaReactivoDbModelClass();
        if ($equipoModel->updateReactivoById($nombre, $lote, $cantidad, $fecha, $fechaIngreso, $fechaApertura, $fechaTerminacion, $id, $tipo, $cantidadActual, $stock, $loteInterno, $fechaPase)) {
            $response = array('result' => '0', 'message' => 'Se ha actualizado el reactivo  correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de actualizar el reactivo ' . $nombre);
            echo json_encode($response);
        }
    }

    public function deleteEstandar($idEstandar, $activo, $nombre) {
        $equipoModel = new TablaEstandarDbModelClass();
        if ($equipoModel->updateActivoById($idEstandar, $activo)) {
            $response = array('result' => '0', 'message' => 'Se ha borrado el estandar ' . $nombre . ' correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de borrar el estandar ' . $nombre);
            echo json_encode($response);
        }
    }

    public function deleteReactivo($idReactivo, $activo, $nombre) {
        $reactivoModel = new TablaReactivoDbModelClass();
        if ($reactivoModel->updateActivoReactivoById($idReactivo, $activo)) {
            $response = array('result' => '0', 'message' => 'Se ha borrado el reactivo ' . $nombre . ' correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de borrar el reactivo ' . $nombre);
            echo json_encode($response);
        }
    }

    //////Fin Estandares
    //////////Metodos////////////////////
    public function crearMetodo($nombre, $activo) {
        $old = NULL;

        $estandarModel = new TablaMetodoDbModelClass();
        $idMetodo = $estandarModel->insertMetodo($nombre, $activo);

        $new = $estandarModel->getMetodoByIdToAud($idMetodo);
        $this->insertMetodoAud($old, $new, $idMetodo, "create", "Creación nuevo método");
    }

    public function paintMetodoAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionMetodos();
    }

    public function updateMetodo($nombre, $id) {
        $equipoModel = new TablaMetodoDbModelClass();

        $old = $equipoModel->getMetodoByIdToAud($id);

        if ($equipoModel->updateMetodoById($nombre, $id)) {

            $new = $equipoModel->getMetodoByIdToAud($id);
            $this->insertMetodoAud($old, $new, $id, "update", "Actualización del metodo");

            $response = array('result' => '0', 'message' => 'Se ha actualizado   correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de actualizar ' . $nombre);
            echo json_encode($response);
        }
    }

    public function deleteMetodo($idMetodo, $activo, $nombre) {
        $equipoModel = new TablaMetodoDbModelClass();
        $old = $equipoModel->getMetodoByIdToAud($idMetodo);

        if ($equipoModel->updateActivoById($idMetodo, $activo)) {

            $new = $equipoModel->getMetodoByIdToAud($idMetodo);
            $this->insertMetodoAud($old, $new, $idMetodo, "update", "Eliminación de método");

            $response = array('result' => '0', 'message' => 'Se ha borrado ' . $nombre . ' correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de borrar ' . $nombre);
            echo json_encode($response);
        }
    }

    //////Fin Metodos





    public function deleteEnsayoPaqueteById($idEnsayoPaquete) {
        $ensayoPaqueteModel = new TablaEnsayoPaqueteDbModelClass();
        $ensayoPaqueteModel->deleteEnsayoPaqueteById($idEnsayoPaquete);
        $response = array('result' => '0', 'message' => 'Se ha actualizado el principio activo ' . $nombre . ' correctamente');
        echo json_encode($response);
    }

    public function agregarEnsayoPaquete($idPaquete, $idEnsayo) {
        $ensayoPaqueteModel = new TablaEnsayoPaqueteDbModelClass();
        $ensayoPaqueteModel->insertEnsayoPaquete($idPaquete, $idEnsayo);
        $response = array('result' => '0', 'message' => 'Se ha actualizado el principio activo ' . $nombre . ' correctamente');
        echo json_encode($response);
    }

    public function paintPaquetesAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionPaquetes();
    }

    public function crearEnsayo($precio, $tiempo, $plantilla, $esPaquete, $descripcion) {

        $ensayoModel = new TablaEnsayoDbModelClass();
        $idEnsayo = $ensayoModel->insertEnsayo($precio, $tiempo, $plantilla, $esPaquete, $descripcion);
        if ($idEnsayo != false) {
            $areas = json_decode($areas, true);
            $areaEnsayoModel = new TablaAreaAnalisisEnsayoDbModelClass();
            for ($i = 0; $i < count($areas); $i++) {
                $areaEnsayoModel->insertAreaAnalisisEnsayo($areas[$i]["id"], $idEnsayo);
            }
            $response = array('result' => '0', 'message' => 'Se ha actualizado el principio activo ' . $nombre . ' correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de actualizar el principio activo ' . $nombre);
            echo json_encode($response);
        }
    }

    public function paintEnsayosAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionEnsayos();
    }

    public function paintPrinActivoAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionPrinActivo();
    }

    public function insertEquipo($codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali) {
        $equipoModel = new TablaEquiposDbModelClass();
        if ($equipoModel->insertEquipo($codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali)) {
            $response = array('result' => '0', 'message' => 'Se ha creado el equipo $descripcion  correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de crear el equipo ' . $nombre);
            echo json_encode($response);
        }
    }

    public function updateEquipo($idEquipo, $codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali, $frecMantpreven, $frecCalib, $fechaUlimoMant, $fechaUltimaCalibracion, $calificacion, $numDiasAlerta, $infoMant, $striker) {
        $equipoModel = new TablaEquiposDbModelClass();
        if ($equipoModel->updateEquipoById($idEquipo, $codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali, $frecMantpreven, $frecCalib, $fechaUlimoMant, $fechaUltimaCalibracion, $calificacion, $numDiasAlerta, $infoMant, $striker)) {
            $response = array('result' => '0', 'message' => 'Se ha actualizado el enquipo  correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de actualizar el equipo ' . $nombre);
            echo json_encode($response);
        }
    }

    public function deleteEquipo($idEquipo, $activo, $nombre) {
        $equipoModel = new TablaEquiposDbModelClass();
        if ($equipoModel->updateActivoById($idEquipo, $activo)) {
            $response = array('result' => '0', 'message' => 'Se ha borrado el enquipo ' . $nombre . ' correctamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Error al tratar de borra el equipo ' . $nombre);
            echo json_encode($response);
        }
    }

    public function paintEquipoAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionEquipo();
    }

    public function paintPerfilAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionPerfil();
    }

    public function createPermision($idPerfil, $idPermiso) {
        $perfilPermisoModel = new TablaPerfilPermisoDbModelClass();
        $result = $perfilPermisoModel->insertPerfilPermiso($idPerfil, $idPermiso);
        if ($result != false) {
            $response = array('result' => '0', 'message' => 'El ha actualizado corectamente el permiso');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualización del permiso');
            echo json_encode($response);
        }
    }

    public function deletePermision($idPerfil, $idPermiso) {
        $perfilPermisoModel = new TablaPerfilPermisoDbModelClass();
        $result = $perfilPermisoModel->deletePerfilPermiso($idPerfil, $idPermiso);
        if ($result != false) {
            $response = array('result' => '0', 'message' => 'El ha actualizado corectamente el permiso');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualización del permiso');
            echo json_encode($response);
        }
    }

    public function paintUsuarioAdmin() {
        $administacionModel = new AdministracionModelClass();
        $administacionModel->paintAdministracionUsuario();
    }

    public function deleteUsuario($idUsuario) {
        $usuarioModel = new TablaUsuariosDbModelClass();
        $old = $usuarioModel->getUsuarioByIdToAud($idUsuario);

        if ($usuarioModel->setEstadoUsuario($idUsuario, 0)) {

            $new = $usuarioModel->getUsuarioByIdToAud($idUsuario);
            $this->insertUsuarioAud($old, $new, $idUsuario, "update", "Eliminación usuario");

            $response = array('result' => '0', 'message' => 'Se ha borrado el usuario exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo borra el usuario');
            echo json_encode($response);
        }
    }

    public function insertUsuario($nombre, $email, $login, $contrasena, $cargo, $jefe, $perfil, $calendario) {
        if ($jefe == -1) {
            $jefe = null;
        }
        $usuarioModel = new TablaUsuariosDbModelClass();
        $old = NULL;

        $idUsuario = $usuarioModel->insertUsuario($nombre, $email, $login, $contrasena, $cargo, $jefe, $perfil, $calendario);
        if ($idUsuario != false) {

            $new = $usuarioModel->getUsuarioByIdToAud($idUsuario);
            $this->insertUsuarioAud($old, $new, $idUsuario, "create", "Creación nuevo usuario");

            $response = array('result' => '0', 'message' => 'Se ha creado el usuario exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo en la creación del usuario');
            echo json_encode($response);
        }
    }

    public function updateUsuario($idUsuario, $nombre, $email, $login, $cargo, $jefe, $perfil, $calendario) {
        if ($jefe == -1) {
            $jefe = null;
        }
        $usuarioModel = new TablaUsuariosDbModelClass();

        $old = $usuarioModel->getUsuarioByIdToAud($idUsuario);

        if ($usuarioModel->updateUsuario($idUsuario, $nombre, $email, $login, $cargo, $jefe, $perfil, $calendario)) {

            $new = $usuarioModel->getUsuarioByIdToAud($idUsuario);
            $this->insertUsuarioAud($old, $new, $idUsuario, "update", "Actualización datos de usuario");

            $response = array('result' => '0', 'message' => 'Se ha actualizado el usuario exitosamente');
            echo json_encode($response);
        } else {
            $response = array('result' => '1', 'message' => 'Fallo la actualización del usuario');
            echo json_encode($response);
        }
    }

    function insertMetodoAud($old, $new, $idMetodo, $evento, $razon) {

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
            $a = 0;
        }
    }

    function insertFormaFarmacuticaAud($old, $new, $idFormaFarmaceutica, $evento, $razon) {

        $formaFarmaceutica = new FormaFarmaceuticaAud();
        $formaFarmaceutica->fecha = new DateTime("now");
        $formaFarmaceutica->old = $old;
        $formaFarmaceutica->new = $new;
        $formaFarmaceutica->id_usuario = $_SESSION['userId'];
        $formaFarmaceutica->id_forma_farmaceutica = $idFormaFarmaceutica;
        $formaFarmaceutica->evento = $evento;
        $formaFarmaceutica->razon = $razon;
        try {
            $formaFarmaceutica->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertTerceroAud($old, $new, $idTercero, $evento, $razon) {

        $terceroAud = new TerceroAud();
        $terceroAud->fecha = new DateTime("now");
        $terceroAud->old = $old;
        $terceroAud->new = $new;
        $terceroAud->id_usuario = $_SESSION['userId'];
        $terceroAud->id_tercero = $idTercero;
        $terceroAud->evento = $evento;
        $terceroAud->razon = $razon;
        try {
            $terceroAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function insertUsuarioAud($old, $new, $idUsuario, $evento, $razon) {

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
            $a = 0;
        }
    }

}
