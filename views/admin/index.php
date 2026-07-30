<h1 class="nombre-pagina">Painel de Administracao</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<h2>Buscar Reservas</h2>
<div class="formulario">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Data</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                value="<?= $fecha ?>" />
        </div>
    </form>
</div>

<?php
if (count($citas) === 0) {
    echo "<h3>Nao ha reserva com esta data</h3>";
}
?>

<div class="" id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita) {
            if ($idCita !== $cita->id) {
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?= $cita->id ?></span></p>
                    <p>Hora: <span><?= $cita->hora ?></span></p>
                    <p>Cliente: <span><?= $cita->cliente ?></span></p>
                    <p>E-mail: <span><?= $cita->email ?></span></p>
                    <p>Telefone: <span><?= $cita->telefono ?></span></p>
                    <h3>Servicos</h3>
                    <?php $idCita = $cita->id;
                    ?>
                <?php }
            $total += $cita->precio;
                ?>
                <p class="servicio"><?= $cita->servicio . " " . $cita->precio ?></p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total: <span>$<?= $total ?></span></p>

                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?= $cita->id ?>">
                        <input class="boton-eliminar" type="submit" value="Eliminar">
                    </form>

                <?php } ?>
            <?php } ?>
    </ul>
</div>

<?php
$script = "<script src='build/js/buscador.js'></script>"
?>