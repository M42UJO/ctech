<?php

session_start();
require_once("db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $id_card_number = $_POST['id_card_number'];

    try {
        $stmt = $conn->prepare("SELECT * FROM applicant WHERE username = ?");
        $stmt->execute([$username]);
        $userData = $stmt->fetch();

        if ($userData && $userData['id_card_number'] === $id_card_number) {
            $_SESSION['user_id'] = $userData['Applicant_ID'];
            header("Location: ../index.php");
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: ../login.php");
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: login.php");
    }
}
