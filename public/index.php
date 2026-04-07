<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../routes.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de controle - EBD</title>

    <base href="http://<?=$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];?>">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sweetalert2.min.css">

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>
    <script src="js/jquery.maskedinput-1.2.1.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>

    <script>
        //funcao para mostrar senha
        mostrarSenha = function() {
            const campo = document.getElementById('senha');
            if (campo.type === "password") {
                campo.type = "text";
            } else {
                campo.type = "password";
            }
        }

        //funcao para mostrar mensagem de erro
        mensagem = function(msg, url, icone) {
            Swal.fire({
                icon: ícone,
                tittle: msg,
                confirmButtonText: 'OK',
            }).then((result) => {
                location.href = url;
            });
        }

        //mensagem de confirmacao para exclusao
        excluir = function(id, tabela) {
            Swal.fire({
                icon: "question",
                title: "Deseja realmente excluir este registro?",
                showCancelButton: true,
                confirmButtonText: 'Ecluir',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = tabela + "/excluir/" + id;
                }
            });
        }
    </script>
</head>

<body>
    <?php
    if ((!isset($_SESSION["projetoebd"])) && (!$_POST)) {
        //nao tem secao e nao foi dado post
        require "../views/index/login.php";
    } else if ((!isset($_SESSION["projetoebd"])) && ($_POST)) {
        //nao tem secao mas foi dado post
        $email = trim($_POST["email"] ?? NULL);
        $senha = trim($_POST["senha"] ?? NULL);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('E-mail Inválido!', 'index', 'error');</script>";
        } else if (empty($senha)) {
            echo "<script>mensagem('Senha Inválida!', 'index', 'error');</script>";
        } else {
            //se tem senha e email validos
            require "../controllers/indexController.php";
            $acao = new indexController();
            $acao->verificar($email, $senha);
        }
    } else {
        //echo "Passou";
    ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index">
                    <img src="../public/images/logo.png" alt="PneusXpress">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <?php if(!empty($_SESSION['user_name'])): ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index">Início</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="professores">Professores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="turmas">Turmas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="alunos">Alunos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="relatorio">Relatório Geral</a>
                        </li>
                    </ul>
                    <div class="d-flex" role="search">   
                        <span>Olá, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                            <a href="index/sair" title="sair" class="btn btn-danger">
                                <i class="fas fa-power-off"></i> Sair
                            </a>
                        <?php else: ?>
                            <a href="index/login">Entrar</a>
                        <?php endif; ?>       
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <?php
                $param = explode("/", $_GET["param"]);
                $controller = $param[0] ?? "index";
                $acao = $param[1] ?? "index";
                $id = $param[2] ?? NULL;

                $controller = ucfirst($controller) . "Controller";

                if (file_exists("../controllers/{$controller}.php")) {
                    require "../controllers/{$controller}.php";
                    $control = new $controller();
                    $control->$acao($id);
                } else {
                    require "../views/index/erro.php";
                }

                

            ?>
        </main>
    <?php
    }
    ?>
</body>

</html>