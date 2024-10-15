<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['admin_login'])) {
    header('Location: admin.php');
    exit();
}




$query = "
    SELECT major.Major_Name, 
           COALESCE(COUNT(form.Major_ID), 0) AS applicant_count,
           COALESCE(SUM(CASE WHEN form.status = 'approve' THEN 1 ELSE 0 END), 0) AS approve_count
    FROM major
    LEFT JOIN form ON form.Major_ID = major.Major_ID";

// ตรวจสอบว่าผู้ใช้เลือกช่วงวันที่หรือไม่
$conditions = [];
$params = [];

if (isset($_GET['startDate']) && !empty($_GET['startDate'])) {
    $conditions[] = "form.created_at >= :startDate";
    $params[':startDate'] = $_GET['startDate'];
}

if (isset($_GET['endDate']) && !empty($_GET['endDate'])) {
    $conditions[] = "form.created_at <= :endDate";
    $params[':endDate'] = $_GET['endDate'];
}

// ถ้ามีเงื่อนไขเพิ่ม ให้รวมเข้าไปใน query
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " GROUP BY major.Major_Name";

// Prepare และ Execute Query
$stmt = $conn->prepare($query);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();

// ดึงข้อมูลทั้งหมดมาเก็บไว้ใน $results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
</head>

<style>

    .order-card {
        color: #fff;
    }


