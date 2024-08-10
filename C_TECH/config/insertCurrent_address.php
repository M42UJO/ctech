<?php
session_start();
require_once("db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_login'];

try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt->execute([$user_id]);
    $userData = $stmt->fetch();
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}

if (isset($_POST['submit'])) {
    $house_number = htmlspecialchars($_POST['house_number']);
    $village = htmlspecialchars($_POST['village']);
    $lane = htmlspecialchars($_POST['lane']);
    $road = htmlspecialchars($_POST['road']);
    $sub_district = htmlspecialchars($_POST['sub_district']);
    $district = htmlspecialchars($_POST['district']);
    $province = htmlspecialchars($_POST['province']);
    $postal_code = htmlspecialchars($_POST['postal_code']);

    try {
        // ตรวจสอบว่ามี Applicant_ID หรือไม่
        $stmt_check = $conn->prepare("SELECT User_ID FROM current_address WHERE User_ID = ?");
        $stmt_check->execute([$user_id]);
        $applicant = $stmt_check->fetch();

        if (!$applicant) {

            // Insert new address
            $sql_insert = $conn->prepare("INSERT INTO current_address (
                house_number, village, lane, road, sub_district, district, province, postal_code, User_ID
            ) VALUES (
                :house_number, :village, :lane, :road, :sub_district, :district, :province, :postal_code, :user_id
            )");

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

            // Get the last inserted Address_ID
           /* $address_id = $conn->lastInsertId();

            // Update applicant table with new Address_ID
            $sql_update_applicant = $conn->prepare("UPDATE applicant SET Address_ID = :address_id WHERE User_ID = :user_id");
            $sql_update_applicant->bindParam(':address_id', $address_id, PDO::PARAM_INT);
            $sql_update_applicant->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $sql_update_applicant->execute();*/

            
        } else {
            // Update existing address
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

        $_SESSION['success'] = "Data has been inserted or updated successfully";
        header("Location: ../Education_info.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Current_address.php");
        exit();
    }
}
?>
