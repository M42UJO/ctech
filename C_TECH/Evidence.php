<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_login'];

// ดึงชื่อไฟล์จากฐานข้อมูล
$sql = "SELECT transcript, house_registration, id_card, slip2000 FROM form WHERE User_ID = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$files = [
    'transcript' => $result['transcript'] ?? '',
    'house_registration' => $result['house_registration'] ?? '',
    'id_card' => $result['id_card'] ?? '',
    'slip2000' => $result['slip2000'] ?? ''
];

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <!-- CSS and other includes -->
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
                    <?php if ($files['transcript']): ?>
                        <small class="form-text text-muted">ชื่อไฟล์ที่เลือก: <?php echo htmlspecialchars($files['transcript']); ?></small>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg เท่านั้น</span></label>
                    <input type="file" class="form-control" name="house_registration" accept=".jpg,.jpeg,.png" required>
                    <?php if ($files['house_registration']): ?>
                        <small class="form-text text-muted">ชื่อไฟล์ที่เลือก: <?php echo htmlspecialchars($files['house_registration']); ?></small>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg เท่านั้น</span></label>
                    <input type="file" class="form-control" name="id_card" accept=".jpg,.jpeg,.png" required>
                    <?php if ($files['id_card']): ?>
                        <small class="form-text text-muted">ชื่อไฟล์ที่เลือก: <?php echo htmlspecialchars($files['id_card']); ?></small>
                    <?php endif; ?>
                </div>
                <div class="col-md-3">
                    <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg เท่านั้น</span></label>
                    <input type="file" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png" required>
                    <?php if ($files['slip2000']): ?>
                        <small class="form-text text-muted">ชื่อไฟล์ที่เลือก: <?php echo htmlspecialchars($files['slip2000']); ?></small>
                    <?php endif; ?>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL " crossorigin="anonymous "></script>
<script src="script.js"></script>
</body>
</html>
