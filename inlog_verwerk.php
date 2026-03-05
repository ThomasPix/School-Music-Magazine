<?php
require ('requires/config.php');
session_start();

$error = "";
$result = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);

    if (strlen($username) > 0 && strlen($password) > 0) {
        
        if (strlen($username) > 30) {
            $error = "Username is too long. (max 30 characters) ";
        }

        if (strlen($password) < 6) {
            $error .= "Password is too short. (atleast 6 characters) ";
        }

        if ($error == "") {
            try {
                $query = "SELECT Username, Password FROM Users WHERE Username = :username AND Deleted_yn = 'N'";
                
                $stmt = $pdo->prepare($query);

                $stmt->execute(['username' => $username]);

                if ($stmt->rowCount() > 0) {
                    $check = $stmt->fetchAll();
                    if (hash_equals($check[0]['Password'], crypt($password, '$6$rounds=5000$lucasIsHot$'))) {
                        $result = "Correct password";

                        $_SESSION['Username'] = $username;

                        header("Location: index.php");
                    } else {
                        $error = "Wrong password. ";
                    }
                } else {
                    $error = "Wrong Username. ";
                }
            } catch (PDOException $e) {
                $error = "Error while logging in. ";
            }
        }

    } else {
        $error = "Not all fields contain data. ";
    }

} else {
    $error = "Wrong server request. ";
}

if (!$error == "") {
    $error .= "Please try again!";
}

include_once 'views/inlog_verwerk_view.php';