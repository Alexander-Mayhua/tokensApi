<?php
namespace App\Control;

class ConsumoApiController {

    // ✅ Muestra el formulario principal
    public function index() {
        require __DIR__ . '/../view/consumoapi/index.php';
    }

    // ✅ Muestra el token registrado (solo informativo)
    public function form() {
        require __DIR__ . '/../view/consumoapi/form.php';
    }

    // ✅ Envía los datos al sistema Instituto con depuración avanzada
    public function procesar() {
        header('Content-Type: application/json; charset=utf-8');

        $token = $_POST['token'] ?? '';
        $data = $_POST['data'] ?? '';
        $rutaApi = $_POST['ruta_api'] ?? '';

        if (empty($token) || empty($data) || empty($rutaApi)) {
            echo json_encode(['status' => false, 'mensaje' => 'Faltan datos para procesar la solicitud.']);
            return;
        }

        // 🚀 Preparar datos POST
        $postData = http_build_query([
            'tipo'  => 'verdocenteapibynombreodni', // 👈 valor exacto que la API del Instituto espera
            'token' => $token,
            'data'  => $data
        ]);

        $ch = curl_init($rutaApi);

        // Configuración cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Devuelve la respuesta
        curl_setopt($ch, CURLOPT_POST, true);           // Método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);// Datos POST
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// Ignorar verificación SSL
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);          // Timeout 20s

        // 🔹 Depuración y seguimiento
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Seguir redirecciones
        curl_setopt($ch, CURLOPT_VERBOSE, true);        // Depuración cURL

        // Ejecutar cURL
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);      // Información de la conexión
        $error = curl_error($ch);
        curl_close($ch);

        // Si hay error, mostrar detalles
        if ($error) {
            echo json_encode([
                'status' => false,
                'mensaje' => 'Error cURL: ' . $error,
                'info' => $info,
                'postData' => $postData,
                'rutaApi' => $rutaApi
            ]);
            return;
        }

        // Respuesta normal
        echo $response ?: json_encode(['status' => false, 'mensaje' => 'Respuesta vacía del servidor del Instituto.']);
    }
}

