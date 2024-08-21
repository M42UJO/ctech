<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: ../login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_login'];
    $courseType = $_POST['CourseType_Name'];
    $level = $_POST['Level_Name'];
    $subjectType = $_POST['Type_Name'];
    $major = $_POST['Major_Name'];

    // ข้อมูลเอกสาร
    $transcript = isset($_POST['transcript']) ? $_POST['transcript'] : null;
    $id_card = isset($_POST['id_card']) ? $_POST['id_card'] : null;
    $house_registration = isset($_POST['house_registration']) ? $_POST['house_registration'] : null;
    $slip2000 = isset($_POST['slip2000']) ? $_POST['slip2000'] : null;
    $date = date('Y-m-d'); // วันที่ปัจจุบัน
    $status = 'pending'; // หรือสถานะอื่น ๆ ที่ต้องการ

    try {
        // ตรวจสอบว่ามีข้อมูลในตาราง form หรือไม่
        $stmtCheck = $conn->prepare("SELECT Form_ID FROM form WHERE User_ID = :user_id");
        $stmtCheck->bindParam(':user_id', $user_id);
        $stmtCheck->execute();
        $existingForm = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existingForm) {
            // ถ้ามีข้อมูลอยู่แล้ว ทำการ update
            $stmt = $conn->prepare("UPDATE form 
                                    SET  
                                        date = :date, 
                                        status = :status, 
                                        Major_ID = :major_id 
                                    WHERE User_ID = :user_id");
        } else {
            // ถ้าไม่มีข้อมูล ทำการ insert
            $stmt = $conn->prepare("INSERT INTO form (date, status, Major_ID, User_ID) 
                                    VALUES (:date, :status, :major_id, :user_id)");
        }

        
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':major_id', $major);
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
    header('Location: ../apply.php');
    exit;
}
?>
