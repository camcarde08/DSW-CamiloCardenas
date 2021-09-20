'use strict';
angular.module('moduleConsultaMuestras', [])


        .controller('consultaMuestrasCtrl', function ($filter, muestraService, utileService) {
            var vm = this;

            vm.loading = true;
            vm.totalMuestras = 0;
            vm.maxPage = 1;
            vm.muestras = [];


            vm.filter = {
                cantidad: 10,
                pagina: 1,
                prefijo: '',
                customId: '',
                producto: '',
                tercero: '',
                lote: '',
                estadoMuestra: '',
                fechaLlegada: '',
                fechaCompromiso: '',
                observacion: '',
                contacto: '',
                numFactura: '',
                fechaEntrega: ''
            };

            vm.$onInit = function () {
                vm.loadNotificationAdminPerfil();
                utileService.getSessionUserData().then(response => {
                    vm.sesionUserData = response.data.data;
                    vm.changeFilter();
                });
            };

            vm.$postLink = function () {



            };

            vm.consultarMuestra = function (index) {

                window.location.href = 'index.php?action=regmuestra&idMuestra=' + vm.muestras[index].prefijo + '-' + vm.muestras[index].custom_id;
            }

            vm.changeFilter = function () {
                muestraService.getMuestrasToConsultaMuetras(vm.filter).then((response) => {
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
            }

            vm.setMaxPage = function () {
                vm.maxPage = parseInt(vm.totalMuestras / vm.filter.cantidad);

                if (vm.totalMuestras % vm.filter.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            vm.eventClickAnularMuestra = function (muestra) {
                vm.muestraAnular = muestra;
                angular.element(motivoAnulacionModal).modal("show");
            }

            vm.anularMuestra = function () {
                angular.element(motivoAnulacionModal).modal("hide");
                muestraService.anularMuestra(vm.muestraAnular.id, vm.muestraAnular.motivo,
                        vm.sesionUserData.userId).then(function (response) {
                    if (response.data.code == '00000') {
                        openNotificationAdminPerfil('success', 'Muestra anulada correctamente');
                        vm.changeFilter();
                    } else {
                        openNotificationAdminPerfil('error', 'Error anulando muestra');
                    }
                });
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
            
            vm.openModalAuditoria = function (muestra) {
                vm.muestraAuditoria = muestra;
                console.log('AUDITORIA', vm.muestraAuditoria);
                muestraService.consultaAuditoriaMuestra(vm.muestraAuditoria.id).then(function (response) {
                    if (response.data.code == '00000') {
                        vm.muestrasAuditoria = response.data.data;
                        console.log('HOLA', vm.muestrasAuditoria);
                        angular.element(auditoriaMuestraModal).modal("show");
                    } else {
                        openNotificationAdminPerfil('error', 'Error');
                    }
                });
                
            }
            
            vm.selectedMuestraAud = function (auditoria) {
                console.log(auditoria);
                vm.selectedMuestraDetalle = auditoria;
                muestraService.consultaAuditoriaMuestraDetallada(auditoria.id).then(function (response) {
                    if (response.data.code == '00000') {
                        vm.muestrasAuditoriaDetalle = response.data.data[0];
                        console.log('DETALLE', vm.muestrasAuditoriaDetalle);
                    } else {
                        openNotificationAdminPerfil('error', 'Error');
                    }
                });
            }
            
            vm.regresarModalAuditoria = function () {
                vm.selectedMuestraDetalle = null;
            }
        })

        .component('sgmConsultaMuestras', {
            templateUrl: './views/ComponentsJS/consulta-muestras/consulta-muestras.html',
            controller: 'consultaMuestrasCtrl',
            controllerAs: 'vm'
        });