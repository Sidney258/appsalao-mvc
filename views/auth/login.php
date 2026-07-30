<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sessao com os teus dados</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Email"
            name="email" />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            placeholder="password"
            name="password" />
    </div>
    <input class="boton" type="submit" value="Iniciar Sessao">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Ainda nao tens uma conta? Criar uma</a>
    <a href="/olvide">Esqueceste a tua password?</a>
</div>