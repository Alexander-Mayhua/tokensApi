<?php
$url = "https://instituto.estudiojuridico.com.pe/?c=consumoapi&a=verDocenteApiByNombreODni";
$token = "f9595f6e9dba9ec3d7ea7a0bad02ce5d-251111-2";

$postData = http_build_query([
    'tipo'  => 'verdocenteapibynombreodni',
    'token' => $token,
    'data'  => 'Juan'
]);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ Error: " . $error;
} else {
    echo "✅ Respuesta: " . $response;
}
