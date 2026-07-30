<h1 class="nombre-pagina">Esqueci a password</h1>

<p class="descripcion-pagina">Reestabelece a tua password escrevendo o teu e-mail</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email">
    </div>

    <input type="submit" class="boton" value="Enviar instrucoes">
</form>

<div class="acciones">
    <a href="/">Ja tens uma conta? Inicia Sessao</a>
    <a href="/crear-cuenta">Ainda nao tens uma conta? Criar uma</a>
</div>