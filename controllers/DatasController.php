<?php
// app/controllers/DatasController.php
require_once __DIR__ . '/../models/DataComemorativa.php';

class DatasController {
    private function checkAdmin() {
        if (empty($_SESSION['usuario_role']) || $_SESSION['usuario_role'] !== 'admin') {
            header('Location: /login'); exit;
        }
    }

    public function index() {
        $this->checkAdmin();
        $datas = DataComemorativa::listarTodas();
        require __DIR__ . '/../views/datas_comemorativas/index.php';
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /datas'); exit; }
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) die('CSRF mismatch');

        DataComemorativa::criar([
            'titulo' => trim($_POST['titulo']),
            'descricao' => trim($_POST['descricao']),
            'data_evento' => $_POST['data_evento'],
            'fixo' => $_POST['fixo'] ?? 'nao'
        ]);
        header('Location: /datas'); exit;
    }

    public function update() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /datas'); exit; }
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) die('CSRF mismatch');

        $id = (int)$_POST['id'];
        DataComemorativa::atualizar($id, [
            'titulo' => trim($_POST['titulo']),
            'descricao' => trim($_POST['descricao']),
            'data_evento' => $_POST['data_evento'],
            'fixo' => $_POST['fixo'] ?? 'nao'
        ]);
        header('Location: /datas'); exit;
    }

    public function delete() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /datas'); exit; }
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) die('CSRF mismatch');
        $id = (int)$_POST['id'];
        DataComemorativa::excluir($id);
        header('Location: /datas'); exit;
    }
}
