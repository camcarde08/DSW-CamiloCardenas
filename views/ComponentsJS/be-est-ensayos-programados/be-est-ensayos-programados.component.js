angular.module('CompBandejaEntrada')

        .controller('sgmBeEstEnsyosProgramadosCtrl', function ($filter, factoryBandejaEntradaService, $timeout, factoryBandejaEntradaService) {
            var vm = this;

            vm.$onInit = function () {



                factoryBandejaEntradaService.getEstEnsayosProgramados().then((response) => {
                    console.log('Estabilidad Ensayos programados', response.data);
                    vm.estSubMuestrasEnsayosPogramados = response.data;
                })

//                while (vm.usuario == undefined) {
//                    console.log('usuario', vm.usuario);
//                }



                $timeout(function () {
                    if (vm.usuario.permisos[163]) {
                        vm.verTodos = undefined;
                    } else {
                        vm.verTodos = vm.usuario.userId;
                    }
                }, 1);
            };


            vm.$postLink = function () {

            };


            vm.eventClickResultadosSubMuestraEstabilidad = function (submuestra) {

                var uid = vm.usuario.session.uidSession;
                window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/159/' + submuestra.muestra.show_id_muestra);
                //console.log(vm.usuario);
            }

            vm.showSubMuestra = function (subMuestra) {

                var response = false;

                if (vm.usuario.permisos[163]) {
                    response = true;
                } else {
                    const ensayos = subMuestra.ensayos_sub_muestra;


                    for (var i = 0; i < ensayos.length; i++) {
                        if (ensayos[i].id_analista == vm.usuario.userId) {
                            response = true;
                            break;
                        }
                    }
                }

                return response;
            }

            vmfilterVerTodos = function () {

                let filter = null;

                if (vm.usuario.permisos[163]) {
                    filter = null;
                } else {
                    filter = vm.usuario.userId
                }
                return filter;
            }

            vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso) {
                return factoryBandejaEntradaService.evaluarAlertaFechaCompromiso(vm.usuario.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
            };


        })
        .component('sgmBeEstEnsayosProgramados', {
            templateUrl: './views/ComponentsJS/be-est-ensayos-programados/be-est-ensayos-programados.html',
            controller: 'sgmBeEstEnsyosProgramadosCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });





