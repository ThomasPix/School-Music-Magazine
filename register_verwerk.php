<?php
require 'requires/config.php';
session_start();

$error = "";
$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirm_password = htmlspecialchars($_POST['confirmpassword']);
    $isArtist = $_POST['isArtist'] ?? 'no';

    if (strlen($username) > 0 && strlen($password) > 0 && strlen($confirm_password) > 0) {

        if (strlen($username) > 30) {
            $error = "Username is too long. (max 30 characters) ";
        }

        if (strlen($password) < 6) {
            $error .= "Password is too short. (atleast 6 characters) ";
        }

        if ($password != $confirm_password) {
            $error .= "Passwords do not match. ";
        }

        if ($isArtist != "Yes") {
            $isArtist = "No";
        }

        if ($error == "") {
            try {
                $checkUsername = "SELECT * FROM Users WHERE Username = :username";

                $statement = $pdo->prepare($checkUsername);

                $statement->execute(['username' => $username]);

                if ($statement->rowCount() == null) {
                    $hashedPassword = crypt($password, '$6$rounds=5000$lucasIsHot$');
                    try {
                        $query = "INSERT INTO Users (Username, Password, IsArtist) VALUES (:username, :password, :isArtist)";

                        $stmt = $pdo->prepare($query);

                        $stmt->execute([
                            'username' => $username,
                            'password' => $hashedPassword,
                            'isArtist' => $isArtist
                        ]);

                        if ($stmt->rowCount() >0) {
                            $result = "User is made!";

                            $_SESSION['Username'] = $username;

                            header("Location: index.php");
                        } else {
                            $error = "Something went wrong while making the User. ";
                        }
                    } catch (PDOExceptions $e) {
                        $error = "Something went wrong " . $e->getMessages() . ". ";
                    }
                } else {
                    $error = "This username is already in use!";
                }
            } catch (PDOException $e) {
                $error = "Something went wrong" . $e->getMessage() . ". ";
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

include 'views/register_verwerk_view.php';