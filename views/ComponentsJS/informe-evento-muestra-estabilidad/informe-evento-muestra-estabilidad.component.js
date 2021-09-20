'use strict';

angular.module('informeEventoMuestraEstabilidadModule', [

])



    .controller('compInformeEventoMuestraEstabilidadCtrl', function ($q, $http) {
        var vm = this;



        vm.$postLink = function () {

        };

        vm.clickInformeMuestra = function(){
            console.log(vm.searchMuestra);
            $http({
                method: 'GET',
                url: 'index.php',
                params: {
                    action: 'queryDb',
                    query: 'getMuestraEstabilidadDetalle',
                    muestra: vm.searchMuestra
                }
            }).then(function(response){
                console.log('response', response);
                vm.muestra = response.data;
            });
        };
    })



    .component('sgmInformeEventoMuestraEstabilidad', {
        templateUrl: './views/ComponentsJS/informe-evento-muestra-estabilidad/informe-evento-muestra-estabilidad.html',
        controller: 'compInformeEventoMuestraEstabilidadCtrl',
        controllerAs: 'vm'
    });