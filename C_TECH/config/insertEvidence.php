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

$files = [
    'transcript',
    'house_registration',
    'id_card',
    'slip2000'
];

$file_paths = [];
$uploadOk = 1;

foreach ($files as $file) {
    $target_file = $target_dir . basename($_FILES[$file]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // ตรวจสอบว่าไฟล์เป็นรูปภาพจริงหรือไม่
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES[$file]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "ไฟล์ $file ไม่ใช่รูปภาพ.";
            $uploadOk = 0;
        }
    }

    // ตรวจสอบว่าไฟล์มีอยู่แล้วหรือไม่
    if (file_exists($target_file)) {
        echo "ไฟล์ $file มีอยู่แล้ว.";
        $uploadOk = 0;
    }

    // ตรวจสอบขนาดไฟล์
    if ($_FILES[$file]["size"] > 500000) {
        echo "ไฟล์ $file ใหญ่เกินไป.";
        $uploadOk = 0;
    }

    // อนุญาตเฉพาะไฟล์ที่เป็น JPG, JPEG, PNG
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "ไฟล์ $file ต้องเป็น JPG, JPEG หรือ PNG เท่านั้น.";
        $uploadOk = 0;
    }

    // ตรวจสอบว่า $uploadOk ถูกตั้งค่าเป็น 0 หรือไม่
    if ($uploadOk == 0) {
        echo "ไม่สามารถอัปโหลดไฟล์ $file ได้.";
    } else {
        if (move_uploaded_file($_FILES[$file]["tmp_name"], $target_file)) {
            $file_paths[$file] = htmlspecialchars(basename($_FILES[$file]["name"]));
        } else {
            echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ $file.";
        }
    }
}

// บันทึกข้อมูลลงในฐานข้อมูล
if (!empty($file_paths)) {
    $user_id = $_SESSION['user_login'];  // ใช้ user_id จากเซสชั่น
    $date = date('Y-m-d');  // วันที่ปัจจุบัน

    // เตรียมคำสั่ง SQL สำหรับ PDO
    $sql = "UPDATE form 
            SET transcript = :transcript, 
                id_card = :id_card, 
                house_registration = :house_registration, 
                slip2000 = :slip2000, 
                date = :date 
            WHERE User_ID = :user_id";
    $stmt = $conn->prepare($sql);

    // ผูกค่ากับพารามิเตอร์
    $stmt->bindValue(':transcript', $file_paths['transcript'] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(':id_card', $file_paths['id_card'] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(':house_registration', $file_paths['house_registration'] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(':slip2000', $file_paths['slip2000'] ?? null, PDO::PARAM_STR);
    $stmt->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

    // ทำการ execute คำสั่ง
    if ($stmt->execute()) {
        echo "ข้อมูลได้ถูกอัปเดตเรียบร้อยแล้ว.";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล.";
    }

    $stmt->closeCursor(); // ปิด cursor
}

$conn = null; // ปิดการเชื่อมต่อฐานข้อมูล
?>
