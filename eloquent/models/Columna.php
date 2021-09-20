<?php

class Columna extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_columna';
    public $timestamps = false;

    function principiosActivos() {
        return $this->hasMany('ColumnaPrincipioActivo', 'id_columna');
    }

}
