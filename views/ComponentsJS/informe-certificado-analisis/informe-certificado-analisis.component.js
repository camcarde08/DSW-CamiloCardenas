'use strict';

angular.module('CompInformeCertificadoAnalisis', [

])



        .controller('compInformeCertificadoAnalisisCtrl', function ($q, informeCertificadoAnalisisService) {
            var vm = this;

            vm.$onInit = function () {
                informeCertificadoAnalisisService.cargarPrefijoDefecto(vm);
            };

            vm.$postLink = function () {
                vm.eventClickInformeCertificado = function () {
                    informeCertificadoAnalisisService.eventClickInformeCertificado(vm);
                };
            };
        })



        .component('sgmInformeCertificadoAnalisis', {
            templateUrl: './views/ComponentsJS/informe-certificado-analisis/informe-certificado-analisis.html',
            controller: 'compInformeCertificadoAnalisisCtrl',
            controllerAs: 'vm'
        });





