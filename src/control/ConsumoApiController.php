<?php
namespace App\Control;

class ConsumoApiController {

    // Muestra el buscador de docentes
    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    // Muestra el token del cliente
    public function form() {
        require __DIR__ . '/../view/consumoapi/form.php';
    }

    // Procesa la solicitud del formulario local y reenvía al servidor del Instituto
    public function procesar() {
        header('Content-Type: application/json; charset=utf-8');

        $token   = $_POST['token']   ?? '';
        $data    = $_POST['data']    ?? '';
        $rutaApi = $_POST['ruta_api'] ?? '';

        if (empty($token) || empty($data) || empty($rutaApi)) {
            echo json_encode(['status' => false, 'mensaje' => 'Faltan datos para procesar la solicitud.']);
            return;
        }

        // Agregamos el parámetro "tipo" porque el servidor del Instituto lo requiere
        $postData = http_build_query([
            'token' => $token,
            'data'  => $data,
            'tipo'  => 'verdocenteapibynombreodni'
        ]);

        $ch = curl_init($rutaApi);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 15
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            echo json_encode(['status' => false, 'mensaje' => 'Error al conectar con el servidor: ' . $error]);
            return;
        }

        // Si el servidor no responde nada
        if (!$response) {
            echo json_encode(['status' => false, 'mensaje' => 'Respuesta vacía del servidor.']);
            return;
        }

        echo $response;
    }
}
