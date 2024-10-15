<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION['admin_login'])) {
    header('Location: admin.php');
    exit();
}

$user_id = $_SESSION['admin_login'];


    $stmt_login = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt_login->execute([$user_id]);
    $login = $stmt_login->fetch();


    

    $comment_slip = htmlspecialchars($_POST['comment_slip']);
    $approve = 'approve';
    $not_approve = 'not_approve';
    

    if (isset($_POST['approve'])) {
        $user_id = $_POST['User_ID'];
        $sql_update = $conn->prepare("UPDATE form SET
                    comment_slip = :comment_slip,
                    status_slip = :status_slip
                    WHERE User_ID = :user_id");

        // ผูกค่าพารามิเตอร์กับตัวแปร
        $sql_update->bindParam(':comment_slip', $comment_slip);
        $sql_update->bindParam(':status_slip', $approve);
        $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql_update->execute();

        header("location: ./slip.php");
    }
    if (isset($_POST['not_approve'])) {
        $user_id = $_POST['User_ID'];
        $sql_update = $conn->prepare("UPDATE form SET
                    comment_slip = :comment_slip,
                    status_slip = :status_slip
                    WHERE User_ID = :user_id");

        // ผูกค่าพารามิเตอร์กับตัวแปร
        $sql_update->bindParam(':comment_slip', $comment_slip);
        $sql_update->bindParam(':status_slip', $not_approve);
        $sql_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sql_update->execute();

        header("location: ./slip.php");
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
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../style.css">
    <link href="path/to/lightbox.css" rel="stylesheet" />
    <script src="path/to/lightbox-plus-jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<style>
    

.btn:hover {
    background-position: right center;
    
}

.btn-1 {
    background-image: linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%);
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
                        <?php if ($login['urole'] == 'admin'){ ?>
                        <a class="nav-link" href="edituser.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            แก้ไขข้อมูลผู้สมัคร
                        </a> 
                        
                        <a class="nav-link" href="staff.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user-pen"></i></div>
                            แก้ไขผู้ใช้
                        </a>
                        <?php } ?>
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

            <!-- mainnnnnnnnnnnnnnnnnnnnnnnnn -->

            <main>
                <div class="container-fluid px-4">
                    

                    <div class="panel panel-default mb-5">

                        <div class="panel-body">

                            <form id="personal-info-form" class="row g-3 mt-2" action="viewSlip.php" method="post">

                            <?php
                                if (isset($_GET['user_id'])) {
                                    $User_ID = $_GET['user_id'];

                                    $stmt = $conn->prepare("SELECT 
                                                                *  
                                                            FROM 
                                                                form
                                                            WHERE 
                                                                User_ID = :user_id
                                                        ");

                                    $stmt->bindParam(':user_id', $User_ID, PDO::PARAM_INT);
                                    $stmt->execute();

                                    $Data_view = $stmt->fetch(PDO::FETCH_ASSOC);
                                }
                                ?>
                            


                                
                                <div class="panel-heading mt-5">หลักฐานการชำระ</div>

                                <div class="col-md-3">
                                <input type="hidden" name="User_ID" value="<?php echo htmlspecialchars($User_ID); ?>">

                                </div>

       

                          

                        

                                <div class="col-md-6 mt-5">
                                    <label class="form-label">หลักฐานการชำระ </label>
                                    <input type="file" id="imgInput4" class="form-control" name="slip2000" accept=".jpg,.jpeg,.png">
                                    <a href="../config/uploads/<?php echo $Data_view["slip2000"]; ?>" data-lightbox="documents" data-title="หลักฐานการชำระ">
                                        <img class="img-thumbnail" id="previewImg4" src="../config/uploads/<?php echo $Data_view["slip2000"]; ?>" width="100%" alt="">
                                    </a>
                                    <input type="hidden" class="form-control" name="slip20002" value="<?php echo $Data_view["slip2000"]; ?>">
                                </div>
                                <div class="col-md-3"></div>

                                <div class="col-md-2 mt-5">
                                    <a href="./slip.php" type="button" class="btn  w-100 py-2 btn-1">
                                    <i class="fa-solid fa-angles-left"></i> ย้อนกลับ
                                    </a>
                                </div>
                                <div class="col-md-1 mt-5">
                                    <p class="text-end fs-4">Comment</p>

                                </div>
                                <div class="col-md-7 mt-5">

                                    <input type="text" class="form-control" name="comment_slip">
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="button" class="btn btn-danger" onclick="confirmNotApprove2()">ไม่อนุมัติ slip<i class="fa-solid fa-xmark"></i></button>
                                    <button type="button" class="btn btn-success" onclick="confirmApprove2()">อนุมัติ slip<i class="fa-solid fa-check"></i></button>
                                </div>
                            </form>

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
    <script src="script.js"></script>

    <script>
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');



        imgInput4.onchange = evt => {
            const [file4] = imgInput4.files;
            if (file4) {
                previewImg4.src = URL.createObjectURL(file4);
            }
        };

        function confirmNotApprove2() {
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "คุณต้องการไม่อนุมัติหลักฐานการชำระ(Slip)นี้หรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'ใช่, ไม่อนุมัติ',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        let form = document.getElementById('personal-info-form');
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'not_approve';
        input.value = 'not_approve';
        form.appendChild(input);
        form.submit(); // ส่งฟอร์ม
      }
    });
  }

  function confirmApprove2() {
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "คุณต้องการอนุมัติหลักฐานการชำระ(Slip)นี้หรือไม่?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, อนุมัติ',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        let form = document.getElementById('personal-info-form');
        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'approve';
        input.value = 'approve';
        form.appendChild(input);
        form.submit(); // ส่งฟอร์ม
      }
    });
  }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>