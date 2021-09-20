<div  style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; text-align: right; margin-right: 10px; margin-top: 55px;">
    <strong>Nombre:<span style='color: white'> <?php echo $_SESSION['user_nombre']; ?></span></strong>
    <br>
    <strong>Perfil:<span style='color: white'><?php echo $_SESSION['user_nom_perfil']; ?></span></strong>
    <br>
    <a href="index.php?action=configuracionPerfil" style="color: white">Cambio de clave</a>
    <br>
    <a href="index.php?action=cerrar" style="color: white">Cerrar Sesión</a>
</div>
