<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: admin.php');
    exit;
}

$users = ['admin' => 'hello'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    if (isset($users[$u]) && $users[$u] === $p) {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Utilizator sau parolă incorectă!";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Autentificare Administrator</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post" class="login-form">
            <label>Utilizator:
                <input type="text" name="username" required>
            </label><br>
            <label>Parolă:
                <input type="password" name="password" required>
            </label><br><br>
            <button type="submit">Autentificare</button>
        </form>
    </div>
</body>
</html>
