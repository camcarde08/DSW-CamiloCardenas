<?php



class Cepa extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_cepa';
    public $timestamps = false;
    
    function lotes(){
        return $this->hasMany('LoteCepa', 'id_cepa');
    }
    
}
