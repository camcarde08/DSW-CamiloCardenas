'use strict'; 
 
angular.module('CompAdminUsuario') 
 
        .factory('adminUsuarioService', function (usuariosService) { 
            var interfaz = { 
                consultarUsuario: consultarUsuario, 
                consultarjefe: consultarjefe, 
                consultarCargo: consultarCargo, 
                consultarPerfil: consultarPerfil 
            } 
 
            function consultarUsuario(vm) { 
                usuariosService.getAllUsuarios().then(function (response) { 
                    console.log('usuarios', response); 
                    vm.consultaUsuario = response.data.data; 
                }); 
            }
            
            function consultarjefe(vm) { 
                usuariosService.getAllJefes().then(function (response) { 
                    console.log('jefes', response); 
                    vm.consultaJefes = response.data.data; 
                }); 
            }
            
            function consultarCargo(vm) { 
                usuariosService.getAllCargos().then(function (response) { 
                    console.log('cargos', response); 
                    vm.consultaCargos = response.data.data; 
                }); 
            }
            
            function consultarPerfil(vm) { 
                usuariosService.getAllPerfiles().then(function (response) { 
                    console.log('perfiles', response); 
                    vm.consultaPerfiles = response.data.data; 
                }); 
            }
 
            return interfaz; 
        });

