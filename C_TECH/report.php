<?php
session_start();
require_once("./config/db.php");
require_once __DIR__ . '../mPDF/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/vendor/mpdf/mpdf/ttfonts',
    ]),
    'fontdata' => $fontData + [
        'frutiger' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabun-Italic.ttf',

        ]
    ],
    'default_font' => 'frutiger'
]);

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





$t = '
<style>
    body{
        font-family: "thsarabun";//เรียกใช้font Garuda สำหรับแสดงผล ภาษาไทย
    }
    @page {
        margin-top: 0.3cm;
        margin-bottom: 0.2cm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
    }
</style>
<br>
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <td align="left"><img src="imagee/logo.jpg"></td>
        <td>
        <table>
            <tr>
                <td align="center">
                <table style="border:3px solid #000;padding-left:10px;padding-right:10px;padding-top:-7px;padding-bottom:-4px;margin-bottom:-5px;">
                    <tr>
                        <td><font style="font-size:35px;"><b>ใบมอบตัวนักศึกษา</b></font></td>
                    </tr>
                </table>
                </td>
            </tr>
            <tr>
                <td align="center" style="padding-bottom:-5px;"><font style="font-size:30px;"><b>วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา</b></font></td>
            </tr>
            <tr>
                <td align="center" style="padding-bottom:-5px;"><font style="font-size:15px;">
                77/1 หมู่ 4 ถนนมิตรภาพ ตำบลบ้านใหม่ อำเภอเมือง จังหวัดนครราชสีมา 30000
                </font></td>
            </tr>
            <tr>
                <td align="center" width="500"><font style="font-size:15px;">
                โทร : 044-465168-9 แฟกซ์ : 044-465165 ต่อ 207 เว็บไซต์ : www.c-tech.ac.th อีเมล : ctechkorat@gmail.com
                </font></td>
            </tr>
            <tr>
                <td align="center" style="padding-top:5px;">
                <font style="font-size:22px;">วันที่.............เดือน......................................พ.ศ. ....................</font>
                </td>
            </tr>
        </table>
        </td>';
if (isset($applicants[0])) {
    $applicant = $applicants[0]; // Access the first applicant record
    $id_card_number = $applicant["id_card_number"];
	$arr_zipcode_std=str_split($applicant["postal_code"]);
	$arr_phone_std=str_split($applicant["phone_number"]);
	$arr_zipcode_s=str_split($applicant["school_postal_code"]);
	$arr_zipcode_f=str_split($applicant["father_postal_code"]);
	$arr_phone_f=str_split($applicant["father_phone_number"]);
	$arr_zipcode_m=str_split($applicant["mother_postal_code"]);
	$arr_phone_m=str_split($applicant["mother_phone_number"]);
	$arr_zipcode_g=str_split($applicant["guardian_postal_code"]);
	$arr_phone_g=str_split($applicant["guardian_phone_number"]);

    $arr_id_card = str_split($id_card_number);
    



    $displaydate = $applicant["birth_day"]."/".$applicant["birth_month"]."/".$applicant["birth_year"]; // ปีเกิด
    $current_year = date("Y") + 543; // ปีปัจจุบันในพุทธศักราช
    $age = $current_year - $applicant["birth_year"]; // คำนวณอายุ
    
    




    if ($applicant["profile_image"] == "") {
        $t .= '<td align="right">
                    <table style="border:3px solid #000;">
                        <tr>
                            <td align="center" style="width:90px;height:120px;"><font style="font-size:20px;">รูปถ่าย 1 นิ้ว</font></td>
                        </tr>
                    </table>
                </td>';
    } else {
        $t .= '<td align="right">
                    <table style="border:3px solid #000;">
                        <tr>
                            <td align="center" style="width:90px;height:120px;"><img src="config/uploads/' . htmlspecialchars($applicant["profile_image"]) . '" style="width:90px;height:120px;"></td>
                        </tr>
                    </table>
                </td>';
    }
    $t .= '</tr>
            </table>';
}

