<html>
    <head>
        <link rel="stylesheet" href="views/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
        <script type="text/javascript" src="views/scripts/fismicdesModule/hojaRutaPrint.js"></script>
        
        <script type="text/javascript" src="views/jqwidgets/scripts/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="views/jqwidgets/jqwidgets/jqx-all.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                var idMuestra = <?php echo $_GET['idMuestra']; ?>;
                
                initialHojaRutaPrint(idMuestra);

            });
        </script>
    </head>
    <body>
        
        <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
            <h2>Hoja de ruta</h2>
        </div>
        <div style="border-style: solid; border: 0; width: 100%; height: auto">
            <div style="border-style: solid; border: 0; width: 100%; height: auto">
                <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px; font-size: 12px">
                    Informacion general de muestra
                </div>
                <!--            renglon1-->
                <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Numero de muestra:</span>
                    </div>
                    <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="inputNumMuestraHojaRutaPrint" type="text" readonly="true"/>
                    </div>
                </div>

                <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Producto:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="inputProductoHojaRutaPrint" readonly="true"/>
                    </div>
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Tipo de estudio:</span>
                    </div>
                    <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="inputTipoEstudioHojaRutaPrint" readonly="true" />
                    </div>

                </div>

                <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Cliente:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="inputClienteHojaRutaPrint" readonly="true"/>
                    </div>


                </div>

                <div style="height: auto; background-color: white; padding-top: 5px; border-style: solid; border: 0; overflow: auto">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 100%; height: auto; border-style: solid; border: 0;  font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Ensayos</div>
                        </div>

                    </div>
                    <div style="width: 100%; float: left">
                        <div id="ensayosDiv"></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>