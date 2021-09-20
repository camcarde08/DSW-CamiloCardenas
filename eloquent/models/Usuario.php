<?php

class Usuario extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_usuario';
    public $timestamps = false;
    protected $hidden = ['clave', 'firma'];

    function perfil() {
        return $this->belongsTo("Perfil", "id_perfil");
    }

}
