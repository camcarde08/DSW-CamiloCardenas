<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaTerceroDbModelClass.php';
require '../TablaContactoDbModel.php';
require '../../DbClass.php';


$modelTercero = new TablaTerceroDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelTercero->getAllTercero();
            foreach ($data as $cargo) {
               $terceros[] = array(
                   'id' => $cargo['id'],
                   'nombre' => $cargo['nombre'],
                   'tipoIdentificacion' => $cargo['tipo_identificacion'],
                   'numeroIdentificacion' => $cargo['numero_identificacion'],
                   'representante' => $cargo['nombre_representante'],
                   'direccion' => $cargo['direccion'],
                   'telefono1' => $cargo['telefono1'],
                   'telefono2' => $cargo['telefono2'],
                   'fax' => $cargo['fax'],
                   'email' => $cargo['email'],
                   'idCiudad' => $cargo['id_ciudad'],
                   'porDescuento' => $cargo['porcent_descuento'],
                   'contrato' => $cargo['tiene_contrato'],
                   'venContrato' => $cargo['vencimiento_contrato'],
                   'fechaVenContrato' => $cargo['fecha_vencimiento_contrato'],
                   'fechaContrato' => $cargo['fecha_contrato'],
                   'estado' => $cargo['estado'],
                   'descuento'=> $cargo['descuento_pronto_pago']
               );
               
               
               
            }
            echo json_encode($terceros);
}

if($_GET['query'] == 'getTercerosJoinArayContactos'){
    
    $modelTablaContacto = new TablaContactoDbModel();
    
    $data = $modelTercero->getAllTercero();
            foreach ($data as $tercero) {
                $contactos = NULL;
                $contactosData = $modelTablaContacto->getContactosNameByTerceroId($tercero['id']);
               foreach ($contactosData as $contacto) {
                   $contactos[] = array(
                       "id" => (int)$contacto["id"],
                       "nombre" => $contacto["nombre"],
                       "cargo" => $contacto["cargo"],
                       "area" => $contacto["area"],
                       "telefono" => (int)$contacto["telefono"],
                       "movil" => (int)$contacto["movil"],
                       "extencion" => (int)$contacto["extencion"],
                       "email" => (int)$contacto["email"],
                       "preferencias" => (int)$contacto["preferencias"]
                   );
                   
               }
               $terceros[] = array(
                   'id' => (int)$tercero['id'],
                   'nombre' => $tercero['nombre'],
                   'tipoIdentificacion' => (int)$tercero['tipo_identificacion'],
                   'numeroIdentificacion' => $tercero['numero_identificacion'],
                   'representante' => $tercero['nombre_representante'],
                   'direccion' => $tercero['direccion'],
                   'telefono1' => $tercero['telefono1'],
                   'telefono2' => $tercero['telefono2'],
                   'fax' => $tercero['fax'],
                   'email' => $tercero['email'],
                   'idCiudad' => (int)$tercero['id_ciudad'],
                   'porDescuento' => $tercero['porcent_descuento'],
                   'contrato' => (int)$tercero['tiene_contrato'],
                   'venContrato' => (int)$tercero['vencimiento_contrato'],
                   'fechaVenContrato' => $tercero['fecha_vencimiento_contrato'],
                   'fechaContrato' => $tercero['fecha_contrato'],
                   'estado' => (int)$tercero['estado'],
                   'descuento'=> (int)$tercero['descuento_pronto_pago'],
                   "contactos" => $contactos
               );
               
               
            }
            echo json_encode($terceros);
}



