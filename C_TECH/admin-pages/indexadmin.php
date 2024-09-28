<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['admin_login'])) {
    header('Location: admin.php');
    exit();
}

$stmt = $conn->prepare("
    SELECT major.Major_Name, 
           COALESCE(COUNT(form.Major_ID), 0) AS applicant_count,
           COALESCE(SUM(CASE WHEN form.status = 'approve' THEN 1 ELSE 0 END), 0) AS approve_count
    FROM major
    LEFT JOIN form ON form.Major_ID = major.Major_ID
    GROUP BY major.Major_Name;
");
$stmt->execute();

$yearStmt = $conn->prepare("
    SELECT DISTINCT YEAR(created_at) AS year
    FROM form
    ORDER BY year DESC;
");
$yearStmt->execute();
$years = $yearStmt->fetchAll(PDO::FETCH_ASSOC);

$selectedYear = isset($_GET['selectYear']) ? $_GET['selectYear'] : null;

$query = "
    SELECT major.Major_Name, 
           COALESCE(COUNT(form.Major_ID), 0) AS applicant_count,
           COALESCE(SUM(CASE WHEN form.status = 'approve' THEN 1 ELSE 0 END), 0) AS approve_count
    FROM major
    LEFT JOIN form ON form.Major_ID = major.Major_ID";

if ($selectedYear) {
    $query .= " WHERE YEAR(form.created_at) = :selectedYear";
}

$query .= " GROUP BY major.Major_Name";

$stmt = $conn->prepare($query);

if ($selectedYear) {
    $stmt->bindParam(':selectedYear', $selectedYear, PDO::PARAM_INT);
}

$stmt->execute();



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

    .bg-c-blue {
        background: linear-gradient(45deg, #4099ff, #73b4ff);
    }

    .bg-c-green {
        background: linear-gradient(45deg, #2ed8b6, #59e0c5);
    }

    .bg-c-yellow {
        background: linear-gradient(45deg, #FFB64D, #ffcb80);
    }

    .bg-c-pink {
        background: linear-gradient(45deg, #FF5370, #ff869a);
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
                        <a class="nav-link" href="edituser.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            แก้ไขผู้ใช้
                        </a>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            ผู้สมัคร
                        </a>
                        <a class="nav-link" href="approve.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            อนุมัติ
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
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="col-md-2 mb-4 ms-auto">
                        <select class="form-select" name="selectYear" id="selectYear" onchange="filterByYear()">
                            <option value="">==เลือกปีที่แสดง==</option>
                            <?php foreach ($years as $year) { ?>
                                <option value="<?php echo htmlspecialchars($year['year']); ?>"
                                    <?php echo isset($_GET['selectYear']) && $_GET['selectYear'] == $year['year'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($year['year']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="row">
                        <?php
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            // Set icon and card color based on Major_Name
                            $icon = '';
                            $cardColor = '';

                            switch ($row['Major_Name']) {
                                case 'การบัญชี':
                                    $icon = 'fa-calculator';
                                    $cardColor = 'bg-c-blue';
                                    break;
                                case 'คอมพิวเตอร์ธุรกิจ':
                                    $icon = 'fa-computer';
                                    $cardColor = 'bg-c-green';
                                    break;
                                case 'เทคโนโลยีธุรกิจดิจิทัล':
                                    $icon = 'fa-microchip';
                                    $cardColor = 'bg-c-pink';
                                    break;
                                case 'เทคโนโลยีสารสนเทศ':
                                    $icon = 'fa-microchip';
                                    $cardColor = 'bg-c-pink';
                                    break;
                                case 'การจัดการธุรกิจค้าปลีก':
                                    $icon = 'fa-truck';
                                    $cardColor = 'bg-c-blue';
                                    break;
                                case 'การจัดการโลจิสติกส์':
                                    $icon = 'fa-plane';
                                    $cardColor = 'bg-c-green';
                                    break;
                                case 'การตลาด':
                                    $icon = 'fa-store';
                                    $cardColor = 'bg-c-yellow';
                                    break;
                                case 'ช่างเทคนิคยานยนต์':
                                    $icon = 'fa-wrench';
                                    $cardColor = 'bg-c-pink';
                                    break;
                                case 'ช่างไฟฟ้า':
                                    $icon = 'fa-plug';
                                    $cardColor = 'bg-c-blue';
                                    break;
                                case 'ช่างไฟฟ้ากำลัง':
                                    $icon = 'fa-plug';
                                    $cardColor = 'bg-c-blue';
                                    break;
                                case 'ช่างอิเล็กทรอนิกส์':
                                    $icon = 'fa-code-fork';
                                    $cardColor = 'bg-c-green';
                                    break;
                                case 'ช่างก่อสร้าง':
                                    $icon = 'fa-road';
                                    $cardColor = 'bg-c-yellow';
                                    break;
                                default:
                                    $icon = 'fa-question'; // Default case
                                    $cardColor = 'bg-c-gray'; // Default color
                                    break;
                            }
                        ?>
                            <div class="col-md-4 col-xl-3">
                                <div class="card <?php echo $cardColor; ?> order-card">
                                    <div class="card-block">
                                        <h5 class="m-b-20">จำนวนผู้สมัคร <?php echo htmlspecialchars($row['Major_Name']); ?></h5>
                                        <h2 class="text-right"><i class="fa-solid <?php echo $icon; ?>"></i><span> <?php echo htmlspecialchars($row['applicant_count']); ?></span></h2>
                                        <p class="m-b-0">Completed Approve<span class="f-right"><?php echo htmlspecialchars($row['approve_count']); ?></span></p>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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
    <script>
    function filterByYear() {
        const year = document.getElementById('selectYear').value;
        const urlParams = new URLSearchParams(window.location.search);
        if (year) {
            urlParams.set('selectYear', year);
        } else {
            urlParams.delete('selectYear');
        }
        window.location.search = urlParams.toString();
    }
</script>

</body>

</html>