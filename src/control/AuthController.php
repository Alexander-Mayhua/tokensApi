<?php
namespace App\Control;
use function App\Lib\view;
use function App\Lib\redirect;
use App\Config\Security;
use App\Model\Usuario;

require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../config/config.php';

class AuthController {
  public function loginForm(): void {
    view('auth/login', ['title'=>'Iniciar sesión','csrf'=>Security::csrf()]);
  }
  public function loginPost(): void {
    Security::check($_POST['csrf'] ?? '');
    $usuario = trim((string)($_POST['usuario'] ?? ''));
    $clave   = (string)($_POST['clave'] ?? '');
    $u = Usuario::authenticate($usuario, $clave);
    if (!$u) {
      view('auth/login', ['title'=>'Iniciar sesión','csrf'=>Security::csrf(),'error'=>'Usuario o clave inválidos, o usuario inactivo.']);
      return;
    }
    session_regenerate_id(true);
    $_SESSION['auth'] = true;
    $_SESSION['user'] = ['id'=>(int)$u['id_usuario'],'usuario'=>$u['usuario'],'rol'=>$u['rol']];
    redirect('dashboard');
  }
  public function logout(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
      $p = session_get_cookie_params();
      setcookie(session_name(), '', time()-42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    redirect('login');
  }
}
