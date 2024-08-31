<?php
session_start();
require_once("../config/db.php");

$approve = 'approve';
$not_approve = 'not_approve';


if (isset($_GET['approve'])) {
    $user_id = $_GET['approve'];

    $sql_update = $conn->prepare("UPDATE form SET               
            status = :status
            WHERE User_ID = :user_id");

    // ผูกค่าพารามิเตอร์กับตัวแปร
    $sql_update->bindParam(':status', $approve);
    $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $sql_update->execute();
}
if (isset($_GET['not_approve'])) {
    $user_id = $_GET['not_approve'];

    $sql_update = $conn->prepare("UPDATE form SET               
            status = :status
            WHERE User_ID = :user_id");

    // ผูกค่าพารามิเตอร์กับตัวแปร
    $sql_update->bindParam(':status', $not_approve);
    $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $sql_update->execute();
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
    <title>Tables - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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



                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                        <a class="nav-link" href="approve.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-check"></i></div>
                            Approve
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
                    <h1 class="">Users Data Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">ตารางข้อมูล ผู้สมัคร</li>
                    </ol>
                    <div class="card mb-4 mt-3">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Applicant
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Lastname</th>
                                        
                                        <th>Id Card Number</th>
                                        <th>Coursetype</th>
                                        <th>Educationlevel</th>
                                        <th>Subjecttype</th>
                                        <th>Major</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // เตรียมคำสั่ง SQL
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
                                                                    f.status = 'pending' OR f.status = 'not_approve'
                                                            ");



                                    // ประมวลผลคำสั่ง
                                    $stmt->execute();

                                    // ดึงข้อมูลทั้งหมด
                                    $applicants = $stmt->fetchAll();

                                    if (!$applicants) {
                                        echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
                                    } else {
                                        foreach ($applicants as $applicant) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo htmlspecialchars($applicant['User_ID']); ?></th>
                                                <td><?php echo htmlspecialchars($applicant['name']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['lastname']); ?></td>
                                                
                                                <td><?php echo htmlspecialchars($applicant['id_card_number']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['CourseType_Name']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['Level_Name']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['Type_Name']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['Major_Name']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['date']); ?></td>
                                                <td><?php echo htmlspecialchars($applicant['status']); ?></td>
                                                <td>
                                                    <a href="view.php?user_id=<?php echo $applicant['User_ID']; ?>" class="btn btn-secondary"><i class="fa-solid fa-eye"></i></a>
                                                    <a onclick="confirmNotApprove('<?php echo htmlspecialchars($applicant['User_ID']); ?>')" class="btn btn-danger">ไม่อนุมัติ <i class="fa-solid fa-xmark"></i></a>
                                                    <a onclick="confirmApprove('<?php echo htmlspecialchars($applicant['User_ID']); ?>')" class="btn btn-success">อนุมัติ <i class="fa-solid fa-check"></i></a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>


            </main>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        function confirmNotApprove(userId) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการไม่อนุมัติใบสมัครนี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ไม่อนุมัติ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?not_approve=" + userId;
                }
            });
        }

        function confirmApprove(userId) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "คุณต้องการอนุมัติใบสมัครนี้หรือไม่?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, อนุมัติ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "?approve=" + userId;
                }
            });
        }
    </script>
</body>

</html>