<?php
$user = current_user();

// Feltöltés kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        // Fájl neve
        $originalName = basename($_FILES['image']['name']);
        $newName = time() . '_' . $originalName;

        // ABSZOLÚT útvonal a szerveren
        $uploadDir = __DIR__ . '/uploads/images/';

        // Ha nincs mappa → létrehozza
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Célfájl teljes elérési útja
        $targetFile = $uploadDir . $newName;

        // Relatív útvonal
        $relativePath = 'uploads/images/' . $newName;

        // Fájl mozgatása
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

            // Mentés adatbázisba
            $stmt = $dbh->prepare("
                INSERT INTO images (filename, title, uploaded_by)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$relativePath, $_POST['title'] ?? null, $user['id'] ?? null]);

        } else {
            echo "<p style='color:red;'>Hiba történt a fájl mozgatása közben.</p>";
        }
    }
}

// Képek lekérése
$images = $dbh->query("
    SELECT i.*, u.login
    FROM images i
    LEFT JOIN users u ON i.uploaded_by = u.id
    ORDER BY i.uploaded_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Képgaléria</h1>

<?php if ($user): ?>
<section class="upload-form">
    <h2>Új kép feltöltése</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Cím:
            <input type="text" name="title">
        </label>
        <label>Kép:
            <input type="file" name="image" accept="image/*" required>
        </label>
        <button type="submit">Feltöltés</button>
    </form>
</section>
<?php else: ?>
<p>Új képet csak bejelentkezett felhasználó tölthet fel.</p>
<?php endif; ?>

<section class="gallery">
    <h2>Galéria</h2>
    <div class="image-grid" style="display:flex; flex-wrap:wrap; gap:20px;">
        <?php foreach ($images as $img): ?>
            <figure style="text-align:center;">
                <img src="<?= htmlspecialchars('/radio/testmapa/' . $img['filename']) ?>"
                     alt="<?= htmlspecialchars($img['title'] ?? '') ?>"
                     style="max-width:300px; height:auto; border:1px solid #ccc; border-radius:8px;">
                <figcaption>
                    <strong><?= htmlspecialchars($img['title'] ?? '') ?></strong><br>
                    Feltöltötte: <?= htmlspecialchars($img['login'] ?? 'Ismeretlen') ?><br>
                    <?= htmlspecialchars($img['uploaded_at']) ?>
                </figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>
