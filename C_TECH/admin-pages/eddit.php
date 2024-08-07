<?php
session_start();
require_once("../config/db.php");


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark navbar-custom">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="indexadmin.php">Admin C-TECH</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <!-- <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div> -->
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="indexadmin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="edituser.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            Editusers
                        </a>

                        <div class="sb-sidenav-menu-heading">Addons</div>

                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>

                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="">Edit data</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Edit data</li>
                    </ol>
                    <div class="panel panel-default mb-5">

                        <div class="panel-body">

                            <form id="personal-info-form" class="row g-3 mt-2" action="#" method="get">
                                <div class="panel-heading">ข้อมูลส่วนตัว</div>
                                <div class="col-md-2">
                                    <label for="prefix" class="form-label">คำนำหน้า <span class="required">**</span></label>
                                    <select id="prefix" class="form-select" required>
                                        <option value="">==เลือก==</option>
                                        <option value="Mr">นาย</option>
                                        <option value="Mrs">นาง</option>
                                        <option value="Ms">นางสาว</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="first-name" class="form-label">ชื่อ <span class="required">**</span></label>
                                    <input type="text" id="first-name" class="form-control" placeholder="ชื่อ" name="name" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="last-name" class="form-label">สกุล <span class="required">**</span></label>
                                    <input type="text" id="last-name" class="form-control" placeholder="สกุล" name="lastname" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="full-name-eng" class="form-label">ชื่อ - สกุล อังกฤษ <span class="required">**</span></label>
                                    <input type="text" id="full-name-eng" class="form-control" placeholder="ชื่อ - สกุล อังกฤษ" name="eng_name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="id-number" class="form-label">เลขบัตรประชาชน <span class="required">** ตัวเลขเท่านั้น</span></label>
                                    <input type="text" class="form-control" id="thai-id" maxlength="17" oninput="formatThaiID(this)" placeholder="x-xxxx-xxxxx-xx-x" name="id_card_number" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="nickname" class="form-label">ชื่อเล่น</label>
                                    <input type="text" id="nickname" class="form-control" placeholder="ชื่อเล่น" name="nickname">
                                </div>
                                <div class="col-md-2">
                                    <label for="birth-day" class="form-label">วันเกิด <span class="required">**</span></label>
                                    <select id="birth-day" class="form-select" name="birth-date" required>
                                        <option value="">==เลือก==</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <!-- Options for days -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="birth-month" class="form-label">เดือนเกิด <span class="required">**</span></label>
                                    <select id="birth-month" class="form-select" name="birth-date" required>
                                        <option value="">==เลือก==</option>
                                        <option value="01">มกราคม</option>
                                        <option value="02">กุมภาพันธ์</option>
                                        <option value="03">มีนาคม</option>
                                        <option value="04">เมษายน</option>
                                        <option value="05">พฤษภาคม</option>
                                        <option value="06">มิถุนายน</option>
                                        <option value="07">กรกฎาคม</option>
                                        <option value="08">สิงหาคม</option>
                                        <option value="09">กันยายน</option>
                                        <option value="10">ตุลาคม</option>
                                        <option value="11">พฤศจิกายน</option>
                                        <option value="12">ธันวาคม</option>
                                        <!-- Options for months -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="birth-year" class="form-label">ปีเกิด <span class="required">**</span></label>
                                    <select id="birth-year" class="form-select" name="birth-date" required>
                                        <option value="">==เลือก==</option>
                                        <option value="2510">2510</option>
                                        <option value="2511">2511</option>
                                        <option value="2512">2512</option>
                                        <option value="2513">2513</option>
                                        <option value="2514">2514</option>
                                        <option value="2515">2515</option>
                                        <option value="2516">2516</option>
                                        <option value="2517">2517</option>
                                        <option value="2518">2518</option>
                                        <option value="2519">2519</option>
                                        <option value="2520">2520</option>
                                        <option value="2521">2521</option>
                                        <option value="2522">2522</option>
                                        <option value="2523">2523</option>
                                        <option value="2524">2524</option>
                                        <option value="2525">2525</option>
                                        <option value="2526">2526</option>
                                        <option value="2527">2527</option>
                                        <option value="2528">2528</option>
                                        <option value="2529">2529</option>
                                        <option value="2530">2530</option>
                                        <option value="2531">2531</option>
                                        <option value="2532">2532</option>
                                        <option value="2533">2533</option>
                                        <option value="2534">2534</option>
                                        <option value="2535">2535</option>
                                        <option value="2536">2536</option>
                                        <option value="2537">2537</option>
                                        <option value="2538">2538</option>
                                        <option value="2539">2539</option>
                                        <option value="2540">2540</option>
                                        <option value="2541">2541</option>
                                        <option value="2542">2542</option>
                                        <option value="2543">2543</option>
                                        <option value="2544">2544</option>
                                        <option value="2545">2545</option>
                                        <option value="2546">2546</option>
                                        <option value="2547">2547</option>
                                        <option value="2548">2548</option>
                                        <option value="2549">2549</option>
                                        <option value="2550">2550</option>
                                        <option value="2551">2551</option>
                                        <option value="2552">2552</option>
                                        <option value="2553">2553</option>
                                        <option value="2554">2554</option>
                                        <option value="2555">2555</option>
                                        <option value="2556">2556</option>
                                        <option value="2557">2557</option>
                                        <option value="2558">2558</option>
                                        <option value="2559">2559</option>
                                        <option value="2560">2560</option>
                                        <!-- Options for years -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="group-code" class="form-label">กรุ๊ปเลือด <span class="required">**</span></label>
                                    <input type="text" id="group-code" class="form-control" placeholder="กรุ๊ปเลือด" name="blood_group" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="height" class="form-label">ส่วนสูง <span class="required">**</span></label>
                                    <input type="number" id="height" class="form-control" min="0" placeholder="ส่วนสูง" name="height" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="weight" class="form-label">น้ำหนัก <span class="required">**</span></label>
                                    <input type="number" id="weight" class="form-control" min="0" placeholder="น้ำหนัก" name="weight" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="nationality" class="form-label">เชื้อชาติ <span class="required">**</span></label>
                                    <input type="text" id="nationality" class="form-control" placeholder="เชื้อชาติ" name="nationality" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="citizenship" class="form-label">สัญชาติ <span class="required">**</span></label>
                                    <input type="text" id="citizenship" class="form-control" placeholder="สัญชาติ" name="citizenship" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="religion" class="form-label">ศาสนา <span class="required">**</span></label>
                                    <input type="text" id="religion" class="form-control" placeholder="ศาสนา" name="religion" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="siblings" class="form-label">จำนวนพี่น้อง <span class="required">**</span></label>
                                    <input type="number" id="siblings" class="form-control" min="0" placeholder="จำนวนพี่น้อง" name="siblings_count" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="current-siblings" class="form-label">จำนวนพี่น้องที่กำลังศึกษาอยู่ <span class="required">**</span></label>
                                    <input type="number" id="current-siblings" class="form-control" min="0" placeholder="จำนวนพี่น้องที่กำลังศึกษาอยู่" name="studying_siblings_count" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="phone" class="form-label">เบอร์โทร <span class="required">**</span></label>
                                    <input type="tel" id="phone" class="form-control" name="phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                </div>
                                <div class="col-md-3">
                                    <label for="line-id" class="form-label">LineID</label>
                                    <input type="text" id="line-id" class="form-control" placeholder="LineID" name="line_id">
                                </div>
                                <div class="col-md-3">
                                    <label for="facebook" class="form-label">Facebook</label>
                                    <input type="text" id="facebook" class="form-control" placeholder="Facebook" name="facebook">
                                </div>
                                <div class="col-md-6">
                                    <label for="photo" class="form-label">รูปภาพ 1 นิ้วครึ่ง <span class="required">** .jpg เท่านั้น</span></label>
                                    <input type="file" id="photo" class="form-control" name="Profile_image" accept=".jpg" required>
                                </div>

                            </form>
                            <div class="panel panel-default mb-5">

                                <div class="panel-body">


                                    <form id="personal-info-form" class="row g-2 mt-2">
                                        <div class="panel-heading">ที่อยู่ปัจจุบัน</div>
                                        <div class="col-md-2">
                                            <label class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                            <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="house_number " required=" ">
                                        </div>
                                        <div class="col-md-1">
                                            <label class="form-label">หมู่ <span class="required">**</span></label>
                                            <input class="form-control " type="text " placeholder="หมู่ " name="village " required=" ">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ซอย </label>
                                            <input class="form-control " type="text " placeholder="ซอย " name="lane ">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ถนน </label>
                                            <input class="form-control " type="text " placeholder="ถนน " name="road ">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">ตำบล <span class="required">**</span></label>
                                            <input type="text " class="form-control " placeholder="ตำบล " name="sub_district " required=" ">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">อำเภอ <span class="required">**</span></label>
                                            <input type="text " class="form-control " placeholder="อำเภอ " name="district " required=" ">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">จังหวัด <span class="required">**</span></label>
                                            <input type="text " class="form-control " placeholder="จังหวัด " name="province " required=" ">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                            <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="postal_code " maxlength="5 " required=" ">
                                        </div>

                                    </form>
                                    <div class="panel panel-default mb-5">

                                        <div class="panel-body">


                                            <form id="personal-info-form" class="row g-2 mt-2">
                                                <div class="panel-heading">ข้อมูลการศึกษา</div>
                                                <div class="col-md-8">
                                                    <label class="form-label">จบจากโรงเรียน <span class="required">**</span></label>
                                                    <input class="form-control " type="text " placeholder="จบจากโรงเรียน " name="school_name " required=" ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">ตำบล <span class="required">**</span></label>
                                                    <input type="text " class="form-control " placeholder="ตำบล " name="school_sub_district " required=" ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">อำเภอ <span class="required">**</span></label>
                                                    <input type="text " class="form-control " placeholder="อำเภอ " name="school_district " required=" ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">จังหวัด <span class="required">**</span></label>
                                                    <input type="text " class="form-control " placeholder="จังหวัด " name="school_province " required=" ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="school_postal_code " maxlength="5 " required=" ">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">จบเมื่อ พ.ศ. <span class="required">**</span></label>
                                                    <input type="text " class="form-control " placeholder="จบเมื่อ พ.ศ. " name="graduation_year " required=" ">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">ผลการเรียน <span class="required">**</span></label>
                                                    <input type="text " class="form-control " placeholder="ผลการเรียน " name="grade_result " required=" ">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">ระดับชั้น <span class="required">**</span></label>
                                                    <select class="form-control " name="class_level " required=" ">
                                                        <option value=" ">==เลือก==</option>
                                                        <option value="ม.3 ">ม.3</option>
                                                        <option value="ม.6 ">ม.6</option>
                                                        <option value="ปวช. ">ปวช.</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">สาขาวิชา </label>
                                                    <input type="text " class="form-control " placeholder="สาขาวิชา " name="major ">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">วุฒิการศึกษาอื่นๆ </label>
                                                    <input type="text " class="form-control " placeholder="วุฒิการศึกษาอื่นๆ " name="degree_other ">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">สาขาวิชา </label>
                                                    <input type="text " class="form-control " placeholder="สาขาวิชา " name="major_other ">
                                                </div>


                                            </form>
                                            <div class="panel panel-default mb-5">

                                                <div class="panel-body">


                                                    <form id="personal-info-form" class="row g-2 mt-2">
                                                        <div class="panel-heading">ข้อมูลบิดา</div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">บิดาชื่อ <span class="required">**</span></label>
                                                            <input class="form-control " type="text " placeholder="โรงเรียน " name="father_name " required=" ">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">สถานะ <span class="required">**</span></label>
                                                            <select class="form-control " name="father_status " required=" ">
                                                                <option value=" ">==เลือก==</option>
                                                                <option value="มีชีวิต ">มีชีวิต</option>
                                                                <option value="เสียชีวิต ">เสียชีวิต</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">อาชีพ <span class="required">**</span></label>
                                                            <input type="text " class="form-control " placeholder="อาชีพ " name="father_occupation " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">รายได้/เดือน <span class="required">**</span></label>
                                                            <input type="text " class="form-control " placeholder="รายได้/เดือน " name="father_income " required=" ">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                                            <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <label class="form-label">หมู่ <span class="required">**</span></label>
                                                            <input class="form-control " type="text " placeholder="หมู่ " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">ซอย </label>
                                                            <input class="form-control " type="text " placeholder="ซอย " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">ถนน </label>
                                                            <input class="form-control " type="text " placeholder="ถนน " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">ตำบล <span class="required">**</span></label>
                                                            <input type="text " class="form-control " placeholder="ตำบล " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">อำเภอ <span class="required">**</span></label>
                                                            <input type="text " class="form-control " placeholder="อำเภอ " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">จังหวัด <span class="required">**</span></label>
                                                            <input type="text " class="form-control " placeholder="จังหวัด " name="father_address " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                                            <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="father_address " maxlength="5 " required=" ">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="phone" class="form-label">เบอร์โทรบิดา<span class="required">**</span></label>
                                                            <input type="tel" id="phone" class="form-control" name="father_phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                                        </div>


                                                    </form>
                                                    <div class="panel panel-default">

                                                        <div class="panel-body">


                                                            <form id="personal-info-form" class="row g-2 mt-2">
                                                                <div class="panel-heading">ข้อมูลมารดา</div>
                                                                <div class="col-md-4">
                                                                    <label for="prefix" class="form-label">มารดาชื่อ <span class="required">**</span></label>
                                                                    <input class="form-control " type="text " placeholder="มารดาชื่อ " name="mother_name " required=" ">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="first-name" class="form-label">สถานะ <span class="required">**</span></label>
                                                                    <select class="form-control " name="mother_status " required=" ">
                                                                        <option value="">==เลือก==</option>
                                                                        <option value="มีชีวิต ">มีชีวิต</option>
                                                                        <option value="เสียชีวิต ">เสียชีวิต</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="last-name" class="form-label">อาชีพ <span class="required">**</span></label>
                                                                    <input type="text " class="form-control " placeholder="อาชีพ " name="mother_occupation " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="full-name-eng" class="form-label">รายได้/เดือน <span class="required">**</span></label>
                                                                    <input type="text " class="form-control " placeholder="รายได้/เดือน " name="mother_income " required=" ">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="prefix" class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                                                    <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label for="prefix" class="form-label">หมู่ <span class="required">**</span></label>
                                                                    <input class="form-control " type="text " placeholder="หมู่ " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="prefix" class="form-label">ซอย </label>
                                                                    <input class="form-control " type="text " placeholder="ซอย " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="prefix" class="form-label">ถนน </label>
                                                                    <input class="form-control " type="text " placeholder="ถนน " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="first-name" class="form-label">ตำบล <span class="required">**</span></label>
                                                                    <input type="text " class="form-control " placeholder="ตำบล " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="last-name" class="form-label">อำเภอ <span class="required">**</span></label>
                                                                    <input type="text " class="form-control " placeholder="อำเภอ " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="full-name-eng" class="form-label">จังหวัด <span class="required">**</span></label>
                                                                    <input type="text " class="form-control " placeholder="จังหวัด " name="mother_address " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="id-number" class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                                                    <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="mother_address " maxlength="5 " required=" ">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="phone" class="form-label">เบอร์โทรมารดา<span class="required">**</span></label>
                                                                    <input type="tel" id="phone" class="form-control" name="mother_phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                                                </div>


                                                            </form>
                                                            <div class="panel panel-default">

                                                                <div class="panel-body">


                                                                    <form id="personal-info-form" class="row g-2 mt-2">
                                                                        <div class="panel-heading">ข้อมูลผู้ปกครองที่ไม่ใช่ บิดา-มารดา</div>
                                                                        <div class="col-md-8">
                                                                            <label for="prefix" class="form-label">ผู้ปกครองที่ไม่ใช่ บิดา-มารดา <span class="required">**</span></label>
                                                                            <input class="form-control " type="text " placeholder="ข้อมูลผู้ปกครองที่ไม่ใช่ บิดา-มารดา " name="guardian_name " required=" ">
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <label for="last-name" class="form-label">ความสัมพันธ์ <span class="required">**</span></label>
                                                                            <input type="text " class="form-control " placeholder="ความสัมพันธ์ " name="guardian_relationship " required=" ">
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="prefix" class="form-label">บ้านเลขที่ <span class="required">**</span></label>
                                                                            <input class="form-control " type="text " placeholder="บ้านเลขที่ " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-1">
                                                                            <label for="prefix" class="form-label">หมู่ <span class="required">**</span></label>
                                                                            <input class="form-control " type="text " placeholder="หมู่ " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="prefix" class="form-label">ซอย </label>
                                                                            <input class="form-control " type="text " placeholder="ซอย " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="prefix" class="form-label">ถนน </label>
                                                                            <input class="form-control " type="text " placeholder="ถนน " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="first-name" class="form-label">ตำบล <span class="required">**</span></label>
                                                                            <input type="text " class="form-control " placeholder="ตำบล " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="last-name" class="form-label">อำเภอ <span class="required">**</span></label>
                                                                            <input type="text " class="form-control " placeholder="อำเภอ " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="full-name-eng" class="form-label">จังหวัด <span class="required">**</span></label>
                                                                            <input type="text " class="form-control " placeholder="จังหวัด " name="guardian_address " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="id-number" class="form-label">รหัสไปรษณีย์ <span class="required">** ตัวเลขเท่านั้น</span></label>
                                                                            <input type="text " class="form-control " placeholder="รหัสไปรษณีย์ " name="guardian_address " maxlength="5 " required=" ">
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="phone" class="form-label">เบอร์โทรผู้ปกครอง<span class="required">**</span></label>
                                                                            <input type="tel" id="phone" class="form-control" name="guardian_phone_number" required maxlength="12" oninput="formatPhoneNumber(this)" placeholder="0xx-xxx-xxxx">
                                                                        </div>


                                                                    </form>
                                                                    <div class="panel panel-default">
                                                                        <div class="panel-body">
                                                                            <form id="personal-info-form" class="row g-2 mt-2">
                                                                                <div class="panel-heading">ต้องการศึกษา</div>
                                                                                <label class="form-label">ต้องการศึกษา <span class="required">**</span></label>
                                                                                <div class="col-xs-12 col-md-3 mt-0">
                                                                                    <div class="form-group ">
                                                                                        <font id="part "><select name="part " class="form-control " onchange="dochange( 'level', this.value) " required=" ">
                                                                                                <option value=" ">coursetype</option>

                                                                                            </select>
                                                                                        </font>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-md-3 mt-0">
                                                                                    <div class="form-group ">
                                                                                        <font id="level "><select name="level " class="form-control ">
                                                                                                <option value=" ">educationlevel</option>
                                                                                            </select></font>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-md-3 mt-0">
                                                                                    <div class="form-group ">
                                                                                        <font id="late "><select name="late " class="form-control ">
                                                                                                <option value=" ">subjecttype</option>
                                                                                            </select></font>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-12 col-md-3 mt-0">
                                                                                    <div class="form-group ">
                                                                                        <font id="subject "><select name="subject " class="form-control ">
                                                                                                <option value=" ">major</option>
                                                                                            </select></font>
                                                                                    </div>
                                                                                </div>




                                                                            </form>
                                                                            <div class="panel panel-default">

                                                                                <div class="panel-body">


                                                                                    <form id="personal-info-form" class="row g-2 mt-2">
                                                                                        <div class="panel-heading">หลักฐานที่ใช้ในการสมัคร</div>
                                                                                        
                                                                                        <div class="col-md-3">
                                                                                            <label class="form-label">สำเนาใบรบ. <span class="required">** .jpg เท่านั้น</span></label>
                                                                                            <input type="file" class="form-control" name="Profile_image" accept=".jpg" required>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <label class="form-label">สำเนาทะเบียนบ้าน <span class="required">** .jpg เท่านั้น</span></label>
                                                                                            <input type="file" class="form-control" name="Profile_image" accept=".jpg" required>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <label class="form-label">สำเนาบัตรประชาชน <span class="required">** .jpg เท่านั้น</span></label>
                                                                                            <input type="file" class="form-control" name="Profile_image" accept=".jpg" required>
                                                                                        </div>
                                                                                        <div class="col-md-3">
                                                                                            <label class="form-label">หลักฐานการชำระ <span class="required">** .jpg เท่านั้น</span></label>
                                                                                            <input type="file" class="form-control" name="Profile_image" accept=".jpg" required>
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

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>


            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>