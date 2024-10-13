<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit();
}

$uploadStatus = isset($_SESSION['upload_status']) ? $_SESSION['upload_status'] : '';
unset($_SESSION['upload_status']); 

$user_id = $_SESSION['user_login'];

try {
    $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt->execute([$user_id]);
    $userData = $stmt->fetch();



    // ดึงข้อมูลสถานะและความคิดเห็นจากตาราง form
    $stmtForm = $conn->prepare("SELECT status, status_slip, comment, comment_slip, slip2000 FROM form WHERE user_id = ?");
    $stmtForm->execute([$user_id]);
    $formData = $stmtForm->fetch();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($formData) {
        $status = $formData['status'];
        $comment = $formData['comment'];
        $status_slip = $formData['status_slip'];
        $comment_slip = $formData['comment_slip'];
    } else {
        $status = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
        $comment = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
        $status_slip = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
        $comment_slip = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
    }


    // กำหนดข้อความตามสถานะและคลาส CSS
    if ($status == 'pending' || $status == 'update') {
        $message = "การสมัครของคุณกำลังอยู่ระหว่างการตรวจสอบ กรุณารอการอนุมัติจากเจ้าหน้าที่ ซึ่งกระบวนการนี้อาจใช้เวลา 1-3 วันทำการ";
        $statusClass = 'status-pending';
        $panelheading = 'panel-headingW';
    } elseif ($status == 'approve') {
        $message = "ยินดีด้วย!! การสมัครของคุณได้รับการอนุมัติเรียบร้อยแล้ว ยินดีต้องรับเข้าสู่ วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา กรุณาเพิ่มหลักฐานการชำระค่าแรกเข้า (Slip) หากท่านต้องการ Bill Payment Pay-In Slip สามารถดาวน์โหลดเพื่อชำระค่าแรกเข้า";
        $statusClass = 'status-approve';
        $panelheading = 'panel-headingS';
    } else {
        $message = "ข้อมูลการสมัครของคุณยังไม่ครบถ้วน กรุณากรอกข้อมูลส่วนตัวตรวจสอบเอกสารและข้อมูลที่ส่งมาเพื่ออัปเดตให้สมบูรณ์ ซึ่งจะช่วยให้เราสามารถดำเนินการตรวจสอบและอนุมัติการสมัครของคุณได้อย่างรวดเร็ว";
        $statusClass = 'status-incomplete';
        $panelheading = 'panel-headingD';
    }
    

    // กำหนดข้อความตามสถานะและคลาส CSS
    if ($status_slip == 'pending' || $status_slip == 'update') {
        $message_slip = "หลักฐานการชำระค่าแรกเข้าของคุณได้รับการส่งเรียบร้อยแล้ว ขณะนี้กำลังอยู่ในขั้นตอนการตรวจสอบ กรุณารอการอนุมัติจากเจ้าหน้าที่ ซึ่งกระบวนการนี้อาจใช้เวลา 1-3 วันทำการ ";
        $statusClass_slip = 'status-pending';
        $panelheading_slip = 'panel-headingW';
    } elseif ($status_slip == 'approve') {
        $message_slip = "หลักฐานการชำระค่าแรกเข้าของคุณได้รับการตรวจสอบและอนุมัติเรียบร้อยแล้ว ขอบคุณที่ชำระค่าแรกเข้าตามกำหนด";
        $statusClass_slip = 'status-approve';
        $panelheading_slip = 'panel-headingS';
    } else {
        $message_slip = "เมื่อการสมัครของคุณได้รับการอนุมัติเรียบร้อยแล้ว กรุณาเพิ่มหลักฐานการชำระค่าแรกเข้า (Slip) เพื่อดำเนินการตรวจสอบและอนุมัติการชำระค่าแรกเข้าของคุณ  กรุณาอัปโหลดหลักฐานการชำระค่าแรกเข้าผ่านทางระบบ";
        $statusClass_slip = 'status-incomplete';
        $panelheading_slip = 'panel-headingD';
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .status-pending {
        background-color: #fff3cd;
        /* สีพื้นหลังเหลืองอ่อน */
        color: #856404;
        /* สีข้อความเหลืองเข้ม */
        border: 1px solid #ffeeba;
        /* สีกรอบเหลืองอ่อน */
        border-radius: 5px;
        /* มุมกรอบมน */
        padding: 15px;
        /* ระยะห่างภายใน */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* เงาสำหรับกรอบ */
    }

    .status-approve {
        background-color: #d4edda;
        /* สีพื้นหลังเขียวอ่อน */
        color: #155724;
        /* สีข้อความเขียวเข้ม */
        border: 1px solid #c3e6cb;
        /* สีกรอบเขียวอ่อน */
        border-radius: 5px;
        /* มุมกรอบมน */
        padding: 15px;
        /* ระยะห่างภายใน */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* เงาสำหรับกรอบ */
    }

    .status-incomplete {
        background-color: #f8d7da;
        /* สีพื้นหลังแดงอ่อน */
        color: #721c24;
        /* สีข้อความแดงเข้ม */
        border: 1px solid #f5c6cb;
        /* สีกรอบแดงอ่อน */
        border-radius: 5px;
        /* มุมกรอบมน */
        padding: 15px;
        /* ระยะห่างภายใน */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* เงาสำหรับกรอบ */
    }

    .panel-headingW {
        font-weight: bold;
        font-size: 1.1em;
        background-color: orange;
        padding: 8px;
        border-radius: 0.25rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 0;
        color: aliceblue;
    }

    .panel-headingD {
        font-weight: bold;
        font-size: 1.1em;
        background-color: #721c24;
        padding: 8px;
        border-radius: 0.25rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 0;
        color: aliceblue;

    }

    .panel-headingS {
        font-weight: bold;
        font-size: 1.1em;
        background-color: #155724;
        padding: 8px;
        border-radius: 0.25rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 0;
        color: aliceblue;

    }

    .title-section {
        background-image: url('./imagee/pic_ctech.jpg');
        /* Replace with your image path */
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0;
        text-align: center;
        position: relative;
    }

    .title-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        /* Adjust overlay opacity */
        z-index: 1;
    }

    .title-content {
        position: relative;
        z-index: 2;
    }

    .breadcrumb {
        background-color: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: white;
        text-decoration: none;
    }

    .breadcrumb-item.active {
        color: orange;
    }

    .btn {
    flex: 1 1 auto;

    text-align: center;
    text-transform: uppercase;
    transition: 0.5s;
    background-size: 200% auto;

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
    <?php require_once("nav.php"); ?>

    <div class="title-section">
        <div class="title-content">
            <h1>ตรวจสอบสถานะการสมัครเรียน</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">C-TECH</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="alert <?php echo $statusClass; ?>" role="alert">
                            <div class="<?php echo $panelheading; ?>">สถานะการสมัคร</div>
                            <h4 class="alert-heading mt-3">สถานะการสมัคร</h4>
                            <p><?php echo $message; ?></p>
                            <?php if (!empty($comment)): ?>
                                <div class="mt-3">
                                    <strong>ความคิดเห็นจากเจ้าหน้าที่:</strong>
                                    <p><?php echo htmlspecialchars($comment); ?></p>
                                </div>
                            <?php endif; ?>
                            <?php if ($status == 'approve'): ?>
                                <a href="report.php" target="_blank" class="btn btn-outline-dark">ดาวน์โหลด PDF ใบมอบตัว</a>
                            <?php endif; ?>

                        </div>
                    </div>  
                </div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <form action="./config/insertSlip.php" method="post" enctype="multipart/form-data"> 
                        <div class="alert <?php echo $statusClass_slip; ?>" role="alert">
                            <div class="<?php echo $panelheading_slip; ?>">สถานะการชำระเงิน</div>
                            <label id="" class="announce mt-3 mb-3   ">วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา <br> Chanapolkhan Technological College, Nakhon Ratchasima <br> กรุณาชำระค่าแรกเข้า จำนวน <span class="highlight">2,000</span> บาท หลังจากกรอกข้อมูลครบถ้วน
                              <br>  ยอดเงินนี้จะถูกนำไปเป็นส่วนลดค่าเทอมของนักศึกษา
                              <br>  โอนเงินผ่านบัญชีธนาคาร ชื่อบัญชี: วิทยาลัยเทคโนโลยีชนะพลขันธ์   เลขที่บัญชี: <span class="highlight">374-105-5883 ธนาคารกรุงไทย</span><br> <span class="required">**หมายเหตุ เมื่อชำระค่าแรกเข้าแล้วทางวิทยาลัยจะไม่คืนเงินทุกกรณี**</span></label>

                            <h4 class="alert-heading mt-3">สถานะการชำระเงิน</h4>
                            <?php if ($status == 'pending' || $status == 'update'): ?>
                            <span class="required">**ต้องสถานะการสมัครเป็น "อนุมัติ" จึงแนบหลักฐานการชำระได้**</span>
                            <?php endif; ?>
                            <p><?php echo $message_slip; ?></p>
                            <?php if (!empty($comment_slip)): ?>
                                <div class="mt-3">
                                    <strong>ความคิดเห็นจากเจ้าหน้าที่:</strong>
                                    <p><?php echo htmlspecialchars($comment_slip); ?></p>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md-6 ">
                                <?php if ($status == 'approve'): ?>
                                    <label class="form-label">Bill Payment Pay-In Slip </label>
                                    <a href="payin.php" target="_blank" class="btn btn-outline-dark">ดาวน์โหลด Pay-In Slip <i class="fa-solid fa-download"></i></a>
                                    <?php endif; ?>
                                </div>
                               

                                <div class="col-md-6">
                                <?php if ($status == 'approve'): ?>
                                    <label class="form-label">หลักฐานการชำระ(Slip) </label>
                                    <input type="file" id="imgInput4" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png" required>
                                    <a href="./config/uploads/<?php echo $formData["slip2000"]; ?>" data-lightbox="documents" data-title="หลักฐานการชำระ">
                                        <img id="previewImg4" src="./config/uploads/<?php echo $formData["slip2000"]; ?>" width="100%" alt="">
                                    </a>
                                    <input type="hidden" class="form-control" name="slip20002" value="<?php echo $formData["slip2000"]; ?>">
                                    
                                </div>
                                <div class="col-md-6 ms-auto mt-2">
                                <button type="submit" name="submit" class="btn w-100  py-2 btn-1">ยืนยัน
                                    <i class="fas fa-check"></i>
                                </button>
                                <?php endif; ?>
                                </div>
                            </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        imgInput4.onchange = evt => {
            const [file4] = imgInput4.files;
            if (file4) {
                previewImg4.src = URL.createObjectURL(file4);
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
        <?php if ($uploadStatus === 'success'): ?>
            Swal.fire({
                title: 'สำเร็จ!',
                text: 'การอัปโหลดหลักฐานการชำระ(Slip)เสร็จสิ้น',
                icon: 'success',
                confirmButtonText: 'ตกลง'
            });
        <?php elseif ($uploadStatus === 'error'): ?>
            Swal.fire({
                title: 'ผิดพลาด!',
                text: 'เกิดข้อผิดพลาดในการอัปโหลดหลักฐานการชำระ(Slip)',
                icon: 'error',
                confirmButtonText: 'ตกลง'
            });
        <?php endif; ?>
    });
    </script>
</body>

</html>