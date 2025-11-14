<?php
namespace App\Config;
use PDO;

class DB {
  private static ?PDO $pdo = null;
  public static function pdo(): PDO {
    if (self::$pdo === null) {
      $host='127.0.0.1'; $db='clienteapi'; $user='root'; $pass=''; $charset='utf8';
      $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
      self::$pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
    return self::$pdo;
  }
}


class Security {
  public static function csrf(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
  }
  public static function check(string $t): void {
    if (!isset($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $t)) {
      http_response_code(419); exit('La sesión caducó. Refresca e inténtalo de nuevo.');
    }
  }
}
