<?php

class EnsayoMuestraCondicionCromatografica extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_ensayo_muestra_condicion_cromatografica';
    public $timestamps = false;

    public function columna() {
        return $this->belongsTo('Columna', 'id_columna');
    }

    public function condicionCromatografica() {
        return $this->belongsTo('CondicionCromatografica', 'id_condicion_cromatografica');
    }

}
