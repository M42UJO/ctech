<?php
session_start();
require_once("../config/db.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_login'])) {
    header('Location: ../login.php');
    exit;
}


// ตั้งค่าตำแหน่งเก็บไฟล์
$target_dir = "uploads/";


    $transcript = $_FILES['transcript'];
    $transcript2 = htmlspecialchars($_POST['transcript2']);
    $house_registration = $_FILES['house_registration'];
    $house_registration2 = htmlspecialchars($_POST['house_registration2']);
    $id_card = $_FILES['id_card'];
    $id_card2 = htmlspecialchars($_POST['id_card2']);
    $slip2000 = $_FILES['slip2000'];
    $slip20002 = htmlspecialchars($_POST['slip20002']);
    
    $user_id = $_SESSION['user_login'];


    $uploadt = $_FILES['transcript']['name'];

        if ($uploadt != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $transcript['name']);
            $fileActExt = strtolower(end($extension));
            $fileNewt = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = $target_dir .$fileNewt;

            if (in_array($fileActExt, $allow)) {
                if ($transcript['size'] > 0 && $transcript['error'] == 0) {
                   move_uploaded_file($transcript['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNewt = $transcript2;
        }
    $uploadh = $_FILES['house_registration']['name'];

        if ($uploadh != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $house_registration['name']);
            $fileActExt = strtolower(end($extension));
            $fileNewh = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = $target_dir .$fileNewh;

            if (in_array($fileActExt, $allow)) {
                if ($house_registration['size'] > 0 && $house_registration['error'] == 0) {
                   move_uploaded_file($house_registration['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNewh = $house_registration2;
        }
    $uploadi = $_FILES['id_card']['name'];

        if ($uploadi != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $id_card['name']);
            $fileActExt = strtolower(end($extension));
            $fileNewi = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = $target_dir .$fileNewi;

            if (in_array($fileActExt, $allow)) {
                if ($id_card['size'] > 0 && $id_card['error'] == 0) {
                   move_uploaded_file($id_card['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNewi = $id_card2;
        }
    $uploads = $_FILES['slip2000']['name'];

        if ($uploads != '') {
            $allow = array('jpg', 'jpeg', 'png');
            $extension = explode('.', $slip2000['name']);
            $fileActExt = strtolower(end($extension));
            $fileNews = rand() . "." . $fileActExt;  // rand function create the rand number 
            $filePath = $target_dir .$fileNews;

            if (in_array($fileActExt, $allow)) {
                if ($slip2000['size'] > 0 && $slip2000['error'] == 0) {
                   move_uploaded_file($slip2000['tmp_name'], $filePath);
                }
            }

        } else {
            $fileNews = $slip20002;
        }

        try {
            $sql_update = $conn->prepare("UPDATE form 
                SET transcript = :transcript, 
                    id_card = :id_card, 
                    house_registration = :house_registration, 
                    slip2000 = :slip2000,
                    updated_at = NOW() -- เพิ่มการอัปเดตเวลาที่นี่
                WHERE User_ID = :user_id");
        
            // Bind parameters
            $sql_update->bindParam(':transcript', $fileNewt);
            $sql_update->bindParam(':id_card', $fileNewi);
            $sql_update->bindParam(':house_registration', $fileNewh);
            $sql_update->bindParam(':slip2000', $fileNews);      
                  
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
            $sql_update->execute();
        
            echo "ข้อมูลได้ถูกอัปเดตเรียบร้อยแล้ว";
        } catch (PDOException $e) {
            echo "ข้อผิดพลาดในการอัปเดต: " . $e->getMessage();
        }
        
?>
