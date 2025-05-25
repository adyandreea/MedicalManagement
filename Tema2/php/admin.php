<?php
session_start();
if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
require 'db.php';

$specializari = $pdo->query("SELECT * FROM specializari")->fetchAll();
$servicii = $pdo->query("SELECT * FROM servicii")->fetchAll();
$medici = $pdo->query("SELECT * FROM medici")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Administrare Clinică</title>
    <link rel="stylesheet" href="../css/admin.css">
    <script src="../javascript/validari.js"></script>
</head>
<body>
    <h1>Panou Administrare</h1>
    <a href="logout.php">Deconectare</a>

    <div class="section">
        <h2>Specializări</h2>
        <form id="formSpec" method="POST" action="specializari.php" onsubmit="return validateForm('formSpec')">
            <input type="hidden" name="actiune" value="adauga">
            <input type="text" name="nume" placeholder="Nume specializare" class="required">
            <button type="submit">Adaugă</button>
        </form>

        <ul>
            <?php foreach ($specializari as $spec): ?>
                <li>
                    <?= htmlspecialchars($spec['nume']) ?>
                    <form method="POST" action="specializari.php" style="display:inline;">
                        <input type="hidden" name="actiune" value="sterge">
                        <input type="hidden" name="id" value="<?= $spec['id'] ?>">
                        <button type="submit">Șterge</button>
                    </form>
                    <form id="formSpecializare<?= $spec['id'] ?>" method="POST" action="specializari.php" style="display:inline;" onsubmit="return validateForm('formSpecializare<?= $spec['id'] ?>')">
                        <input type="hidden" name="actiune" value="modifica">
                        <input type="hidden" name="id" value="<?= $spec['id'] ?>">
                        <input type="text" name="nume" placeholder="Nume specializare" value="<?= htmlspecialchars($spec['nume']) ?>" class="required">
                        <button type="submit">Modifică</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="section">
        <h2>Servicii medicale</h2>
        <form id="formServ" method="POST" action="servicii.php" onsubmit="return validateForm('formServ')">
            <input type="hidden" name="actiune" value="adauga">
            <input type="text" name="nume" placeholder="Nume serviciu" class="required">
            <button type="submit">Adaugă</button>
        </form>

        <ul>
            <?php foreach ($servicii as $serv): ?>
                <li>
                    <?= htmlspecialchars($serv['nume']) ?>
                    <form method="POST" action="servicii.php" style="display:inline;">
                        <input type="hidden" name="actiune" value="sterge">
                        <input type="hidden" name="id" value="<?= $serv['id'] ?>">
                        <button type="submit">Șterge</button>
                    </form>
                    <form id="formServ<?= $serv['id'] ?>" method="POST" action="servicii.php" style="display:inline;" onsubmit="return validateForm('formServ<?= $serv['id'] ?>')">
                        <input type="hidden" name="actiune" value="modifica">
                        <input type="hidden" name="id" value="<?= $serv['id'] ?>">
                        <input type="text" name="nume" placeholder="Nume serviciu" value="<?= htmlspecialchars($serv['nume']) ?>" class="required">
                        <button type="submit">Modifică</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="section">
        <h2>Echipa medicală</h2>
        <form id="formMedic" method="POST" action="echipa.php" onsubmit="return validateForm('formMedic')">
            <input type="hidden" name="actiune" value="adauga">
            <input type="text" name="nume" placeholder="Nume medic"  class="required">
            <select name="specializare_id" class="required">
                <option value="">Selectează specializare</option>
                <?php foreach ($specializari as $spec): ?>
                    <option value="<?= $spec['id'] ?>"><?= htmlspecialchars($spec['nume']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Adaugă</button>
        </form>

        <ul>
            <?php foreach ($medici as $medic): ?>
                <li>
                    <?= htmlspecialchars($medic['nume']) ?> -
                    <?php
                        $specName = '';
                        foreach ($specializari as $spec) {
                            if ($spec['id'] == $medic['specializare_id']) {
                                $specName = $spec['nume'];
                                break;
                            }
                        }
                        echo htmlspecialchars($specName);
                    ?>
                    <form method="POST" action="echipa.php" style="display:inline;">
                        <input type="hidden" name="actiune" value="sterge">
                        <input type="hidden" name="id" value="<?= $medic['id'] ?>">
                        <button type="submit">Șterge</button>
                    </form>
                    <form id="formMedic<?= $medic['id'] ?>" method="POST" action="echipa.php" style="display:inline;" onsubmit="return validateForm('formMedic<?= $medic['id'] ?>')">
                        <input type="hidden" name="actiune" value="modifica">
                        <input type="hidden" name="id" value="<?= $medic['id'] ?>">
                        <input type="text" name="nume" placeholder="Nume medic" value="<?= htmlspecialchars($medic['nume']) ?>"  class="required">
                        <select name="specializare_id" required>
                            <?php foreach ($specializari as $spec): ?>
                                <option value="<?= $spec['id'] ?>" <?= $spec['id'] == $medic['specializare_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($spec['nume']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit">Modifică</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
