<h1 class="nombre-pagina">Novo Servicio</h1>
<p class="descripcion-pagina">Preenche todos campos para adicionar um novo servico</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . '/formulario.php' ?>
    <input type="submit" value="Guardar Servico" class="boton">
</form>