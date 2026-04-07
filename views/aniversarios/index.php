<h2>Aniversariantes da Semana</h2>
<?php if (empty($aniversarios)): ?>
    <p>Nenhum aniversariante nesta semana.</p>
<?php else: ?>
    <ul>
        <?php foreach($aniversarios as $a): ?>
            <li><?= htmlspecialchars($a['nome']) ?> — <?= date('d/m', strtotime($a['data_nascimento'])) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<h2>Datas Comemorativas</h2>
<?php if (empty($datas)): ?>
    <p>Sem datas esta semana.</p>
<?php else: ?>
    <ul>
    <?php foreach($datas as $d): ?>
        <li><strong><?= htmlspecialchars($d['titulo']) ?></strong> — <?= date('d/m', strtotime($d['data_evento'])) ?>
            <div><?= nl2br(htmlspecialchars($d['descricao'])) ?></div>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>