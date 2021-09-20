<?php 
 
class EstMuestra extends Illuminate\Database\Eloquent\Model { 
 
    protected $table = 'sgm_est_muestra'; 
    public $timestamps = false; 
 
    public function producto() { 
        return $this->belongsTo('Producto', 'id_producto'); 
    } 
     
    public function tipoMuestra() { 
        return $this->belongsTo('TipoMuestra', 'id_tipo_muestra'); 
    } 
    
    public function tipoEstabilidad() { 
        return $this->belongsTo('EstTipoEstabilidad', 'id_tipo_estabilidad'); 
    }
    
    public function tercero() { 
        return $this->belongsTo('Tercero', 'id_tercero'); 
    }
    
    public function envase() { 
        return $this->belongsTo('Envase', 'id_envase'); 
    }
    
    public function empaque() { 
        return $this->belongsTo('Empaque', 'id_empaque'); 
    }
    
    public function subMuestras(){
        return $this->hasMany('EstSubMuestra', 'id_muestra');
    }
    
 
} 
