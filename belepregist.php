<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // BELÉPÉS
    if ($_POST['action'] === 'login') {

        if (!login($dbh, $_POST['login'], $_POST['password'])) {
            $errors[] = 'Hibás belépési adatok.';
        } else {
            header('Location: index.php?page=home');
            exit;
        }

    }

    // REGISZTRÁCIÓ
    elseif ($_POST['action'] === 'register') {

        try {
            register_user(
                trim($_POST['lastname']),
                trim($_POST['firstname']),
                trim($_POST['login']),
                $_POST['password']
            );

            // Sikeres regisztráció után NEM léptetjük be automatikusan
            $errors[] = "Sikeres regisztráció! Most már beléphetsz.";

        } catch (PDOException $e) {
            $errors[] = 'Nem sikerült a regisztráció (lehet, hogy foglalt a login név).';
        }
    }
}
?>

<h1>Belépés / Regisztráció</h1>

<?php foreach ($errors as $e): ?>
    <p class="error"><?= htmlspecialchars($e) ?></p>
<?php endforeach; ?>

<section class="auth-forms">
    <div class="auth-box">
        <h2>Belépés</h2>
        <form method="post">
            <input type="hidden" name="action" value="login">

            <label>Login név:
                <input type="text" name="login" required>
            </label>

            <label>Jelszó:
                <input type="password" name="password" required>
            </label>

            <button type="submit">Belépés</button>
        </form>
    </div>

    <div class="auth-box">
        <h2>Regisztráció</h2>
        <form method="post">
            <input type="hidden" name="action" value="register">

            <label>Családi név:
                <input type="text" name="lastname" required>
            </label>

            <label>Utónév:
                <input type="text" name="firstname" required>
            </label>

            <label>Login név:
                <input type="text" name="login" required>
            </label>

            <label>Jelszó:
                <input type="password" name="password" required>
            </label>

            <button type="submit">Regisztráció</button>
        </form>
    </div>
</section>
<iframe 
    src="https://www.google.com/maps/embed?pb=VALAMI"
    width="600" height="450" style="border:0;" 
    allowfullscreen="" loading="lazy">
</iframe>
