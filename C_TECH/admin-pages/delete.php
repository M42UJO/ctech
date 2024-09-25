<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['admin_login'])) {
    header('Location: admin.php');
    exit();
}

// ตรวจสอบว่ามีการส่ง `user_id` มาไหม
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // ใช้คำสั่ง SQL เพื่อเตรียมลบข้อมูลจากทุกตารางที่เกี่ยวข้อง
    try {
        $conn->beginTransaction();

        // ลบข้อมูลจากตาราง current_address ที่อ้างอิง User_ID
        $stmt = $conn->prepare("DELETE FROM current_address WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        // ลบข้อมูลจากตาราง form ที่อ้างอิง User_ID
        $stmt = $conn->prepare("DELETE FROM form WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        // ลบข้อมูลจากตาราง education_info ที่อ้างอิง User_ID
        $stmt = $conn->prepare("DELETE FROM education_info WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        // ลบข้อมูลจากตาราง parent_info ที่อ้างอิง User_ID
        $stmt = $conn->prepare("DELETE FROM parent_info WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        // ลบข้อมูลจากตาราง applicant
        $stmt = $conn->prepare("DELETE FROM applicant WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        // ลบข้อมูลจากตาราง user
        $stmt = $conn->prepare("DELETE FROM user WHERE User_ID = ?");
        $stmt->execute([$user_id]);

        $conn->commit();
        header("Location: edituser.php"); // เปลี่ยนเส้นทางกลับไปที่หน้าหลังจากลบข้อมูล
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No user ID specified.";
}
?>
