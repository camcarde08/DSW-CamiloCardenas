'use strict';

angular.module('CompHojaCalculo', ['chart.js'])



    .controller('compHojaCalculoCtrl', function ($scope, $filter, $window, $location, $q, hojaCalculoService, muestraService) {
        var vm = this;

        vm.$onInit = function () {
            vm.estado = '0';
            vm.fecha = $filter('date')(new Date(), 'yyyy-MM-dd');
            var a = $location.absUrl();
            if (a.includes("&idEnsayoMuestra=")) {
                a = a.split('idEnsayoMuestra=');
                vm.numEnsayoMuestra = a[1];
                hojaCalculoService.eventClickConsultarInformacionGeneral(vm);

                vm.consultaHojaCalculoGuardada();
            }

        };

        vm.$postLink = function () {

        };

        vm.data = {
            estandar: {},
            muestra: {},
            calculo: {},
            dato: {},
            alicuota: {},
            modelocalculo: {},
        };

        vm.validar = function(idFuncion){
            return vm.funciones.includes(idFuncion);
        };

        vm.save = function(){
            hojaCalculoService.eventClickSaveEnsayoMuestraHojaCalculo(vm);
        };

        vm.update = function(){
            hojaCalculoService.eventClickUpdateEnsayoMuestraHojaCalculo(vm);
        };

        vm.consultaHojaCalculoGuardada = function() {
            muestraService.getHojaCalculoEnsayoMuestra(vm.numEnsayoMuestra).then(function (response) {
                if (response.data.code == "00000") {
                    if(response.data.data.length > 0){
                        console.log('DATAJSON', response);
                        vm.hojaCalculoEnsayoMuestra = response.data.data[0];
                        vm.estado = parseInt(response.data.data[0].id_estado);
                        vm.idHojaCalculoEnsayoMuestra = parseInt(response.data.data[0].id);
                        vm.funciones = [];
                        if(response.data.data[0].data.estandar){
                            vm.funciones.push(response.data.data[0].data.estandar.id);
                        }
                        if(response.data.data[0].data.muestra){
                            vm.funciones.push(response.data.data[0].data.muestra.id);
                        }
                        if(response.data.data[0].data.calculo){
                            vm.funciones.push(response.data.data[0].data.calculo.id);
                        }
                        if(response.data.data[0].data.dato){
                            vm.funciones.push(response.data.data[0].data.dato.id);
                        }
                        if(response.data.data[0].data.alicuota){
                            vm.funciones.push(response.data.data[0].data.alicuota.id);
                        }
                        if(response.data.data[0].data.modelocalculo){
                            vm.funciones.push(response.data.data[0].data.modelocalculo.id);
                        }
                        console.log('DATAJSON1', response);
                        setTimeout(function(){
                            $scope.$apply(function () {
                                vm.data = angular.copy(response.data.data[0].data);
                            });
                            console.log('DATAJSON2', vm.data);
                        },500);
                    } else {
                        hojaCalculoService.consultaFuncionesHojaCalculo(vm);
                    }
                }
            });
        }

        $scope.$on('addMuestraEmit', function(event, data){
            $scope.$broadcast('addMuestraCalculoEmit', '');
            $scope.$broadcast('addMuestraDatoEmit', '');
            $scope.$broadcast('addMuestraAlicuotaEmit', '');
        });

        $scope.$on('deleteMuestraEmit', function(event, data){
            $scope.$broadcast('deleteMuestraCalculoEmit', data);
            $scope.$broadcast('deleteMuestraDatoEmit', data);
            $scope.$broadcast('deleteMuestraAlicuotaEmit', data);
        });

        $scope.$on('addEstandarEmit', function(event, data){
            $scope.$broadcast('addEstandarAlicuotaEmit', '');
        });

        $scope.$on('deleteEstandarEmit', function(event, data){
            $scope.$broadcast('deleteEstandarAlicuotaEmit', data);
        });



    })



    .component('sgmHojaCalculo', {
        templateUrl: './views/ComponentsJS/hojas-calculo/hoja/hoja-calculo/hoja-calculo.html',
        controller: 'compHojaCalculoCtrl',
        controllerAs: 'vm',
        bindings: {

        }

    });