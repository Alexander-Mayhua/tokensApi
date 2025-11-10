<?php
namespace App\Control;

class ConsumoApiController {
    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    public function verDocenteApiByNombreODni() {
        header('Content-Type: application/json; charset=utf-8');

        $tipo  = strtolower($_POST['tipo'] ?? '');
        $term  = trim($_POST['data'] ?? '');
        $token = trim($_POST['token'] ?? '');

        if ($tipo !== 'verdocenteapibynombreodni') {
            echo json_encode(['status' => false, 'msg' => 'Parámetro tipo inválido']);
            return;
        }

        // ✅ Aquí defines la URL del servidor del INSTITUTO (tu API real)
        $apiUrl = 'https://instituto.estudiojuridico.com.pe/';

        // Prepara los datos POST que se enviarán al servidor del Instituto
        $postData = [
            'tipo'  => $tipo,
            'data'  => $term,
            'token' => $token
        ];

        // Realiza la conexión usando cURL
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // <- temporal si hay error SSL

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            echo json_encode(['status' => false, 'msg' => "No se pudo conectar con la API ($error)"]);
            return;
        }

        // Devuelve al navegador la respuesta del servidor institucional
        echo $response;
    }
}
