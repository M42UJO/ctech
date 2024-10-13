<?php
session_start();
require_once("../config/db.php");
require_once __DIR__ . '/../mPDF/vendor/autoload.php';

try {
    $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => array_merge($fontDirs, [
            __DIR__ . '/vendor/mpdf/mpdf/ttfonts',
        ]),
        'fontdata' => $fontData + [
            'thsarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabun-Italic.ttf',
            ]
        ],
        'default_font' => 'thsarabun'
    ]);
} catch (\Mpdf\MpdfException $e) { 
    die('เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
}

// รับค่าช่วงวันที่จาก GET
$startDate = $_GET['startDate'] ?? null;
$endDate = $_GET['endDate'] ?? null;

if (!$startDate || !$endDate) {
    die('กรุณาเลือกวันที่เริ่มต้นและวันที่สิ้นสุด');
}

$stmt = $conn->prepare("
    SELECT 
        b.name, 
        b.lastname, 
        b.id_card_number, 
        c.created_at, 
        c.status, 
        c.Major_ID,
        d.Major_Name
    FROM user a, applicant b, form c, major d 
    WHERE 
        a.User_ID = b.User_ID AND a.User_ID = c.User_ID AND c.Major_ID = d.Major_ID AND 
        c.created_at BETWEEN :startDate AND :endDate
    GROUP BY 
        d.Major_ID
");

$stmt->bindParam(':startDate', $startDate);
$stmt->bindParam(':endDate', $endDate);

$stmt->execute();

$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row = $stmt->rowCount();

if (empty($applicants)) {
    die('ไม่มีผู้สมัครในช่วงวันที่ที่เลือก');
}

$html = '<style>
    body {
        font-family: "thsarabun";
    }
    @page {
        margin-top: 0.1cm;
        margin-bottom: 0.2cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
    }
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .logo {
        height: 80px;
    }
    .header-text {
        flex: 1;
        text-align: center;
        margin-left: 10px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 8px;
        text-align: center;
    }
</style>';

$currentMajor = '';
$index = 1; 
$i = 0;

foreach ($applicants as $applicant) {
    $stmt_view = $conn->prepare("
        SELECT 
            b.name, 
            b.lastname, 
            b.id_card_number, 
            c.created_at, 
            c.status, 
            c.Major_ID,
            g.CourseType_Name,
            l.Level_Name,
            e.Type_Name,
            d.Major_Name
        FROM user a
        JOIN applicant b ON a.User_ID = b.User_ID
        JOIN form c ON a.User_ID = c.User_ID
        JOIN major d ON c.Major_ID = d.Major_ID
        JOIN subjecttype e ON d.Type_ID = e.Type_ID 
        JOIN educationlevel l ON e.Level_ID = l.Level_ID 
        JOIN coursetype g ON l.CourseType_ID = g.CourseType_ID 
        WHERE 
            c.created_at BETWEEN :startDate AND :endDate 
            AND c.Major_ID = :majorID
        ORDER BY 
            d.Major_ID
    ");
    
    $stmt_view->bindParam(':startDate', $startDate);
    $stmt_view->bindParam(':endDate', $endDate);
    $stmt_view->bindParam(':majorID', $applicant['Major_ID'], PDO::PARAM_INT);

    $stmt_view->execute();

    $user_views = $stmt_view->fetchAll(PDO::FETCH_ASSOC);
    $currentMajor = $applicant['Major_Name'];

    $html .= '
    <div class="header-container">
        <div>
            <img src="../imagee/logo.jpg" class="logo">
        </div>
        <div class="header-text">
            <h1>รายงานรายชื่อผู้สมัครเข้าศึกษา</h1>
            <h2>วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา</h2>
            <h3>ระหว่างวันที่ ' . htmlspecialchars($startDate) . ' ถึง ' . htmlspecialchars($endDate) . ' สาขา ' . htmlspecialchars($currentMajor) . '</h3>
        </div>
    </div>
    <h3>รายชื่อผู้สมัคร สาขา ' . htmlspecialchars($currentMajor) . '</h3>
    <table>
        <thead>
            <tr>
                <th>ลำดับ</th>
                <th>ชื่อ-นามสกุล</th>
                <th>เลขบัตรประชาชน</th>
                <th>สาขาวิชา</th>
                <th>วันที่สมัคร</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>';
    $index = 1;

    foreach ($user_views as $user_view) {
        $html .= '
        <tr>
            <td>' . $index++ . '</td> 
            <td>' . htmlspecialchars($user_view['name'] . ' ' . $user_view['lastname']) . '</td> 
            <td>' . htmlspecialchars($user_view['id_card_number']) . '</td> 
            <td>' . htmlspecialchars($user_view['CourseType_Name'] .' '.$user_view['Level_Name'] .' '. $user_view['Type_Name'].' '. $user_view['Major_Name']) . '</td> 
            
            <td>' . htmlspecialchars($user_view['created_at']) . '</td> 
            <td>' . htmlspecialchars($user_view['status']) . '</td> 
        </tr>';
    }
    $html .= '</tbody></table>';

    $i++;

    if ($row == $i) {
        // Last iteration, do nothing
    } else {
        $html .= '<div style="page-break-after: always"></div>';
    }
}

$mpdf->WriteHTML($html);
$mpdf->Output();
?>
