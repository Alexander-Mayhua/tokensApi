<?php
namespace App\Control;

class ConsumoApiController {

    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    public function form() {
        require __DIR__ . '/../view/consumoapi/form.php';
    }

    public function procesar() {
        header('Content-Type: application/json; charset=utf-8');

        $token   = $_POST['token']    ?? '';
        $data    = $_POST['data']     ?? '';
        $rutaApi = $_POST['ruta_api'] ?? '';

        if (empty($token) || empty($data) || empty($rutaApi)) {
            echo json_encode([
                'status'  => false,
                'mensaje' => 'Faltan datos para procesar la solicitud.'
            ]);
            exit;
        }

        if (!filter_var($rutaApi, FILTER_VALIDATE_URL)) {
            echo json_encode([
                'status'  => false,
                'mensaje' => 'URL de API no válida.'
            ]);
            exit;
        }

        $postData = http_build_query([
            'tipo'  => 'verdocenteapibynombreodni',
            'token' => $token,
            'data'  => $data,
        ]);

        $ch = curl_init($rutaApi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]);

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        $info     = curl_getinfo($ch);
        curl_close($ch);

        if ($error) {
            echo json_encode([
                'status'  => false,
                'mensaje' => 'Error al conectar con el servidor del Instituto.',
                'detalle' => $error,
                'ruta'    => $rutaApi
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $jsonData = json_decode($response, true);
        if ($jsonData === null) {
            echo json_encode([
                'status'        => false,
                'mensaje'       => 'Respuesta no válida del Instituto (no es JSON).',
                'respuesta_raw' => $response,
                'http_code'     => $info['http_code'] ?? null,
                'content_type'  => $info['content_type'] ?? null,
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
