var repoDocs = angular.module("repoDocs", ["jqwidgets"]);

repoDocs.controller("repoDocsController", function ($scope, $http) {



    $scope.loader = {
        show: false
    };


    $scope.archivo = {
        model: null
    };

    $scope.searchmodal = "";
    
    





    $scope.fileUpload = {
        settings: {
            width: "275px",
            multipleFilesUpload: false,
            localization: {
                browseButton: "Explorar",
                uploadButton: "Adjuntar",
                cancelButton: "Cancelar",
                uploadFileTooltip: "Adjuntar",
                cancelFileTooltip: "Cancelar"
            },
            uploadUrl: "index.php",
            fileInputName: 'fileToUpload'

        },
        events: {
            uploadStart: function (event) {
                $scope.repositorio.show = false;
                $scope.loader.show = true;
                //alert("se subira a: "+$scope.fileUpload.settings.uploadUrl)
            },
            uploadEnd: function (event) {

                $scope.functions.link($scope.repositorio.dataCurrentPath);

            }
        }
    }




    $scope.windowConfRepoRepoDocs = {
        settings: {
            maxHeight: 1000,
            maxWidth: 1000,
            minHeight: 30,
            minWidth: 250,
            height: 400,
            width: 410,
            resizable: false,
            isModal: true,
            autoOpen: false,
            title: "configuracion nuevo repositorio",
            okButton: $("#buttonOKConfRepoRepoDocs"),
            cancelButton: $("#buttonCancelarConfRepoRepoDocs"),
            initContent: function () {
                var source =
                        {
                            datatype: "json",
                            datafields: [
                                {name: 'id'},
                                {name: 'parent'},
                                {name: 'nombre'},
                                {name: 'path'},
                                {name: 'icon'}
                            ],
                            id: 'id',
                            url: 'index.php?action=getRootsRepoDocs',
                            async: false
                        };
                var dataAdapter = new $.jqx.dataAdapter(source);
                dataAdapter.dataBind();
                var records = dataAdapter.getRecordsHierarchy('id', 'parent', 'items', [{name: 'nombre', map: 'label'}, {name: 'path', map: 'value'}, {name: 'icon', map: 'icon'}]);
                $scope.treeConfRepoRepoDocs = {
                    settings: {
                        source: records,
                        width: '300px',
                        height: '300px'
                    }
                };
            }
        },
        events: {
            close: function (event) {
                if (event.args.dialogResult.OK === true) {
                    $scope.repositorio.show = false;
                    $scope.loader.show = true;
                    var selectedFolder = $scope.treeConfRepoRepoDocs.settings.apply('getSelectedItem');

                    var data = {
                        action: "chargeNewRootPathRepoDocs",
                        rootPath: selectedFolder.value
                    };

                    $http({
                        method: 'GET',
                        url: 'index.php',
                        params: data
                    }).then(function successCallback(response) {
                        $scope.functions.cargaInicialRepositorio();
                    }, function errorCallback(response) {
                        // called asynchronously if an error occurs
                        // or server returns response with an error status.
                    });
                }
            }
        }
    };



    //$scope.prueba = "texto de rpueba";

    $scope.repositorio = {
        show: true,
        ubicacion: {
            label: "ubicacion incial",
            path: "pathubicacion inicial"
        }
    }



    $scope.repositorio.isShow = function (id) {
        if (id != -1) {
            return true;
        } else {
            return false;
        }
    }

    $scope.repositorio.configurarRepositorio = function (event) {
        $scope.windowConfRepoRepoDocs.settings.apply("open");
    };

    $scope.crearCarpeta = {
        nombreNuevaCarpeta: "",
        crear: function (event) {
            $scope.repositorio.show = false;
            $scope.loader.show = true;
            data = {
                action: "crearCarpetaRepoDocs",
                nombre: $scope.crearCarpeta.nombreNuevaCarpeta,
                selectedId: $scope.repositorio.dataCurrentPath.id
            };
            $scope.functions.callPost("index.php", data).then(
                    function successCallback(response) {
                        $scope.functions.link($scope.repositorio.dataCurrentPath);
                        $scope.crearCarpeta.nombreNuevaCarpeta = "";


                    }, function errorCallback(response) {

            });


        }
    };


    $scope.functions = {
        callPost: function (url, data) {
            return $http({
                method: "POST",
                url: url,
                data: $.param(data),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
        },
        link: function (data) {
            if (data.esCarpeta === true) {
                $scope.repositorio.show = false;
                $scope.loader.show = true;
                var id = data.id;
                var data = {
                    query: "fullScanRepoById",
                    idPath: id
                };
                $http({
                    method: 'GET',
                    url: 'model/DB/jqw/repositorioData.php',
                    params: data
                }).then(function successCallback(response) {
                    $scope.repositorio.dataCurrentPath = response.data.current[0];
                    $scope.repositorio.dataCurrentParent = response.data.parent[0];
                    $scope.repositorio.dataCurrentChilds = response.data.childs;
                    $scope.fileUpload.settings.uploadUrl = "index.php?action=uploadFileRepoDocs&idParentFolder=" + $scope.repositorio.dataCurrentPath.id;
                    $scope.loader.show = false;
                    $scope.repositorio.show = true;
                }, function errorCallback(response) {
                    // called asynchronously if an error occurs
                    // or server returns response with an error status.
                });
            } else {
                window.open(data.link, '_blank');
            }
        },
        cargaInicialRepositorio: function () {
            var data = {
                query: "fullScanRepoById",
                idPath: 1
            };

            $http({
                method: 'GET',
                url: 'model/DB/jqw/repositorioData.php',
                params: data
            }).then(function successCallback(response) {
                $scope.repositorio.dataCurrentPath = response.data.current[0];
                $scope.repositorio.dataCurrentParent = response.data.parent[0];
                $scope.repositorio.dataCurrentChilds = response.data.childs;
                $scope.nombreMostrar = $scope.repositorio.dataCurrentPath.link;
                $scope.fileUpload.settings.uploadUrl = "index.php?action=uploadFileRepoDocs&idParentFolder=" + $scope.repositorio.dataCurrentPath.id;
                $scope.loader.show = false;
                $scope.repositorio.show = true;

                


            }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        },
        eliminarPath: function (path) {

            $scope.repositorio.show = false;
            $scope.loader.show = true;

            var data = {
                action: "eliminarFileRepoDocsById",
                idFile: path.id
            };

            $http({
                method: 'GET',
                url: 'index.php',
                params: data
            }).then(function successCallback(response) {
                $scope.functions.link($scope.repositorio.dataCurrentPath);
            }, function errorCallback(response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
            });
        },
        clickSearchIcon: function () {
            $scope.searchModal = "block";
            var url = "model/DB/jqw/repositorioData.php?query=searchLikeName&name=%";
            // prepare the data
            var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id', type: 'int'},
                            {name: 'esCarpeta', type: 'int'},
                            {name: 'nombre', type: 'string'},
                            {name: 'extension', type: 'string'},
                            {name: 'nombreCompleto', type: 'string'},
                            {name: 'path', type: 'string'},
                            {name: 'icon', type: 'string'},
                            {name: 'link', type: 'string'}
                        ],
                        id: 'id',
                        url: url,
                        root: 'data',
                        async: false
                    };
            var imagerenderer = function (row, datafield, value) {
                return '<img style="margin-left: 5px; margin-top: 5px;" height="16" width="16" src="' + value + '"/>';
            }
            var linkRender = function (row, datafield, value) {
                if (value != '') {
                    return '<a href="' + value + '" target="_blank"><img style="margin-left: 5px; margin-top: 5px;" height="16" width="16" src="views/images/downloadimage.png"/></a>';
                } else {

                }

            }
            var dataAdapter = new $.jqx.dataAdapter(source, {
                loadComplete: function (data) {
                    $("#divGridSearchResultRepoDocs").show("slow");
                }
            });
            $("#gridSearchResultRepoDocs").jqxGrid(
                    {
                        width: 510,
                        height: 330,
                        source: dataAdapter,
                        filterable: true,
                        showfilterrow: true,
                        columns: [
                            {text: 'id', dataField: 'id', width: 200, hidden: true},
                            {text: '', dataField: 'icon', width: 25, cellsrenderer: imagerenderer},
                            {text: 'Nombre', dataField: 'nombreCompleto', width: 400, cellsalign: 'right'},
                            {text: 'Ext', dataField: 'extension', width: 40, cellsalign: 'center'},
                            {text: '.', dataField: 'link', width: 25, cellsrenderer: linkRender},
                        ]
                    });
        },
        closeModal: function () {
            $scope.searchModal = "";
        }
    }

    $scope.functions.cargaInicialRepositorio();



    $scope.prueba = function () {
        alert("test");
    };
    
    $scope.$watch("repositorio.dataCurrentPath", function(newValue,oldValue){
        $scope.nombreMostrar = $scope.repositorio.dataCurrentPath.link.replace("./docs\\repositorio", "");
        $scope.nombreMostrar = $scope.nombreMostrar.replace("/", "");
        $scope.nombreMostrar = "Ruta actual: " + $scope.nombreMostrar;
    });






});
