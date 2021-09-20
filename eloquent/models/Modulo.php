<?php



class Modulo extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_modulo';
    public $timestamps = false;

    function permisos(){
        return $this->hasMany('Permiso', 'modulo_id');
    }

}
