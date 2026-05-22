<?php
$id = $_GET['id'] ?? null;

if (isset($_GET['delete'])) {
    $stmt = $dbh->prepare('DELETE FROM shows WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
    header('Location: index.php?page=crud');
    exit;
}

$title = $host = $start = $end = '';
if ($id) {
    $stmt = $dbh->prepare('SELECT * FROM shows WHERE id = ?');
    $stmt->execute([$id]);
    $show = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($show) {
        $title = $show['title'];
        $host  = $show['host'];
        $start = $show['start_time'];
        $end   = $show['end_time'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $host  = trim($_POST['host']);
    $start = $_POST['start_time'];
    $end   = $_POST['end_time'];

    if ($id) {
        $stmt = $dbh->prepare('UPDATE shows
                               SET title = ?, host = ?, start_time = ?, end_time = ?
                               WHERE id = ?');
        $stmt->execute([$title, $host, $start, $end, $id]);
    } else {
        $stmt = $dbh->prepare('INSERT INTO shows (title, host, start_time, end_time)
                               VALUES (?, ?, ?, ?)');
        $stmt->execute([$title, $host, $start, $end]);
    }
    header('Location: index.php?page=crud');
    exit;
}
?>

<h1><?= $id ? 'Műsor szerkesztése' : 'Új műsor' ?></h1>

<form method="post">
    <label>Cím:
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>
    </label>
    <label>Műsorvezető:
        <input type="text" name="host" value="<?= htmlspecialchars($host) ?>" required>
    </label>
    <label>Kezdés:
        <input type="time" name="start_time" value="<?= htmlspecialchars($start) ?>" required>
    </label>
    <label>Befejezés:
        <input type="time" name="end_time" value="<?= htmlspecialchars($end) ?>" required>
    </label>
    <button type="submit">Mentés</button>
</form>
