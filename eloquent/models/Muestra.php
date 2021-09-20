<?php

class Muestra extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_muestra';
    public $timestamps = false;

    function ensayosMuestra() {
        return $this->hasMany('EnsayoMuestra', 'id_muestra');
    }

    function areaAnalisis() {
        return $this->belongsTo('AreaAnalisis', 'id_area_analisis');
    }

    function mustraDetalleMic() {
        return $this->hasOne('MuestraDetalleMic', 'id_muestra');
    }

    function tercero() {
        return $this->belongsTo('Tercero', 'id_tercero');
    }

    function producto() {
        return $this->belongsTo('Producto', 'id_producto');
    }

    function lote() {
        return $this->hasOne('Lote', 'id_muestra');
    }

    function almacenamientos() {
        return $this->hasMany('Almacenamiento', 'id_muestra');
    }
    
    function estado() {
        return $this->belongsTo('Estado', 'id_estado_muestra');
    }

}
