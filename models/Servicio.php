<?php

namespace Model;

use Override;

class Servicio extends ActiveRecord
{

    // base de dados
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    #[Override]
    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'O Nome do Servico e Obrigatorio';
        }
        if (!$this->precio) {
            self::$alertas['error'][] = 'O preco do Servico e Obrigatorio';
        }
        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'O preco nao e valido';
        }

        return self::$alertas;
    }
}
