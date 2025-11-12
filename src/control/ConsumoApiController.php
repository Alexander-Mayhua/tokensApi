<?php
namespace App\Control;

class ConsumoApiController {
    
    // Muestra el formulario de búsqueda
    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    // Muestra el token del cliente
    public function form() {
        require __DIR__ . '/../view/consumoapi/form.php';
    }

    // Procesa la petición hacia la API principal
    public function procesar() {
        $token = $_POST['token'] ?? '';
        $data = $_POST['data'] ?? '';
        $rutaApi = $_POST['ruta_api'] ?? '';

        if (empty($token) || empty($data) || empty($rutaApi)) {
            echo json_encode(['status' => false, 'mensaje' => 'Faltan datos para procesar la solicitud.']);
            return;
        }

        $postData = http_build_query(['token' => $token, 'data' => $data]);

        $ch = curl_init($rutaApi);
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

        echo $response ?: json_encode(['status' => false, 'mensaje' => 'Respuesta vacía del servidor.']);
    }
}
