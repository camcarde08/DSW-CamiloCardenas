'use strict'

angular.module('moduleCompSgmJqxTypeahead', [
    'jqwidgets'
])

        .controller('compSgmJqxTypeaheadCtrl', function ($scope) {

            var vm = this;
            vm.jqxInputInstance = {};
            
            vm.inputClienteSettings = vm.sgmJqxSettings;
            
            $scope.$watch(angular.bind(this, function () {
                    return this.currentValue;
                }), function (newVal) {
                    
                    if(newVal !== null && typeof newVal === 'object'){
                        
                        vm.sgmJqxComplexValue = vm.inputClienteSettings.source.find(function(item){
                            return item.id == newVal.value;
                        });
                    }
                });
        })

        .component('sgmJqxTypeahead', {
            templateUrl: './views/ComponentsJS/sgm-jqx-typeahead/sgm-typeahead.html',
            controller: 'compSgmJqxTypeaheadCtrl',
            bindings: {
                sgmJqxSettings: '=',
                sgmJqxComplexValue: '=',
                sgmJqxCreate: '='
            }
        });