$t2 = '
<table width="100%" style="border-collapse: collapse;">
    <tr>
        <td style="border:3px solid #000;padding-left:6px;">
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;"><b>สมัครเป็นนักศึกษา</b></font></td>
                    <td align="right" style="padding-left:4px;padding-right:4px;width:40px;padding-bottom:0px;">';
if ($applicant["Major_ID"] == 1 or $applicant["Major_ID"] == 3) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">ภาคปกติ</font></td>
                    <td align="right" style="padding-left:4px;padding-right:4px;width:40px;padding-bottom:0px;">';
if ($applicant["Major_ID"] == 2) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">ภาคสมทบ</font></td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-left:4px;padding-right:4px;padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 2 or $applicant["Major_ID"] == 4) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">หลักสูตร ปวช. ปกติ</font></td>
                    <td align="right" style="padding-left:4px;padding-right:4px;width:40px;padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 3) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">หลักสูตร ปวช. ทวิภาคี</font></td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-left:4px;padding-right:4px;padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 1) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">หลักสูตร ปวส. ปกติ</font></td>
                    <td align="right" style="padding-left:4px;padding-right:4px;width:40px;padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 5) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                    <td style="padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">หลักสูตร ปวส. ทวิภาคี</font></td>
                </tr>
            </table>
        </td>
        <td style="border:3px solid #000;padding-right:6px;" align="right">
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">รหัสประจำตัวนักศึกษา</font></td>
                    <td style="padding-left:4px;">
                    <table width="100%" style="padding:0px;border-collapse: collapse;">
                        <tr>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                            <td style="border:2px solid #000;width:16px;height:16px;"></td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-left:4px;padding-right:4px;"><img src="imagee/check2.jpg"></td>
                    <td><font style="font-size:18px;">ผู้กู้รายเก่า (ทุนต่อเนื่อง)</font></td>
                    <td align="right" style="padding-left:4px;padding-right:4px;width:40px;"><img src="imagee/check2.jpg"></td>
                    <td><font style="font-size:18px;">ผู้กู้รายใหม่</font></td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td><font style="font-size:18px;">เลขบัตรประจำตัวประชาชน</font></td>
                    <td>
                    <table width="100%" style="padding:0px;border-collapse: collapse;">
                        <tr>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[0] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[2] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[3] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[4] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[5] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[7] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[8] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[9] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[10] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[11] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[13] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[14] . '</b></td>
                            <td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>' . $arr_id_card[16] . '</b></td>
                        </tr>
                    </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="border:3px solid #000;padding-left:6px;padding-top:-3px;padding-bottom:-1px;"><font style="font-size:18px;"><b>สาขาวิชา ระดับ ปวช.</b></font></td>
        <td style="border:3px solid #000;padding-left:6px;padding-top:-3px;padding-bottom:-1px;"><font style="font-size:18px;"><b>สาขาวิชา ระดับ ปวส.</b></font></td>
    </tr>
    <tr>
        <td style="border:3px solid #000;padding-left:20px;padding-bottom:5px;" valign="top">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 1) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการบัญชี</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 2 or $applicant["Major_ID"] == 41) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาคอมพิวเตอร์ธุรกิจ</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 5) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาธุรกิจค้าปลีก</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 46) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการตลาด</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 43) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาช่างยนต์</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 44 or $applicant["Major_ID"] == 8) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาช่างไฟฟ้ากำลัง</font></td>
            </tr>
        </table>
        </td>
        <td style="border:3px solid #000;padding-left:20px;" valign="top">
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 12 or $applicant["Major_ID"] == 25) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการบัญชี</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 19) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาเทคนิคยานยนต์</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 23 or $applicant["Major_ID"] == 45) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาเทคโนโลยีดิจิทัล</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 20 or $applicant["Major_ID"] == 27) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาไฟฟ้ากำลัง</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 24) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการตลาด</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 28) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาอิเล็กทรอนิกส์</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 18) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการโรงแรม</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 38) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาช่างก่อสร้าง</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 31) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการจัดการธุรกิจค้าปลีก</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 22 or $applicant["Major_ID"] == 29) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาเทคโนโลยีคอมพิวเตอร์</font></td>
            </tr>
            <tr>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 17 or $applicant["Major_ID"] == 37) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาการจัดการโลจิสติกส์</font></td>
                <td style="padding-bottom:-3px;">';
