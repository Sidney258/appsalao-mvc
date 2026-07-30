<h1 class="nombre-pagina">Criar Reserva</h1>

<p class="descripcion-pagina">Escolhe os teus servicos e coloca os teus dados</p>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<div class="app">
    <nav class="tabs">
        <button type="button" class="actual" data-paso="1">Servicos</button>
        <button type="button" data-paso="2">Informacao Reserva</button>
        <button type="button" data-paso="3">Resumo</button>
    </nav>

    <div id="paso-1" class="seccion">
        <h2>Servicos</h2>
        <p class="text-center">Escolhe os teus servicos</p>
        <div id="servicios" class="listado-servicios">

        </div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Teus Dados e Reserva</h2>
        <p class="text-center">Coloca os teus dados e a Data da Reserva</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nome</label>
                <input
                    id="nombre"
                    type="text"
                    value="<?= $nombre ?>"
                    disabled />
            </div>

            <div class="campo">
                <label for="fecha">Data</label>
                <input
                    id="fecha"
                    type="date"
                    min="<?= date('Y-m-d') ?>" />
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input
                    id="hora"
                    type="time" />
            </div>
            <input type="hidden" id="id" value="<?= $id ?>">

        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumo</h2>
        <p class="text-center">Verifica se a informacao esta correcta</p>
    </div>

    <div class="paginacion">
        <button id="anterior" class="boton">
            &laquo; Anterior
        </button>
        <button id="siguiente" class="boton">
            Seguinte &raquo;
        </button>
    </div>
</div>
<?php

$script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";

?>