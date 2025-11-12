<?php
namespace App\Control;

class ConsumoApiController {

    // ✅ Muestra el formulario principal
    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    // ✅ Muestra el token registrado (opcional)
    public function form() {
        require __DIR__ . '/../view/consumoapi/form.php';
    }

    // ✅ Envía los datos al sistema del Instituto
    public function procesar() {
        header('Content-Type: application/json; charset=utf-8');

        $token = $_POST['token'] ?? '';
        $data = $_POST['data'] ?? '';
        $rutaApi = $_POST['ruta_api'] ?? '';

        if (empty($token) || empty($data) || empty($rutaApi)) {
            echo json_encode(['status' => false, 'mensaje' => 'Faltan datos para procesar la solicitud.']);
            return;
        }

        // 🚀 Preparar datos POST exactos que la API del Instituto espera
        $postData = http_build_query([
            'tipo'  => 'verdocenteapibynombreodni',
            'token' => $token,
            'data'  => $data
        ]);

        $ch = curl_init($rutaApi);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        // Seguir redirecciones por si el hosting redirige HTTP/HTTPS
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if ($error) {
            echo json_encode([
                'status' => false,
                'mensaje' => 'Error al conectar con el servidor del Instituto.',
                'detalle' => $error,
                'ruta' => $rutaApi
            ]);
            return;
        }

        // Validar si la respuesta es JSON
        $jsonData = json_decode($response, true);
        if ($jsonData === null) {
            echo json_encode([
                'status' => false,
                'mensaje' => 'Respuesta no válida del Instituto.',
                'respuesta_raw' => $response,
                'info' => $info
            ]);
            return;
        }

        // Devolver la respuesta del servidor Instituto tal cual
        echo json_encode($jsonData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}