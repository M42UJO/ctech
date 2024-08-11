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
    $mother_name = htmlspecialchars($_POST['mother_name']);
    $mother_status = htmlspecialchars($_POST['mother_status']);
    $mother_occupation = htmlspecialchars($_POST['mother_occupation']);
    $mother_income = htmlspecialchars($_POST['mother_income']);
    $mother_house_number = htmlspecialchars($_POST['mother_house_number']);
    $mother_village = htmlspecialchars($_POST['mother_village']);
    $mother_lane = htmlspecialchars($_POST['mother_lane']);
    $mother_road = htmlspecialchars($_POST['mother_road']);
    $mother_sub_district = htmlspecialchars($_POST['mother_sub_district']);
    $mother_district = htmlspecialchars($_POST['mother_district']);
    $mother_province = htmlspecialchars($_POST['mother_province']);
    $mother_postal_code = htmlspecialchars($_POST['mother_postal_code']);
    $mother_phone_number = htmlspecialchars($_POST['mother_phone_number']);

    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM parent_info WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ายังไม่มีที่อยู่ของผู้ใช้, ทำการแทรกข้อมูลใหม่ลงในฐานข้อมูล
            $sql_insert = $conn->prepare("INSERT INTO parent_info (
                mother_name, mother_status, mother_occupation, mother_income, 
                mother_house_number, mother_village, mother_lane, mother_road, 
                mother_sub_district, mother_district, mother_province, mother_postal_code, 
                mother_phone_number, User_ID
            ) VALUES (
                :mother_name, :mother_status, :mother_occupation, :mother_income, 
                :mother_house_number, :mother_village, :mother_lane, :mother_road, 
                :mother_sub_district, :mother_district, :mother_province, :mother_postal_code, 
                :mother_phone_number, :user_id
            )");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->bindParam(':mother_name', $mother_name);
            $sql_insert->bindParam(':mother_status', $mother_status);
            $sql_insert->bindParam(':mother_occupation', $mother_occupation);
            $sql_insert->bindParam(':mother_income', $mother_income);
            $sql_insert->bindParam(':mother_house_number', $mother_house_number);
            $sql_insert->bindParam(':mother_village', $mother_village);
            $sql_insert->bindParam(':mother_lane', $mother_lane);
            $sql_insert->bindParam(':mother_road', $mother_road);
            $sql_insert->bindParam(':mother_sub_district', $mother_sub_district);
            $sql_insert->bindParam(':mother_district', $mother_district);
            $sql_insert->bindParam(':mother_province', $mother_province);
            $sql_insert->bindParam(':mother_postal_code', $mother_postal_code);
            $sql_insert->bindParam(':mother_phone_number', $mother_phone_number);
            $sql_insert->bindParam(':user_id', $user_id);
            $sql_insert->execute();
            
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE parent_info SET
                mother_name = :mother_name,
                mother_status = :mother_status,
                mother_occupation = :mother_occupation,
                mother_income = :mother_income,
                mother_house_number = :mother_house_number,
                mother_village = :mother_village,
                mother_lane = :mother_lane,
                mother_road = :mother_road,
                mother_sub_district = :mother_sub_district,
                mother_district = :mother_district,
                mother_province = :mother_province,
                mother_postal_code = :mother_postal_code,
                mother_phone_number = :mother_phone_number
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':mother_name', $mother_name);
            $sql_update->bindParam(':mother_status', $mother_status);
            $sql_update->bindParam(':mother_occupation', $mother_occupation);
            $sql_update->bindParam(':mother_income', $mother_income);
            $sql_update->bindParam(':mother_house_number', $mother_house_number);
            $sql_update->bindParam(':mother_village', $mother_village);
            $sql_update->bindParam(':mother_lane', $mother_lane);
            $sql_update->bindParam(':mother_road', $mother_road);
            $sql_update->bindParam(':mother_sub_district', $mother_sub_district);
            $sql_update->bindParam(':mother_district', $mother_district);
            $sql_update->bindParam(':mother_province', $mother_province);
            $sql_update->bindParam(':mother_postal_code', $mother_postal_code);
            $sql_update->bindParam(':mother_phone_number', $mother_phone_number);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Parent_info.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Mather_info.php");
        exit();
    }
}
?>
