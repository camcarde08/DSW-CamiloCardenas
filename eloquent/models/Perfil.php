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
class Perfil extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_perfil';
    public $timestamps = false;
    
    public function permisos() {
        return $this->belongsToMany('Permiso', 'sgm_perfil_permiso', 'id_perfil', 'id_permiso');
    }
    
    public function permisosBandejaEntrada() {
        return $this->belongsToMany('PermisoBandejaEntrada', 'sgm_perfil_permiso_bandeja_entrada', 'id_perfil', 'id_permiso_bandeja');
    }

    
}
