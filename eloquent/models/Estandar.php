<?php



class Estandar extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_estandar';
    public $timestamps = false;
    
    function lotes(){
        return $this->hasMany('LoteEstandar', 'id_estandar');
    }
    
}
