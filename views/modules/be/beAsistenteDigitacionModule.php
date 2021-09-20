<script type="text/javascript">
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadBeAsistente(idPerfil, idUsuario);

    });
</script>
<style>     


</style>


<div style="margin-top: 20px; margin-bottom: 10px; margin-left: 70px; height: 350px; width: 1170px">    
    Bandeja de Entrada de Asistente
    <form action="pdf/informes/informeAnalisis.php" method="POST" target="view" id="formEnvio">
        <input name="idMuestra" id="idMuestraHiden" type="hidden"/>
        <input name="idPerfil" id="idPerfilHiden" type="hidden"/>
    </form>
    <div id="gridPrincipalBeAsistente">

    </div>
</div>



