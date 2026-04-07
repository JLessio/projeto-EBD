<?php
require_once __DIR__ . '/../models/Presenca.php';
require_once __DIR__ . '/../models/Classe.php';

class PresencaController {

    public function marcar($classe_id) {

        $alunos = Presenca::listarAlunosDaClasse($classe_id);

        require __DIR__ . '/../views/presenca/marcar.php';
    }

    public function salvar() {

        if (!isset($_POST['alunos']) || empty($_POST['alunos'])) {
            header("Location: " . BASE_URL . "presenca/erro");
            exit;
        }

        $classe_id = $_POST['classe_id'];
        $alunos = $_POST['alunos']; // array: [id => status]

        foreach ($alunos as $aluno_id => $status) {
            Presenca::registrarPresenca($aluno_id, $classe_id, $status);
        }

        header("Location: " . BASE_URL . "presenca/sucesso");
    }
}
