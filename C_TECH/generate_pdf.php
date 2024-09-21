<?php
// เรียกใช้งาน autoload ของ Composer
require './mPDF/vendor/autoload.php';

// สร้างอินสแตนซ์ของ mPDF
$mpdf = new \Mpdf\Mpdf();

// เขียนเนื้อหาที่ต้องการแสดงใน PDF
$htmlContent = '
<!DOCTYPE html>
<html>
<head>
    <title>My PDF</title>
</head>
<body>
    <h1>ยินดีต้อนรับสู่ mPDF!</h1>
    <p>นี่คือการสร้าง PDF ด้วย mPDF 7.1</p>
</body>
</html>
';

// เขียนเนื้อหาลงใน PDF
$mpdf->WriteHTML($htmlContent);

// ส่ง PDF ไปยังเบราว์เซอร์
$mpdf->Output('my_pdf.pdf', 'D'); // D สำหรับดาวน์โหลด, I สำหรับแสดงในเบราว์เซอร์
