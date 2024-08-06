<?php
session_start();
require_once("config/db.php");
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
                <li class="step-wizard-item current-item">
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


                <form id="personal-info-form" class="row g-2 mt-2">
                    <div class="panel-heading">ข้อมูลบิดา</div>
                    <div class="col-md-4">
                        <label class="form-label">บิดาชื่อ <span class="required">**</span></label>
                        <input class="form-control " type="text " placeholder="โรงเรียน " name="father_name " required=" ">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">สถานะ <span class="required">**</span></label>
                        <select class="form-control " name="father_status " required=" ">
                                            <option value=" ">==เลือก==</option>
                                            <option value="มีชีวิต ">มีชีวิต</option>
                                            <option value="เสียชีวิต ">เสียชีวิต</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">อาชีพ <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="อาชีพ " name="father_occupation " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">รายได้/เดือน <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="รายได้/เดือน " name="father_income " required=" ">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                        <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="father_address " required=" ">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">หมู่ <span class="required">**</span></label>
                        <input class="form-control " type="text " placeholder="หมู่ " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ซอย </label>
                        <input class="form-control " type="text " placeholder="ซอย " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ถนน </label>
                        <input class="form-control " type="text " placeholder="ถนน " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ตำบล <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="ตำบล " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">อำเภอ <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="อำเภอ " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">จังหวัด <span class="required">**</span></label>
                        <input type="text " class="form-control " placeholder="จังหวัด " name="father_address " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                        <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="father_address " maxlength="5 " required=" ">
                    </div>
                    <div class="col-md-3">
                        <label for="phone" class="form-label">เบอร์โทรบิดา<span class="required">**</span></label>
                        <input type="tel" id="phone" class="form-control" name="father_phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-warning w-100 py-2 btn-custom" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-warning w-100 py-2 btn-custom">ถัดไป
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL " crossorigin="anonymous "></script>
    <script src="script.js"></script>
    <script>
        document.getElementById('personal-info-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            window.location.href = 'Mother_info.html'; // Redirect to the new page
        });
    </script>
</body>

</html>