<?php
    require 'requires/config.php';
    $res = [];

if (!isset($_GET['id'])) {
    $res = ['error' => 'No song found'];
} else {
    $query = "SELECT * FROM Songs WHERE Song_ID = :ID AND Deleted_yn = 'N';";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['ID' => $_GET['id']]);
    $res = $stmt->fetch();

}
header('Content-Type: application/json');
?> <?= json_encode($res) ?>