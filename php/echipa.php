<?php
session_start();
if (!isset($_SESSION['logged_in'])) die("Acces interzis");
require 'db.php';

$actiune = $_POST['actiune'] ?? '';
$id = $_POST['id'] ?? null;
$nume = trim($_POST['nume'] ?? '');
$spec_id = $_POST['specializare_id'] ?? null;

switch ($actiune) {
    case 'adauga':
        if ($nume && $spec_id) {
            $stmt = $pdo->prepare("INSERT INTO medici (nume, specializare_id) VALUES (:nume, :spec)");
            $stmt->execute(['nume' => $nume, 'spec' => $spec_id]);
        }
        break;

    case 'modifica':
        if ($id && $nume && $spec_id) {
            $stmt = $pdo->prepare("UPDATE medici SET nume = :nume, specializare_id = :spec WHERE id = :id");
            $stmt->execute(['nume' => $nume, 'spec' => $spec_id, 'id' => $id]);
        }
        break;

    case 'sterge':
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM medici WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
        break;
}

header("Location: admin.php");
exit;
