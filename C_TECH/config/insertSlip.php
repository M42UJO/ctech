<?php
session_start();
require_once("../config/db.php");

// ตรวจสอบการเข้าสู่ระบบ
if (!isset($_SESSION['user_login'])) {
    header('Location: ../login.php');
    exit;
}
$user_id = $_SESSION['user_login'];
// ค้นหาผู้สมัครตาม user_id
$stmt = $conn->prepare("
    SELECT 
        u.*, 
        p.*, 
        f.*, 
        e.*, 
        c.*, 
        a.*,
        major.Major_Name,
        subjecttype.Type_Name,
        educationlevel.Level_Name,
        coursetype.CourseType_Name
    FROM 
        user u
    LEFT JOIN 
        parent_info p ON u.User_ID = p.User_ID
    LEFT JOIN 
        form f ON u.User_ID = f.User_ID
    LEFT JOIN 
        education_info e ON u.User_ID = e.User_ID
    LEFT JOIN 
        current_address c ON u.User_ID = c.User_ID
    LEFT JOIN 
        applicant a ON u.User_ID = a.User_ID
    LEFT JOIN 
        major ON f.Major_ID = major.Major_ID
    LEFT JOIN 
        subjecttype ON major.Type_ID = subjecttype.Type_ID
    LEFT JOIN 
        educationlevel ON subjecttype.Level_ID = educationlevel.Level_ID
    LEFT JOIN 
        coursetype ON educationlevel.CourseType_ID = coursetype.CourseType_ID
    WHERE 
        u.User_ID = :user_id
");

// กำหนดค่าให้กับตัวแปรใน SQL
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

// ดึงข้อมูลของผู้สมัครจากผลลัพธ์
$applicant = $stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลเพียงแถวเดียว


// ตั้งค่าตำแหน่งเก็บไฟล์
$target_dir = "uploads/";


$slip2000 = $_FILES['slip2000'];
$slip20002 = htmlspecialchars($_POST['slip20002']);





$uploads = $_FILES['slip2000']['name'];
if ($uploads != '') {
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $slip2000['name']);
    $fileActExt = strtolower(end($extension));
    $fileNews = rand() . "." . $fileActExt;  // rand function create the rand number 
    $filePath = $target_dir . $fileNews;

    if (in_array($fileActExt, $allow)) {
        if ($slip2000['size'] > 0 && $slip2000['error'] == 0) {
            move_uploaded_file($slip2000['tmp_name'], $filePath);
        }
    }
} else {
    $fileNews = $slip20002;
}

// ฟังก์ชันสำหรับส่งการแจ้งเตือนผ่าน Line Notify
function sendLineNotify($message, $token)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://notify-api.line.me/api/notify");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "message=" . $message);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $headers = array("Content-type: application/x-www-form-urlencoded", "Authorization: Bearer " . $token);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

try {
    // Prepare the SQL update statement
    $sql_update = $conn->prepare("UPDATE form 
        SET slip2000 = :slip2000,
            status_slip = 'pending',
            updated_slip_at = NOW()
        WHERE User_ID = :user_id");

    // Bind parameters
    $sql_update->bindParam(':slip2000', $fileNews);
    $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Execute the update statement
    $sql_update->execute();

    // Send Line notification
    if ($applicant) {
        $message = "มีการเพิ่มหลักฐานการชำระค่าแรกเข้า (Slip) ที่ C-TECH จากผู้ใช้: คุณ " . $applicant['name'] . " " . $applicant['lastname'] . 
                   " ประเภทของหลักสูตร: " . $applicant['CourseType_Name'] . 
                   " ระดับการศึกษา: " . $applicant['Level_Name'] . 
                   " ประเภทวิชา: " . $applicant['Type_Name'] . 
                   " สาขาวิชา: " . $applicant['Major_Name'];

        $token = "oIWaEZLBganyA04ZGRTTHgnnT7aij2hMalEJ7dSeoQ3";  // Insert your access token here
        sendLineNotify($message, $token);
    } else {
        $_SESSION['upload_status'] = 'error'; // Set session variable for error notification
        echo "ไม่พบข้อมูลการสมัครของผู้ใช้ที่มี User_ID นี้";
        exit();
    }

    $_SESSION['upload_status'] = 'success'; // Set session variable for success notification
    header('Location: ../checkstatus.php');
    exit();

} catch (PDOException $e) {
    $_SESSION['upload_status'] = 'error'; // Set session variable for error notification
    echo "ข้อผิดพลาดในการอัปเดต: " . $e->getMessage();
    exit();
}

