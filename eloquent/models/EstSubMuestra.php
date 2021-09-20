<?php

class EstSubMuestra extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_est_sub_muestra';
    public $timestamps = false;

    function ensayosSubMuestra() {
        return $this->hasMany('EstEnsayoSubMuestra', 'id_sub_muestra');
    }

    function muestra() {
        return $this->hasOne('EstMuestra', 'id', 'id_muestra');
    }

    function duracionEstabilidad() {
        return $this->belongsTo("EstDuracionEstabilidad", "id_duracion");
    }

    function temperatura() {
        return $this->belongsTo("EstTemperatura", "id_temperatura");
    }

    public function duracion() {
        return $this->belongsTo('EstDuracionEstabilidad', 'id_duracion');
    }

    public function estado() {
        return $this->belongsTo('Estado', 'id_estado');
    }
    
    function usuarioAprobacion() {
        return $this->belongsTo("Usuario", "id_usuario_conclusion");
    }

}
