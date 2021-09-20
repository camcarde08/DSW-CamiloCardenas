'use strict';
angular.module('ModuleAdminPerfil', ['chart.js'])

        .controller('compAdminPerfilCtrl', function (adminPerfilService) {
            var vm = this;
            vm.$onInit = function () {
                adminPerfilService.getPerfiles(vm);
                adminPerfilService.getPermisosModulo(vm);

            };


            vm.$postLink = function () {

            };

            vm.selectPerfil = function (idPerfil) {

                for (var i = 0; i < vm.perfiles.length; i++) {
                    if (vm.perfiles[i].id == idPerfil) {
                        vm.selectedPerfil = vm.perfiles[i];
                        vm.perfiles[i].selected = true;
                            for (let modulo of vm.permisosModulo) {
                                for (let permiso of modulo["permisos"]) {
                                    let aux = vm.selectedPerfil.permisos.find(function (element) {
                                        return element.id == permiso.id
                                    });
                                    if (aux != undefined) {
                                        permiso.check = true;
                                    } else {
                                        permiso.check = false;
                                    }


                                }
                            }
                    } else {
                        vm.perfiles[i].selected = false;
                    }
                }
            }

            vm.setPermiso = function (permiso, perfil) {

                if (permiso.check) {
                    addPermiso(permiso, perfil);
                } else {
                    removePermiso(permiso, perfil);
                }

            }

            vm.mostrarModulo = function(modulo){
                if(vm.permisoFiltro){
                    console.log(modulo);
                    var contador = (modulo.permisos.filter(permiso => permiso.nombre.toLocaleLowerCase().includes(vm.permisoFiltro.nombre.toLocaleLowerCase()))).length
                    return contador > 0 ? true : false;
                } else {
                    return true;
                }

            }

            function addPermiso(permiso, perfil) {
                adminPerfilService.createPerfilPermiso(perfil.id, permiso.id).then((response) => {
                    perfil.permisos.push(permiso);
                });

            }

            function removePermiso(permiso, perfil) {
                adminPerfilService.removePerfilPermiso(perfil.id, permiso.id).then((response) => {
                    let auxPermisos = [];
                    for (let per of perfil.permisos) {
                        if (permiso.id != per.id) {
                            auxPermisos.push(per);
                        }
                    }
                    perfil.permisos = auxPermisos;
                });


            }
        })

        .directive('toggle', function(){
            return {
                restrict: 'A',
                link: function(scope, element, attrs){
                    $(element).popover();
                }
            };
        })



        .component('sgmAdminPerfil', {
            templateUrl: './views/ComponentsJS/admin-perfil/admin-perfil.html',
            controller: 'compAdminPerfilCtrl',
            controllerAs: 'vm'
        });










