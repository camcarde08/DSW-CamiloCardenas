<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ensayo
 *
 * @author hidro
 */
class Ensayo extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_ensayo';
    public $timestamps = false;

    public function plantilla() {
        return $this->belongsTo('Plantilla', 'id_plantilla');
    }
    
    public function equipos() {
        return $this->hasMany('EnsayoEquipo', 'id_ensayo');
    }

}
