<?php
// app/controllers/ClassesController.php
require_once __DIR__ . '/../models/Classe.php';

class ClassesController {
    private function checkAdmin() {
        if (empty($_SESSION['usuario_role']) || $_SESSION['usuario_role'] !== 'admin') {
            header('Location: /login'); exit;
        }
    }

    public function index() {
        $this->checkAdmin();
        $classes = Classe::listar();
        require __DIR__ . '/../views/classes/index.php';
    }

    public function store() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('Location: /classes');
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) die('CSRF mismatch');
        Classe::criar(trim($_POST['nome']), trim($_POST['faixa']));
        header('Location: /classes'); exit;
    }

    public function delete() {
        $this->checkAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') header('Location: /classes');
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) die('CSRF mismatch');
        Classe::excluir((int)$_POST['id']);
        header('Location: /classes'); exit;
    }
}
