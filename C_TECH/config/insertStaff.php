<?php

session_start();
require_once 'db.php';

if (isset($_POST['submit'])) {
    $name_staff = $_POST['name_staff'];
    $lname_staff = $_POST['lname_staff'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $urole = $_POST['urole'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $userExists = $stmt->fetchColumn();

    if ($userExists > 0) {
        $_SESSION['warning'] = "มีชื่อผู้ใช้อยู่แล้ว โปรดเลือกชื่อผู้ใช้อื่น";
        header("location: ../admin-pages/addStaff.php");
    } else {
        // Insert the new user
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user(name_staff, lname_staff, username, password, urole) VALUES(:name_staff, :lname_staff, :username, :password, :urole)");
        $stmt->bindParam(":name_staff", $name_staff);
        $stmt->bindParam(":lname_staff", $lname_staff);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $passwordHash);
        $stmt->bindParam(":urole", $urole);
        $stmt->execute();

        $_SESSION['success'] = "เพิ่มเจ้าหน้าที่ เรียบร้อยแล้ว!";
        header("location: ../admin-pages/addStaff.php");
    }
}
?>
