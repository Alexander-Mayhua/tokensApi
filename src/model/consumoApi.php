<?php
// src/model/ConsumoApi.php
use App\Config\DB;

class ConsumoApi
{
    // Buscar docentes por nombre o DNI
    public static function buscarDocentes(string $term, int $limit = 50, int $offset = 0): array
    {
        $pdo = DB::pdo();

        // Si es un DNI exacto (solo números y 8 dígitos)
        if (preg_match('/^\d{8}$/', $term)) {
            $stmt = $pdo->prepare("SELECT * FROM docente WHERE dni = :dni LIMIT 1");
            $stmt->execute([':dni' => $term]);
            return $stmt->fetchAll();
        }

        // Buscar por nombres o apellidos
        $stmt = $pdo->prepare("
            SELECT * FROM docente
            WHERE nombres LIKE :term
               OR apellidos LIKE :term
            LIMIT :offset, :limit
        ");
        $stmt->bindValue(':term', "%$term%", PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Buscar cliente por ID (para validar token)
    public static function buscarClienteById(int $id): ?array
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("SELECT * FROM clienteapi WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $res = $stmt->fetch();
        return $res ?: null;
    }
}
