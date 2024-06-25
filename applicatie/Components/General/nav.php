<!-- /includes/nav.php -->
<?php
$isLoggedin = isLoggedIn();
$isLoggedin = isset($_SESSION['rol']);
$rol = $_SESSION['rol'] ?? '';
?>

    <nav>
    <ul>
        <li><a href="../index.php">Home</a></li>
        <?php if ($isLoggedin && $rol === 'medewerker') { ?>
            <li><a href="../index.php">CheckIn</a></li>
            <li><a href="../Views/medewerker.php">Zoeken</a></li>
            <li><a href="../Views/nieuwvlucht.php">Vlucht+</a></li>
            <li><a href="../Views/nieuwpassagier.php">Passagier+</a></li>
        <?php } elseif ($isLoggedin && $rol === 'passagier') { ?>
            <li><a href="../Views/passagier.php">Checkin</a></li>
        <?php } ?>
        <li><a href="../Views/Privacy.php">Privacy</a></li>
        <?php if ($isLoggedin) { ?>
            <li><?= htmlspecialchars($_SESSION['rol'], ENT_QUOTES, 'UTF-8') . ':' . htmlspecialchars($_SESSION['gebruikersnaam'], ENT_QUOTES, 'UTF-8') ?> (<a href="../Views/logout.php">Logout</a>)</li>
        <?php } else { ?>
            <li><a href="../Views/login.php">Login</a></li>
        <?php } ?>
    </ul>
</nav>