.bg-c-accounting {
    background: linear-gradient(45deg, #FF5733, #FF9F43); 
}

.bg-c-business-computer {
    background: linear-gradient(45deg, #FF9F43, #FFEA00); 
}

.bg-c-digital-tech {
    background: linear-gradient(45deg, #FFEA00, #8BC34A); 
}

.bg-c-digital-techs {
    background: linear-gradient(45deg, #8BC34A, #00B0FF); 
}

.bg-c-retail-management {
    background: linear-gradient(45deg, #00B0FF, #00E5FF); 
}

.bg-c-logistics {
    background: linear-gradient(45deg, #00E5FF, #3F51B5); 
}

.bg-c-marketing {
    background: linear-gradient(45deg, #3F51B5, #673AB7); 
}

.bg-c-auto-mechanics {
    background: linear-gradient(45deg, #673AB7, #FF4081); 
}

.bg-c-electrical {
    background: linear-gradient(45deg, #FF4081, #FF80AB); 
}

.bg-c-electricals {
    background: linear-gradient(45deg, #FF80AB, #FF1493); 
}

.bg-c-electronics {
    background: linear-gradient(45deg, #FF1493, #FF6F61); 
}

.bg-c-construction {
    background: linear-gradient(45deg, #FFD740, #FFC107); 
}

.bg-c-gray {
    background: linear-gradient(45deg, #D3D3D3, #A9A9A9); 
}
















    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        box-shadow: 0 1px 2.94px 0.06px rgba(4, 26, 55, 0.16);
        border: none;
        margin-bottom: 30px;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }

    .card .card-block {
        padding: 25px;
    }

    .order-card i {
        font-size: 26px;
    }

    .f-left {
        float: left;
    }

    .f-right {
        float: right;
    }
</style>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark navbar-custom">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="indexadmin.php">Admin C-TECH</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../config/adminLogout.php">Logout</a></li>
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
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="edituser.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            แก้ไขข้อมูลผู้สมัคร
                        </a>
                        <a class="nav-link" href="staff.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            แก้ไขผู้ใช้
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            ผู้สมัคร
                        </a>
                        <a class="nav-link" href="approve.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            อนุมัติ การสมัคร
                        </a>
                        <a class="nav-link" href="slip.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            อนุมัติ slip
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
                    <h1 class="mt-4">Dashboard</h1>
                    <div class="row">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <div class="row d-flex align-items-center">
                        <form action="./reportAd.php" method="get" class="d-flex">

                            <div class="col-md-1 mb-4 m-2 ms-auto">
                                <label for="startDate" class="form-label">ตั้งแต่วันที่:</label>
                                <input type="date" class="form-control" name="startDate" id="startDate" value="<?php echo isset($_GET['startDate']) ? htmlspecialchars($_GET['startDate']) : ''; ?>">
                            </div>

                            <div class="col-md-1 mb-4 m-2">
                                <label for="endDate" class="form-label">ถึงวันที่:</label>
                                <input type="date" class="form-control" name="endDate" id="endDate" value="<?php echo isset($_GET['endDate']) ? htmlspecialchars($_GET['endDate']) : ''; ?>">

                            </div>


                            <div class="col-md-1 mb-4 m-2 mt-3">
                                <label for="" class="form-label"></label>
                                <button type="submit" class="btn btn-outline-primary w-100">ดูรายงาน</button>

                            </div>
                            <div class="col-md-1 mb-4 m-2 mt-3">
                            <label for="" class="form-label"></label>
                                <button type="submit" class="btn btn-outline-danger w-100" name="pdf" value="1" target="_blank">รายงาน PDF</button>
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <?php foreach ($results as $row) { 
                            $icon = '';
                            $cardColor = '';

                            switch ($row['Major_Name']) {
                                case 'การบัญชี':
                                    $icon = 'fa-calculator';
                                    $cardColor = 'bg-c-accounting';
                                    break;
                                case 'คอมพิวเตอร์ธุรกิจ':
                                    $icon = 'fa-computer';
                                    $cardColor = 'bg-c-business-computer';
                                    break;
                                case 'เทคโนโลยีสารสนเทศ':
                                    $icon = 'fa-microchip';
                                    $cardColor = 'bg-c-digital-techs';
                                    break;
                                case 'เทคโนโลยีธุรกิจดิจิทัล':
                                    $icon = 'fa-microchip';
                                    $cardColor = 'bg-c-digital-tech';
                                    break;
                                case 'การจัดการธุรกิจค้าปลีก':
                                    $icon = 'fa-truck';
                                    $cardColor = 'bg-c-retail-management';
                                    break;
                                case 'การจัดการโลจิสติกส์':
                                    $icon = 'fa-plane';
                                    $cardColor = 'bg-c-logistics';
                                    break;
                                case 'การตลาด':
                                    $icon = 'fa-store';
                                    $cardColor = 'bg-c-marketing';
                                    break;
                                case 'ช่างเทคนิคยานยนต์':
                                    $icon = 'fa-wrench';
                                    $cardColor = 'bg-c-auto-mechanics';
                                    break;
                                case 'ช่างไฟฟ้า':
                                    $icon = 'fa-plug';
                                    $cardColor = 'bg-c-electricals';
                                    break;
                                case 'ช่างไฟฟ้ากำลัง':
                                    $icon = 'fa-plug';
                                    $cardColor = 'bg-c-electrical';
                                    break;
                                case 'ช่างอิเล็กทรอนิกส์':
                                    $icon = 'fa-code-fork';
                                    $cardColor = 'bg-c-electronics';
                                    break;
                                case 'ช่างก่อสร้าง':
                                    $icon = 'fa-road';
                                    $cardColor = 'bg-c-construction';
                                    break;
                                default:
                                    $icon = 'fa-question'; 
                                    $cardColor = 'bg-c-gray'; 
                                    break;
                            }
                            
                        ?>
                            <div class="col-md-4 col-xl-3">
                                <div class="card <?php echo $cardColor; ?> order-card">
                                    <div class="card-block">
                                        <h5 class="m-b-20">จำนวนผู้สมัคร <?php echo htmlspecialchars($row['Major_Name']); ?></h5>
                                        <h2 class="text-right">
                                            <i class="fa-solid <?php echo $icon; ?>"></i>
                                            <span> <?php echo htmlspecialchars($row['applicant_count']); ?></span>
                                        </h2>
                                        <p class="m-b-0">Completed Approve<span class="f-right"><?php echo htmlspecialchars($row['approve_count']); ?></span></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
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
    <script>

    </script>

</body>

</html>
