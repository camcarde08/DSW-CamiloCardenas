<?php

class EstEnsayoSubMuestraReactivoLote extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_est_ensayo_submuestra_reactivo_lote';
    public $timestamps = false;

    public function reactivo() {
        return $this->belongsTo('Reactivo', 'id_reactivo');
    }

    public function lote() {
        return $this->belongsTo('LoteReactivo', 'id_lote');
    }

}
