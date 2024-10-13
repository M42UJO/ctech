<?php
session_start();
require_once("db.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        $_SESSION['error'] = 'กรุณากรอก username';
        header("location: ../admin.php");
        exit();
    } else if (empty($password)) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
        header("location: ../admin.php");
        exit();
    } else if (strlen($password) > 20 || strlen($password) < 5) {
        $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
        header("location: ../admin.php");
        exit();
    } else {
        try {
            $check_data = $conn->prepare("SELECT * FROM user WHERE username = :username");
            $check_data->bindParam(":username", $username);
            $check_data->execute();
            $row = $check_data->fetch(PDO::FETCH_ASSOC);

            if ($check_data->rowCount() > 0) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['admin_login'] = $row['User_ID'];
                    header("location: ../admin-pages/indexadmin.php");
                    exit();
                } else {
                    $_SESSION['error'] = 'รหัสผ่านผิด';
                    header("location: ../admin.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                header("location: ../admin.php");
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
            header("location: ../admin.php");
            exit();
        }
    }
}
?>
