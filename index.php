<?php
require 'requires/config.php';
session_start();

$query = "SELECT * FROM Songs ORDER BY RAND() LIMIT 30;";
$stmt = $pdo->prepare($query);
$stmt->execute();
$sonkz = $stmt->fetchAll();

//$user = $_SESSION['Username'];

include 'views/index_view.php';