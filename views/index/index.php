<?php
// app/Views/index/index.php
?>
<h1>Página inicial</h1>

<h2>Aniversariantes da Semana</h2>
<?php if (!empty($birthdays)): ?>
  <ul>
  <?php foreach ($birthdays as $b): ?>
    <li><?= htmlspecialchars($b['nome']) ?> — <?= date('d/m', strtotime($b['data_nascimento'])) ?></li>
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Sem aniversariantes esta semana.</p>
<?php endif; ?>

<h2>Datas Comemorativas</h2>
<?php if (!empty($events)): ?>
  <ul>
  <?php foreach ($events as $e): ?>
    <li><?= htmlspecialchars($e['titulo']) ?> — <?= date('d/m', strtotime($e['data'])) ?>
      <div><?= nl2br(htmlspecialchars($e['descricao'])) ?></div>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else: ?>
  <p>Sem datas esta semana.</p>
<?php endif; ?>
