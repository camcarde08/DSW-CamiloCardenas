'use strict';

angular.module('CompInformeResumenMuestras', [

])



    .controller('compInformeResumenMuestrasCtrl', function ($q, informeResumenMuestrasService, muestraService) {
        var vm = this;

        vm.loading = true;
        vm.totalMuestras = 0;
        vm.maxPage = 1;
        vm.muestras = [];


        vm.filter = {
            cantidad: 5,
            pagina: 1,
            muestra: '',
            producto: '',
            analista: '',
            ensayos: '',
            estadoMuestra: '',
            cliente: ''
        };

        vm.$onInit = function () {
            vm.changeFilter();
        };

        vm.$postLink = function () {

        };

        vm.consultarMuestra = function (index) {

            window.location.href = 'index.php?action=regmuestra&idMuestra=' + vm.muestras[index].muestra;
        }

        vm.changeFilter = function () {
            // angular.element('#modalespera').modal("show");
            muestraService.getResumenMuestras(vm.filter).then((response) => {
                console.log(response);
                vm.muestras = response.data.data.muestras;
                vm.totalMuestras = response.data.data.cantidad_total;
                vm.loading = false;
                vm.setMaxPage();
            });
        }

        vm.changeFilterHeader = function () {
            vm.firstPage();
        }


        vm.firstPage = function () {
            vm.filter.pagina = 1;
            vm.changeFilter();
        }

        vm.resPage = function () {
            if (vm.filter.pagina > 1) {
                vm.filter.pagina--;
            }
            vm.changeFilter();
        }

        vm.addPage = function () {
            if (vm.filter.pagina < vm.maxPage) {
                vm.filter.pagina++;
            }
            vm.changeFilter();
        }

        vm.lastPage = function () {
            vm.filter.pagina = vm.maxPage;
            vm.changeFilter();
        }

        vm.setMaxPage = function () {
            vm.maxPage = parseInt(vm.totalMuestras / vm.filter.cantidad);

            if (vm.totalMuestras % vm.filter.cantidad > 0) {
                vm.maxPage++;
            }
            // angular.element('#modalespera').modal("hide");
        }

        vm.loadNotificationAdminPerfil = function () {
            $("#notificationAdminPerfil").jqxNotification({
                width: 250, position: "top-right", opacity: 0.9,
                autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
            });
        }

        function openNotificationAdminPerfil(template, message) {
            $("#messageNotificationAdminPerfil").text(message);
            $("#notificationAdminPerfil").jqxNotification({template: template});
            $("#notificationAdminPerfil").jqxNotification("open");
        }

        vm.eventClickExcelResumenMuestra = function () {
            informeResumenMuestrasService.eventClickExcelResumenMuestra(vm);
        };

    })



    .component('sgmInformeResumenMuestras', {
        templateUrl: './views/ComponentsJS/informe-resumen-muestras/informe-resumen-muestras.html',
        controller: 'compInformeResumenMuestrasCtrl',
        controllerAs: 'vm'
    });