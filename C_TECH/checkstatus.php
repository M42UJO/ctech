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

    // ดึงข้อมูลสถานะและความคิดเห็นจากตาราง form
    $stmtForm = $conn->prepare("SELECT status, comment FROM form WHERE user_id = ?");
    $stmtForm->execute([$user_id]);
    $formData = $stmtForm->fetch();

    // ตรวจสอบว่ามีข้อมูลหรือไม่
if ($formData) {
    $status = $formData['status'];
    $comment = $formData['comment'];
} else {
    $status = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
    $comment = null; // หรือกำหนดค่าเริ่มต้นอื่นๆ
}


    // กำหนดข้อความตามสถานะและคลาส CSS
    if ($status == 'pending' || $status == 'update') {
        $message = "การสมัครของคุณอยู่ระหว่างการตรวจสอบ ทีมงานกำลังตรวจสอบเอกสารที่คุณได้ส่งมา หากต้องการข้อมูลเพิ่มเติมหรือมีข้อสงสัยใด ๆ กรุณาติดต่อเรา";
        $statusClass = 'status-pending';
    } elseif ($status == 'approve') {
        $message = "คุณได้รับการอนุมัติแล้ว ขอแสดงความยินดี! การสมัครของคุณได้รับการอนุมัติเรียบร้อยแล้ว กรุณาตรวจสอบรายละเอียดเพิ่มเติมในระบบหรือติดต่อเรา หากมีข้อสงสัย";
        $statusClass = 'status-approve';
    } else {
        $message = "ข้อมูลยังไม่ครบถ้วน ข้อมูลการสมัครของคุณยังไม่สมบูรณ์ กรุณาตรวจสอบเอกสารและข้อมูลที่ส่งมาแล้วอัพเดตให้ครบถ้วนเพื่อให้เราสามารถดำเนินการตรวจสอบได้";
        $statusClass = 'status-incomplete';
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
</head>
<style>
    .status-pending {
    background-color: #fff3cd; /* สีพื้นหลังเหลืองอ่อน */
    color: #856404; /* สีข้อความเหลืองเข้ม */
    border: 1px solid #ffeeba; /* สีกรอบเหลืองอ่อน */
    border-radius: 5px; /* มุมกรอบมน */
    padding: 15px; /* ระยะห่างภายใน */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เงาสำหรับกรอบ */
}

.status-approve {
    background-color: #d4edda; /* สีพื้นหลังเขียวอ่อน */
    color: #155724; /* สีข้อความเขียวเข้ม */
    border: 1px solid #c3e6cb; /* สีกรอบเขียวอ่อน */
    border-radius: 5px; /* มุมกรอบมน */
    padding: 15px; /* ระยะห่างภายใน */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เงาสำหรับกรอบ */
}

.status-incomplete {
    background-color: #f8d7da; /* สีพื้นหลังแดงอ่อน */
    color: #721c24; /* สีข้อความแดงเข้ม */
    border: 1px solid #f5c6cb; /* สีกรอบแดงอ่อน */
    border-radius: 5px; /* มุมกรอบมน */
    padding: 15px; /* ระยะห่างภายใน */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* เงาสำหรับกรอบ */
}
.title-section {
            background-image: url('./imagee/pic_ctech.jpg'); /* Replace with your image path */
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
            background-color: rgba(0, 0, 0, 0.6); /* Adjust overlay opacity */
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
                            <div class="panel-heading">สถานะการสมัคร</div>
                            <h4 class="alert-heading mt-3">สถานะการสมัคร</h4>
                            <p><?php echo $message; ?></p>
                            <?php if (!empty($comment)): ?>
                                <div class="mt-3">
                                    <strong>ความคิดเห็นจากเจ้าหน้าที่:</strong>
                                    <p><?php echo htmlspecialchars($comment); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <a href="report.php" target="_blank" class="btn btn-outline-dark">ดาวน์โหลด PDF</a>
            </div>
            <div class="col-md-6 mt-5">
            <embed src="imagee/register2018.pdf" width="100%" height="800px" type="application/pdf">

                
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
