<?php
session_start();
require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_card_number = $_POST['id_card_number'];
    $username = $_POST['username'];

    try {
        // ตรวจสอบว่าหมายเลขบัตรประชาชนมีอยู่แล้วหรือไม่
        $checkSql = $conn->prepare("SELECT COUNT(*) FROM applicant WHERE id_card_number = :id_card_number");
        $checkSql->bindParam(":id_card_number", $id_card_number, PDO::PARAM_STR);
        $checkSql->execute();
        $count = $checkSql->fetchColumn();

        if ($count > 0) {
            // หมายเลขบัตรประชาชนมีอยู่แล้ว
            $_SESSION['error'] = "ข้อผิดพลาด: หมายเลขบัตรประชาชนนี้มีอยู่แล้ว";
            header("Location: ../register.php");
            exit();
        } else {
            // แทรกข้อมูลใหม่
            $sql = $conn->prepare("INSERT INTO applicant (id_card_number, username) VALUES (:id_card_number, :username)");
            $sql->bindParam(":id_card_number", $id_card_number, PDO::PARAM_STR);
            $sql->bindParam(":username", $username, PDO::PARAM_STR);
            $sql->execute();

            $_SESSION['success'] = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
            header("Location: ../register.php");
            exit();
        }
    } catch (Exception $e) {
        // จัดการข้อผิดพลาด
        $_SESSION['error'] = "ข้อผิดพลาด: เกิดข้อผิดพลาด: " . $e->getMessage();
        header("Location: register.php");
        exit();
    }
}
?>
