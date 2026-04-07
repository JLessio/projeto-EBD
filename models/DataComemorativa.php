<?php
// app/models/DataComemorativa.php
require_once __DIR__ . '/../../config/database.php';

class DataComemorativa {
    private static function db() { return Database::conectar(); }

    public static function listarEntre(string $startMd, string $endMd) {
        $db = self::db();
        $sql = "SELECT id, titulo, descricao, data_evento, fixo
                FROM datas_comemorativas
                WHERE DATE_FORMAT(data_evento, '%m-%d') BETWEEN :start AND :end
                OR (fixo = 'sim' AND DATE_FORMAT(data_evento, '%m-%d') BETWEEN :start AND :end)
                ORDER BY DATE_FORMAT(data_evento, '%m-%d')";
        $stmt = $db->prepare($sql);
        $stmt->execute([':start' => $startMd, ':end' => $endMd]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function listarTodas() {
        $db = self::db();
        $stmt = $db->query("SELECT * FROM datas_comemorativas ORDER BY DATE_FORMAT(data_evento, '%m-%d')");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function criar($data) {
        $db = self::db();
        $sql = "INSERT INTO datas_comemorativas (titulo, descricao, data_evento, fixo) VALUES (:titulo, :descricao, :data_evento, :fixo)";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'] ?? null,
            ':data_evento' => $data['data_evento'],
            ':fixo' => $data['fixo'] ?? 'nao'
        ]);
    }

    public static function atualizar($id, $data) {
        $db = self::db();
        $sql = "UPDATE datas_comemorativas SET titulo = :titulo, descricao = :descricao, data_evento = :data_evento, fixo = :fixo WHERE id = :id limit 1";
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            ':titulo' => $data['titulo'],
            ':descricao' => $data['descricao'] ?? null,
            ':data_evento' => $data['data_evento'],
            ':fixo' => $data['fixo'] ?? 'nao',
            ':id' => $id
        ]);
    }

    public static function excluir($id) {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM datas_comemorativas WHERE id = :id limit 1");
        return $stmt->execute([':id' => $id]);
    }

    public static function buscarPorId($id) {
        $db = self::db();
        $stmt = $db->prepare("SELECT * FROM datas_comemorativas WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
