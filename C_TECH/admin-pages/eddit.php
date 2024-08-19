<?php
session_start();
require_once("../config/db.php");

if (isset($_POST['update'])) {
    try {
        // Start a transaction
        $conn->beginTransaction();

        // Applicant Table Update
        $applicant_query = "UPDATE applicant SET 
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
            WHERE User_ID = :user_id";

        $applicant_stmt = $conn->prepare($applicant_query);
        $applicant_stmt->execute([
            ':prefix' => htmlspecialchars($_POST['prefix']),
            ':name' => htmlspecialchars($_POST['name']),
            ':lastname' => htmlspecialchars($_POST['lastname']),
            ':eng_name' => htmlspecialchars($_POST['eng_name']),
            ':id_card_number' => htmlspecialchars($_POST['id_card_number']),
            ':nickname' => htmlspecialchars($_POST['nickname']),
            ':birth_day' => htmlspecialchars($_POST['birth_day']),
            ':birth_month' => htmlspecialchars($_POST['birth_month']),
            ':birth_year' => htmlspecialchars($_POST['birth_year']),
            ':blood_group' => htmlspecialchars($_POST['blood_group']),
            ':height' => htmlspecialchars($_POST['height']),
            ':weight' => htmlspecialchars($_POST['weight']),
            ':nationality' => htmlspecialchars($_POST['nationality']),
            ':citizenship' => htmlspecialchars($_POST['citizenship']),
            ':religion' => htmlspecialchars($_POST['religion']),
            ':siblings_count' => htmlspecialchars($_POST['siblings_count']),
            ':studying_siblings_count' => htmlspecialchars($_POST['studying_siblings_count']),
            ':phone_number' => htmlspecialchars($_POST['phone_number']),
            ':line_id' => htmlspecialchars($_POST['line_id']),
            ':facebook' => htmlspecialchars($_POST['facebook']),
            ':user_id' => $_SESSION['user_id']
        ]);

        // Current Address Table Update
        $current_address_query = "UPDATE current_address SET 
            house_number = :house_number,
            village = :village,
            lane = :lane,
            road = :road,
            sub_district = :sub_district,
            district = :district,
            province = :province,
            postal_code = :postal_code
            WHERE User_ID = :user_id";

        $current_address_stmt = $conn->prepare($current_address_query);
        $current_address_stmt->execute([
            ':house_number' => htmlspecialchars($_POST['house_number']),
            ':village' => htmlspecialchars($_POST['village']),
            ':lane' => htmlspecialchars($_POST['lane']),
            ':road' => htmlspecialchars($_POST['road']),
            ':sub_district' => htmlspecialchars($_POST['sub_district']),
            ':district' => htmlspecialchars($_POST['district']),
            ':province' => htmlspecialchars($_POST['province']),
            ':postal_code' => htmlspecialchars($_POST['postal_code']),
            ':user_id' => $_SESSION['user_id']
        ]);

        // Education Info Table Update
        $education_info_query = "UPDATE education_info SET 
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
            WHERE User_ID = :user_id";

        $education_info_stmt = $conn->prepare($education_info_query);
        $education_info_stmt->execute([
            ':school_name' => htmlspecialchars($_POST['school_name']),
            ':school_sub_district' => htmlspecialchars($_POST['school_sub_district']),
            ':school_district' => htmlspecialchars($_POST['school_district']),
            ':school_province' => htmlspecialchars($_POST['school_province']),
            ':school_postal_code' => htmlspecialchars($_POST['school_postal_code']),
            ':graduation_year' => htmlspecialchars($_POST['graduation_year']),
            ':grade_result' => htmlspecialchars($_POST['grade_result']),
            ':class_level' => htmlspecialchars($_POST['class_level']),
            ':major' => htmlspecialchars($_POST['major']),
            ':degree_other' => htmlspecialchars($_POST['degree_other']),
            ':major_other' => htmlspecialchars($_POST['major_other']),
            ':user_id' => $_SESSION['user_id']
        ]);

        // Parent Info (Father, Mother, Guardian) Table Updates
        $parent_info_query = "UPDATE parent_info SET 
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
            father_phone_number = :father_phone_number,
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
            mother_phone_number = :mother_phone_number,
            guardian_name = :guardian_name,
            guardian_relationship = :guardian_relationship,
            guardian_house_number = :guardian_house_number,
            guardian_village = :guardian_village,
            guardian_lane = :guardian_lane,
            guardian_road = :guardian_road,
            guardian_sub_district = :guardian_sub_district,
            guardian_district = :guardian_district,
            guardian_province = :guardian_province,
            guardian_postal_code = :guardian_postal_code,
            guardian_phone_number = :guardian_phone_number
            WHERE User_ID = :user_id";

        $parent_info_stmt = $conn->prepare($parent_info_query);
        $parent_info_stmt->execute([
            ':father_name' => htmlspecialchars($_POST['father_name']),
            ':father_status' => htmlspecialchars($_POST['father_status']),
            ':father_occupation' => htmlspecialchars($_POST['father_occupation']),
            ':father_income' => htmlspecialchars($_POST['father_income']),
            ':father_house_number' => htmlspecialchars($_POST['father_house_number']),
            ':father_village' => htmlspecialchars($_POST['father_village']),
            ':father_lane' => htmlspecialchars($_POST['father_lane']),
            ':father_road' => htmlspecialchars($_POST['father_road']),
            ':father_sub_district' => htmlspecialchars($_POST['father_sub_district']),
            ':father_district' => htmlspecialchars($_POST['father_district']),
            ':father_province' => htmlspecialchars($_POST['father_province']),
            ':father_postal_code' => htmlspecialchars($_POST['father_postal_code']),
            ':father_phone_number' => htmlspecialchars($_POST['father_phone_number']),
            ':mother_name' => htmlspecialchars($_POST['mother_name']),
            ':mother_status' => htmlspecialchars($_POST['mother_status']),
            ':mother_occupation' => htmlspecialchars($_POST['mother_occupation']),
            ':mother_income' => htmlspecialchars($_POST['mother_income']),
            ':mother_house_number' => htmlspecialchars($_POST['mother_house_number']),
            ':mother_village' => htmlspecialchars($_POST['mother_village']),
            ':mother_lane' => htmlspecialchars($_POST['mother_lane']),
            ':mother_road' => htmlspecialchars($_POST['mother_road']),
            ':mother_sub_district' => htmlspecialchars($_POST['mother_sub_district']),
            ':mother_district' => htmlspecialchars($_POST['mother_district']),
            ':mother_province' => htmlspecialchars($_POST['mother_province']),
            ':mother_postal_code' => htmlspecialchars($_POST['mother_postal_code']),
            ':mother_phone_number' => htmlspecialchars($_POST['mother_phone_number']),
            ':guardian_name' => htmlspecialchars($_POST['guardian_name']),
            ':guardian_relationship' => htmlspecialchars($_POST['guardian_relationship']),
            ':guardian_house_number' => htmlspecialchars($_POST['guardian_house_number']),
            ':guardian_village' => htmlspecialchars($_POST['guardian_village']),
            ':guardian_lane' => htmlspecialchars($_POST['guardian_lane']),
            ':guardian_road' => htmlspecialchars($_POST['guardian_road']),
            ':guardian_sub_district' => htmlspecialchars($_POST['guardian_sub_district']),
            ':guardian_district' => htmlspecialchars($_POST['guardian_district']),
            ':guardian_province' => htmlspecialchars($_POST['guardian_province']),
            ':guardian_postal_code' => htmlspecialchars($_POST['guardian_postal_code']),
            ':guardian_phone_number' => htmlspecialchars($_POST['guardian_phone_number']),
            ':user_id' => $_SESSION['user_id']
        ]);

        // Commit transaction if all queries were successful
        $conn->commit();
        echo "<script>alert('Data updated successfully');</script>";
        echo "<script>window.location.href = 'my_profile.php';</script>";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollBack();
        echo "<script>alert('Error updating data: " . $e->getMessage() . "');</script>";
        echo "<script>window.location.href = 'my_profile.php';</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark navbar-custom">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="indexadmin.php">Admin C-TECH</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="indexadmin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="edituser.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            Editusers
                        </a>



                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>

                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">

            <!-- mainnnnnnnnnnnnnnnnnnnnnnnnn -->

            <main>
                <div class="container-fluid px-4">
                    <h1 class="">Edit data</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Edit data</li>
                    </ol>
                    <div class="panel panel-default mb-5">

                        <div class="panel-body">

                            <form id="personal-info-form" class="row g-3 mt-2" action="eddit.php" method="post" enctype="multipart/form-data">

                                <?php
                                if (isset($_GET['user_id'])) {
                                    $User_ID = $_GET['user_id'];

                                    $stmt = $conn->prepare("SELECT 
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

                                    $stmt->bindParam(':user_id', $User_ID, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $Data_view = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                ?>




                                <div class="panel-heading">ข้อมูลส่วนตัว</div>
                                <div class="col-md-2">
                                    <label for="prefix" class="form-label">คำนำหน้า <span class="required">**</span></label>
                                    <select id="prefix" class="form-select" name="prefix" required>
                                        <option value="">==เลือก==</option>
                                        <option value="Mr" <?php echo ($Data_view["prefix"] == "Mr") ? 'selected' : ''; ?>>นาย</option>
                                        <option value="Mrs" <?php echo ($Data_view["prefix"] == "Mrs") ? 'selected' : ''; ?>>นาง</option>
                                        <option value="Ms" <?php echo ($Data_view["prefix"] == "Ms") ? 'selected' : ''; ?>>นางสาว</option>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <label for="first-name" class="form-label">ชื่อ <span class="required">**</span></label>
                                    <input type="text" id="first-name" class="form-control" placeholder="ชื่อ" name="name" value="<?php echo $Data_view["name"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="last-name" class="form-label">สกุล <span class="required">**</span></label>
                                    <input type="text" id="last-name" class="form-control" placeholder="สกุล" name="lastname" value="<?php echo $Data_view["lastname"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="full-name-eng" class="form-label">ชื่อ - สกุล อังกฤษ <span class="required">**</span></label>
                                    <input type="text" id="full-name-eng" class="form-control" placeholder="ชื่อ - สกุล อังกฤษ" name="eng_name" value="<?php echo $Data_view["eng_name"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="id-number" class="form-label">เลขบัตรประชาชน <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text" class="form-control" id="thai-id" maxlength="17" placeholder="x-xxxx-xxxxx-xx-x" name="id_card_number" value="<?php echo $Data_view["id_card_number"]; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="nickname" class="form-label">ชื่อเล่น</label>
                                    <input type="text" id="nickname" class="form-control" placeholder="ชื่อเล่น" name="nickname" value="<?php echo $Data_view["nickname"]; ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="birth_day" class="form-label">วันเกิด <span class="required">**</span></label>
                                    <select id="birth_day" class="form-select" name="birth_day" required>
                                        <option value="">==เลือก==</option>
                                        <?php
                                        for ($i = 1; $i <= 31; $i++) {
                                            $selected = ($Data_view["birth_day"] == $i) ? 'selected' : '';
                                            echo "<option value=\"$i\" $selected>$i</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-2">
                                    <label for="birth-month" class="form-label">เดือนเกิด <span class="required">**</span></label>
                                    <select id="birth-month" class="form-select" name="birth_month" required>
                                        <option value="">==เลือก==</option>
                                        <?php
                                        $months = [
                                            "01" => "มกราคม",
                                            "02" => "กุมภาพันธ์",
                                            "03" => "มีนาคม",
                                            "04" => "เมษายน",
                                            "05" => "พฤษภาคม",
                                            "06" => "มิถุนายน",
                                            "07" => "กรกฎาคม",
                                            "08" => "สิงหาคม",
                                            "09" => "กันยายน",
                                            "10" => "ตุลาคม",
                                            "11" => "พฤศจิกายน",
                                            "12" => "ธันวาคม"
                                        ];

                                        foreach ($months as $value => $label) {
                                            $selected = ($Data_view["birth_month"] == $value) ? 'selected' : '';
                                            echo "<option value=\"$value\" $selected>$label</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-2">
                                    <label for="birth-year" class="form-label">ปีเกิด <span class="required">**</span></label>
                                    <select id="birth-year" class="form-select" name="birth_year" required>
                                        <option value="">==เลือก==</option>
                                        <?php
                                        $currentYear = date("Y") + 543; // ปีปัจจุบันในปฏิทินไทย
                                        $startYear = 2510; // ปีเริ่มต้นที่ต้องการแสดง
                                        $endYear = 2560; // ปีสิ้นสุดที่ต้องการแสดง

                                        for ($year = $currentYear; $year >= $startYear; $year--) {
                                            $selected = ($Data_view["birth_year"] == $year) ? 'selected' : '';
                                            echo "<option value=\"$year\" $selected>$year</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-2">
                                    <label for="blood-group" class="form-label">กรุ๊ปเลือด <span class="required">**</span></label>
                                    <select id="blood-group" class="form-select" name="blood_group" required>
                                        <option value="">==เลือก==</option>
                                        <option value="A" <?php echo ($Data_view["blood_group"] == "A") ? 'selected' : ''; ?>>A</option>
                                        <option value="B" <?php echo ($Data_view["blood_group"] == "B") ? 'selected' : ''; ?>>B</option>
                                        <option value="AB" <?php echo ($Data_view["blood_group"] == "AB") ? 'selected' : ''; ?>>AB</option>
                                        <option value="O" <?php echo ($Data_view["blood_group"] == "O") ? 'selected' : ''; ?>>O</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="height" class="form-label">ส่วนสูง <span class="required">**</span></label>
                                    <input type="number" id="height" class="form-control" min="0" placeholder="ส่วนสูง" name="height" value="<?php echo $Data_view["height"]; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="weight" class="form-label">น้ำหนัก <span class="required">**</span></label>
                                    <input type="number" id="weight" class="form-control" min="0" placeholder="น้ำหนัก" name="weight" value="<?php echo $Data_view["weight"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="nationality" class="form-label">เชื้อชาติ <span class="required">**</span></label>
                                    <input type="text" id="nationality" class="form-control" placeholder="เชื้อชาติ" name="nationality" value="<?php echo $Data_view["nationality"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="citizenship" class="form-label">สัญชาติ <span class="required">**</span></label>
                                    <input type="text" id="citizenship" class="form-control" placeholder="สัญชาติ" name="citizenship" value="<?php echo $Data_view["citizenship"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="religion" class="form-label">ศาสนา <span class="required">**</span></label>
                                    <input type="text" id="religion" class="form-control" placeholder="ศาสนา" name="religion" value="<?php echo $Data_view["religion"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="siblings" class="form-label">จำนวนพี่น้อง <span class="required">**</span></label>
                                    <input type="number" id="siblings" class="form-control" min="0" placeholder="จำนวนพี่น้อง" name="siblings_count" value="<?php echo $Data_view["siblings_count"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="current-siblings" class="form-label">จำนวนพี่น้องที่กำลังศึกษาอยู่ <span class="required">**</span></label>
                                    <input type="number" id="current-siblings" class="form-control" min="0" placeholder="จำนวนพี่น้องที่กำลังศึกษาอยู่" name="studying_siblings_count" value="<?php echo $Data_view["studying_siblings_count"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">เบอร์โทร <span class="required">**</span></label>
                                    <input type="tel" id="phone" class="form-control" name="phone_number" value="<?php echo $Data_view["phone_number"]; ?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="xxx-xxx-xxxx">
                                </div>
                                <div class="col-md-3">
                                    <label for="line-id" class="form-label">LineID</label>
                                    <input type="text" id="line-id" class="form-control" placeholder="LineID" name="line_id" value="<?php echo $Data_view["line_id"]; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" id="facebook" class="form-control" placeholder="Facebook" name="facebook" value="<?php echo $Data_view["facebook"]; ?>">
                                    <input type="text" hidden class="form-control" name="User_ID" value="<?php echo $Data_view["User_ID"]; ?>">
                                    
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">รูปภาพ 1 นิ้วครึ่ง <span class="required">** .jpg เท่านั้น</span></label>
                                    <input type="file" id="imgInput" class="form-control" name="profile_image" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg" src="../config/uploads/<?php echo $Data_view["profile_image"]; ?>" width="50%" alt="">
                                    <input type="hidden" class="form-control" name="profile_image2" value="<?php echo $Data_view["profile_image"]; ?>">
                                </div>




                                <div class="panel-heading mt-5">ที่อยู่ปัจจุบัน</div>
                                <div class="col-md-2">
                                    <label class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="house_number" value="<?php echo $Data_view["house_number"]; ?>" required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">หมู่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="หมู่ " name="village" value="<?php echo $Data_view["village"]; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ซอย </label>
                                    <input class="form-control " type="text " placeholder="ซอย " name="lane" value="<?php echo $Data_view["lane"]; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ถนน </label>
                                    <input class="form-control " type="text " placeholder="ถนน " name="road" value="<?php echo $Data_view["road"]; ?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ตำบล <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ตำบล " name="sub_district" value="<?php echo $Data_view["sub_district"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">อำเภอ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อำเภอ " name="district" value="<?php echo $Data_view["district"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">จังหวัด <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จังหวัด " name="province" value="<?php echo $Data_view["province"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="postal_code" maxlength="5" value="<?php echo $Data_view["postal_code"]; ?>" required>
                                </div>







                                <div class="panel-heading mt-5">ข้อมูลการศึกษา</div>
                                <div class="col-md-8">
                                    <label class="form-label">จบจากโรงเรียน <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="จบจากโรงเรียน " name="school_name" value="<?php echo $Data_view["school_name"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">ตำบล <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ตำบล " name="school_sub_district" value="<?php echo $Data_view["school_sub_district"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">อำเภอ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อำเภอ " name="school_district" value="<?php echo $Data_view["school_district"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">จังหวัด <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จังหวัด " name="school_province" value="<?php echo $Data_view["school_province"]; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="school_postal_code" value="<?php echo $Data_view["school_postal_code"]; ?>" maxlength="5 " required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">จบเมื่อ พ.ศ. <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จบเมื่อ พ.ศ. " name="graduation_year" value="<?php echo $Data_view["graduation_year"]; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">ผลการเรียน <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ผลการเรียน " name="grade_result" value="<?php echo $Data_view["grade_result"]; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">ระดับชั้น <span class="required">**</span></label>
                                    <select class="form-select" name="class_level" required>
                                        <option value="">==เลือก==</option>
                                        <option value="ม.3" <?php echo ($Data_view["class_level"] == "ม.3") ? 'selected' : ''; ?>>ม.3</option>
                                        <option value="ม.6" <?php echo ($Data_view["class_level"] == "ม.6") ? 'selected' : ''; ?>>ม.6</option>
                                        <option value="ปวช." <?php echo ($Data_view["class_level"] == "ปวช.") ? 'selected' : ''; ?>>ปวช.</option>
                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">สาขาวิชา </label>
                                    <input type="text " class="form-control " placeholder="สาขาวิชา" name="major" value="<?php echo $Data_view["major"]; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">วุฒิการศึกษาอื่นๆ </label>
                                    <input type="text " class="form-control " placeholder="วุฒิการศึกษาอื่นๆ" name="degree_other" value="<?php echo $Data_view["degree_other"]; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">สาขาวิชา </label>
                                    <input type="text " class="form-control " placeholder="สาขาวิชา " name="major_other" value="<?php echo $Data_view["major_other"]; ?>">
                                </div>







                                <div class="panel-heading mt-5">ข้อมูลบิดา</div>
                                <div class="col-md-4">
                                    <label class="form-label">บิดาชื่อ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="บิดาชื่อ" name="father_name" value="<?php echo $Data_view["father_name"]; ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">สถานะ <span class="required">**</span></label>
                                    <select class="form-control" name="father_status" required>
                                        <option value="">==เลือก==</option>
                                        <option value="มีชีวิต" <?php echo ($Data_view["father_status"] == "มีชีวิต") ? 'selected' : ''; ?>>มีชีวิต</option>
                                        <option value="เสียชีวิต" <?php echo ($Data_view["father_status"] == "เสียชีวิต") ? 'selected' : ''; ?>>เสียชีวิต</option>
                                    </select>

                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">อาชีพ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อาชีพ " name="father_occupation" value="<?php echo $Data_view["father_occupation"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">รายได้/เดือน <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="รายได้/เดือน " name="father_income" value="<?php echo $Data_view["father_income"]; ?>" required=" ">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="father_house_number" value="<?php echo $Data_view["father_house_number"]; ?>" required=" ">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">หมู่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="หมู่ " name="father_village" value="<?php echo $Data_view["father_village"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ซอย </label>
                                    <input class="form-control " type="text " placeholder="ซอย " name="father_lane" value="<?php echo $Data_view["father_lane"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ถนน </label>
                                    <input class="form-control " type="text " placeholder="ถนน " name="father_road" value="<?php echo $Data_view["father_road"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">ตำบล <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ตำบล " name="father_sub_district" value="<?php echo $Data_view["father_sub_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">อำเภอ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อำเภอ " name="father_district" value="<?php echo $Data_view["father_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">จังหวัด <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จังหวัด " name="father_province" value="<?php echo $Data_view["father_province"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="father_postal_code" value="<?php echo $Data_view["father_postal_code"]; ?>" maxlength="5 " required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">เบอร์โทรบิดา<span class="required">**</span></label>
                                    <input type="tel" id="phone" class="form-control" name="father_phone_number" value="<?php echo $Data_view["father_phone_number"]; ?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                </div>







                                <div class="panel-heading mt-5">ข้อมูลมารดา</div>
                                <div class="col-md-4">
                                    <label for="prefix" class="form-label">มารดาชื่อ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="มารดาชื่อ " name="mother_name" value="<?php echo $Data_view["mother_name"]; ?>" required=" ">
                                </div>
                                <div class="col-md-2">
                                    <label for="first-name" class="form-label">สถานะ <span class="required">**</span></label>
                                    <select class="form-control" name="mother_status" required>
                                        <option value="">==เลือก==</option>
                                        <option value="มีชีวิต" <?php echo ($Data_view["mother_status"] == "มีชีวิต") ? 'selected' : ''; ?>>มีชีวิต</option>
                                        <option value="เสียชีวิต" <?php echo ($Data_view["mother_status"] == "เสียชีวิต") ? 'selected' : ''; ?>>เสียชีวิต</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="last-name" class="form-label">อาชีพ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อาชีพ " name="mother_occupation" value="<?php echo $Data_view["mother_occupation"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="full-name-eng" class="form-label">รายได้/เดือน <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="รายได้/เดือน " name="mother_income" value="<?php echo $Data_view["mother_income"]; ?>" required=" ">
                                </div>
                                <div class="col-md-2">
                                    <label for="prefix" class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="mother_house_number" value="<?php echo $Data_view["mother_house_number"]; ?>" required=" ">
                                </div>
                                <div class="col-md-1">
                                    <label for="prefix" class="form-label">หมู่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="หมู่ " name="mother_village" value="<?php echo $Data_view["mother_village"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="prefix" class="form-label">ซอย </label>
                                    <input class="form-control " type="text " placeholder="ซอย " name="mother_lane" value="<?php echo $Data_view["mother_lane"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="prefix" class="form-label">ถนน </label>
                                    <input class="form-control " type="text " placeholder="ถนน " name="mother_road" value="<?php echo $Data_view["mother_road"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="first-name" class="form-label">ตำบล <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ตำบล " name="mother_sub_district" value="<?php echo $Data_view["mother_sub_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="last-name" class="form-label">อำเภอ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อำเภอ " name="mother_district" value="<?php echo $Data_view["mother_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="full-name-eng" class="form-label">จังหวัด <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จังหวัด " name="mother_province" value="<?php echo $Data_view["mother_province"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="id-number" class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="mother_postal_code" value="<?php echo $Data_view["mother_postal_code"]; ?>" maxlength="5 " required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">เบอร์โทรมารดา<span class="required">**</span></label>
                                    <input type="tel" id="phone" class="form-control" name="mother_phone_number" value="<?php echo $Data_view["mother_phone_number"]; ?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                </div>







                                <div class="panel-heading mt-5">ข้อมูลผู้ปกครอง</div>
                                <div class="col-md-8">
                                    <label for="prefix" class="form-label">ผู้ปกครอง<span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="ชื่อผู้ปกครอง " name="guardian_name" value="<?php echo $Data_view["guardian_name"]; ?>" required=" ">
                                </div>

                                <div class="col-md-4">
                                    <label for="last-name" class="form-label">ความสัมพันธ์ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ความสัมพันธ์ " name="guardian_relationship" value="<?php echo $Data_view["guardian_relationship"]; ?>" required=" ">
                                </div>
                                <div class="col-md-2">
                                    <label for="prefix" class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="guardian_house_number" value="<?php echo $Data_view["guardian_house_number"]; ?>" required=" ">
                                </div>
                                <div class="col-md-1">
                                    <label for="prefix" class="form-label">หมู่ <span class="required">**</span></label>
                                    <input class="form-control " type="text " placeholder="หมู่ " name="guardian_village" value="<?php echo $Data_view["guardian_village"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="prefix" class="form-label">ซอย </label>
                                    <input class="form-control " type="text " placeholder="ซอย " name="guardian_lane" value="<?php echo $Data_view["guardian_lane"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="prefix" class="form-label">ถนน </label>
                                    <input class="form-control " type="text " placeholder="ถนน " name="guardian_road" value="<?php echo $Data_view["guardian_road"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="first-name" class="form-label">ตำบล <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="ตำบล " name="guardian_sub_district" value="<?php echo $Data_view["guardian_sub_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="last-name" class="form-label">อำเภอ <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="อำเภอ " name="guardian_district" value="<?php echo $Data_view["guardian_district"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="full-name-eng" class="form-label">จังหวัด <span class="required">**</span></label>
                                    <input type="text " class="form-control " placeholder="จังหวัด " name="guardian_province" value="<?php echo $Data_view["guardian_province"]; ?>" required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="id-number" class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="guardian_postal_code" value="<?php echo $Data_view["guardian_postal_code"]; ?>" maxlength="5 " required=" ">
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">เบอร์โทรผู้ปกครอง<span class="required">**</span></label>
                                    <input type="tel" id="phone" class="form-control" name="guardian_phone_number" value="<?php echo $Data_view["guardian_phone_number"]; ?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                </div>





                                <div class="panel-heading mt-5">ต้องการศึกษา</div>

                                <div class="row mt-5">
                                    <div class="col-lg-3">
                                        <label class="form-label">ประเภทของหลักสูตร <span class="required">**</span></label>
                                        <input type="text" class="form-control" name="CourseType_Name" id="CourseType_Name" value="<?php echo $Data_view["CourseType_Name"]; ?>" readonly>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">ระดับการศึกษา <span class="required">**</span></label>
                                        <input type="text" class="form-control" name="Level_Name" id="Level_Name" value="<?php echo $Data_view["Level_Name"]; ?>" readonly>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">ประเภทวิชา <span class="required">**</span></label>
                                        <input type="text" class="form-control" name="Type_Name" id="Type_Name" value="<?php echo $Data_view["Type_Name"]; ?>" readonly>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="form-label">สาขาวิชา <span class="required">**</span></label>
                                        <input type="text" class="form-control" name="Major_Name" id="Major_Name" value="<?php echo $Data_view["Major_Name"]; ?>" readonly>
                                    </div>
                                </div>


                                <div class="panel-heading mt-5">หลักฐานที่ใช้ในการสมัคร</div>

                                <div class="col-md-3 mt-5">
                                    <label class="form-label">สำเนาใบรบ. <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput1" class="form-control" name="transcript" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg1" src="../config/uploads/<?php echo $Data_view["transcript"]; ?>" width="100%" alt="">
                                    <input type="hidden" class="form-control" name="transcript2" value="<?php echo $Data_view["transcript"]; ?>">
                                </div>
                                <div class="col-md-3 mt-5">
                                    <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput2" class="form-control" name="house_registration" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg2" src="../config/uploads/<?php echo $Data_view["house_registration"]; ?>" width="100%" alt="">
                                    <input type="hidden" class="form-control" name="house_registration2" value="<?php echo $Data_view["house_registration"]; ?>">
                                </div>
                                <div class="col-md-3 mt-5">
                                    <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput3" class="form-control" name="id_card" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg3" src="../config/uploads/<?php echo $Data_view["id_card"]; ?>" width="100%" alt="">
                                    <input type="hidden" class="form-control" name="id_card2" value="<?php echo $Data_view["id_card"]; ?>">
                                </div>
                                <div class="col-md-3 mt-5">
                                    <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput4" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg4" src="../config/uploads/<?php echo $Data_view["slip2000"]; ?>" width="100%" alt="">
                                    <input type="hidden" class="form-control" name="slip20002" value="<?php echo $Data_view["slip2000"]; ?>">
                                </div>
                                <div>
                                    <a href="edituser.php" class="btn btn-secondary"> Back</a>
                                    <button type="submit" class="btn btn-primary" name="update">update</button>
                                </div>


                            </form>

                        </div>
                    </div>
                </div>
        </div>

        </main>

    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="script.js"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }

        imgInput1.onchange = evt => {
            const [file1] = imgInput1.files;
            if (file1) {
                previewImg1.src = URL.createObjectURL(file1);
            }
        };

        imgInput2.onchange = evt => {
            const [file2] = imgInput2.files;
            if (file2) {
                previewImg2.src = URL.createObjectURL(file2);
            }
        };

        imgInput3.onchange = evt => {
            const [file3] = imgInput3.files;
            if (file3) {
                previewImg3.src = URL.createObjectURL(file3);
            }
        };

        imgInput4.onchange = evt => {
            const [file4] = imgInput4.files;
            if (file4) {
                previewImg4.src = URL.createObjectURL(file4);
            }
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>