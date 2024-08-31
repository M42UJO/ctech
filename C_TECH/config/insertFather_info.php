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
    $father_name = htmlspecialchars($_POST['father_name']);
    $father_status = htmlspecialchars($_POST['father_status']);
    $father_occupation = htmlspecialchars($_POST['father_occupation']);
    $father_income = htmlspecialchars($_POST['father_income']);
    $father_house_number = htmlspecialchars($_POST['father_house_number']);
    $father_village = htmlspecialchars($_POST['father_village']);
    $father_lane = htmlspecialchars($_POST['father_lane']);
    $father_road = htmlspecialchars($_POST['father_road']);
    $father_sub_district = htmlspecialchars($_POST['father_sub_district']);
    $father_district = htmlspecialchars($_POST['father_district']);
    $father_province = htmlspecialchars($_POST['father_province']);
    $father_postal_code = htmlspecialchars($_POST['father_postal_code']);
    $father_phone_number = htmlspecialchars($_POST['father_phone_number']);

    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM parent_info WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ายังไม่มีที่อยู่ของผู้ใช้, ทำการแทรกข้อมูลใหม่ลงในฐานข้อมูล
            $sql_insert = $conn->prepare("INSERT INTO parent_info (
                father_name, father_status, father_occupation, father_income, 
                father_house_number, father_village, father_lane, father_road, 
                father_sub_district, father_district, father_province, father_postal_code, 
                father_phone_number, User_ID
            ) VALUES (
                :father_name, :father_status, :father_occupation, :father_income, 
                :father_house_number, :father_village, :father_lane, :father_road, 
                :father_sub_district, :father_district, :father_province, :father_postal_code, 
                :father_phone_number, :user_id
            )");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->bindParam(':father_name', $father_name);
            $sql_insert->bindParam(':father_status', $father_status);
            $sql_insert->bindParam(':father_occupation', $father_occupation);
            $sql_insert->bindParam(':father_income', $father_income);
            $sql_insert->bindParam(':father_house_number', $father_house_number);
            $sql_insert->bindParam(':father_village', $father_village);
            $sql_insert->bindParam(':father_lane', $father_lane);
            $sql_insert->bindParam(':father_road', $father_road);
            $sql_insert->bindParam(':father_sub_district', $father_sub_district);
            $sql_insert->bindParam(':father_district', $father_district);
            $sql_insert->bindParam(':father_province', $father_province);
            $sql_insert->bindParam(':father_postal_code', $father_postal_code);
            $sql_insert->bindParam(':father_phone_number', $father_phone_number);
            $sql_insert->bindParam(':user_id', $user_id);
            $sql_insert->execute();
            
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE parent_info SET
                father_name = :father_name,
                father_status = :father_status,
                father_occupation = :father_occupation,
                father_income = :father_income,
                father_house_number = :father_house_number,
                father_village = :father_village,
                father_lane = :father_lane,
                father_road = :father_road,
                father_sub_district = :father_sub_district,
                father_district = :father_district,
                father_province = :father_province,
                father_postal_code = :father_postal_code,
                father_phone_number = :father_phone_number
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':father_name', $father_name);
            $sql_update->bindParam(':father_status', $father_status);
            $sql_update->bindParam(':father_occupation', $father_occupation);
            $sql_update->bindParam(':father_income', $father_income);
            $sql_update->bindParam(':father_house_number', $father_house_number);
            $sql_update->bindParam(':father_village', $father_village);
            $sql_update->bindParam(':father_lane', $father_lane);
            $sql_update->bindParam(':father_road', $father_road);
            $sql_update->bindParam(':father_sub_district', $father_sub_district);
            $sql_update->bindParam(':father_district', $father_district);
            $sql_update->bindParam(':father_province', $father_province);
            $sql_update->bindParam(':father_postal_code', $father_postal_code);
            $sql_update->bindParam(':father_phone_number', $father_phone_number);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();;

            $sql_status_update = $conn->prepare("UPDATE form SET status = 'update' WHERE User_ID = ?");
            $sql_status_update->execute([$user_id]);
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Mother_info.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Father_info.php");
        exit();
    }
}
?>
