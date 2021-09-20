<?php

class EstEnsayoSubMuestraCondicionCromatografica extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_est_ensayo_submuestra_condicion_cromatografica';
    public $timestamps = false;

    public function condicionCromatografica() {
        return $this->belongsTo('CondicionCromatografica', 'id_condicion_cromatografica');
    }

    public function columna() {
        return $this->belongsTo('Columna', 'id_columna');
    }

}
