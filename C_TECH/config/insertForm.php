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
    // ตรวจสอบข้อมูลที่ส่งมาว่ามีค่าหรือไม่
    $transcript = isset($_POST['transcript']) ? $_POST['transcript'] : null;
    $id_card = isset($_POST['id_card']) ? $_POST['id_card'] : null;
    $house_registration = isset($_POST['house_registration']) ? $_POST['house_registration'] : null;
    $slip2000 = isset($_POST['slip2000']) ? $_POST['slip2000'] : null;
    $date = date('Y-m-d'); // วันที่ปัจจุบัน
    $status = 'pending'; // หรือสถานะอื่น ๆ ที่ต้องการ

    try {
        $stmt = $conn->prepare("INSERT INTO form (transcript, id_card, house_registration, slip2000, date, status, Major_ID, User_ID) 
                                VALUES (:transcript, :id_card, :house_registration, :slip2000, :date, :status, :major_id, :user_id)");
        $stmt->bindParam(':transcript', $transcript);
        $stmt->bindParam(':id_card', $id_card);
        $stmt->bindParam(':house_registration', $house_registration);
        $stmt->bindParam(':slip2000', $slip2000);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':major_id', $major);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        // Redirect after successful insertion
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
