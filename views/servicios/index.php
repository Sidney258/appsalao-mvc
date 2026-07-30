<h1 class="nombre-pagina">Servicos</h1>
<p class="descripcion-pagina">Administracao de Servicos</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<ul class="servicios">
    <?php foreach ($servicios as $servicio) { ?>
        <li>
            <p>Nome: <span><?= $servicio->nombre ?></span></p>
            <p>Preco: <span>$<?= $servicio->precio ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?= $servicio->id ?>">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?= $servicio->id ?>">
                    <input class="boton-eliminar" type="submit" value="Eliminar">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>