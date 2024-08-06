<?php
session_start();
require_once("db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
}

try {
    $stmt = $conn->prepare("SELECT * FROM applicant WHERE Applicant_ID = ?");
    $stmt->execute([$user_id]);
    $userData = $stmt->fetch();

    $address_id = $userData['Address_ID'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
        // ใช้ INSERT เพื่อเพิ่มข้อมูลใหม่
        $sql_insert = $conn->prepare("INSERT INTO current_address (
                Address_ID, Applicant_ID, house_number, village, lane, road, sub_district, district, province, postal_code
            ) VALUES (
                :address_id, :user_id, :house_number, :village, :lane, :road, :sub_district, :district, :province, :postal_code
            )");

        $sql_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql_insert->bindParam(':address_id', $address_id, PDO::PARAM_INT);
        $sql_insert->bindParam(':house_number', $house_number);
        $sql_insert->bindParam(':village', $village);
        $sql_insert->bindParam(':lane', $lane);
        $sql_insert->bindParam(':road', $road);
        $sql_insert->bindParam(':sub_district', $sub_district);
        $sql_insert->bindParam(':district', $district);
        $sql_insert->bindParam(':province', $province);
        $sql_insert->bindParam(':postal_code', $postal_code);
        $sql_insert->execute();

        // ตรวจสอบว่ามีการแทรกข้อมูลใหม่สำเร็จแล้วค่อยทำการอัพเดต
        if ($sql_insert->rowCount() > 0) {
            $sql_update = $conn->prepare("UPDATE current_address SET
                house_number = :house_number,
                village = :village,
                lane = :lane,
                road = :road,
                sub_district = :sub_district,
                district = :district,
                province = :province,
                postal_code = :postal_code
                WHERE Address_ID = :address_id");

            $sql_update->bindParam(':address_id', $address_id, PDO::PARAM_INT);
            $sql_update->bindParam(':house_number', $house_number);
            $sql_update->bindParam(':village', $village);
            $sql_update->bindParam(':lane', $lane);
            $sql_update->bindParam(':road', $road);
            $sql_update->bindParam(':sub_district', $sub_district);
            $sql_update->bindParam(':district', $district);
            $sql_update->bindParam(':province', $province);
            $sql_update->bindParam(':postal_code', $postal_code);
            $sql_update->execute();
        }

        $_SESSION['success'] = "Data has been inserted and updated successfully";
        header("Location: ../Education_info.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database Error: " . $e->getMessage();
        header("Location: ../Current_address.php");
        exit();
    }
}
?>
