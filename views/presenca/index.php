<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
?>
<h1>Marcar Presença</h1>
<p><a href="/">Voltar</a></p>

<form method="post" action="/presenca">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="action" value="store">
    <label>Classe:
        <select name="classe_id">
            <?php foreach($classes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Data: <input type="date" name="data" value="<?= date('Y-m-d') ?>"></label><br>

    <h3>Marcar por aluno (exemplo)</h3>
    <!-- aqui ideal buscar alunos por classe; por ora exemplo manual -->
    <label>Aluno ID: <input name="pres[1]" value="presente"></label><br>
    <label>Aluno ID: <input name="pres[2]" value="ausente"></label><br>

    <button type="submit">Salvar presença</button>
</form>
