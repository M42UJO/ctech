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
    $prefix = htmlspecialchars($_POST['prefix']);
    $name = htmlspecialchars($_POST['name']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $eng_name = htmlspecialchars($_POST['eng_name']);
    $id_card_number = htmlspecialchars($_POST['id_card_number']);
    $nickname = htmlspecialchars($_POST['nickname']);
    $birth_day = htmlspecialchars($_POST['birth_day']);
    $birth_month = htmlspecialchars($_POST['birth_month']);
    $birth_year = htmlspecialchars($_POST['birth_year']);
    $blood_group = htmlspecialchars($_POST['blood_group']);
    $height = htmlspecialchars($_POST['height']);
    $weight = htmlspecialchars($_POST['weight']);
    $nationality = htmlspecialchars($_POST['nationality']);
    $citizenship = htmlspecialchars($_POST['citizenship']);
    $religion = htmlspecialchars($_POST['religion']);
    $siblings_count = htmlspecialchars($_POST['siblings_count']);
    $studying_siblings_count = htmlspecialchars($_POST['studying_siblings_count']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $line_id = htmlspecialchars($_POST['line_id']);
    $facebook = htmlspecialchars($_POST['facebook']);
    $profile_image = htmlspecialchars($_POST['profile_image']); // รับค่า profile_image

    try {
        // ตรวจสอบว่ามีที่อยู่ของผู้ใช้ในฐานข้อมูลหรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM applicant WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {
            // ถ้ายังไม่มีที่อยู่ของผู้ใช้, ทำการแทรกข้อมูลใหม่ลงในฐานข้อมูล
            $sql_insert = $conn->prepare("INSERT INTO applicant (
                prefix, name, lastname, eng_name, id_card_number, nickname, birth_day, birth_month, birth_year, 
                blood_group, height, weight, nationality, citizenship, religion, siblings_count, studying_siblings_count, 
                phone_number, line_id, facebook, profile_image, User_ID
            ) VALUES (
                :prefix, :name, :lastname, :eng_name, :id_card_number, :nickname, :birth_day, :birth_month, :birth_year, 
                :blood_group, :height, :weight, :nationality, :citizenship, :religion, :siblings_count, :studying_siblings_count, 
                :phone_number, :line_id, :facebook, :profile_image, :user_id
            )");
            
            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->bindParam(':prefix', $prefix);
            $sql_insert->bindParam(':name', $name);
            $sql_insert->bindParam(':lastname', $lastname);
            $sql_insert->bindParam(':eng_name', $eng_name);
            $sql_insert->bindParam(':id_card_number', $id_card_number);
            $sql_insert->bindParam(':nickname', $nickname);
            $sql_insert->bindParam(':birth_day', $birth_day);
            $sql_insert->bindParam(':birth_month', $birth_month);
            $sql_insert->bindParam(':birth_year', $birth_year);
            $sql_insert->bindParam(':blood_group', $blood_group);
            $sql_insert->bindParam(':height', $height);
            $sql_insert->bindParam(':weight', $weight);
            $sql_insert->bindParam(':nationality', $nationality);
            $sql_insert->bindParam(':citizenship', $citizenship);
            $sql_insert->bindParam(':religion', $religion);
            $sql_insert->bindParam(':siblings_count', $siblings_count);
            $sql_insert->bindParam(':studying_siblings_count', $studying_siblings_count);
            $sql_insert->bindParam(':phone_number', $phone_number);
            $sql_insert->bindParam(':line_id', $line_id);
            $sql_insert->bindParam(':facebook', $facebook);
            $sql_insert->bindParam(':profile_image', $profile_image);
            $sql_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_insert->execute();
        } else {
            // ถ้ามีที่อยู่แล้ว, ทำการอัปเดตข้อมูลที่มีอยู่
            $sql_update = $conn->prepare("UPDATE applicant SET
            prefix = :prefix,
            name = :name,
            lastname = :lastname,
            eng_name = :eng_name,
            id_card_number = :id_card_number,
            nickname = :nickname,
            birth_day = :birth_day,
            birth_month = :birth_month,
            birth_year = :birth_year,
            blood_group = :blood_group,
            height = :height,
            weight = :weight,
            nationality = :nationality,
            citizenship = :citizenship,
            religion = :religion,
            siblings_count = :siblings_count,
            studying_siblings_count = :studying_siblings_count,
            phone_number = :phone_number,
            line_id = :line_id,
            facebook = :facebook,
            profile_image = :profile_image
            WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->bindParam(':prefix', $prefix);
            $sql_update->bindParam(':name', $name);
            $sql_update->bindParam(':lastname', $lastname);
            $sql_update->bindParam(':eng_name', $eng_name);
            $sql_update->bindParam(':id_card_number', $id_card_number);
            $sql_update->bindParam(':nickname', $nickname);
            $sql_update->bindParam(':birth_day', $birth_day);
            $sql_update->bindParam(':birth_month', $birth_month);
            $sql_update->bindParam(':birth_year', $birth_year);
            $sql_update->bindParam(':blood_group', $blood_group);
            $sql_update->bindParam(':height', $height);
            $sql_update->bindParam(':weight', $weight);
            $sql_update->bindParam(':nationality', $nationality);
            $sql_update->bindParam(':citizenship', $citizenship);
            $sql_update->bindParam(':religion', $religion);
            $sql_update->bindParam(':siblings_count', $siblings_count);
            $sql_update->bindParam(':studying_siblings_count', $studying_siblings_count);
            $sql_update->bindParam(':phone_number', $phone_number);
            $sql_update->bindParam(':line_id', $line_id);
            $sql_update->bindParam(':facebook', $facebook);
            $sql_update->bindParam(':profile_image', $profile_image);
            $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update->execute();
        }

        // กำหนดข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าข้อมูลการศึกษา
        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Current_address.php");
        exit();
    } catch (PDOException $e) {
        // กำหนดข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Personal_info.php");
        exit();
    }
}
?>
