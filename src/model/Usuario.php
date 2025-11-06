<?php
namespace App\Model;
use App\Config\DB;

class Usuario {
  public static function authenticate(string $usuario, string $clave): ?array {
    $st = DB::pdo()->prepare("SELECT id_usuario, usuario, clave, rol, estado, fecha_registro FROM usuarios WHERE usuario=? AND estado='Activo'");
    $st->execute([$usuario]);
    $row = $st->fetch();
    if (!$row) return null;
    $hash = $row['clave'] ?? '';
    $ok = false;
    if (preg_match('/^\$2[aby]\$/', $hash)) { $ok = password_verify($clave, $hash); }
    else { $ok = (md5($clave) === $hash); }
    return $ok ? $row : null;
  }

  public static function findById(int $id): ?array {
    $st = DB::pdo()->prepare("SELECT id_usuario, usuario, rol, estado, fecha_registro FROM usuarios WHERE id_usuario=?");
    $st->execute([$id]);
    $r = $st->fetch();
    return $r ?: null;
  }
}
