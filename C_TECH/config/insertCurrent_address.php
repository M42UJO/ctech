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
if (isset($_POST['submit'])) {
    // รับค่าจากฟอร์มและทำการป้องกัน XSS โดยการใช้ htmlspecialchars
    $house_number = htmlspecialchars($_POST['house_number']);
    $village = htmlspecialchars($_POST['village']);
    $lane = htmlspecialchars($_POST['lane']);
    $road = htmlspecialchars($_POST['road']);
    $sub_district = htmlspecialchars($_POST['sub_district']);
    $district = htmlspecialchars($_POST['district']);
    $province = htmlspecialchars($_POST['province']);
    $postal_code = htmlspecialchars($_POST['postal_code']);

    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM current_address WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ายังไม่มีที่อยู่ของผู้ใช้, ทำการแทรกข้อมูลใหม่ลงในฐานข้อมูล
            $sql_insert = $conn->prepare("INSERT INTO current_address (
                house_number, village, lane, road, sub_district, district, province, postal_code, User_ID
            ) VALUES (
                :house_number, :village, :lane, :road, :sub_district, :district, :province, :postal_code, :user_id
            )");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->bindParam(':house_number', $house_number);
            $sql_insert->bindParam(':village', $village);
            $sql_insert->bindParam(':lane', $lane);
            $sql_insert->bindParam(':road', $road);
            $sql_insert->bindParam(':sub_district', $sub_district);
            $sql_insert->bindParam(':district', $district);
            $sql_insert->bindParam(':province', $province);
            $sql_insert->bindParam(':postal_code', $postal_code);
            $sql_insert->bindParam(':user_id', $user_id);
            $sql_insert->execute();
            
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE current_address SET
                house_number = :house_number,
                village = :village,
                lane = :lane,
                road = :road,
                sub_district = :sub_district,
                district = :district,
                province = :province,
                postal_code = :postal_code
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':house_number', $house_number);
            $sql_update->bindParam(':village', $village);
            $sql_update->bindParam(':lane', $lane);
            $sql_update->bindParam(':road', $road);
            $sql_update->bindParam(':sub_district', $sub_district);
            $sql_update->bindParam(':district', $district);
            $sql_update->bindParam(':province', $province);
            $sql_update->bindParam(':postal_code', $postal_code);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Education_info.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Current_address.php");
        exit();
    }
}
?>
