<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h2>Listagem de Supervisores/Professores</h2>
            </div>
            <div class="float-end">
                <a href="usuario/index" class="btn btn-success">
                    <i class="fas fa-file"></i> Adicionar novo Supervisor/Professor
                </a>
                <a href="usuario/listar" class="btn btn-success">
                    <i class="fas fa-search"></i> Listar
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Nome</td>
                        <td>Email</td>
                        <td>Telefone</td>
                        <td>Nível</td>
                        <td>Ativo</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $dadosUsuario = $this->usuario->listar();
                        foreach ($dadosUsuario as $dados) {

                            if ($dados->ativo == 'S') {
                                $ativo = "Sim";
                            } else {
                                $ativo = "Não";
                            }

                        ?>
                        <tr>
                            <td><?=$dados->id?></td>
                            <td><?=$dados->nome?></td>
                            <td><?=$dados->email?></td>
                            <td><?=$dados->telefone?></td>
                            <td><?=$dados->nivel?></td>
                            <td><?=$ativo?></td>
                            <td>
                                <a href="usuario/index/<?=$dados->id?>" class="btn btn-success">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:excluir(<?=$dados->id?>,'usuario')" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>