<?php



class Reactivo extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_reactivo';
    public $timestamps = false;
    
    function lotes(){
        return $this->hasMany('LoteReactivo', 'id_reactivo');
    }
    
}
