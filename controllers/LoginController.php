<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // verificar se o usuario existe(atraves do email)
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // autenticar o usuario
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header("Location: /admin");
                        } else {
                            header("Location: /cita");
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'usuario nao econtrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router)
    {

        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado == "1") {
                    // gerar um token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar um email com as intrucoes para resetear a password
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'verifica o teu email');
                } else {
                    Usuario::setAlerta('error', 'O usuario nao existe ou nao esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {

        $error = false;
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'token  invalido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if ($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // revisar que alertas este vacio
            if (empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // hashear el password
                    $usuario->hashPassword();

                    // generar un token unico
                    $usuario->crearToken();

                    // enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    // crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }

                    debuguear($usuario);
                }
            }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (!$usuario) {
            $alertas = Usuario::setAlerta('error', 'Token  invalido');
        } else {
            $usuario->confirmado = '1';
            $usuario->token = "";
            $usuario->guardar();

            $alertas = Usuario::setAlerta('exito', 'Conta confirmada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
