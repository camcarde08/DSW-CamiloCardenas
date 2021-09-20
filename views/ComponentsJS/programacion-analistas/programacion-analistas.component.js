'use strict'

angular.module('ProgramacionAnalistasModule', [])

        .controller('ProgramacionAnalistasCtrl', function () {
            var vm = this;

            vm.$onInit = function () {

               
            };






        })
        .component('sgmProgramacionAnalistasComponent', {
            templateUrl: './views/ComponentsJS/programacion-analistas/programacion-analistas.html',
            controller: 'ProgramacionAnalistasCtrl',
            controllerAs: 'vm'
        });





