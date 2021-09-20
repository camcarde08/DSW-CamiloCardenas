<?php

class Paquete extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_ensayo';
    public $timestamps = false;
    
    public function ensayos(){
        return $this->belongsToMany('Ensayo', 'sgm_ensayo_paquete','id_paquete','id_ensayo');
    }

}
