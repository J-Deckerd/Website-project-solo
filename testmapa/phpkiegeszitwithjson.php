<?php
$user = current_user();
$errors = [];

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (strlen($name) < 3) $errors[] = 'A név túl rövid.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Érvénytelen e-mail cím.';
if (strlen($subject) < 3) $errors[] = 'A tárgy túl rövid.';
if (strlen($message) < 10) $errors[] = 'Az üzenet túl rövid.';

if (empty($errors)) {
    $stmt = $dbh->prepare('INSERT INTO messages (name, email, subject, message, user_id)
                           VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([
        $name,
        $email,
        $subject,
        $message,
        $user['id'] ?? null
    ]);
}
?>

<h1>Kapott üzenet</h1>

<?php if ($errors): ?>
    <h2>Hibák:</h2>
    <ul>
        <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
    </ul>
    <p><a href="index.php?page=kapcsolat">Vissza az űrlaphoz</a></p>
<?php else: ?>
    <p>Köszönjük az üzenetet!</p>
    <h2>Összefoglaló</h2>
    <ul>
        <li>Név: <?= htmlspecialchars($name) ?></li>
        <li>E-mail: <?= htmlspecialchars($email) ?></li>
        <li>Tárgy: <?= htmlspecialchars($subject) ?></li>
        <li>Üzenet: <?= nl2br(htmlspecialchars($message)) ?></li>
    </ul>
<?php endif; ?>