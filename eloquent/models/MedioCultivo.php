<?php


class MedioCulivo extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_medio_cultivo';
    public $timestamps = false;
    
    
    function cepas(){
        return $this->belongsToMany('Cepa', 'sgm_medio_cultivo_cepa', 'id_medio_cultivo', 'id_cepa');
    }
    
    function lotes(){
        return $this->hasMany('LoteMedioCultivo', 'id_medio_cultivo');
    }
    
    
    
}
