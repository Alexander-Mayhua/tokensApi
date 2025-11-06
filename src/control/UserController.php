<?php
namespace App\Control;
use function App\Lib\view;
use App\Model\Usuario;

require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../library/helpers.php';

class UserController {
  public function show(): void {
    $id = (int)($_SESSION['user']['id'] ?? 0);
    if ($id <= 0) { http_response_code(401); exit('No autenticado'); }
    $usr = Usuario::findById($id);
    if (!$usr) { http_response_code(404); exit('Usuario no encontrado'); }
    view('usuario/show', ['title'=>'Usuario', 'usr'=>$usr]);
  }
}
