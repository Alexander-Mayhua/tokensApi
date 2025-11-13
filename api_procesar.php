<?php
// api_procesar.php
// Endpoint simple que delega en el controlador ConsumoApiController::procesar()

// 👇 CORREGIDO: el controlador está dentro de /src/control/
require __DIR__ . '/src/control/ConsumoApiController.php';

use App\Control\ConsumoApiController;

$ctrl = new ConsumoApiController();
$ctrl->procesar(); // Esto ya devuelve JSON y hace exit;
