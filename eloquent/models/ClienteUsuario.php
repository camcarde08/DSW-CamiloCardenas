<?php

class ClienteUsuario extends Illuminate\Database\Eloquent\Model {

    protected $table = 'sgm_cliente_usuario';
    public $timestamps = false;
    protected $hidden = ['contrasena'];

    function usuarioPermisos() {
        return $this->hasMany("ClienteUsuarioPermiso", "id_usuario");
    }

}
