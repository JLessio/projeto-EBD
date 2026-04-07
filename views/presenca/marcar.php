<?php include __DIR__ . "/../layout.php"; ?>

<h2>Marcar Presença</h2>

<form action="<?= BASE_URL ?>presenca/salvar" method="POST">

    <input type="hidden" name="classe_id" value="<?= $classe_id ?>">

    <table border="1" cellpadding="10" width="100%">
        <tr>
            <th>Aluno</th>
            <th>Presença</th>
            <th>Falta</th>
            <th>Visitante</th>
        </tr>

        <?php foreach($alunos as $a): ?>
        <tr>
            <td><?= $a['nome'] ?></td>

            <td align="center">
                <input type="radio" name="alunos[<?= $a['id'] ?>]" value="presente" required>
            </td>

            <td align="center">
                <input type="radio" name="alunos[<?= $a['id'] ?>]" value="falta">
            </td>

            <td align="center">
                <input type="radio" name="alunos[<?= $a['id'] ?>]" value="visitante">
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <br>
    <button type="submit">Salvar Presenças</button>
</form>
