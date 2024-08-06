<?php
session_start();
require_once("db.php");

$isLoggedIn = isset($_SESSION['user_login']);

if ($isLoggedIn) {
    $user_id = $_SESSION['user_login'];
    try {
        $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $errorMessage = "Error: " . htmlspecialchars($e->getMessage());
        echo $errorMessage; // เพิ่มการแสดงข้อผิดพลาด
    }
}

if (isset($_POST['submit'])) {
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

    // การจัดการไฟล์ภาพ
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = ['jpg', 'jpeg'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = 'uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_image = $dest_path;
            }
        }
    }

    try {
        $sql = $conn->prepare("INSERT INTO applicant (
            prefix, name, lastname, eng_name, id_card_number, nickname, birth_day, birth_month, birth_year, 
            blood_group, height, weight, nationality, citizenship, religion, siblings_count, studying_siblings_count, 
            phone_number, line_id, facebook, profile_image
        ) VALUES (
            :prefix, :name, :lastname, :eng_name, :id_card_number, :nickname, :birth_day, :birth_month, :birth_year, 
            :blood_group, :height, :weight, :nationality, :citizenship, :religion, :siblings_count, :studying_siblings_count, 
            :phone_number, :line_id, :facebook, :profile_image
        )");

        // Bind parameters as before
        $sql->bindParam(':prefix', $prefix);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':lastname', $lastname);
        $sql->bindParam(':eng_name', $eng_name);
        $sql->bindParam(':id_card_number', $id_card_number);
        $sql->bindParam(':nickname', $nickname);
        $sql->bindParam(':birth_day', $birth_day);
        $sql->bindParam(':birth_month', $birth_month);
        $sql->bindParam(':birth_year', $birth_year);
        $sql->bindParam(':blood_group', $blood_group);
        $sql->bindParam(':height', $height);
        $sql->bindParam(':weight', $weight);
        $sql->bindParam(':nationality', $nationality);
        $sql->bindParam(':citizenship', $citizenship);
        $sql->bindParam(':religion', $religion);
        $sql->bindParam(':siblings_count', $siblings_count);
        $sql->bindParam(':studying_siblings_count', $studying_siblings_count);
        $sql->bindParam(':phone_number', $phone_number);
        $sql->bindParam(':line_id', $line_id);
        $sql->bindParam(':facebook', $facebook);
        $sql->bindParam(':profile_image', $profile_image);

        $result = $sql->execute();

        if ($result) {
            $_SESSION['success'] = "Data has been inserted successfully";
            header("Location: ../Current_address.php");
            exit();
        } else {
            $_SESSION['error'] = "Data insertion failed";
            echo "Data insertion failed: " . $sql->errorInfo()[2];
            header("Location: ../Personal_info.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        echo "Database Error: " . $e->getMessage();
        header("Location: ../Personal_info.php");
        exit();
    }
}
