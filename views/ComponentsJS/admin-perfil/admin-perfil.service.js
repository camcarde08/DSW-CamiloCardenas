

angular.module('ModuleAdminPerfil')

        .factory('adminPerfilService', function (perfilService) {
            var interfaz = {
                test: test,
                getPerfiles: getPerfiles,
                getPermisosModulo: getPermisosModulo,
                createPerfilPermiso: createPerfilPermiso,
                removePerfilPermiso: removePerfilPermiso,
            };
            
            function test(){
                console.log('prueba servicio');
            }
            
            function getPerfiles(vm){
                perfilService.getPerfiles().then((response) => {
                    vm.perfiles = response.data.data;
                    console.log('PERFILES', vm.perfiles);
                });
            }

            function getPermisosModulo(vm){
                perfilService.getPermisosModulo().then((response) => {
                    console.log(response);
                    vm.permisosModulo = response.data;
                    console.log(vm.permisosModulo);

                });
            }
            
            function createPerfilPermiso(idPerfil, idPermiso){
                return perfilService.createPerfilPermiso(idPerfil, idPermiso);
            }
            
            function removePerfilPermiso(idPerfil, idPermiso){
                return perfilService.removePerfilPermiso(idPerfil, idPermiso);
            }

            

            return interfaz;
        });


