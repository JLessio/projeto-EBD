<?php
// app/models/Classe.php
require_once __DIR__ . '/../../config/Conexao.php';

class Classe {
    private static function db() { return Conexao::conectar(); }

    public static function listar() {
        $stmt = self::db()->query("SELECT * FROM classes ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criar($nome, $faixa) {
        $sql = "INSERT INTO classes (nome, faixa_etaria) VALUES (:nome, :faixa)";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute([':nome' => $nome, ':faixa' => $faixa]);
    }

    public static function excluir($id) {
        $stmt = self::db()->prepare("DELETE FROM classes WHERE id = :id limit 1");
        return $stmt->execute([':id' => $id]);
    }
}
