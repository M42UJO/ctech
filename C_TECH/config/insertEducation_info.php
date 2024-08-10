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
    $school_name = htmlspecialchars($_POST['school_name']);
    $school_sub_district = htmlspecialchars($_POST['school_sub_district']);
    $school_district = htmlspecialchars($_POST['school_district']);
    $school_province = htmlspecialchars($_POST['school_province']);
    $school_postal_code = htmlspecialchars($_POST['school_postal_code']);
    $graduation_year = htmlspecialchars($_POST['graduation_year']);
    $grade_result = htmlspecialchars($_POST['grade_result']);
    $class_level = htmlspecialchars($_POST['class_level']);
    $major = htmlspecialchars($_POST['major']);
    $degree_other = htmlspecialchars($_POST['degree_other']);
    $major_other = htmlspecialchars($_POST['major_other']);
    
    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM education_info WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE education_info SET
            school_name = :school_name,
            school_sub_district = :school_sub_district,
            school_district = :school_district,
            school_province = :school_province,
            school_postal_code = :school_postal_code,
            graduation_year = :graduation_year,
            grade_result = :grade_result,
            class_level = :class_level,
            major = :major,
            degree_other = :degree_other,
            major_other = :major_other
            WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':school_name', $school_name);
            $sql_update->bindParam(':school_sub_district', $school_sub_district);
            $sql_update->bindParam(':school_district', $school_district);
            $sql_update->bindParam(':school_province', $school_province);
            $sql_update->bindParam(':school_postal_code', $school_postal_code);
            $sql_update->bindParam(':graduation_year', $graduation_year);
            $sql_update->bindParam(':grade_result', $grade_result);
            $sql_update->bindParam(':class_level', $class_level);
            $sql_update->bindParam(':major', $major);
            $sql_update->bindParam(':degree_other', $degree_other);
            $sql_update->bindParam(':major_other', $major_other);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();

            
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE education_info SET
                school_name = :school_name,
                school_sub_district = :school_sub_district,
                school_district = :school_district,
                school_province = :school_province,
                school_postal_code = :school_postal_code,
                graduation_year = :graduation_year,
                grade_result = :grade_result,
                class_level = :class_level,
                major = :major
                degree_other = :degree_other
                major_other = :major_other
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':school_name', $school_name);
            $sql_update->bindParam(':school_sub_district', $school_sub_district);
            $sql_update->bindParam(':school_district', $school_district);
            $sql_update->bindParam(':school_province', $school_province);
            $sql_update->bindParam(':school_postal_code', $school_postal_code);
            $sql_update->bindParam(':graduation_year', $graduation_year);
            $sql_update->bindParam(':grade_result', $grade_result);
            $sql_update->bindParam(':class_level', $class_level);
            $sql_update->bindParam(':major', $major);
            $sql_update->bindParam(':degree_other', $degree_other);
            $sql_update->bindParam(':major_other', $major_other);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Father_info.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Education_info.php");
        exit();
    }
}
?>
