<?php
$shows = $dbh->query('SELECT * FROM shows ORDER BY start_time')->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Műsorok (CRUD)</h1>

<p><a href="index.php?page=crud_form">Új műsor hozzáadása</a></p>

<table>
    <thead>
        <tr>
            <th>Cím</th>
            <th>Műsorvezető</th>
            <th>Kezdés</th>
            <th>Befejezés</th>
            <th>Műveletek</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($shows as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['title']) ?></td>
            <td><?= htmlspecialchars($s['host']) ?></td>
            <td><?= htmlspecialchars($s['start_time']) ?></td>
            <td><?= htmlspecialchars($s['end_time']) ?></td>
            <td>
                <a href="index.php?page=crud_form&id=<?= $s['id'] ?>">Szerkesztés</a> |
                <a href="index.php?page=crud_form&delete=<?= $s['id'] ?>"
                   onclick="return confirm('Biztos törlöd?');">Törlés</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
