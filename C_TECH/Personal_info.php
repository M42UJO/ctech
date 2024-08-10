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
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
    exit();
}
?>
<?php if (isset($_SESSION['error'])) : ?>
    <div class="alert alert-danger" role="alert">
        <?php
        echo $_SESSION['error'];
        unset($_SESSION['error']);
        ?>
    </div>
<?php endif; ?>







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
</head>

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

                <form id="personal-info-form" class="row g-3 mt-2" action="config/insertPersonal_info.php" method="post">
                    <div class="panel-heading">ข้อมูลส่วนตัว</div>
                    <div class="col-md-2">
                        <label for="prefix" class="form-label">คำนำหน้า <span class="required">**</span></label>
                        <select id="prefix" class="form-select" name="prefix" required>
                            <option value="">==เลือก==</option>
                            <option value="Mr">นาย</option>
                            <option value="Mrs">นาง</option>
                            <option value="Ms">นางสาว</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="first-name" class="form-label">ชื่อ <span class="required">**</span></label>
                        <input type="text" id="first-name" class="form-control" placeholder="ชื่อ" name="name" required>
                    </div>
                    <div class="col-md-3">
                        <label for="last-name" class="form-label">สกุล <span class="required">**</span></label>
                        <input type="text" id="last-name" class="form-control" placeholder="สกุล" name="lastname" required>
                    </div>
                    <div class="col-md-4">
                        <label for="full-name-eng" class="form-label">ชื่อ - สกุล อังกฤษ <span class="required">**</span></label>
                        <input type="text" id="full-name-eng" class="form-control" placeholder="ชื่อ - สกุล อังกฤษ" name="eng_name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="id-number" class="form-label">เลขบัตรประชาชน <span class="required">** ตัวเลขเท่านั้น</span></label>
                        <input type="text" class="form-control" id="thai-id" maxlength="17"  placeholder="x-xxxx-xxxxx-xx-x" name="id_card_number" required >
                    </div>
                    <div class="col-md-2">
                        <label for="nickname" class="form-label">ชื่อเล่น</label>
                        <input type="text" id="nickname" class="form-control" placeholder="ชื่อเล่น" name="nickname">
                    </div>
                    <div class="col-md-2">
                        <label for="birth_day" class="form-label">วันเกิด <span class="required">**</span></label>
                        <select id="birth_day" class="form-select" name="birth_day" required>
                            <option value="">==เลือก==</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <!-- Options for days -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="birth-month" class="form-label">เดือนเกิด <span class="required">**</span></label>
                        <select id="birth-month" class="form-select" name="birth_month" required>
                            <option value="">==เลือก==</option>
                            <option value="01">มกราคม</option>
                            <option value="02">กุมภาพันธ์</option>
                            <option value="03">มีนาคม</option>
                            <option value="04">เมษายน</option>
                            <option value="05">พฤษภาคม</option>
                            <option value="06">มิถุนายน</option>
                            <option value="07">กรกฎาคม</option>
                            <option value="08">สิงหาคม</option>
                            <option value="09">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                            <!-- Options for months -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="birth-year" class="form-label">ปีเกิด <span class="required">**</span></label>
                        <select id="birth-year" class="form-select" name="birth_year" required>
                            <option value="">==เลือก==</option>
                            <option value="2510">2510</option>
                            <option value="2511">2511</option>
                            <option value="2512">2512</option>
                            <option value="2513">2513</option>
                            <option value="2514">2514</option>
                            <option value="2515">2515</option>
                            <option value="2516">2516</option>
                            <option value="2517">2517</option>
                            <option value="2518">2518</option>
                            <option value="2519">2519</option>
                            <option value="2520">2520</option>
                            <option value="2521">2521</option>
                            <option value="2522">2522</option>
                            <option value="2523">2523</option>
                            <option value="2524">2524</option>
                            <option value="2525">2525</option>
                            <option value="2526">2526</option>
                            <option value="2527">2527</option>
                            <option value="2528">2528</option>
                            <option value="2529">2529</option>
                            <option value="2530">2530</option>
                            <option value="2531">2531</option>
                            <option value="2532">2532</option>
                            <option value="2533">2533</option>
                            <option value="2534">2534</option>
                            <option value="2535">2535</option>
                            <option value="2536">2536</option>
                            <option value="2537">2537</option>
                            <option value="2538">2538</option>
                            <option value="2539">2539</option>
                            <option value="2540">2540</option>
                            <option value="2541">2541</option>
                            <option value="2542">2542</option>
                            <option value="2543">2543</option>
                            <option value="2544">2544</option>
                            <option value="2545">2545</option>
                            <option value="2546">2546</option>
                            <option value="2547">2547</option>
                            <option value="2548">2548</option>
                            <option value="2549">2549</option>
                            <option value="2550">2550</option>
                            <option value="2551">2551</option>
                            <option value="2552">2552</option>
                            <option value="2553">2553</option>
                            <option value="2554">2554</option>
                            <option value="2555">2555</option>
                            <option value="2556">2556</option>
                            <option value="2557">2557</option>
                            <option value="2558">2558</option>
                            <option value="2559">2559</option>
                            <option value="2560">2560</option>
                            <!-- Options for years -->
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="group-code" class="form-label">กรุ๊ปเลือด <span class="required">**</span></label>
                        <input type="text" id="group-code" class="form-control" placeholder="กรุ๊ปเลือด" name="blood_group" required>
                    </div>
                    <div class="col-md-2">
                        <label for="height" class="form-label">ส่วนสูง <span class="required">**</span></label>
                        <input type="number" id="height" class="form-control" min="0" placeholder="ส่วนสูง" name="height" required>
                    </div>
                    <div class="col-md-2">
                        <label for="weight" class="form-label">น้ำหนัก <span class="required">**</span></label>
                        <input type="number" id="weight" class="form-control" min="0" placeholder="น้ำหนัก" name="weight" required>
                    </div>
                    <div class="col-md-3">
                        <label for="nationality" class="form-label">เชื้อชาติ <span class="required">**</span></label>
                        <input type="text" id="nationality" class="form-control" placeholder="เชื้อชาติ" name="nationality" required>
                    </div>
                    <div class="col-md-3">
                        <label for="citizenship" class="form-label">สัญชาติ <span class="required">**</span></label>
                        <input type="text" id="citizenship" class="form-control" placeholder="สัญชาติ" name="citizenship" required>
                    </div>
                    <div class="col-md-3">
                        <label for="religion" class="form-label">ศาสนา <span class="required">**</span></label>
                        <input type="text" id="religion" class="form-control" placeholder="ศาสนา" name="religion" required>
                    </div>
                    <div class="col-md-3">
                        <label for="siblings" class="form-label">จำนวนพี่น้อง <span class="required">**</span></label>
                        <input type="number" id="siblings" class="form-control" min="0" placeholder="จำนวนพี่น้อง" name="siblings_count" required>
                    </div>
                    <div class="col-md-3">
                        <label for="current-siblings" class="form-label">จำนวนพี่น้องที่กำลังศึกษาอยู่ <span class="required">**</span></label>
                        <input type="number" id="current-siblings" class="form-control" min="0" placeholder="จำนวนพี่น้องที่กำลังศึกษาอยู่" name="studying_siblings_count" required>
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">เบอร์โทร <span class="required">**</span></label>
                        <input type="tel" id="phone" class="form-control" name="phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="xxx-xxx-xxxx">
                    </div>
                    <div class="col-md-3">
                        <label for="line-id" class="form-label">LineID</label>
                        <input type="text" id="line-id" class="form-control" placeholder="LineID" name="line_id">
                    </div>
                    <div class="col-md-3">
                        <label for="facebook" class="form-label">Facebook</label>
                        <input type="text" id="facebook" class="form-control" placeholder="Facebook" name="facebook">
                    </div>
                    <div class="col-md-6">
                        <label for="photo" class="form-label">รูปภาพ 1 นิ้วครึ่ง <span class="required">** .jpg เท่านั้น</span></label>
                        <input type="file" id="imgInput" class="form-control" name="profile_image" accept=".jpg" >
                        <img id="previewImg" width="50%" alt="">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning w-100 py-2 btn-custom" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="submit" class="btn btn-warning w-100 py-2 btn-custom" onclick="console.log('Submit button clicked');">ถัดไป
                            <i class="fas fa-arrow-right"></i>
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