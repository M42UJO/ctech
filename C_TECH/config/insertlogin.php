<?php
session_start();
require_once("db.php");

if (isset($_POST['login'])) {
    $id_card_number = $_POST['id_card_number'];

    if (empty($id_card_number)) {
        $_SESSION['error'] = 'กรุณากรอกเลขบัตรประชาชน';
        header("location: ../login.php");
        exit();
    } else {
        try {
            // ตรวจสอบว่ามีเลขบัตรประชาชนในระบบหรือไม่
            $check_data = $conn->prepare("SELECT * FROM user WHERE id_card_number = :id_card_number");
            $check_data->bindParam(":id_card_number", $id_card_number);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                // ถ้ามีข้อมูลในระบบ ก็เข้าสู่ระบบ
                $_SESSION['user_login'] = $row['User_ID'];
                header("location: ../index.php");
                exit();
            } else {
                // ถ้าไม่มีข้อมูล ให้เพิ่มข้อมูลเข้าไปในฐานข้อมูล
                $urole = 'user'; // กำหนดค่า urole เป็นค่าเริ่มต้น (ปรับได้ตามความต้องการ)
                $stmt = $conn->prepare("INSERT INTO user(id_card_number, urole) VALUES(:id_card_number, :urole)");
                $stmt->bindParam(":id_card_number", $id_card_number);
                $stmt->bindParam(":urole", $urole);
                $stmt->execute();

                // ดึงข้อมูลผู้ใช้ที่เพิ่งเพิ่มเข้ามา เพื่อใช้ใน session
                $new_user_id = $conn->lastInsertId();
                $_SESSION['user_login'] = $new_user_id;

                header("location: ../index.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("location: ../login.php");
            exit();
        }
    }
}
?>
