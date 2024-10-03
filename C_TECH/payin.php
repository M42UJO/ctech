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
        ใบแจ้งยอดชำระเงินค่าสมัคร ปีการศึกษา(....) <br>
        วันที่ (....)</h4>
    </div>
</div>
    <hr style = "margin: 0">
    <h4>REF. NO1: 0000000001</h4>
    <hr style = "margin: 0">
    <h4>ชื่อ - สกุล: [กรอกชื่อที่นี่]</h4>
    <h4>เลขประจำตัวประชาชน: [กรอกเลขบัตรประชาชน]</h4>


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
        <tbody>
            <tr>
                <td>1</td>
                <td>ค่าสมัครเรียน</td>
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
    <h4>กำหนดชำระเงินภายในวันที่: [วันที่กำหนด]</h4>
    <p>หากพ้นกำหนดจะไม่สามารถชำระเงินได้ และการสมัครจะเป็นโมฆะ</p>
</div>

<div class="notice">
    <p>หมายเหตุ: เก็บเอกสารฉบับนี้ไว้เป็นหลักฐานการชำระเงิน โดยสามารถตรวจสอบสถานะการชำระเงินหลังจากท่านได้ชำระเงินแล้ว 1-2 วันทำการ</p>
</div>

<div class="contact">
    <p>หากมีข้อสงสัยเพิ่มเติม โปรดติดต่อฝ่ายการเงิน โทร. <strong>044-123456</strong></p>
    <p>หรือส่งอีเมล: <strong>finance@chncollege.ac.th</strong></p>
</div>


';

$mpdf->WriteHTML($html);
$mpdf->Output();
