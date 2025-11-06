<?php
namespace App\Control;
use function App\Lib\view;
use function App\Lib\redirect;
use App\Config\Security;
use App\Model\Token;

require_once __DIR__ . '/../model/Token.php';
require_once __DIR__ . '/../library/helpers.php';
require_once __DIR__ . '/../config/config.php';

class TokenController {
  public function index(): void {
    $tokens = Token::all();
    view('tokens/index', ['title'=>'Tokens API', 'tokens'=>$tokens]);
  }
  public function view(): void {
    $value = (string)($_GET['value'] ?? '');
    $token = Token::find($value);
    if (!$token) { http_response_code(404); exit('Token no encontrado'); }
    view('tokens/view', ['title'=>'Ver token', 'token'=>$token]);
  }
  public function edit(): void {
    $value = (string)($_GET['value'] ?? '');
    $token = Token::find($value);
    if (!$token) { http_response_code(404); exit('Token no encontrado'); }
    view('tokens/edit', ['title'=>'Editar token', 'token'=>$token, 'csrf'=>Security::csrf()]);
  }
  public function update(): void {
    Security::check($_POST['csrf'] ?? '');
    $old = (string)($_POST['old'] ?? '');
    $new = trim((string)($_POST['new'] ?? ''));
    if ($new !== '') { Token::update($old, $new); }
    redirect('tokens');
  }
}
