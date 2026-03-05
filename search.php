<?php
    require 'requires/config.php';
    $res = [];

    if (!isset($_GET['info'])) {
        $res = ['error' => 'No songs found'];
    } else {
        $query = "SELECT * FROM Songs WHERE Song_name LIKE :INFO AND Deleted_yn = 'N';";
        $stmt = $pdo->prepare($query);

        $stmt->execute(['INFO' => ('%'. $_GET['info'] . '%') ]);
        array_push($res, $stmt->fetchAll());

        $stmt->execute(['INFO' => ($_GET['info'] . '%') ]);
        array_push($res, $stmt->fetchAll());

        $stmt->execute(['INFO' => ('%'. $_GET['info']) ]);
        array_push($res, $stmt->fetchAll());

        $unique = [];
        foreach (array_filter($res[0]) as $row) {
            $unique[$row['Song_ID']] = $row;
        }
        $res = array_values($unique);

    }
    header('Content-Type: application/json');
?> <?= json_encode($res) ?>