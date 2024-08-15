<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_login'];
    
    // ตรวจสอบว่ามีการอัปโหลดไฟล์หรือไม่
    if (empty($_FILES['transcript']) || empty($_FILES['house_registration']) || empty($_FILES['id_card']) || empty($_FILES['slip2000'])) {
        die('Error: One or more files are missing.');
    }

    // ข้อมูลเอกสาร
    $transcript = $_FILES['transcript'];
    $house_registration = $_FILES['house_registration'];
    $id_card = $_FILES['id_card'];
    $slip2000 = $_FILES['slip2000'];
    $date = date('Y-m-d'); // วันที่ปัจจุบัน
    $status = 'pending'; // หรือสถานะอื่น ๆ ที่ต้องการ

    // โฟลเดอร์สำหรับเก็บไฟล์
    $uploadDir = '../uploads/';

    // ฟังก์ชันเพื่ออัปโหลดไฟล์
    function uploadFile($file, $uploadDir) {
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        $targetFile = $uploadDir . basename($file['name']);
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // ตรวจสอบประเภทไฟล์
        if (!in_array($fileType, $allowedTypes)) {
            return false;
        }

        // ย้ายไฟล์ไปยังโฟลเดอร์ปลายทาง
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return basename($file['name']);
        } else {
            return false;
        }
    }

    // อัปโหลดไฟล์และรับเส้นทาง
    $transcriptPath = uploadFile($transcript, $uploadDir);
    $houseRegistrationPath = uploadFile($house_registration, $uploadDir);
    $idCardPath = uploadFile($id_card, $uploadDir);
    $slip2000Path = uploadFile($slip2000, $uploadDir);

    if (!$transcriptPath || !$houseRegistrationPath || !$idCardPath || !$slip2000Path) {
        die('Error uploading files.');
    }

    try {
        // ตรวจสอบว่ามีข้อมูลในตาราง form หรือไม่
        $stmtCheck = $conn->prepare("SELECT Form_ID FROM form WHERE User_ID = :user_id");
        $stmtCheck->bindParam(':user_id', $user_id);
        $stmtCheck->execute();
        $existingForm = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingForm) {
            // ถ้ามีข้อมูลอยู่แล้ว ทำการ update
            $stmt = $conn->prepare("UPDATE form 
                                    SET transcript = :transcript, 
                                        id_card = :id_card, 
                                        house_registration = :house_registration, 
                                        slip2000 = :slip2000, 
                                        date = :date, 
                                        status = :status 
                                    WHERE User_ID = :user_id");
        } else {
            // ถ้าไม่มีข้อมูล ทำการ insert
            $stmt = $conn->prepare("INSERT INTO form (transcript, id_card, house_registration, slip2000, date, status, User_ID) 
                                    VALUES (:transcript, :id_card, :house_registration, :slip2000, :date, :status, :user_id)");
        }

        $stmt->bindParam(':transcript', $transcriptPath);
        $stmt->bindParam(':id_card', $idCardPath);
        $stmt->bindParam(':house_registration', $houseRegistrationPath);
        $stmt->bindParam(':slip2000', $slip2000Path);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        // Redirect after successful insertion or update
        header('Location: ../Evidence.php'); // หน้าแสดงผลลัพธ์หลังจากการส่งข้อมูลสำเร็จ
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // If not a POST request, redirect back to form
    header('Location: ../Evidence.php');
    exit;
}
?>
