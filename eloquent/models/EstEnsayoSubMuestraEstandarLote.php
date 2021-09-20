<?php 
 
class EstEnsayoSubMuestraEstandarLote extends Illuminate\Database\Eloquent\Model { 
 
    protected $table = 'sgm_est_ensayo_submuestra_estandar_lote'; 
    public $timestamps = false; 
 
    public function estandar() {
        return $this->belongsTo('Estandar', 'id_estandar');
    }
    
    public function lote() {
        return $this->belongsTo('LoteEstandar', 'id_lote');
    }
 
} 
