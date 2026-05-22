<?php
$user = current_user();
if (!$user) {
    echo '<p>Az üzenetek megtekintéséhez be kell jelentkezni.</p>';
    return;
}

$stmt = $dbh->query('SELECT * FROM messages ORDER BY created_at DESC');
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Beérkezett üzenetek</h1>

<table>
    <thead>
        <tr>
            <th>Dátum</th>
            <th>Név</th>
            <th>E-mail</th>
            <th>Tárgy</th>
            <th>Üzenet</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($messages as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['created_at']) ?></td>
            <td><?= htmlspecialchars($m['name'] ?: 'Vendég') ?></td>
            <td><?= htmlspecialchars($m['email']) ?></td>
            <td><?= htmlspecialchars($m['subject']) ?></td>
            <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
