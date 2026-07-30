<div class="barra">
    <p>Cliente: <?= $nombre ?? '' ?></p>
    <a href="/logout" class="boton">Sair</a>
</div>

<?php if (isset($_SESSION['admin'])) { ?>

    <div class="barra-servicios">
        <a class="boton" href="/admin">Reservas</a>
        <a class="boton" href="/servicios">Ver Servicos</a>
        <a class="boton" href="/servicios/crear">Novo Servico</a>
    </div>

<?php } ?>