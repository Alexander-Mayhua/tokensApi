<?php
namespace App\Model;
use App\Config\DB;

class Token {
  public static function count(): int {
    $row = DB::pdo()->query("SELECT COUNT(*) c FROM tokens_api")->fetch();
    return (int)($row['c'] ?? 0);
  }
  public static function all(): array {
    return DB::pdo()->query("SELECT tokens FROM tokens_api ORDER BY tokens")->fetchAll();
  }
  public static function find(string $value): ?array {
    $st = DB::pdo()->prepare("SELECT tokens FROM tokens_api WHERE tokens=?");
    $st->execute([$value]);
    $r = $st->fetch();
    return $r ?: null;
  }
  public static function update(string $old, string $new): bool {
    $st = DB::pdo()->prepare("UPDATE tokens_api SET tokens=? WHERE tokens=?");
    return $st->execute([$new, $old]);
  }
}
