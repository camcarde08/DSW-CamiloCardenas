<?php



class Tercero extends Illuminate\Database\Eloquent\Model {
    
    protected $table = 'sgm_terceros';
    public $timestamps = false;
    
    function contactos(){
        return $this->hasMany('Contacto', 'id_tercero');
    }
    
    function usuariosCliente(){
        return $this->hasMany('ClienteUsuario', 'cliente');
    }
}
