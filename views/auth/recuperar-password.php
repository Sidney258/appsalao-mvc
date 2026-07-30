<h1 class="nombre pagina">Recuperar Password</h1>

<p class="descripcion-pagina">Coloca a tua nova password</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if ($error) return; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            placeholder="Nova Password"
            name="password" />
    </div>
    <input class="boton" type="submit" value="Guardar Nova Password">
</form>

<div class="acciones">
    <a href="/">Ja tens uma conta? Inicia Sessao</a>
    <a href="/crear-cuenta">Ainda nao tens uma conta? Criar uma</a>
</div>