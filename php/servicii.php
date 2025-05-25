<?php
session_start();
if (!isset($_SESSION['logged_in'])) die("Acces interzis");
require 'db.php';

$actiune = $_POST['actiune'] ?? '';
$id = $_POST['id'] ?? null;
$nume = trim($_POST['nume'] ?? '');

switch ($actiune) {
    case 'adauga':
        if ($nume !== '') {
            $stmt = $pdo->prepare("INSERT INTO servicii (nume) VALUES (:nume)");
            $stmt->execute(['nume' => $nume]);
        }
        break;

    case 'modifica':
        if ($id && $nume !== '') {
            $stmt = $pdo->prepare("UPDATE servicii SET nume = :nume WHERE id = :id");
            $stmt->execute(['nume' => $nume, 'id' => $id]);
        }
        break;

    case 'sterge':
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM servicii WHERE id = :id");
            $stmt->execute(['id' => $id]);
        }
        break;
}

header("Location: admin.php");
exit;
