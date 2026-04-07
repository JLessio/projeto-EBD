<?php 
    if (!empty($id)) {
        $dados = $this->usuario->editar($id);
    }

    $nome = $dados->nome ?? NULL;
    $email = $dados->email ?? NULL;
    $ativo = $dados->ativo ?? NULL;
    $telefone = $dados->telefone ?? NULL;
    $nivel = $dados->nivel ?? NULL;
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="float-start">
                <h2>Cadastro de Supervisores/Professores</h2>
            </div>
            <div class="float-end">
                <a href="usuario" class="btn btn-success">
                    <i class="fas fa-file"></i> Novo
                </a>
                <a href="usuario/listar" class="btn btn-success">
                    <i class="fas fa-search"></i> Listar
                </a>
            </div>
        </div>
        <div class="card-body">
            <form name="formUsuario" method="post" data-parsley-validate="" action="usuario/salvar">
                <div class="row">
                    <div class="col-12 col-md-1">
                        <label for="id">ID:</label>
                        <input type="text" name="id" id="id" class="form-control" readonly value="<?=$id?>">
                    </div>
                    <div class="col-12 col-md-11">
                        <label for="nome">Nome do Usuário</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?=$nome?>" required data-parsley-required-message="Preencha o e-mail" data-parsley-type-message="Digite um e-mail válido">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="email">Digite seu e-mail:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?=$email?>" required >
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="senha">Digite sua senha:</label>
                        <input type="password" name="senha" id="senha" class="form-control">
                    </div>
                    <div class="col-12 col-md-3">
                        <label for="redigite">Redigite sua senha:</label>
                        <input type="password" name="redigite" id="redigite" class="form-control" data-parsley-equalto="#senha" data-parsley-equalto-message="As senhas não são iguais">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 co-md-4">
                        <label for="telefone">Telefone:</label>
                        <input type="text" name="telefone" id="telefone" class="form-control" required data-parsley-required-message="Digite um telefone(só números)" value="<?=$telefone?>">
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="nivel">Nível:</label>
                        <select name="nivel" id="nivel" class="form-control" required data-parsley-required-message="Selecione a situação"> 
                            <option value=""></option>
                            <option value="super">Supervisor</option>
                            <option value="professor">Professor</option>
                        </select>
                        <script>
                            $("#nivel").val("<?=$nivel?>");
                        </script>
                    </div>
                    <div class="col-12 col-md-2">
                        <label for="ativo">Ativo:</label>
                        <select name="ativo" id="ativo" class="form-control" required data-parsley-required-message="Selecione a situação"> 
                            <option value=""></option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                        <script>
                            $("#ativo").val("<?=$ativo?>");
                        </script>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-success float-end">
                    <i class="fas fa-check"></i>Salvar/Atualizar dados                
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#telefone").inputmask("(99) 99999-9999");
    });
</script>