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

$transcript = $_FILES['transcript'];
$transcript2 = htmlspecialchars($_POST['transcript2']);
$house_registration = $_FILES['house_registration'];
$house_registration2 = htmlspecialchars($_POST['house_registration2']);
$id_card = $_FILES['id_card'];
$id_card2 = htmlspecialchars($_POST['id_card2']);




$uploadt = $_FILES['transcript']['name'];
if ($uploadt != '') {
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $transcript['name']);
    $fileActExt = strtolower(end($extension));
    $fileNewt = rand() . "." . $fileActExt;  // rand function create the rand number 
    $filePath = $target_dir . $fileNewt;

    if (in_array($fileActExt, $allow)) {
        if ($transcript['size'] > 0 && $transcript['error'] == 0) {
            move_uploaded_file($transcript['tmp_name'], $filePath);
        }
    }
} else {
    $fileNewt = $transcript2;
}

$uploadh = $_FILES['house_registration']['name'];
if ($uploadh != '') {
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $house_registration['name']);
    $fileActExt = strtolower(end($extension));
    $fileNewh = rand() . "." . $fileActExt;  // rand function create the rand number 
    $filePath = $target_dir . $fileNewh;

    if (in_array($fileActExt, $allow)) {
        if ($house_registration['size'] > 0 && $house_registration['error'] == 0) {
            move_uploaded_file($house_registration['tmp_name'], $filePath);
        }
    }
} else {
    $fileNewh = $house_registration2;
}

$uploadi = $_FILES['id_card']['name'];
if ($uploadi != '') {
    $allow = array('jpg', 'jpeg', 'png');
    $extension = explode('.', $id_card['name']);
    $fileActExt = strtolower(end($extension));
    $fileNewi = rand() . "." . $fileActExt;  // rand function create the rand number 
    $filePath = $target_dir . $fileNewi;

    if (in_array($fileActExt, $allow)) {
        if ($id_card['size'] > 0 && $id_card['error'] == 0) {
            move_uploaded_file($id_card['tmp_name'], $filePath);
        }
    }
} else {
    $fileNewi = $id_card2;
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
    $sql_update = $conn->prepare("UPDATE form 
        SET transcript = :transcript, 
            id_card = :id_card, 
            house_registration = :house_registration, 
            updated_at = NOW()
        WHERE User_ID = :user_id");

    // Bind parameters
    $sql_update->bindParam(':transcript', $fileNewt);
    $sql_update->bindParam(':id_card', $fileNewi);
    $sql_update->bindParam(':house_registration', $fileNewh);
    $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    $sql_update->execute();

    echo "ข้อมูลได้ถูกอัปเดตเรียบร้อยแล้ว";

    // ส่งการแจ้งเตือนผ่าน Line
    if ($applicant) {
        $message = "มีการสมัครเข้าศึกษาที่ C-TECH จากผู้ใช้: คุณ " . $applicant['name'] . " " . $applicant['lastname'] . 
                   " ประเภทของหลักสูตร: " . $applicant['CourseType_Name'] . 
                   " ระดับการศึกษา: " . $applicant['Level_Name'] . 
                   " ประเภทวิชา: " . $applicant['Type_Name'] . 
                   " สาขาวิชา: " . $applicant['Major_Name'] . 
                   " เมื่อเวลา: " . $applicant['updated_at'];
    
        $token = "oIWaEZLBganyA04ZGRTTHgnnT7aij2hMalEJ7dSeoQ3";  // ใส่ Access Token ของคุณที่นี่
        sendLineNotify($message, $token);
    } else {
        echo "ไม่พบข้อมูลการสมัครของผู้ใช้ที่มี User_ID นี้";
    }
    
} catch (PDOException $e) {
    echo "ข้อผิดพลาดในการอัปเดต: " . $e->getMessage();
}
