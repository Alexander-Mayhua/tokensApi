<?php
class ConsumoApiController
{
    public function index()
    {
        // Carga la vista principal del formulario
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    public function procesar()
    {
        header('Content-Type: application/json; charset=utf-8');

        $tipo = $_POST['tipo'] ?? '';
        $token = $_POST['token'] ?? '';
        $data = $_POST['data'] ?? '';
        $ruta_api = $_POST['ruta_api'] ?? '';

        if (empty($ruta_api)) {
            echo json_encode(['status' => false, 'mensaje' => 'No se especificó la ruta del API']);
            return;
        }

        $postData = [
            'tipo' => $tipo,
            'token' => $token,
            'data' => $data
        ];

        $ch = curl_init($ruta_api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo json_encode(['status' => false, 'mensaje' => 'Error al conectar con el servidor: ' . $error]);
            return;
        }

        $jsonData = json_decode($response, true);
        if ($jsonData === null) {
            echo json_encode([
                'status' => false,
                'mensaje' => 'La respuesta del servidor no es un JSON válido',
                'respuesta_raw' => $response
            ]);
            return;
        }

        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
