<script type="text/javascript">
$(document).ready(function () {
    var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
    var idUsuario = <?php echo $_SESSION['userId']; ?>;
    initLoadBeCoordinador(idPerfil, idUsuario);
    
});
</script>
 <style>     
        .green {
            color: black\9;
            background-color: #b6ff00\9;
        }
        .yellow {
            color: black\9;
            background-color: yellow\9;
        }
        .red {
            color: black\9;
            background-color: #e83636\9;
        }
        .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #b6ff00;
        }
        .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: yellow;
        }
        .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
            color: black;
            background-color: #e83636;
        }
    
</style>
<div style="margin-top: 20px; margin-bottom: 10px; margin-left: 70px; height: 350px; width: 1100px">
    Bandeja de Entrada del Coordinador
    <div id="gridPrincipalBeCoordinador">
        
    </div>
</div>
