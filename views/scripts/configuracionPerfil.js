angular.module('configuracionPerfil', ['jqwidgets'])
        .controller('configuracionPerfilCtrl', ['$scope', function ($scope) {
                $("#notificationConfiguracionPerfil").jqxNotification({
                    width: 250, position: "top-right", opacity: 1,
                    autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "error"
                });
                $scope.input1 = {
                    class: 'btn btn-danger btn-xs'
                };

                $scope.input2 = {
                };




                $scope.classInput1 = function () {
                    if ($scope.nuevaContrasena != '' && $scope.nuevaContrasena != null) {
                        return 'btn btn-success btn-xs';
                    } else {
                        return 'btn btn-danger btn-xs';
                    }
                };

                $scope.classInput2 = function () {
                    if ($scope.nuevaContrasena != $scope.cNuevaContrasena) {
                        return 'btn btn-danger btn-xs';
                    } else {
                        return 'btn btn-success btn-xs';
                    }
                };

                $scope.iconInput1 = function () {
                    if ($scope.nuevaContrasena != '' && $scope.nuevaContrasena != null) {

                        return 'glyphicon glyphicon-ok';
                    } else {

                        return 'glyphicon glyphicon-remove';
                    }
                };

                $scope.iconInput2 = function () {
                    if ($scope.nuevaContrasena != $scope.cNuevaContrasena) {
                        return 'glyphicon glyphicon-remove';
                    } else {
                        return 'glyphicon glyphicon-ok';
                    }
                };
                $scope.actualizar = function () {
                    if ($scope.nuevaContrasena == '' || $scope.nuevaContrasena == null) {
                        $("#notificationConfiguracionPerfil").jqxNotification({template: "error"});
                        $("#messageNotificationConfiguracionPerfil").html("El campo contraseña no puede estar vacio");
                        $("#notificationConfiguracionPerfil").jqxNotification("open");
                    } else {
                        if($scope.nuevaContrasena != $scope.cNuevaContrasena){
                            $("#notificationConfiguracionPerfil").jqxNotification({template: "error"});
                            $("#messageNotificationConfiguracionPerfil").html("El campo confirmar contraseña no coincide");
                            $("#notificationConfiguracionPerfil").jqxNotification("open");
                        } else {
                            var promiseActualizar = ajaxActualizarPasswaord($scope.nuevaContrasena);
                            promiseActualizar.success(function (data) {
                                var response = JSON.parse(data);
                                if (response != null) {
                                    $scope.nuevaContrasena = '';
                                    $scope.cNuevaContrasena = '';
                                    if(response.result == 0){
                                        var template = 'success';
                                        var message = response.message;
                                    } else {
                                        var template = 'error';
                                        var message = response.message;
                                    }
                                    $("#notificationConfiguracionPerfil").jqxNotification({template: template});
                                    $("#messageNotificationConfiguracionPerfil").html(message);
                                    $("#notificationConfiguracionPerfil").jqxNotification("open");
                                }
                            });

                        }
                        
                    }

                }
                
                function ajaxActualizarPasswaord(newPassword) {
                    var url = "index.php";
                    var data = "action=updatePassword";
                    data = data + "&newPassword=" + newPassword;

                    return $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        async: false
                    });
                }
            }]);


