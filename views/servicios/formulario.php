<div class="campo">
    <label for="nombre">Nome</label>
    <input
        type="text"
        name="nombre"
        id="nombre"
        placeholder="Nome Servico"
        value="<?= $servicio->nombre ?>">
</div>
<div class="campo">
    <label for="precio">Preco</label>
    <input
        type="number"
        name="precio"
        id="precio"
        placeholder="Preco Servico"
        value="<?= $servicio->precio ?>">
</div>