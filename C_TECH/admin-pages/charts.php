<?php 
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['admin_login'])) {
    header('Location: admin.php');
    exit();
}

// ดึงข้อมูลจำนวนผู้สมัครต่อสาขา
$stmt = $conn->prepare("
    SELECT major.Major_Name, 
           COUNT(form.Major_ID) AS applicant_count
    FROM major
    LEFT JOIN form ON form.Major_ID = major.Major_ID
    GROUP BY major.Major_Name
");
$stmt->execute();

$chartData = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $chartData[] = [$row['Major_Name'], (int)$row['applicant_count']];
}

// ดึงข้อมูลจำนวนผู้สมัครต่อปี
$yearStmt = $conn->prepare("
    SELECT YEAR(created_at) AS year, COUNT(*) AS applicant_count
    FROM form
    GROUP BY YEAR(created_at)
    ORDER BY year ASC
");
$yearStmt->execute();

$yearData = [];
while ($row = $yearStmt->fetch(PDO::FETCH_ASSOC)) {
    $yearData[] = [(int)$row['year'], (int)$row['applicant_count']];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Charts - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        // ข้อมูลสำหรับกราฟสาขา
        var dataMajor = google.visualization.arrayToDataTable([
          ['Major', 'Applicants'],
          <?php
          foreach ($chartData as $data) {
              echo "['" . addslashes($data[0]) . "', " . $data[1] . "],";
          }
          ?>
        ]);

        var optionsMajor = {
          title: 'จำนวนผู้สมัคร ในแต่ละสาขา',
          pieHole: 0.4, // สำหรับ PieChart แบบ Donut
          // สามารถเพิ่ม options อื่น ๆ ได้ตามต้องการ
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('piechart'));
        chart1.draw(dataMajor, optionsMajor);

        var chart2 = new google.visualization.BarChart(document.getElementById('BarChart'));
        chart2.draw(dataMajor, optionsMajor);

        var chart3 = new google.visualization.Histogram(document.getElementById('Histogram'));
        chart3.draw(dataMajor, optionsMajor);

        var chart4 = new google.visualization.ColumnChart(document.getElementById('ColumnChart'));
        chart4.draw(dataMajor, optionsMajor);

        var chart5 = new google.visualization.LineChart(document.getElementById('LineChart'));
        chart5.draw(dataMajor, optionsMajor);

        // ข้อมูลสำหรับกราฟปี
        var dataYear = google.visualization.arrayToDataTable([
          ['Year', 'Applicants'],
          <?php
          foreach ($yearData as $data) {
              echo "[" . $data[0] . ", " . $data[1] . "],";
          }
          ?>
        ]);

        var optionsYear = {
          title: 'จำนวนผู้สมัคร ในแต่ละปี',
          hAxis: { title: 'ปี', minValue: 0 },
          vAxis: { title: 'จำนวนผู้สมัคร', minValue: 0 },
          // สามารถเพิ่ม options อื่น ๆ ได้ตามต้องการ
        };

        var chartYear = new google.visualization.LineChart(document.getElementById('YearChart'));
        chartYear.draw(dataYear, optionsYear);
      }
    </script>
</head>

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
                    <h1 class="mt-4">Charts</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="indexadmin.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Charts</li>
                    </ol>
                    <div class="col-md-12 mx-auto text-center">
                        <div id="piechart" style="width: 1100px; height: 700px; margin: 0 auto;"></div>
                        <div id="BarChart" style="width: 1100px; height: 700px; margin: 0 auto;"></div>
                        <div id="Histogram" style="width: 1100px; height: 700px; margin: 0 auto;"></div>
                        <div id="ColumnChart" style="width: 1100px; height: 700px; margin: 0 auto;"></div>
                        <div id="LineChart" style="width: 1100px; height: 700px; margin: 0 auto;"></div>
                        <div id="YearChart" style="width: 1100px; height: 700px; margin: 50px auto 0;"></div>
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
    <script src="assets/demo/chart-pie-demo.js"></script>
</body>

</html>
