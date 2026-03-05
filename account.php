<?php
    require 'requires/config.php';
    session_start();

    if (!isset($_SESSION['Username'])) {header('Location: index.php');}

    $user = $_SESSION['Username'];

    try {
    $query = "SELECT * FROM Users WHERE Username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $user]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    if ($_POST) {
        if ($_POST['action'] == 'delete') {
            $query = "UPDATE Users SET Deleted_yn = 'Y' WHERE Username = :username AND Deleted_yn = 'N';";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $user]);

            unset($_SESSION['Username']);
            session_unset();
            session_destroy();
        } elseif ($_POST['action'] == 'update') {
            $query = "UPDATE Users SET Username = :newusername WHERE Username = :username AND Deleted_yn = 'N';";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'username' => $user,
                'newusername' => $_POST['user']
            ]);

            $query = "UPDATE Songs SET Username = :newusername WHERE Username = :username AND Deleted_yn = 'N';";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                'username' => $user,
                'newusername' => $_POST['user']
            ]);

            $_SESSION['Username'] = $_POST['user'];
        } elseif ($_POST['action'] == 'upload') {
            $audio = 'songs/audio/' . count(scandir('songs/audio')) . bin2hex(random_bytes(6)) . $_FILES['song']['name'];
            $cover = 'songs/covers/' . count(scandir('songs/covers')) . bin2hex(random_bytes(6)) . $_FILES['cover']['name'];

            move_uploaded_file($_FILES['song']['tmp_name'], $audio);
            move_uploaded_file($_FILES['cover']['tmp_name'], $cover);

            $query = "INSERT INTO Songs(Song_name, Audio_file, Cover, Username) VALUES(:NAME, :AUDIO, :COVER, :USERNAME);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([
                ':NAME' => $_POST['name'],
                ':AUDIO' => $audio,
                ':COVER' => $cover,
                ':USERNAME' => $_SESSION['Username']
            ]);

//        $check = $stmt->fetchAll();
        } elseif ($_POST['action'] == 'logout') {
            unset($_SESSION['Username']);
            session_unset();
            session_destroy();
            header('Location: index.php');
        }
    }

    $query = "SELECT * FROM Users WHERE Username = :username;";
    $stmt69 = $pdo->prepare($query);
    $stmt69->execute(['username' => $user]);
    $depresoespreso = $stmt69->fetch();

    var_dump($depresoespreso);

    include_once 'views/account_view.php';
?>