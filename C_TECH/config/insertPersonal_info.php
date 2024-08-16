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
                phone_number, line_id, facebook, User_ID
            ) VALUES (
                :prefix, :name, :lastname, :eng_name, :id_card_number, :nickname, :birth_day, :birth_month, :birth_year, 
                :blood_group, :height, :weight, :nationality, :citizenship, :religion, :siblings_count, :studying_siblings_count, 
                :phone_number, :line_id, :facebook, :user_id
            )");
            
            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_insert->execute([
                ':prefix' => $prefix,
                ':name' => $name,
                ':lastname' => $lastname,
                ':eng_name' => $eng_name,
                ':id_card_number' => $id_card_number,
                ':nickname' => $nickname,
                ':birth_day' => $birth_day,
                ':birth_month' => $birth_month,
                ':birth_year' => $birth_year,
                ':blood_group' => $blood_group,
                ':height' => $height,
                ':weight' => $weight,
                ':nationality' => $nationality,
                ':citizenship' => $citizenship,
                ':religion' => $religion,
                ':siblings_count' => $siblings_count,
                ':studying_siblings_count' => $studying_siblings_count,
                ':phone_number' => $phone_number,
                ':line_id' => $line_id,
                ':facebook' => $facebook,
                ':user_id' => $user_id
            ]);
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
                facebook = :facebook
                WHERE User_ID = :user_id");

            // ผูกค่าพารามิเตอร์กับตัวแปร
            $sql_update->execute([
                ':prefix' => $prefix,
                ':name' => $name,
                ':lastname' => $lastname,
                ':eng_name' => $eng_name,
                ':id_card_number' => $id_card_number,
                ':nickname' => $nickname,
                ':birth_day' => $birth_day,
                ':birth_month' => $birth_month,
                ':birth_year' => $birth_year,
                ':blood_group' => $blood_group,
                ':height' => $height,
                ':weight' => $weight,
                ':nationality' => $nationality,
                ':citizenship' => $citizenship,
                ':religion' => $religion,
                ':siblings_count' => $siblings_count,
                ':studying_siblings_count' => $studying_siblings_count,
                ':phone_number' => $phone_number,
                ':line_id' => $line_id,
                ':facebook' => $facebook,
                ':user_id' => $user_id
            ]);
        }

        // ตั้งค่าตำแหน่งเก็บไฟล์
        $target_dir = "uploads/";
        $file_paths = [];
        $uploadOk = 1;

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $profile_image = $_FILES['profile_image'];
            $allow = array('jpg', 'jpeg', 'png');
            $file_extension = strtolower(pathinfo($profile_image['name'], PATHINFO_EXTENSION));
            $fileNew = uniqid() . "." . $file_extension;  // สร้างชื่อไฟล์ที่ไม่ซ้ำ
            $filePath = $target_dir . $fileNew;

            if (in_array($file_extension, $allow)) {
                if ($profile_image['size'] > 0 && $profile_image['error'] == 0) {
                    if (move_uploaded_file($profile_image['tmp_name'], $filePath)) {
                        $file_paths['profile_image'] = htmlspecialchars($fileNew);
                    } else {
                        echo "เกิดข้อผิดพลาดในการอัปโหลดไฟล์ profile_image.";
                        $uploadOk = 0;
                    }
                }
            } else {
                echo "ไฟล์ต้องเป็น JPG, JPEG หรือ PNG เท่านั้น.";
                $uploadOk = 0;
            }
        }

        // บันทึกข้อมูลไฟล์ลงในฐานข้อมูลถ้ามีการอัปโหลดไฟล์สำเร็จ
        if ($uploadOk == 1 && !empty($file_paths)) {
            try {
                $sql = "UPDATE applicant 
                        SET profile_image = :profile_image 
                        WHERE User_ID = :user_id";
                $stmt = $conn->prepare($sql);

                $stmt->execute([
                    ':profile_image' => $file_paths['profile_image'] ?? null,
                    ':user_id' => $user_id
                ]);

                echo "ข้อมูลและไฟล์ได้ถูกอัปเดตเรียบร้อยแล้ว.";
            } catch (PDOException $e) {
                echo "Database Error: " . htmlspecialchars($e->getMessage());
            }
        } else {
            echo "ไฟล์ไม่ได้ถูกอัปโหลด.";
        }

        // ตั้งข้อความสำเร็จในเซสชันและเปลี่ยนเส้นทางไปยังหน้าที่ต้องการ
        $_SESSION['success'] = "Data and files have been inserted or updated successfully";
        header("Location: ../Current_address.php");
        exit();
    } catch (PDOException $e) {
        // ตั้งข้อความข้อผิดพลาดในเซสชันและเปลี่ยนเส้นทางกลับไปที่หน้าที่อยู่ปัจจุบัน
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Personal_info.php");
        exit();
    }
}

$conn = null; // ปิดการเชื่อมต่อฐานข้อมูล
?>
