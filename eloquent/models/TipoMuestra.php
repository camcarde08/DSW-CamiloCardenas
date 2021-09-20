<?php

class TipoMuestra extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_tipo_muestra';
    public $timestamps = false;

    public function equipos() {
        return $this->belongsToMany('Equipo', 'sgm_tipo_muestra_equipo', 'id_tipo_muestra', 'id_equipo');
    }

}
