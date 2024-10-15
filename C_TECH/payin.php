<?php
session_start();
require_once("./config/db.php");
require_once __DIR__ . '../mPDF/vendor/autoload.php';

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
    die('เกิดข้อผิดพลาดในการสร้าง PDF: ' . $e->getMessage());
}


$user_id = $_SESSION['user_login'];

$stmt = $conn->prepare("
SELECT 
    u.*, 
    p.*, 
    f.*, 
    e.*, 
    c.*, 
    a.*,
    major.Major_Name,
    subjecttype.Type_Name,
    educationlevel.Level_Name,
    coursetype.CourseType_Name
FROM 
    user u
LEFT JOIN 
    parent_info p ON u.User_ID = p.User_ID
LEFT JOIN 
    form f ON u.User_ID = f.User_ID
LEFT JOIN 
    education_info e ON u.User_ID = e.User_ID
LEFT JOIN 
    current_address c ON u.User_ID = c.User_ID
LEFT JOIN 
    applicant a ON u.User_ID = a.User_ID
LEFT JOIN 
    major ON f.Major_ID = major.Major_ID
LEFT JOIN 
    subjecttype ON major.Type_ID = subjecttype.Type_ID
LEFT JOIN 
    educationlevel ON subjecttype.Level_ID = educationlevel.Level_ID
LEFT JOIN 
    coursetype ON educationlevel.CourseType_ID = coursetype.CourseType_ID
WHERE 
    u.User_ID = :user_id
");

// Bind parameter and execute the query
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Fetch all the results
$applicants = $stmt->fetchAll();


// ตรวจสอบว่ามีการกำหนดวันที่ไว้ใน session หรือยัง
if (!isset($_SESSION['print_date'])) {
    $_SESSION['print_date'] = date('d/m/Y'); // บันทึกวันที่ครั้งแรกใน session
}

$year = date("Y") + 543; // แปลงปีเป็น พ.ศ.
$date = new DateTime($_SESSION['print_date']);

// บวก 90 วันจากวันที่พิมพ์
$date->modify('+90 days');
$Schedule = $date->format('d/m/Y'); // แปลงกลับเป็นรูปแบบวันที่ที่ต้องการ








$html = '<style>
    body {
        font-family: "thsarabun";
    }
    @page {
        margin-top: 0.3cm;
        margin-bottom: 0.2cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
    }
.header-container {
    margin-bottom: 10px;
}
.logo {
    width: 60px; /* ลดขนาดโลโก้ */
    margin-bottom: 20px;
    float: left; /* ชิดซ้าย */
}
.header-text {
    margin-left: 20px; /* เว้นที่ให้ข้อความ */
    text-align: left; /* ชิดซ้าย */
}

.header-text h4 {
    font-size: 20px;
    color: #333;
    margin:  0;
    font-weight: normal;
}
.info-section {
    text-align: left;
    margin-bottom: 30px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}
h4 {
    font-size: 18px;
    margin: 5px 0;
}
.table-container {
    margin-bottom: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 0px;
    font-size: 16px;
}
table, th, td {
    border: 1px solid #ccc;
}
th {
    background-color: #e7f3fe;
    font-weight: bold;
    color: #0056b3;
    padding: 12px;
}
td {
    padding: 12px;
    text-align: center;
}
.total-row {
    background-color: #d9edf7;
    font-weight: bold;
    color: #0056b3;
}
.bank-details, .notice {
    padding: 15px;
    border: 1px solid #ddd;
    background-color: #f9f9f9;
    margin: 20px 0;
    color: #333;
}
.bank-details h4, .notice p {
    margin: 0;
}
.contact {
    text-align: center;
    font-size: 16px;
    color: #0056b3;
    margin-top: 10px;
}
.contact strong {
    color: #333;
}
.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 14px;
    color: #666;
}
.footer p {
    margin: 5px 0;
}
</style>';

$html .= '
<div class="header-container">
    <img src="./imagee/logo.jpg" class="logo">
    <div class="header-text">
        <h4>วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา <br>
        ใบแจ้งยอดชำระเงินค่าสมัคร ปีการศึกษา '.$year.' <br>
        วันที่ '.date('d/m/Y', strtotime($_SESSION['print_date'])).'</h4>
    </div>
</div>
    <hr style = "margin: 0">
    <h4>REF. NO1: 0000000001</h4>
    <hr style = "margin: 0">
    <h4>ชื่อ - สกุล: '.$applicants['name'].'  '.$applicants['lastname'].'</h4>
    <h4>เลขประจำตัวประชาชน: '.$applicants['id_card_number'].'</h4>


<div class="table-container">
    <h4 style = "margin-top: 20px">รายละเอียดการชำระเงิน</h4>
    <table>
        <thead>
            <tr>
                <th>NO.</th>
                <th>รายการ (Description)</th>
                <th>จำนวน (Amount)</th>
            </tr>
        </thead>
        <tbody style = "height: 200px";>
            <tr>
                <td>1</td>
                <td>ค่าธรรมเนียมการสมัคร สาขา '.$applicants['CourseType_Name'].' '.$applicants['Level_Name'].' '.$applicants['Type_Name'].' '.$applicants['Major_Name'].'</td>
                <td>2,000</td>
            </tr>
            <tr class="total-row">
                <td colspan="2">ยอดรวมทั้งหมด</td>
                <td>2,000</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="bank-details">
    <h4>กรุณาชำระเงินค่าแรกเข้า จำนวน 2,000 บาท ผ่านบัญชีธนาคารดังนี้:</h4>
    <p><strong>ชื่อบัญชี:</strong> วิทยาลัยเทคโนโลยีชนะพลขันธ์</p>
    <p><strong>เลขที่บัญชี:</strong> 374-105-5883</p>
    <p><strong>ธนาคาร:</strong> กรุงไทย</p>
    <h4>กำหนดชำระเงินภายในวันที่: '.$Schedule.'</h4>
    <p>หากพ้นกำหนดจะไม่สามารถชำระเงินได้ และการสมัครจะเป็นโมฆะ</p>
</div>

<div class="notice">
    <p>หมายเหตุ: เก็บเอกสารฉบับนี้ไว้เป็นหลักฐานการชำระเงิน โดยสามารถตรวจสอบสถานะการชำระเงินหลังจากท่านได้ชำระเงินแล้ว 1-3 วันทำการ</p>
</div>

<div class="contact">
    <p>หากมีข้อสงสัยเพิ่มเติม โปรดติดต่อ โทร.<strong> 088-3425813
</strong>  (อ.นา)</p>
    <p>หรือติดต่อไลน์: <strong>@745wetoo</strong></p>
</div>


';

$mpdf->WriteHTML($html);
$mpdf->Output();
