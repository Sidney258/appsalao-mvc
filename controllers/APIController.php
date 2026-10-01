<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController
{

    public static function index()
    {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }

    // public static function guardar()
    // {
    //     $cita = new Cita($_POST);
    //     $resultado = $cita->guardar();

    //     $id = $resultado['id'];
    //     // * guardas as citas e o servicios selecionados na base de datos
    //     $idServicios = explode(",", $_POST['servicios']);

    //     foreach ($idServicios as $idServicio) {
    //         $args = [
    //             'citaId' => $id,
    //             'servicioId' => $idServicio
    //         ];
    //         $citaServicio = new CitaServicio($args);
    //         $citaServicio->guardar();
    //     }

    //     echo json_encode(['resultado' => $resultado]);
    // }
    public static function guardar()
    {
        try {
            $cita = new Cita($_POST);
            $resultado = $cita->guardar();

            $id = $resultado['id'];
            $idServicios = explode(",", $_POST['servicios']);

            foreach ($idServicios as $idServicio) {
                $citaServicio = new CitaServicio([
                    'citaId' => $id,
                    'servicioId' => $idServicio
                ]);
                $citaServicio->guardar();
            }

            echo json_encode(['resultado' => $resultado]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['erro' => $e->getMessage()]);
        }
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
