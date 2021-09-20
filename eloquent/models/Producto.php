<?php

class Producto extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_producto';
    public $timestamps = false;

    function paquetes() {
        return $this->belongsToMany('Paquete', 'sgm_producto_paquete', 'id_producto', 'id_ensayo');
    }
    
    function productoEnsayos() {
        return $this->hasMany('ProductoEnsayo', 'id_producto');
    }
    
    function principiosActivos() {
        return $this->belongsToMany('PrincipioActivo', 'sgm_producto_principio_activo', 'id_producto', 'id_principio_activo');
    }
    
    function formaFarmaceutica(){
        return $this->belongsTo('FormaFarmaceutica', 'id_formula_farma');
    }

}
