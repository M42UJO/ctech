<?php
session_start();
require_once("../config/db.php");


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
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
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

                        <div class="sb-sidenav-menu-heading">Addons</div>

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

                                    // ปรับปรุง SQL Query เพื่อดึงข้อมูลจากหลายตาราง
                                    $stmt = $conn->prepare("
                                        SELECT 
                                            u.*, 
                                            p.*, 
                                            f.*, 
                                            e.*, 
                                            c.*, 
                                            a.*
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
                                        WHERE 
                                            u.User_ID = :user_id
                                    ");

                                    // ใช้ prepare เพื่อความปลอดภัยจาก SQL Injection และ bind ค่า
                                    $stmt->bindParam(':user_id', $User_ID, PDO::PARAM_INT);
                                    $stmt->execute();

                                    // ดึงข้อมูลทั้งหมดจากตารางที่เกี่ยวข้อง
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
                                    <input type="hidden" class="form-control" name="profile_image2" value="<?php echo $Data_view["profile_image"]; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">รูปภาพ 1 นิ้วครึ่ง <span class="required">** .jpg เท่านั้น</span></label>
                                    <input type="file" id="imgInput" class="form-control" name="profile_image" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg" src="../config/uploads/<?php echo $Data_view["profile_image"]; ?>" width="50%" alt="">
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
                                        <select id="CourseType_Name" name="CourseType_Name" class="form-control" required>
                                            <option value="">เลือกประเภทของหลักสูตร</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">ระดับการศึกษา <span class="required">**</span></label>
                                        <select id="Level_Name" name="Level_Name" class="form-control" required>
                                            <option value="">เลือกระดับการศึกษา</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">ประเภทวิชา <span class="required">**</span></label>
                                        <select id="Type_Name" name="Type_Name" class="form-control" required>
                                            <option value="">เลือกประเภทวิชา</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="form-label">สาขาวิชา <span class="required">**</span></label>
                                        <select id="Major_Name" name="Major_Name" class="form-control" required>
                                            <option value="">เลือกสาขาวิชา</option>
                                        </select>
                                    </div>
                                </div>







                                <div class="panel-heading mt-5">หลักฐานที่ใช้ในการสมัคร</div>
                                <label id="announce" class="">วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา<br> Chanapolkhan Technological College, Nakhon Ratchasima</label>
                                <label id="announce" class="">กรุณาชำระค่าแรกเข้า จำนวน <span class="highlight">2,000</span> บาท หลังจากกรอกข้อมูลครบถ้วน</label>
                                <label id="announce" class="">ยอดเงินนี้จะถูกนำไปเป็นส่วนลดค่าเทอมของนักศึกษา</label>
                                <label id="announce" class="mb-5">โอนเงินผ่านบัญชีธนาคาร ชื่อบัญชี: วิทยาลัยเทคโนโลยีชนะพลขันธ์<br>เลขที่บัญชี: <span class="highlight">374-105-5883 ธนาคารกรุงไทย</span> </label>

                                <div class="col-md-3">
                                    <label class="form-label">สำเนาใบรบ. <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput1" class="form-control" name="transcript" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg1" width="50%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput2" class="form-control" name="house_registration" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg2" width="50%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput3" class="form-control" name="id_card" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg3" width="50%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                                    <input type="file" id="imgInput4" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png">
                                    <img id="previewImg4" width="50%" alt="">
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


        document.addEventListener('DOMContentLoaded', function() {
            const courseTypeSelect = document.getElementById('CourseType_Name');
            const levelSelect = document.getElementById('Level_Name');
            const subjectTypeSelect = document.getElementById('Type_Name');
            const majorSelect = document.getElementById('Major_Name');

            const levels = <?php echo json_encode($levels); ?>;
            const subjectTypes = <?php echo json_encode($subjectTypes); ?>;
            const majors = <?php echo json_encode($majors); ?>;

            // Populate initial dropdowns
            populateSelect(courseTypeSelect, <?php echo json_encode($courseTypes); ?>, 'CourseType_ID', 'CourseType_Name');

            // Event handler for changing courseType
            courseTypeSelect.addEventListener('change', function() {
                const selectedCourseType = this.value;
                const filteredLevels = levels.filter(level => level.CourseType_ID == selectedCourseType);
                populateSelect(levelSelect, filteredLevels, 'Level_ID', 'Level_Name');
                clearSelect(subjectTypeSelect);
                clearSelect(majorSelect);
            });

            // Event handler for changing level
            levelSelect.addEventListener('change', function() {
                const selectedLevel = this.value;
                const filteredSubjectTypes = subjectTypes.filter(type => type.Level_ID == selectedLevel);
                populateSelect(subjectTypeSelect, filteredSubjectTypes, 'Type_ID', 'Type_Name');
                clearSelect(majorSelect);
            });

            // Event handler for changing subjectType
            subjectTypeSelect.addEventListener('change', function() {
                const selectedSubjectType = this.value;
                const filteredMajors = majors.filter(major => major.Type_ID == selectedSubjectType);
                populateSelect(majorSelect, filteredMajors, 'Major_ID', 'Major_Name');
            });

            // Set initial values
            courseTypeSelect.value = '<?php echo $courseType; ?>';
            const initialLevels = levels.filter(level => level.CourseType_ID == courseTypeSelect.value);
            populateSelect(levelSelect, initialLevels, 'Level_ID', 'Level_Name');
            levelSelect.value = '<?php echo $level; ?>';
            const initialSubjectTypes = subjectTypes.filter(type => type.Level_ID == levelSelect.value);
            populateSelect(subjectTypeSelect, initialSubjectTypes, 'Type_ID', 'Type_Name');
            subjectTypeSelect.value = '<?php echo $subjectType; ?>';
            const initialMajors = majors.filter(major => major.Type_ID == subjectTypeSelect.value);
            populateSelect(majorSelect, initialMajors, 'Major_ID', 'Major_Name');
            majorSelect.value = '<?php echo $major; ?>';
        });

        function populateSelect(selectElement, data, valueKey, textKey) {
            selectElement.innerHTML = '<option value="">= เลือกตัวเลือก =</option>'; // Clear existing options
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[textKey];
                selectElement.appendChild(option);
            });
        }

        function clearSelect(selectElement) {
            selectElement.innerHTML = '<option value="">= เลือกตัวเลือก =</option>';
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($guardianMissing): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'ข้อมูลไม่ครบถ้วน',
                    text: 'กรุณากรอกข้อมูลส่วนตัวให้ครบถ้วน จึงสมัครได้',
                    confirmButtonText: 'ตกลง',
                    willClose: () => {
                        window.location.href = 'Personal_info.php';
                    }
                });
            <?php endif; ?>
        });

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