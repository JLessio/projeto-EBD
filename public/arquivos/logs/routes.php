<?php
// routes.php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        require_once 'app/Controllers/indexController.php';
        (new indexController())->index();
        break;

    case '/login':
        require_once 'app/Controllers/AuthController.php';
        $auth = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $auth->login();
        else $auth->showLogin();
        break;

    case '/logout':
        require_once 'app/Controllers/AuthController.php';
        (new AuthController())->logout();
        break;

    case '/admin':
        require_once 'app/Controllers/AdminController.php';
        (new AdminController())->index();
        break;

    case '/professor':
        require_once 'app/Controllers/ProfessorController.php';
        (new ProfessorController())->index();
        break;

    default:
        http_response_code(404);
        echo "Página não encontrada";
        break;
}