if ($applicant["Major_ID"] == 47) {
    $t2 .= '<img src="imagee/check_t.jpg">';
} else {
    $t2 .= '<img src="imagee/check2.jpg">';
}
$t2 .= '</td>
                <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สาขาวิชาเทคโนโลยีสารสนเทศ</font></td>
            </tr>
        </table>
        </td>
    </tr>
</table>
';

$t3 = '
	<table width="100%" style="border-collapse: collapse;">
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;"><font style="font-size:18px;">ชื่อ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:230px;padding-bottom:-1px;" align="center"><font style="font-size:18px;"><b>'.$applicant["prefix"].$applicant["name"].'&nbsp;'.$applicant["lastname"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;"><font style="font-size:18px;">&nbsp;&nbsp;อังกฤษ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:260px;padding-bottom:-1px;" align="center"><font style="font-size:18px;"><b>'.$applicant["eng_name"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;"><font style="font-size:18px;">&nbsp;&nbsp;ชื่อเล่น : </font></td>
						<td style="border-bottom: 1px dotted #000;width:110px;padding-bottom:-1px;" align="center"><font style="font-size:18px;"><b>'.$applicant["nickname"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">วัน/เดือน/ปีเกิด&nbsp;:&nbsp;</font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$displaydate.'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อายุ&nbsp;:&nbsp;</font></td>
						<td style="border-bottom: 1px dotted #000;width:60px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$age.'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ปี</font></td>
						<td valign="bottom" align="right" style="width:90px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">กรุ๊ปเลือด&nbsp;:&nbsp;</font></td>
						<td style="border-bottom: 1px dotted #000;width:60px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["blood_group"].'</b></font></td>
						<td valign="bottom" align="right" style="width:70px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ส่วนสูง&nbsp;:&nbsp;</font></td>
						<td style="border-bottom: 1px dotted #000;width:60px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["height"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ซม.</font></td>
						<td valign="bottom" align="right" style="width:70px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">น้ำหนัก&nbsp;:&nbsp;</font></td>
						<td style="border-bottom: 1px dotted #000;width:60px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["weight"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">กก.</font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">เชื้อชาติ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["nationality"].'</b></font></td>
						<td valign="bottom" align="right" style="width:60px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">สัญชาติ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["citizenship"].'</b></font></td>
						<td valign="bottom" align="right" style="width:60px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ศาสนา : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["religion"].'</b></font></td>
						<td valign="bottom" align="right" style="width:90px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จำนวนพี่น้อง : </font></td>
						<td style="border-bottom: 1px dotted #000;width:40px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["siblings_count"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">คน</font></td>
						<td valign="bottom" align="right" style="width:160px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จำนวนพี่น้องที่กำลังศึกษาอยู่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:40px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["studying_siblings_count"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">คน</font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ที่อยู่ปัจจุบัน เลขที่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:50px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["house_number"].'</b></font></td>
						<td valign="bottom" align="right" style="width:30px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">หมู่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:20px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["village"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ซอย : </font></td>
						<td style="border-bottom: 1px dotted #000;width:80px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["lane"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ถนน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:80px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["road"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ตำบล : </font></td>
						<td style="border-bottom: 1px dotted #000;width:100px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["sub_district"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อำเภอ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:100px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["district"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จังหวัด : </font></td>
						<td style="border-bottom: 1px dotted #000;width:170px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["province"].'</b></font></td>
						<td valign="bottom" align="right" style="width:100px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รหัสไปรษณีย์ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_std[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_std[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_std[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_std[3].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_std[4].'</b></td>
							</tr>
						</table>
						</td>
						<td valign="bottom" align="right" style="width:120px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">โทรศัพท์มือถือ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[4].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[5].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[6].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[8].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[9].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[10].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_std[11].'</b></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ID LINE : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["line_id"].'</b></font></td>
						<td valign="bottom" align="right" style="width:90px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">FACEBOOK : </font></td>
						<td style="border-bottom: 1px dotted #000;width:190px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["facebook"].'</b></font></td>
						<td valign="bottom" align="right" style="width:70px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">E-Mail : </font></td>
						<td style="border-bottom: 1px dotted #000;width:200px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.''.'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จบการศึกษาจากโรงเรียน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:430px;padding-bottom:-1px;padding-top:-7px;" align="left"><font style="font-size:18px;"><b>'.$applicant["school_name"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ตำบล : </font></td>
						<td style="border-bottom: 1px dotted #000;width:135px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["school_sub_district"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อำเภอ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:130px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["school_district"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จังหวัด : </font></td>
						<td style="border-bottom: 1px dotted #000;width:170px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["school_province"].'</b></font></td>
						<td valign="bottom" align="right" style="width:80px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รหัสไปรษณีย์ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;width:120px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_s[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_s[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_s[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_s[3].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_s[4].'</b></td>
							</tr>
						</table>
						</td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จบเมื่อ พ.ศ. : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["graduation_year"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						
						<td valign="bottom" style="width:70px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ผลการเรียน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["grade_result"].'</b></font></td>
						<td valign="bottom" align="right" style="width:60px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ระดับชั้น : </font></td>
						<td style="padding-bottom:-3px;">';
						if($applicant["class_level"]=="ม.3"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ม.3</font></td>
						<td style="padding-bottom:-3px;">';
						if($applicant["class_level"]=="ม.6"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ม.6</font></td>
						<td style="padding-bottom:-3px;">';
						if($applicant["class_level"]=="ปวช."){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ปวช.</font></td>
						<td valign="bottom" align="right" style="width:60px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">สาขาวิชา : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["major"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">วุฒิอื่นๆ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["degree_other"].'</b></font></td>
						</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:60px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">สาขาวิชา : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["major_other"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">บิดาชื่อ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:200px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_name"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ชื่ออังกฤษ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:220px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.''.'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td style="padding-bottom:-3px;padding-left:2px;">';
						if($applicant["father_status"]=="มีชีวิต"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">มีชีวิต</font></td>
						<td style="padding-bottom:-3px;padding-left:15px;">';
						if($applicant["father_status"]=="เสียชีวิต"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">เสียชีวิต</font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อาชีพ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_occupation"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รายได้ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.($applicant["father_income"]).'</b></font></td>
						<td valign="bottom" align="right" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">บาท/เดือน</font></td>
						<td valign="bottom" align="right" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ที่อยู่บิดา เลขที่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:80px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_house_number"].'</b></font></td>
						<td valign="bottom" align="right" style="width:30px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">หมู่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:30px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_village"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ซอย : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_lane"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ถนน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_road"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ตำบล : </font></td>
						<td style="border-bottom: 1px dotted #000;width:100px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_sub_district"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อำเภอ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:110px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_district"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จังหวัด : </font></td>
						<td style="border-bottom: 1px dotted #000;width:120px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["father_province"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:100px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รหัสไปรษณีย์ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_f[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_f[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_f[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_f[3].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_f[4].'</b></td>
							</tr>
						</table>
						</td>
						<td valign="bottom" align="right" style="width:120px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">โทรศัพท์มือถือ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[4].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[5].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[6].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[8].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[9].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[10].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_f[11].'</b></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">มารดาชื่อ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:220px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_name"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ชื่ออังกฤษ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:220px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.''.'</b></font></td>
						<td style="padding-bottom:-3px;padding-left:15px;">';
						if($applicant["mother_status"]=="มีชีวิต"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">มีชีวิต</font></td>
						<td style="padding-bottom:-3px;padding-left:15px;">';
						if($applicant["mother_status"]=="เสียชีวิต"){
							$t3 .= '<img src="imagee/check_t.jpg">';
						}else{
							$t3 .= '<img src="imagee/check2.jpg">';
						}
						$t3 .= '</td>
						<td valign="bottom" align="left" style="width:25px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">เสียชีวิต</font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อาชีพ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:120px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_occupation"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รายได้ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.($applicant["mother_income"]).'</b></font></td>
						<td valign="bottom" align="right" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">บาท/เดือน</font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ที่อยู่มารดา เลขที่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_house_number"].'</b></font></td>
						<td valign="bottom" align="right" style="width:30px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">หมู่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:20px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_village"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ซอย : </font></td>
						<td style="border-bottom: 1px dotted #000;width:100px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_lane"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ถนน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:100px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_road"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ตำบล : </font></td>
						<td style="border-bottom: 1px dotted #000;width:130px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_sub_district"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อำเภอ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:130px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_district"].'</b></font></td>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จังหวัด : </font></td>
						<td style="border-bottom: 1px dotted #000;width:170px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["mother_province"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="width:100px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รหัสไปรษณีย์ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_m[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_m[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_m[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_m[3].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_m[4].'</b></td>
							</tr>
						</table>
						</td>
						<td valign="bottom" align="right" style="width:120px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">โทรศัพท์มือถือ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[4].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[5].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[6].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[8].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[9].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[10].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_m[11].'</b></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ชื่อผู้ปกครองที่ไม่ใช่ บิดา-มารดา : </font></td>
						<td style="border-bottom: 1px dotted #000;width:200px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_name"].'</b></font></td>
						<td valign="bottom" align="right" style="width:100px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ความสัมพันธ์ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:150px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_relationship"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ที่อยู่ผู้ปกครอง เลขที่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:50px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_house_number"].'</b></font></td>
						<td valign="bottom" align="right" style="width:30px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">หมู่ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:20px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_village"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ซอย : </font></td>
						<td style="border-bottom: 1px dotted #000;width:70px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_lane"].'</b></font></td>
						<td valign="bottom" align="right" style="width:40px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ถนน : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_road"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">ตำบล : </font></td>
						<td style="border-bottom: 1px dotted #000;width:90px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_sub_district"].'</b></font></td>
						<td valign="bottom" align="right" style="width:50px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">อำเภอ : </font></td>
						<td style="border-bottom: 1px dotted #000;width:110px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_district"].'</b></font></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding:5px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">จังหวัด : </font></td>
						<td style="border-bottom: 1px dotted #000;width:170px;padding-bottom:-1px;padding-top:-7px;" align="center"><font style="font-size:18px;"><b>'.$applicant["guardian_province"].'</b></font></td>
						<td valign="bottom" align="right" style="width:100px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">รหัสไปรษณีย์ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_g[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_g[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_g[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_g[3].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_zipcode_g[4].'</b></td>
							</tr>
						</table>
						</td>
						<td valign="bottom" align="right" style="width:120px;padding-bottom:-5px;padding-top:-7px;"><font style="font-size:18px;">โทรศัพท์มือถือ : </font></td>
						<td style="padding-bottom:-5px;padding-top:-7px;padding-left:15px;">
						<table width="100%" style="padding:0px;border-collapse: collapse;">
							<tr>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[0].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[1].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[2].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[4].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[5].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[6].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[8].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[9].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[10].'</b></td>
								<td style="border:2px solid #000;width:16px;height:16px;padding-bottom:-1px;padding-top:-3px;" align="center"><b>'.$arr_phone_g[11].'</b></td>
							</tr>
						</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="border:0px solid #000;padding-top:25px;">
				<table width="100%" style="padding:4px;border-collapse: collapse;">
					<tr>
						<td valign="bottom" style="padding-bottom:-5px;padding-top:-7px;"><font style="font-size:15px;"><b>*การมอบตัวจะเสร็จสมบูรณ์ เมื่อชำระเงินครบเรียบร้อยแล้ว</b></font></td>
						<td valign="bottom" align="right" style="width:100px;padding-bottom:-5px;padding-top:-7px;padding-left:18px;"><font style="font-size:18px;"><strong>ลงชื่อ....................................................นักศึกษา</strong></font></td>
						<td valign="bottom" align="right" style="width:100px;padding-bottom:-5px;padding-top:-7px;padding-left:18px;"><font style="font-size:18px;"><strong>ลงชื่อ....................................................ผู้ปกครอง</strong></font></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	';

$t4 = '
<table width="100%" style="margin-top:7px;border-collapse: collapse;">
    <tr>
        <td style="border:3px solid #000;padding-left:6px;width:50%;"><font style="font-size:18px;"><b>เจ้าหน้าที่บันทึก</b></font></td>
        <td style="border:3px solid #000;padding-left:6px;width:50%;"><font style="font-size:18px;"><b>หลักฐานการมอบตัว</b></font></td>
    </tr>
    <tr>
        <td style="border:3px solid #000;padding-left:6px;">
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">จองที่เรียน : ..............................................</font></td>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">เลขที่ใบเสร็จ : ................................</font></td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">นัดมอบตัว วันที่ : ........................................................</font></td>
                </tr>
            </table>
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">ชำระค่าเล่าเรียนแล้ว : ...................บาท</font></td>
                    <td style="padding-left:15px;padding-top:-1px;"><font style="font-size:18px;">เลขที่ใบเสร็จ : ...............................</font></td>
                </tr>
            </table>
            <table align="center" width="100%" style="margin-top:10px;border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">ลงชื่อ........................................................ผู้รับเงิน</font></td>
                </tr>
                <tr>
                    <td style="padding-left:25px;padding-top:-1px;"><font style="font-size:18px;">(......................................................)</font></td>
                </tr>
            </table>
        </td>
        <td style="border:3px solid #000;padding-left:6px;">
            <table width="100%" style="border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:-3px;padding-left:20px;"><img src="imagee/check2.jpg"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">รูปถ่ายขนาด 2 นิ้ว จำนวน 2 รูป</font></td>
                    <td style="padding-bottom:-3px;padding-left:20px;"><img src="imagee/check2.jpg"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สำเนาใบ รบ.</font></td>
                </tr>
                <tr>
                    <td style="padding-bottom:-3px;padding-left:20px;"><img src="imagee/check2.jpg"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">ใบ รบ. ตัวจริง</font></td>
                    <td style="padding-bottom:-3px;padding-left:20px;"><img src="imagee/check2.jpg"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สำเนาบัตรประชาชน</font></td>
                </tr>
                <tr>
                    <td style="padding-bottom:-3px;padding-left:20px;"><img src="imagee/check2.jpg"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"><font style="font-size:18px;">สำเนาทะเบียนบ้าน</font></td>
                    <td style="padding-bottom:-3px;"></td>
                    <td style="padding-left:5px;padding-bottom:-3px;padding-top:-1px;"></td>
                </tr>
            </table>
            <table align="center" width="100%" style="margin-top:10px;border-collapse: collapse;">
                <tr>
                    <td style="padding-bottom:0px;padding-top:-1px;"><font style="font-size:18px;">ลงชื่อ........................................................ผู้ตรวจหลักฐาน</font></td>
                </tr>
                <tr>
                    <td style="padding-left:25px;padding-top:-1px;"><font style="font-size:18px;">(......................................................)</font></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';


$mpdf->WriteHTML($t);
$mpdf->WriteHTML($t2);
$mpdf->WriteHTML($t3);
$mpdf->WriteHTML($t4);
$mpdf->Output();
