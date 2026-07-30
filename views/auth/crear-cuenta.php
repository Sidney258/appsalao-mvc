<h1 class="nombre-pagina">Criar Conta</h1>
<p class="descripcion-pagina">Preenche o seguinte formulario para criar uma conta</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nome</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nome" value="<?= s($usuario->nombre) ?>" />
    </div>
    <div class="campo">
        <label for="apellido">Apelido</label>
        <input type="text" name="apellido" id="apellido" placeholder="Apelido" value="<?= s($usuario->apellido) ?>" />
    </div>
    <div class="campo">
        <label for="telefono">Telefone</label>
        <input type="tel" name="telefono" id="telefono" placeholder="Telefone" value="<?= s($usuario->telefono) ?>" />
    </div>
    <div class="campo">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Email" value="<?= s($usuario->email) ?>" />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="password" />
    </div>

    <input class="boton" type="submit" value="Criar Conta">
</form>

<div class="acciones">
    <a href="/">Ja tens uma conta? Inicia Sessao</a>
    <a href="/olvide">Esqueceste a tua password?</a>
</div>