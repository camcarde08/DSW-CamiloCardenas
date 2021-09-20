<?php

class EstEnsayoSubMuestra extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_est_ensayo_sub_muestra';
    public $timestamps = false;

    public function metodo() {
        return $this->belongsTo('Metodo', 'id_metodo');
    }

    public function ensayo() {
        return $this->belongsTo('Ensayo', 'id_ensayo');
    }

    function usuarioProgramado() {
        return $this->belongsTo("Usuario", "id_analista");
    }

    public function subMuestra() {
        return $this->belongsTo('EstSubMuestra', 'id_sub_muestra');
    }

    public function estado() {
        return $this->belongsTo('EstadoEnsayoMuestra', 'estado_ensayo');
    }

    public function paquete() {
        return $this->belongsTo('Ensayo', 'id_paquete');
    }

    public function estandaresLote() {
        return $this->hasMany('EstEnsayoSubMuestraEstandarLote', 'id_ensayo_submuestra');
    }

    public function reactivosLote() {
        return $this->hasMany('EstEnsayoSubMuestraReactivoLote', 'id_ensayo_submuestra');
    }

    public function condicionesCromatograficas() {
        return $this->hasMany('EstEnsayoSubMuestraCondicionCromatografica', 'id_ensayo_submuestra');
    }

}
