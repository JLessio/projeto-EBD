<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
?>

<h2>Cadastrar nova data</h2>
<form method="post" action="/datas">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="action" value="store">
    <label>Título: <input name="titulo" required></label><br>
    <label>Data: <input type="date" name="data_evento" required></label><br>
    <label>Fixo: <select name="fixo"><option value="nao">Não</option><option value="sim">Sim</option></select></label><br>
    <label>Descrição:<br><textarea name="descricao"></textarea></label><br>
    <button type="submit">Salvar</button>
</form>

<h2>Lista</h2>
<ul>
    <?php foreach($datas as $d): ?>
        <li>
            <strong><?= htmlspecialchars($d['titulo']) ?></strong> — <?= date('d/m', strtotime($d['data_evento'])) ?>
            <form method="post" action="/datas" style="display:inline">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                <button type="submit" onclick="return confirm('Excluir?')">Excluir</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>