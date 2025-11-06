<?php
namespace App\Control;
use function App\Lib\view;
use App\Model\Token;

require_once __DIR__ . '/../model/Token.php';
require_once __DIR__ . '/../library/helpers.php';

class DashboardController {
  public function index(): void {
    $totalTokens = Token::count();
    view('dashboard/index', ['title'=>'Dashboard', 'totalTokens'=>$totalTokens]);
  }
}
