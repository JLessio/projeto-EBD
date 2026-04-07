<?php
// Se o form foi submetido, realiza a exclusão
if ($_POST) {
    $id = $_POST['id'] ?? null;

    if (empty($id)) {
        echo "<script>mensagem('ID inválido','usuario/listar','error');</script>";
        exit;
    }

    require "../config/Conexao.php";
    $db = new Conexao();
    $pdo = $db->conectar();

    $sql = "DELETE FROM usuarios WHERE id = :id LIMIT 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id, PDO::PARAM_INT);

    if ($consulta->execute()) {
        echo "<script>mensagem('Registro excluído com sucesso','usuario/listar','ok');</script>";
    } else {
        echo "<script>mensagem('Erro ao excluir registro','usuario/listar','error');</script>";
    }
    exit;
}

// Mostrar confirmação: tenta obter dados via model, senão via consulta direta
$dados = null;
if (!empty($id)) {
    if (isset($this->usuario) && method_exists($this->usuario, 'editar')) {
        $dados = $this->usuario->editar($id);
    }

    if (empty($dados)) {
        require "../config/Conexao.php";
        $db = new Conexao();
        $pdo = $db->conectar();
        $stmt = $pdo->prepare("SELECT id, nome, email FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_OBJ);
    }
}
?>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Excluir Usuário</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($dados)): ?>
                <p>Você tem certeza que deseja excluir o usuário abaixo?</p>
                <ul>
                    <li><strong>ID:</strong> <?=htmlspecialchars($dados->id)?></li>
                    <li><strong>Nome:</strong> <?=htmlspecialchars($dados->nome)?></li>
                    <li><strong>E-mail:</strong> <?=htmlspecialchars($dados->email ?? '')?></li>
                    <li><strong>Telefone:</strong> <?=htmlspecialchars($dados->telefone ?? '')?></li>
                </ul>

                <!-- substitui o form simples por confirmação via SweetAlert2 -->
                <form id="form-excluir" method="post" action="" style="display:none;">
                    <input type="hidden" name="id" id="form-id" value="<?=htmlspecialchars($dados->id)?>">
                </form>

                <button type="button" id="btn-confirm" class="btn btn-danger">Confirmar exclusão</button>
                <a href="usuario/listar" class="btn btn-secondary">Cancelar</a>

                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    (function(){
                        const btn = document.getElementById('btn-confirm');
                        if (!btn) return;

                        const user = <?= json_encode([
                            'id' => $dados->id,
                            'nome' => $dados->nome,
                            'email' => $dados->email ?? ''
                        ]) ?>;

                        function escapeHtml(text){
                            if (!text) return '';
                            return String(text).replace(/[&<>"']/g, function(m){
                                return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'}[m];
                            });
                        }

                        btn.addEventListener('click', function(){
                            Swal.fire({
                                title: 'Atenção',
                                html: `<p>Deseja excluir o usuário abaixo?</p>
                                       <ul style="text-align:left">
                                         <li><strong>ID:</strong> ${user.id}</li>
                                         <li><strong>Nome:</strong> ${escapeHtml(user.nome)}</li>
                                         <li><strong>E-mail:</strong> ${escapeHtml(user.email)}</li>
                                       </ul>`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Excluir',
                                cancelButtonText: 'Cancelar',
                                reverseButtons: true
                            }).then(function(result){
                                if (result.isConfirmed) {
                                    document.getElementById('form-excluir').submit();
                                }
                            });
                        });
                    })();
                </script>
            <?php else: ?>
                <p class="text-danger">Registro não encontrado.</p>
                <a href="usuario/listar" class="btn btn-secondary">Voltar</a>
            <?php endif; ?>
        </div>
    </div>
</div>