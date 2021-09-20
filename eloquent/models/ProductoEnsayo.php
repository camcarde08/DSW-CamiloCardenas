<?php

class ProductoEnsayo extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_producto_ensayo';
    public $timestamps = false;

    function reactivos() {
        return $this->belongsToMany('Reactivo', 'sgm_producto_ensayo_reactivo', 'id_producto_ensayo', 'id_reactivo');
    }

    function estandares() {
        return $this->belongsToMany('Estandar', 'sgm_producto_ensayo_estandar', 'id_producto_ensayo', 'id_estandar');
    }

    function ensayo() {
        return $this->belongsTo('Ensayo', 'id_ensayo');
    }

    function condicionCromatografica() {
        return $this->belongsTo('CondicionCromatografica', 'id_condicion_cromatografica');
    }

    function columna() {
        return $this->belongsTo('Columna', 'id_columna');
    }

}
