<script type="text/javascript">
    $(document).ready(function () {
        initialLoadResultadosEstadistica();

    });
</script>

<style type="text/css">
    .prueba {
        font-size: 20;
    }
</style>

<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Cuadro de Resultados</h1>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto; overflow: hidden" >
    <div style="border-style: solid; border: 0; width: 100%">
        <div id="gridResultados"></div>
        <br>
        <input type="button" value="Excel" id="loadButtonExportData"    />
        <br>
        <br>
        <input type="button" value="Generar Grafica" id="crearGrafica"    />
        <div id='chartContainer' style="width:850px; height:500px;">
	</div>
    </div>

</div>

