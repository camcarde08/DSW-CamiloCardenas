'use strict'; 
 
angular.module('CompAdminMetodo') 
 
        .factory('adminMetodoService', function (metodoService) { 
            var interfaz = {  
                consultarMetodos: consultarMetodos
            } 
 
             function consultarMetodos(vm) { 
                metodoService.getAllMetodo().then(function (response) { 
                    console.log('Metodos', response); 
                    vm.consultaMetodo = response.data;
                }); 
            }
 
 
 
            return interfaz; 
        });