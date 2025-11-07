<?php
declare(strict_types=1);
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_samesite', 'Lax');
session_start();

require __DIR__ . '/src/config/config.php';
require __DIR__ . '/src/library/helpers.php';

use function App\Lib\redirect;

$route  = $_GET['r'] ?? 'login';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$public = ['login'];

$loggedIn = isset($_SESSION['auth']) && $_SESSION['auth'] === true;
if (!$loggedIn && !in_array($route, $public, true)) {
  redirect('login'); exit;
}

switch ($route) {
  case 'login':
    require __DIR__ . '/src/control/AuthController.php';
    $c = new \App\Control\AuthController();
    if ($method === 'POST') { $c->loginPost(); } else { $c->loginForm(); }
    break;
  case 'logout':
    require __DIR__ . '/src/control/AuthController.php';
    (new \App\Control\AuthController())->logout();
    break;
  case 'dashboard':
    require __DIR__ . '/src/control/DashboardController.php';
    (new \App\Control\DashboardController())->index();
    break;
  case 'tokens':
    require __DIR__ . '/src/control/TokenController.php';
    (new \App\Control\TokenController())->index();
    break;
  case 'tokens/view':
    require __DIR__ . '/src/control/TokenController.php';
    (new \App\Control\TokenController())->view();
    break;
  case 'tokens/edit':
    require __DIR__ . '/src/control/TokenController.php';
    (new \App\Control\TokenController())->edit();
    break;
  case 'tokens/update':
    require __DIR__ . '/src/control/TokenController.php';
    (new \App\Control\TokenController())->update();
    break;
  case 'usuario':
    require __DIR__ . '/src/control/UserController.php';
    (new \App\Control\UserController())->show();
    break;
    case 'consumoapi':
    require __DIR__ . '/src/control/ConsumoApiController.php';
    (new \App\Control\ConsumoApiController())->index();
    break;
  default:
    redirect('dashboard');
}
