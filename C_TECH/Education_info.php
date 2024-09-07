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

    $stmt_view = $conn->prepare("SELECT * FROM education_info WHERE User_ID = ?");
    $stmt_view->execute([$user_id]);
    $Data_view = $stmt_view->fetch();

    if (!$Data_view) {
        $Data_view = [
            "school_name" => "",
            "school_sub_district" => "",
            "school_district" => "",
            "school_province" => "",
            "school_postal_code" => "",
            "graduation_year" => "",
            "grade_result" => "",
            "class_level" => "",
            "major" => "",
            "degree_other" => "",
            "major_other" => "",
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
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
    text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
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
                <li class="step-wizard-item current-item">
                    <span class="progress-count">3</span>
                    <span class="progress-label">ข้อมูลการศึกษา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">4</span>
                    <span class="progress-label">ข้อมูลบิดา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">5</span>
                    <span class="progress-label">ข้อมูลมารดา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">6</span>
                    <span class="progress-label">ข้อมูลผู้ปกครอง</span>
                </li>
              
            </ul>
        </section>







        <div class="panel panel-default mb-5">

            <div class="panel-body">


                <form id="personal-info-form" class="row g-2 mt-2" action="config/insertEducation_info.php" method="post">
                    <div class="panel-heading">ข้อมูลการศึกษา</div>
                    <div class="col-md-8">
                        <label class="form-label">จบจากโรงเรียน <span class="required">**</span></label>
                        <input class="form-control " type="text " placeholder="จบจากโรงเรียน " name="school_name" value="<?php echo $Data_view["school_name"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ตำบล <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="ตำบล " name="school_sub_district" value="<?php echo $Data_view["school_sub_district"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">อำเภอ <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="อำเภอ " name="school_district" value="<?php echo $Data_view["school_district"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">จังหวัด <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="จังหวัด " name="school_province" value="<?php echo $Data_view["school_province"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                        <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="school_postal_code" value="<?php echo $Data_view["school_postal_code"];?>" maxlength="5 " required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">จบเมื่อ พ.ศ. <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="จบเมื่อ พ.ศ. " name="graduation_year" value="<?php echo $Data_view["graduation_year"];?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">เกรดเฉลี่ยสะสม <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="เกรดเฉลี่ยสะสม " name="grade_result" value="<?php echo $Data_view["grade_result"];?>" required>
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
                        <input type="text " class="form-control " placeholder="สาขาวิชา" name="major" value="<?php echo $Data_view["major"];?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">วุฒิการศึกษาอื่นๆ </label>
                        <input type="text " class="form-control " placeholder="วุฒิการศึกษาอื่นๆ" name="degree_other" value="<?php echo $Data_view["degree_other"];?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">สาขาวิชา </label>
                        <input type="text " class="form-control " placeholder="สาขาวิชา " name="major_other" value="<?php echo $Data_view["major_other"];?>">
                    </div>
                    <div class="col-md-2">
                        <a href="./Current_address.php" type="button" class="btn  w-100 py-2 btn-1">
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
    
</body>

</html>