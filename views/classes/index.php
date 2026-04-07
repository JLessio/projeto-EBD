<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
?>

<h1>Classes</h1>
<form method="post" action="/classes">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <input type="hidden" name="action" value="store">
    <label>Nome: <input name="nome" required></label>
    <label>Faixa etária: <input name="faixa"></label>
    <button type="submit">Criar</button>
</form>

<ul>
<?php foreach($classes as $c): ?>
    <li><?= htmlspecialchars($c['nome']) ?> (<?= htmlspecialchars($c['faixa_etaria']) ?>)
        <form method="post" action="/classes" style="display:inline">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button type="submit" onclick="return confirm('Excluir?')">Excluir</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>

