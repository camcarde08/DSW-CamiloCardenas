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
class EnsayoEquipo extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_ensayo_equipo';
    public $timestamps = false;

    public function equipo() {
        return $this->belongsTo('Equipo', 'id_equipo');
    }
}
