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

    $stmt_view = $conn->prepare("SELECT * FROM applicant WHERE User_ID = ?");
    $stmt_view->execute([$user_id]);
    $Data_view = $stmt_view->fetch();

    // ถ้าไม่มีข้อมูลใน $Data_view ให้ตั้งค่าเริ่มต้น
    if (!$Data_view) {
        $Data_view = [
            "prefix" => "",
            "name" => "",
            "lastname" => "",
            "eng_name" => "",
            "id_card_number" => "",
            "nickname" => "",
            "birth_day" => "",
            "birth_month" => "",
            "birth_year" => "",
            "blood_group" => "",
            "height" => "",
            "weight" => "",
            "nationality" => "",
            "citizenship" => "",
            "religion" => "",
            "siblings_count" => "",
            "studying_siblings_count" => "",
            "phone_number" => "",
            "line_id" => "",
            "facebook" => "",
            "profile_image" => ""
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="button.css">
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
                <li class="step-wizard-item current-item">
                    <span class="progress-count">1</span>
                    <span class="progress-label">ข้อมูลส่วนตัว</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">2</span>
                    <span class="progress-label">ที่อยู่ปัจจุบัน</span>
                </li>
                <li class="step-wizard-item">
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

                <form id="personal-info-form" class="row g-3 mt-2" action="config/insertPersonal_info.php" method="post" enctype="multipart/form-data">
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
                        <input type="text" id="first-name" class="form-control" placeholder="ชื่อ" name="name" value="<?php echo $Data_view["name"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="last-name" class="form-label">สกุล <span class="required">**</span></label>
                        <input type="text" id="last-name" class="form-control" placeholder="สกุล" name="lastname" value="<?php echo $Data_view["lastname"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="full-name-eng" class="form-label">ชื่อ - สกุล อังกฤษ <span class="required">**</span></label>
                        <input type="text" id="full-name-eng" class="form-control" placeholder="ชื่อ - สกุล อังกฤษ" name="eng_name" value="<?php echo $Data_view["eng_name"];?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="id-number" class="form-label">เลขบัตรประชาชน <span class="required">** ตัวเลขเท่านั้น</span></label>
                        <input type="text" class="form-control" id="thai-id" maxlength="17"  placeholder="x-xxxx-xxxxx-xx-x" name="id_card_number" value="<?php echo $Data_view["id_card_number"];?>" required >
                    </div>
                    <div class="col-md-2">
                        <label for="nickname" class="form-label">ชื่อเล่น</label>
                        <input type="text" id="nickname" class="form-control" placeholder="ชื่อเล่น" name="nickname" value="<?php echo $Data_view["nickname"];?>">
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
                        <input type="number" id="height" class="form-control" min="0" placeholder="ส่วนสูง" name="height" value="<?php echo $Data_view["height"];?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="weight" class="form-label">น้ำหนัก <span class="required">**</span></label>
                        <input type="number" id="weight" class="form-control" min="0" placeholder="น้ำหนัก" name="weight" value="<?php echo $Data_view["weight"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nationality" class="form-label">เชื้อชาติ <span class="required">**</span></label>
                        <input type="text" id="nationality" class="form-control" placeholder="เชื้อชาติ" name="nationality" value="<?php echo $Data_view["nationality"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="citizenship" class="form-label">สัญชาติ <span class="required">**</span></label>
                        <input type="text" id="citizenship" class="form-control" placeholder="สัญชาติ" name="citizenship" value="<?php echo $Data_view["citizenship"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="religion" class="form-label">ศาสนา <span class="required">**</span></label>
                        <input type="text" id="religion" class="form-control" placeholder="ศาสนา" name="religion" value="<?php echo $Data_view["religion"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="siblings" class="form-label">จำนวนพี่น้อง <span class="required">**</span></label>
                        <input type="number" id="siblings" class="form-control" min="0" placeholder="จำนวนพี่น้อง" name="siblings_count" value="<?php echo $Data_view["siblings_count"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="current-siblings" class="form-label">จำนวนพี่น้องที่กำลังศึกษาอยู่ <span class="required">**</span></label>
                        <input type="number" id="current-siblings" class="form-control" min="0" placeholder="จำนวนพี่น้องที่กำลังศึกษาอยู่" name="studying_siblings_count" value="<?php echo $Data_view["studying_siblings_count"];?>" required>
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">เบอร์โทร <span class="required">**</span></label>
                        <input type="tel" id="phone" class="form-control" name="phone_number" value="<?php echo $Data_view["phone_number"];?>" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="xxx-xxx-xxxx">
                    </div>
                    <div class="col-md-3">
                        <label for="line-id" class="form-label">LineID</label>
                        <input type="text" id="line-id" class="form-control" placeholder="LineID" name="line_id" value="<?php echo $Data_view["line_id"];?>">
                    </div>
                    <div class="col-md-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" id="facebook" class="form-control" placeholder="Facebook" name="facebook" value="<?php echo $Data_view["facebook"];?>">
                        <input type="text" hidden  class="form-control"  name="User_ID" value="<?php echo $Data_view["User_ID"];?>">
                        <input type="hidden"  class="form-control"  name="profile_image2" value="<?php echo $Data_view["profile_image"];?>">
                    </div>
                    <div class="col-md-6">
                        <label for="photo" class="form-label">รูปภาพ 1 นิ้วครึ่ง <span class="required">** </span></label>
                        <input type="file" id="imgInput" class="form-control" name="profile_image" accept=".jpg,.jpeg,.png" >
                        <img id="previewImg" src="config/uploads/<?php echo $Data_view["profile_image"];?>" width="50%" alt="">
                    </div>
                    <div class="col-md-2">
                        <a href="index.php" type="button" class="btn  w-100 py-2 btn-1">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
    <script src="script.js"></script>
</body>

</html>