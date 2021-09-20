<?php

class EnsayoMuestra extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_ensayo_muestra';
    public $timestamps = false;

    public function resultados() {
        return $this->hasMany('Resultados', 'id_ensayo_muestra');
    }

    public function ensayo() {
        return $this->belongsTo('Ensayo', 'id_ensayo');
    }

    public function paquete(){
        return $this->belongsTo('Paquete', 'id_paquete');

    }

    public function estado() {
        return $this->belongsTo('EstadoEnsayoMuestra', 'estado_ensayo');
    }

    public function condicionCromatografica() {
        return $this->hasMany('EnsayoMuestraCondicionCromatografica', 'id_ensayo_muestra');
    }

    public function estandares() {
        return $this->hasMany('EnsayoMuestraEstandarLote', 'id_ensayo_muestra');
    }

    public function reactivos() {
        return $this->hasMany('EnsayoMuestraReactivoLote', 'id_ensayo_muestra');
    }

    public function programacion() {
        return $this->hasMany('ProgramacionAnalistas', 'id_ensayo_muestra');
    }
    
    public function analistaProgramado(){
        return true;
    }

    public function metodo() {
        return $this->belongsTo('Metodo', 'id_metodo');
    }

}
