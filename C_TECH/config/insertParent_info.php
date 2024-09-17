<?php
// เริ่มต้นเซสชัน
session_start();

// รวมไฟล์การเชื่อมต่อฐานข้อมูล
require_once("db.php");

// ตรวจสอบว่าเซสชันของผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION['user_login'])) {
    // ถ้าไม่ได้ล็อกอิน, เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
    header('Location: login.php');
    exit();
}

// รับ ID ของผู้ใช้จากเซสชัน
$user_id = $_SESSION['user_login'];

try {
    // ดึงข้อมูลของผู้ใช้จากฐานข้อมูลโดยใช้ User_ID
    $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt->execute([$user_id]);
    $userData = $stmt->fetch();
} catch (PDOException $e) {
    // แสดงข้อผิดพลาดหากเกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}

// ตรวจสอบว่าแบบฟอร์มถูกส่งหรือไม่
if (isset($_POST['submit_button'])) {
    // รับค่าจากฟอร์มและทำการป้องกัน XSS โดยการใช้ htmlspecialchars
    $guardian_name = htmlspecialchars($_POST['guardian_name']);
    $guardian_relationship = htmlspecialchars($_POST['guardian_relationship']);
    $guardian_house_number = htmlspecialchars($_POST['guardian_house_number']);
    $guardian_village = htmlspecialchars($_POST['guardian_village']);
    $guardian_lane = htmlspecialchars($_POST['guardian_lane']);
    $guardian_road = htmlspecialchars($_POST['guardian_road']);
    $guardian_sub_district = htmlspecialchars($_POST['guardian_sub_district']);
    $guardian_district = htmlspecialchars($_POST['guardian_district']);
    $guardian_province = htmlspecialchars($_POST['guardian_province']);
    $guardian_postal_code = htmlspecialchars($_POST['guardian_postal_code']);
    $guardian_phone_number = htmlspecialchars($_POST['guardian_phone_number']);

    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM parent_info WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ายังไม่มีที่อยู่ของผู้ใช้, ทำการแทรกข้อมูลใหม่ลงในฐานข้อมูล
            $sql_insert = $conn->prepare("INSERT INTO guardian_info (
                guardian_name, guardian_relationship, guardian_house_number, 
                guardian_village, guardian_lane, guardian_road, guardian_sub_district, 
                guardian_district, guardian_province, guardian_postal_code, guardian_phone_number, 
                User_ID
            ) VALUES (
                :guardian_name, :guardian_relationship, :guardian_house_number, 
                :guardian_village, :guardian_lane, :guardian_road, :guardian_sub_district, 
                :guardian_district, :guardian_province, :guardian_postal_code, :guardian_phone_number, 
                :user_id
            )");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->bindParam(':guardian_name', $guardian_name);
            $sql_insert->bindParam(':guardian_relationship', $guardian_relationship);
            $sql_insert->bindParam(':guardian_house_number', $guardian_house_number);
            $sql_insert->bindParam(':guardian_village', $guardian_village);
            $sql_insert->bindParam(':guardian_lane', $guardian_lane);
            $sql_insert->bindParam(':guardian_road', $guardian_road);
            $sql_insert->bindParam(':guardian_sub_district', $guardian_sub_district);
            $sql_insert->bindParam(':guardian_district', $guardian_district);
            $sql_insert->bindParam(':guardian_province', $guardian_province);
            $sql_insert->bindParam(':guardian_postal_code', $guardian_postal_code);
            $sql_insert->bindParam(':guardian_phone_number', $guardian_phone_number);
            $sql_insert->bindParam(':user_id', $user_id);
            $sql_insert->execute();
            
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE parent_info SET
                guardian_name = :guardian_name,
                guardian_relationship = :guardian_relationship,
                guardian_house_number = :guardian_house_number,
                guardian_village = :guardian_village,
                guardian_lane = :guardian_lane,
                guardian_road = :guardian_road,
                guardian_sub_district = :guardian_sub_district,
                guardian_district = :guardian_district,
                guardian_province = :guardian_province,
                guardian_postal_code = :guardian_postal_code,
                guardian_phone_number = :guardian_phone_number
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':guardian_name', $guardian_name);
            $sql_update->bindParam(':guardian_relationship', $guardian_relationship);
            $sql_update->bindParam(':guardian_house_number', $guardian_house_number);
            $sql_update->bindParam(':guardian_village', $guardian_village);
            $sql_update->bindParam(':guardian_lane', $guardian_lane);
            $sql_update->bindParam(':guardian_road', $guardian_road);
            $sql_update->bindParam(':guardian_sub_district', $guardian_sub_district);
            $sql_update->bindParam(':guardian_district', $guardian_district);
            $sql_update->bindParam(':guardian_province', $guardian_province);
            $sql_update->bindParam(':guardian_postal_code', $guardian_postal_code);
            $sql_update->bindParam(':guardian_phone_number', $guardian_phone_number);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();

            $sql_status_update = $conn->prepare("UPDATE form SET status = 'update' WHERE User_ID = ?");
            $sql_status_update->execute([$user_id]);
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../apply.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Parent_info.php");
        exit();
    }
}
?>
