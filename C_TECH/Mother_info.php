<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_login'];

try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt->execute([$user_id]);
    $userData = $stmt->fetch();

    $stmt_view = $conn->prepare("SELECT * FROM parent_info WHERE User_ID = ?");
    $stmt_view->execute([$user_id]);
    $Data_view = $stmt_view->fetch();

    if (!$Data_view) {
        $Data_view = [
            "mother_name" => "",
            "mother_status" => "",
            "mother_occupation" => "",
            "mother_income" => "",
            "mother_house_number" => "",
            "mother_village" => "",
            "mother_lane" => "",
            "mother_road" => "",
            "mother_sub_district" => "",
            "mother_district" => "",
            "mother_province" => "",
            "mother_postal_code" => "",
            "mother_phone_number" => "",
        ];
    }
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <link rel="stylesheet" href="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/JQL.min.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dependencies/typeahead.bundle.js"></script>
    <script type="text/javascript" src="https://earthchie.github.io/jquery.Thailand.js/jquery.Thailand.js/dist/jquery.Thailand.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .btn {
        flex: 1 1 auto;
        margin: 10px;
        padding: 30px;
        text-align: center;
        text-transform: uppercase;
        transition: 0.5s;
        background-size: 200% auto;
        color: white;
        text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 0 20px #eee;
        border-radius: 10px;
    }

    .btn:hover {
        background-position: right center;

    }

    .btn-1 {
        background-image: linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%);
    }
</style>

<body>
    <?php
    require_once("nav.php");
    ?>

    <div class="container mt-5">

        <section class="step-wizard">
            <ul class="step-wizard-list">
                <li class="step-wizard-item">
                    <span class="progress-count">1</span>
                    <span class="progress-label">ข้อมูลส่วนตัว</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">2</span>
                    <span class="progress-label">ที่อยู่ปัจจุบัน</span>
                </li>
                <li class="step-wizard-item ">
                    <span class="progress-count">3</span>
                    <span class="progress-label">ข้อมูลการศึกษา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">4</span>
                    <span class="progress-label">ข้อมูลบิดา</span>
                </li>
                <li class="step-wizard-item current-item">
                    <span class="progress-count">5</span>
                    <span class="progress-label">ข้อมูลมารดา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">6</span>
                    <span class="progress-label">ข้อมูลผู้ปกครอง</span>
                </li>

            </ul>
        </section>






        <div class="panel panel-default">

            <div class="panel-body">


                <form id="personal-info-form" class="row g-2 mt-2" action="config/insertMother_info.php" method="post">
                    <div class="panel-heading">ข้อมูลมารดา</div>
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
                        <label for="mother-occupation" class="form-label">อาชีพ <span class="required">**</span></label>
                        <select class="form-select" name="mother_occupation" required>
                            <option value="" disabled selected>เลือกอาชีพ</option>
                            <option value="พนักงานบริษัท" <?php echo ($Data_view["mother_occupation"] == 'พนักงานบริษัท') ? 'selected' : ''; ?>>พนักงานบริษัท</option>
                            <option value="แม่บ้าน" <?php echo ($Data_view["mother_occupation"] == 'แม่บ้าน') ? 'selected' : ''; ?>>แม่บ้าน</option>
                            <option value="ธุรกิจส่วนตัว" <?php echo ($Data_view["mother_occupation"] == 'ธุรกิจส่วนตัว') ? 'selected' : ''; ?>>ธุรกิจส่วนตัว</option>
                            <option value="ลูกจ้าง" <?php echo ($Data_view["mother_occupation"] == 'ลูกจ้าง') ? 'selected' : ''; ?>>ลูกจ้าง</option>
                            <option value="ค้าขาย" <?php echo ($Data_view["mother_occupation"] == 'ค้าขาย') ? 'selected' : ''; ?>>ค้าขาย</option>
                            <option value="อื่นๆ" <?php echo ($Data_view["mother_occupation"] == 'อื่นๆ') ? 'selected' : ''; ?>>อื่นๆ</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="mother-income" class="form-label">รายได้/เดือน <span class="required">**</span></label>
                        <select class="form-select" name="mother_income" required>
                            <option value="" disabled selected>เลือกจำนวนรายได้</option>
                            <option value="0-10,000" <?php echo ($Data_view["mother_income"] == '0-10,000') ? 'selected' : ''; ?>>ต่ำกว่า 10,000 บาท</option>
                            <option value="10,000-20,000" <?php echo ($Data_view["mother_income"] == '10,000-20,000') ? 'selected' : ''; ?>>10,000-20,000 บาท</option>
                            <option value="20,001-30,000" <?php echo ($Data_view["mother_income"] == '20,001-30,000') ? 'selected' : ''; ?>>20,001-30,000 บาท</option>
                            <option value="30,001-50,000" <?php echo ($Data_view["mother_income"] == '30,001-50,000') ? 'selected' : ''; ?>>30,001-50,000 บาท</option>
                            <option value="50,001 ขึ้นไป" <?php echo ($Data_view["mother_income"] == '50,001 ขึ้นไป') ? 'selected' : ''; ?>>50,001 ขึ้นไป</option>
                        </select>
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
                        <input class="form-control " type="text " placeholder="ซอย " name="mother_lane" value="<?php echo $Data_view["mother_lane"]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="prefix" class="form-label">ถนน </label>
                        <input class="form-control " type="text " placeholder="ถนน " name="mother_road" value="<?php echo $Data_view["mother_road"]; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="first-name" class="form-label">ตำบล <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="ตำบล " id="district" name="mother_sub_district" value="<?php echo $Data_view["mother_sub_district"]; ?>" required=" ">
                    </div>
                    <div class="col-md-3">
                        <label for="last-name" class="form-label">อำเภอ <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="อำเภอ " id="amphoe" name="mother_district" value="<?php echo $Data_view["mother_district"]; ?>" required=" ">
                    </div>
                    <div class="col-md-3">
                        <label for="full-name-eng" class="form-label">จังหวัด <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="จังหวัด " id="province" name="mother_province" value="<?php echo $Data_view["mother_province"]; ?>" required=" ">
                    </div>
                    <div class="col-md-3">
                        <label for="id-number" class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                        <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " id="zipcode" name="mother_postal_code" value="<?php echo $Data_view["mother_postal_code"]; ?>" maxlength="5 " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">เบอร์โทรมารดา<span class="required">**</span></label>
                        <input type="tel" id="phone" class="form-control" name="mother_phone_number" value="<?php echo $Data_view["mother_phone_number"]; ?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                    </div>
                    <div class="col-md-2">
                        <a href="./Father_info.php" type="button" class="btn  w-100 py-2 btn-1">
                            <i class="fa-solid fa-angles-left"></i> ย้อนกลับ
                        </a>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="submit" class="btn  w-100 py-2 btn-1">ถัดไป
                            <i class="fa-solid fa-angles-right"></i>
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
    <?php
    require_once("footer.php");
    ?>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL " crossorigin="anonymous "></script>
    <script src="script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.Thailand({
                $district: $('#district'), // input ของตำบล
                $amphoe: $('#amphoe'), // input ของอำเภอ
                $province: $('#province'), // input ของจังหวัด
                $zipcode: $('#zipcode'), // input ของรหัสไปรษณีย์
            });
        });
    </script>

</body>

</html>