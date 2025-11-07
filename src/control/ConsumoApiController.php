<?php
// src/control/consumoApiController.php
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../model/ClientApi.php';
require_once __DIR__ . '/../model/ConsumoApi.php';

class ConsumoApiController
{
    public function index()
    {
        // Carga la vista principal de consumo API
         require __DIR__ . '/../view/consumoapi/index.php';
    }

    // Ruta: ?c=consumoapi&a=verDocenteApiByNombreODni
    // Espera: POST { tipo:'verdocenteapibynombreodni', token, data }
    public function verDocenteApiByNombreODni()
    {
        require_once __DIR__ . '/../model/ConsumoApi.php';
        header('Content-Type: application/json; charset=utf-8');

        $tipo  = strtolower($_POST['tipo'] ?? '');
        $term  = trim((string)($_POST['data'] ?? ''));
        $token = trim((string)($_POST['token'] ?? ''));

        if ($tipo !== 'verdocenteapibynombreodni') {
            echo json_encode(['status' => false, 'msg' => 'Parámetro tipo inválido']);
            return;
        }

        // Token opcional: si viene, validar cliente
        if ($token !== '') {
            $parts = array_filter(array_map('trim', explode('-', $token)), 'strlen');
            $last  = end($parts);
            $id_cliente = (ctype_digit($last) ? (int)$last : null);

            if (!$id_cliente) {
                echo json_encode(['status' => false, 'msg' => 'Token inválido o incompleto']);
                return;
            }

            $owner  = ConsumoApi::buscarClienteById($id_cliente);
            $estado = is_array($owner) ? ($owner['estado'] ?? null) : null;
            if (!$owner || $estado !== 'Activo') {
                echo json_encode(['status' => false, 'msg' => 'Error, cliente no activo o no encontrado']);
                return;
            }
        }

        if ($term === '') {
            echo json_encode(['status' => true, 'msg' => '', 'contenido' => []]);
            return;
        }

        try {
            $docentes = ConsumoApi::buscarDocentes($term, 50, 0);
            echo json_encode(['status' => true, 'msg' => '', 'contenido' => $docentes]);
        } catch (\Throwable $e) {
            echo json_encode(['status' => false, 'msg' => 'Error interno']);
        }
    }
}
