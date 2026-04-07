<?php
// app/controllers/AniversariosController.php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/DataComemorativa.php';

class AniversariosController {
    public function index() {
        $start = date('m-d');
        $end = date('m-d', strtotime('+7 days'));
        $aniversarios = Usuario::listarAniversariantesEntre($start, $end);
        $datas = DataComemorativa::listarEntre($start, $end);
        require __DIR__ . '/../views/aniversarios/index.php';
    }
}
?>