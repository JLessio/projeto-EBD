<link rel="stylesheet" href="../../public/css/style.css">
<div class="login">
    <div class="card">
        <div class="card-header">
            <img src="images/logo.png" alt="PneuXpress">
        </div>
        <div class="card-body">
            <form name="form1" method="post" data-parsley-validate="">
                <label for="email">E-mail:</label>
                <input type="emai" name="email" id="email" class="form-control" required data-parsley-required-message="Preencha o e-mail" data-parsley-type-message="Preencha um e-mail válido" placeholder="Digite um e-mail">
                <br>
                <label for="senha">Senha:</label>
                <div class="input-group mb-3">
                    <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha:" data-parsley-required-message="Digite uma senha" required data-parsley-errors-container="#erro">
                    <button type="button" class="btn btn-outline-secondary" onclick="mostrarSenha()"><i class="fas fa-eye"></i></button>
                </div>
                <div id="erro"></div>
                <br>
                <button type="submit" class="btn bnt-success w-100">
                    <i class="fas fa-check"></i> Fazer login
                </button>
            </form>
        </div>
    </div>
</div>