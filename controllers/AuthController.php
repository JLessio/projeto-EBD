<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';

class AuthController {
    public function showLogin() {
        if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
        require __DIR__ . '/../views/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('/login');
        // CSRF
        if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) {
            die('Token CSRF inválido');
        }

        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        if (!$email || !$senha) {
            $_SESSION['flash'] = 'Preencha email e senha';
            $this->redirect('/login');
        }

        $usuario = Usuario::buscarPorEmail($email);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_role'] = $usuario['role'];

            // redirect por role
            if ($usuario['role'] === 'admin') $this->redirect('/classes');
            if ($usuario['role'] === 'professor') $this->redirect('/presenca');
            $this->redirect('/');
        } else {
            $_SESSION['flash'] = 'Credenciais inválidas';
            $this->redirect('/login');
        }
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        $this->redirect('/login');
    }

    private function redirect($url) {
        header("Location: {$url}");
        exit;
    }
}
