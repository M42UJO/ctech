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
    a.name, 
    a.lastname, 
    u.id_card_number, 
    f.created_at, 
    f.status, 
    f.Major_ID,
    major.Major_Name
FROM 
    user u
LEFT JOIN 
    form f ON u.User_ID = f.User_ID
LEFT JOIN 
    applicant a ON u.User_ID = a.User_ID
LEFT JOIN 
    major ON f.Major_ID = major.Major_ID
WHERE 
    YEAR(f.created_at) = :year
ORDER BY 
    f.Major_ID
");
$stmt->bindParam(':year', $selectYear, PDO::PARAM_INT);

// Execute the statement
$stmt->execute();

// Fetch all the data
$applicants = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($applicants)) {
    die('ไม่มีข้อมูลผู้สมัคร');
}

$html = '
<style>
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
</style>
';

$currentMajor = '';
$index = 1; // เปลี่ยนเป็น 1 นอกลูป

foreach ($applicants as $applicant) {
    // Check if the current major is different from the previous
    if ($currentMajor != $applicant['Major_Name']) {
        // Close the previous table if it's not the first major
        if ($currentMajor != '') {
            $html .= '</tbody></table>';
        }

        // Add a new page for the new major
        $mpdf->AddPage();
        
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
    }

    // Add each applicant's data to the table
    $html .= '
    <tr>
        <td>' . $index++ . '</td> 
        <td>' . htmlspecialchars($applicant['name'] . ' ' . $applicant['lastname']) . '</td> 
        <td>' . htmlspecialchars($applicant['id_card_number']) . '</td> 
        <td>' . htmlspecialchars($applicant['created_at']) . '</td> 
        <td>' . htmlspecialchars($applicant['status']) . '</td> 
    </tr>';
}

// Close the last table after the loop
if ($currentMajor != '') {
    $html .= '</tbody></table>'; // ปิดตารางสุดท้าย
}

// Generate the PDF with the entire HTML
$mpdf->WriteHTML($html);
$mpdf->Output();
