<h1 class="nombre-pagina">Actualizar Servicos</h1>
<p class="descripcion-pagina">Modifica os valores do formulario</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" method="post">
    <?php include_once __DIR__ . '/formulario.php'; ?>
    <input type="submit" class="boton" value="Actualizar">
</form>