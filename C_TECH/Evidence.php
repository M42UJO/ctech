<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
                    <span class="progress-label">ข้อมูลมารดา</span>
                </li>
                <li class="step-wizard-item current-item">
                    <span class="progress-count ">2</span>
                    <span class="progress-label ">ข้อมูลผู้ปกครอง</span>
                </li>
            </ul>
        </section>

        <div class="panel panel-default">
            <div class="panel-body">
                <form id="personal-info-form" class="row g-2 mt-2" action="config/insertEvidence.php" method="post" enctype="multipart/form-data">
                    <div class="panel-heading">หลักฐานที่ใช้ในการสมัคร</div>
                    <label id="announce" class="">วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา<br> Chanapolkhan Technological College, Nakhon Ratchasima</label>
                    <label id="announce" class="">กรุณาชำระค่าแรกเข้า จำนวน <span class="highlight">2,000</span> บาท หลังจากกรอกข้อมูลครบถ้วน</label>
                    <label id="announce" class="">ยอดเงินนี้จะถูกนำไปเป็นส่วนลดค่าเทอมของนักศึกษา</label>
                    <label id="announce" class="mb-5">โอนเงินผ่านบัญชีธนาคาร ชื่อบัญชี: วิทยาลัยเทคโนโลยีชนะพลขันธ์<br>เลขที่บัญชี: <span class="highlight">374-105-5883 ธนาคารกรุงไทย</span> </label>

                    <div class="col-md-3">
                        <label class="form-label">สำเนาใบรบ. <span class="required">** .jpg เท่านั้น</span></label>
                        <input type="file" class="form-control" name="transcript" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg เท่านั้น</span></label>
                        <input type="file" class="form-control" name="house_registration" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg เท่านั้น</span></label>
                        <input type="file" class="form-control" name="id_card" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg เท่านั้น</span></label>
                        <input type="file" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png" required>
                    </div>

                    <div class="col-md-2 mt-5">
                        <button type="button" class="btn btn-warning w-100 py-2 btn-custom" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>
                    <div class="col-md-8 mt-5"></div>
                    <div class="col-md-2 mt-5">
                        <button type="submit" name="submit" class="btn btn-warning w-100 py-2 btn-custom">ยืนยัน
                            <i class="fas fa-check"></i> 
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <?php
    require_once("footer.php");
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
    document.getElementById('personal-info-form').addEventListener('submit', function(event) {
        event.preventDefault(); // หยุดการส่งฟอร์มแบบปกติ

        // สร้าง FormData object
        const formData = new FormData(this);

        // ส่งข้อมูลด้วย Fetch API
        fetch('config/insertEvidence.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result.includes("ข้อมูลได้ถูกอัปเดตเรียบร้อยแล้ว")) {
                Swal.fire({
                    title: 'สำเร็จ!',
                    text: 'คุณสมัครเรียนเรียบร้อยแล้ว เจ้าหน้าที่กำลังตรวจสอบข้อมูล โปรดติดตามสถานะการสมัคร.',
                    icon: 'success',
                    confirmButtonText: 'ตกลง'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php';  // เปลี่ยนเส้นทางไปยังหน้าที่ต้องการหลังจากปิด SweetAlert2
                    }
                });
            } else {
                Swal.fire({
                    title: 'ข้อผิดพลาด!',
                    text: 'เกิดข้อผิดพลาดในการสมัคร กรุณาลองใหม่อีกครั้ง.',
                    icon: 'error',
                    confirmButtonText: 'ตกลง'
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'ข้อผิดพลาด!',
                text: 'เกิดข้อผิดพลาดในการส่งข้อมูล.',
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        });
    });
    </script>
</body>
</html>
