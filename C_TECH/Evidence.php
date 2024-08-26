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

$stmt_view = $conn->prepare("SELECT * FROM form WHERE User_ID = ?");
$stmt_view->execute([$user_id]);
$Data_view = $stmt_view->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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
</head>

<body>
    <?php require_once("nav.php"); ?>

    <div class="container mt-5">
        <section class="step-wizard">
            <ul class="step-wizard-list">
                <li class="step-wizard-item">
                    <span class="progress-count">1</span>
                    <span class="progress-label">ข้อมูลมารดา</span>
                </li>
                <li class="step-wizard-item current-item">
                    <span class="progress-count">2</span>
                    <span class="progress-label">ข้อมูลผู้ปกครอง</span>
                </li>
            </ul>
        </section>

        <div class="panel panel-default">
            <div class="panel-body">
                <form id="personal-info-form" class="row g-2 mt-2" action="config/insertEvidence.php" method="post" enctype="multipart/form-data">
                    <div class="panel-heading">หลักฐานที่ใช้ในการสมัคร</div>
                    <label id="announce">วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา<br> Chanapolkhan Technological College, Nakhon Ratchasima</label>
                    <label id="announce">กรุณาชำระค่าแรกเข้า จำนวน <span class="highlight">2,000</span> บาท หลังจากกรอกข้อมูลครบถ้วน</label>
                    <label id="announce">ยอดเงินนี้จะถูกนำไปเป็นส่วนลดค่าเทอมของนักศึกษา</label>
                    <label id="announce" class="mb-5">โอนเงินผ่านบัญชีธนาคาร ชื่อบัญชี: วิทยาลัยเทคโนโลยีชนะพลขันธ์<br>เลขที่บัญชี: <span class="highlight">374-105-5883 ธนาคารกรุงไทย</span></label>

                    <div class="col-md-3 mt-5">
                        <label class="form-label">สำเนาใบรบ. <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                        <input type="file" id="imgInput1" class="form-control" name="transcript" accept=".jpg,.jpeg,.png">
                        <a href="../config/uploads/<?php echo $Data_view["transcript"]; ?>" data-lightbox="documents" data-title="สำเนาใบรบ.">
                            <img id="previewImg1" src="./config/uploads/<?php echo $Data_view["transcript"]; ?>" width="100%" alt="">
                        </a>
                        <input type="hidden" class="form-control" name="transcript2" value="<?php echo $Data_view["transcript"]; ?>">
                    </div>

                    <div class="col-md-3 mt-5">
                        <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                        <input type="file" id="imgInput2" class="form-control" name="house_registration" accept=".jpg,.jpeg,.png">
                        <a href="../config/uploads/<?php echo $Data_view["house_registration"]; ?>" data-lightbox="documents" data-title="สำเนาทะเบียนบ้าน">
                            <img id="previewImg2" src="./config/uploads/<?php echo $Data_view["house_registration"]; ?>" width="100%" alt="">
                        </a>
                        <input type="hidden" class="form-control" name="house_registration2" value="<?php echo $Data_view["house_registration"]; ?>">
                    </div>

                    <div class="col-md-3 mt-5">
                        <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                        <input type="file" id="imgInput3" class="form-control" name="id_card" accept=".jpg,.jpeg,.png">
                        <a href="../config/uploads/<?php echo $Data_view["id_card"]; ?>" data-lightbox="documents" data-title="สำเนาบัตรประชาชน">
                            <img id="previewImg3" src="./config/uploads/<?php echo $Data_view["id_card"]; ?>" width="100%" alt="">
                        </a>
                        <input type="hidden" class="form-control" name="id_card2" value="<?php echo $Data_view["id_card"]; ?>">
                    </div>

                    <div class="col-md-3 mt-5">
                        <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg .jpeg เท่านั้น</span></label>
                        <input type="file" id="imgInput4" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png">
                        <a href="../config/uploads/<?php echo $Data_view["slip2000"]; ?>" data-lightbox="documents" data-title="หลักฐานการชำระ">
                            <img id="previewImg4" src="./config/uploads/<?php echo $Data_view["slip2000"]; ?>" width="100%" alt="">
                        </a>
                        <input type="hidden" class="form-control" name="slip20002" value="<?php echo $Data_view["slip2000"]; ?>">
                    </div>

                    <div class="col-md-2 mt-5">
                        <a href="Form.php" type="button" class="btn  w-100 py-2 btn-1">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </a>
                    </div>
                    <div class="col-md-8 mt-5"></div>
                    <div class="col-md-2 mt-5">
                        <button type="submit" name="submit" class="btn  w-100 py-2 btn-1">ยืนยัน
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
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
                console.log(result);  // Log the response for debugging
                if (result.includes("ข้อมูลได้ถูกอัปเดตเรียบร้อยแล้ว")) {
                    Swal.fire({
                        title: 'สำเร็จ!',
                        text: 'คุณสมัครเรียนเรียบร้อยแล้ว เจ้าหน้าที่กำลังตรวจสอบข้อมูล โปรดติดตามสถานะการสมัคร.',
                        icon: 'success',
                        confirmButtonText: 'ตกลง'
                    }).then(() => {
                        window.location.href = 'success.php';
                    });
                } else {
                    Swal.fire({
                        title: 'ผิดพลาด!',
                        text: 'มีข้อผิดพลาดในการสมัคร กรุณาลองใหม่อีกครั้ง.',
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>

</html>
