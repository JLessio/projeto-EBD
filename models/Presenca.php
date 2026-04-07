<?php
require_once __DIR__ . "/../../config/Conexao.php";

class Presenca {

    public static function listarAlunosDaClasse($classe_id) {
        $db = Conexao::conectar();

        $sql = "SELECT u.id, u.nome
                FROM usuarios u
                INNER JOIN aluno_classe ac ON ac.aluno_id = u.id
                WHERE ac.classe_id = ?
                ORDER BY u.nome ASC";

        $stm = $db->prepare($sql);
        $stm->execute([$classe_id]);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function registrarPresenca($aluno_id, $classe_id, $status) {
        $db = Conexao::conectar();

        // impedir duplicação no mesmo dia
        $sqlVerifica = "SELECT id FROM presenca 
                        WHERE aluno_id = ? 
                        AND classe_id = ?
                        AND data = CURDATE()";

        $stm = $db->prepare($sqlVerifica);
        $stm->execute([$aluno_id, $classe_id]);

        if ($stm->rowCount() > 0) {
            // atualizar registro ao invés de duplicar
            $sqlUpdate = "UPDATE presenca 
                          SET status = ? 
                          WHERE aluno_id = ? 
                          AND classe_id = ? 
                          AND data = CURDATE()";

            $stm = $db->prepare($sqlUpdate);
            return $stm->execute([$status, $aluno_id, $classe_id]);
        }

        // inserir novo registro
        $sql = "INSERT INTO presenca (aluno_id, classe_id, data, status)
