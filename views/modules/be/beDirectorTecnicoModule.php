<script type="text/javascript">
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadBeDirectorTecnico(idPerfil, idUsuario);

    });
</script>
<style>     


</style>
<div style="margin-top: 20px; margin-bottom: 10px; margin-left: 70px; height: 350px; width: 1170px">    
    Bandeja de Entrada del Director Técnico
    <div id="gridPrincipalBeDirectorTecnico">

    </div>
</div>

