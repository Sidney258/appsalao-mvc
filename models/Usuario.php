<?php

namespace Model;

class Usuario extends ActiveRecord
{

    // base de dados
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // mensagens de validacoes para formularios
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'O nome e obrigatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'O apelido e obrigatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'O email e obrigatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'O password e obrigatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'O password deve conter pelo menos 6 caracteres';
        }

        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'O e-mail e obrigatorio';
        }
        return self::$alertas;
    }

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'O email e obrigatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'O password e obrigatorio';
        }

        return self::$alertas;
    }

    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'O password e obrigatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'O password deve conter pelo menos 6 caracteres';
        }

        return self::$alertas;
    }

    // revisa si el usuario ya existe
    public function existeUsuario()
    {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'O usuario ja esta registado';
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password)
    {
        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password incorrecta ou a tua conta nao foi confirmada';
        } else {
            false;
        }
        return $resultado;
    }
}
