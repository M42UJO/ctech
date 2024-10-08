<?php
session_start();
require_once("../config/db.php");
require_once __DIR__ . '/../mPDF/vendor/autoload.php';

// สร้างอ็อบเจกต์ mPDF
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
    // รหัสสำหรับจัดการข้อผิดพลาดในการสร้าง mPDF
    die('เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
}

$selectYear = $_POST['selectYear'] ?? date("Y");


// ตรวจสอบการเตรียมคำสั่ง SQL
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
    a.User_ID = b.User_ID and a.User_ID = c.User_ID and c.Major_ID = d.Major_ID and 
    YEAR(c.created_at) = :year
GROUP BY 
    d.Major_ID
");
$stmt->bindParam(':year', $selectYear, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch all the data
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row = $stmt->rowCount();

if (empty($applicants)) {
    die('กรุณาเลือกปีที่แสดง');
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
$index = 1; // เปลี่ยนเป็น 1 นอกลูป
$i=0;
foreach ($applicants as $applicant) {
    $stmt_view = $conn->prepare("
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
        a.User_ID = b.User_ID and a.User_ID = c.User_ID and c.Major_ID = d.Major_ID and 
        YEAR(c.created_at) = :year and c.Major_ID = :majorID
    ORDER BY 
        d.Major_ID
    ");
    $stmt_view->bindParam(':year', $selectYear, PDO::PARAM_INT);
    $stmt_view->bindParam(':majorID', $applicant['Major_ID'], PDO::PARAM_INT);

    // Execute the statement
    $stmt_view->execute();

    // Fetch all the data
    $user_views = $stmt_view->fetchAll(PDO::FETCH_ASSOC);

    

        // Update the current major
        $currentMajor = $applicant['Major_Name'];

        // Add header for the new major
        $html .= '
        <div class="header-container">
            <div>
                <img src="../imagee/logo.jpg" class="logo">
            </div>
            <div class="header-text">
                <h1>รายงานรายชื่อผู้สมัครเข้าศึกษา</h1>
                <h2>วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา</h2>
                <h3>ประจำปีการศึกษา ' . htmlspecialchars($selectYear) . ' สาขา ' . htmlspecialchars($currentMajor) . '</h3>
            </div>
        </div>
        <h3>รายชื่อผู้สมัคร สาขา ' . htmlspecialchars($currentMajor) . '</h3>
        <table>
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>เลขบัตรประชาชน</th>
                    <th>วันที่สมัคร</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>';
        $index = 1; // Reset the index for the new major
    //}

    foreach ($user_views as $user_view) {
    // Add each applicant's data to the table
    $html .= '
    <tr>
        <td>' . $index++ . '</td> 
        <td>' . htmlspecialchars($user_view['name'] . ' ' . $user_view['lastname']) . '</td> 
        <td>' . htmlspecialchars($user_view['id_card_number']) . '</td> 
        <td>' . htmlspecialchars($user_view['created_at']) . '</td> 
        <td>' . htmlspecialchars($user_view['status']) . '</td> 
    </tr>';
    }
    $html .= '</tbody></table>';

    $i++;

    if($row == $i){}else{
        $html .= '<div style="page-break-after: always"></div>';
    }
    
    //$mpdf->AddPage();
}
// Close the last table after the loop
/*if ($currentMajor != '') {
    $html .= '</tbody></table>'; // ปิดตารางสุดท้าย
}*/

// Generate the PDF with the entire HTML
//$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output();
?>