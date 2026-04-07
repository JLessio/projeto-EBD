<?php
// app/models/Usuario.php
require_once __DIR__ . '/../../config/Conexao.php';

class Usuario {
    private static function db() {
        return Conexao::conectar();
    }

    public static function buscarPorEmail(string $email) {
        $db = self::db();
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function buscarPorId(int $id) {
        $db = self::db();
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function listarAniversariantesEntre(string $startMd, string $endMd) {
        // startMd, endMd -> mm-dd
        $db = self::db();
        $sql = "SELECT id, nome, data_nascimento FROM usuarios
                WHERE DATE_FORMAT(data_nascimento, '%m-%d') BETWEEN :start AND :end
                ORDER BY DATE_FORMAT(data_nascimento, '%m-%d')";
        $stmt = $db->prepare($sql);
        $stmt->execute([':start' => $startMd, ':end' => $endMd]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criar(array $data) {
        $db = self::db();
        $sql = "INSERT INTO usuarios (nome, email, senha, data_nascimento, telefone, role)
                VALUES (:nome, :email, :senha, :data_nascimento, :telefone, :role)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':nome' => $data['nome'],
            ':email' => $data['email'],
            ':senha' => password_hash($data['senha'], PASSWORD_DEFAULT),
            ':data_nascimento' => $data['data_nascimento'] ?? null,
            ':telefone' => $data['telefone'] ?? null,
            ':role' => $data['role'] ?? 'aluno'
        ]);
    }
}
