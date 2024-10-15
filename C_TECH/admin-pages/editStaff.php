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

$user_id = $_GET['user_id'];

// ใช้ prepared statements เพื่อหลีกเลี่ยง SQL Injection
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $User_ID = $_POST['User_ID'];
    $name_staff = htmlspecialchars($_POST['name_staff']);
    $lname_staff = htmlspecialchars($_POST['lname_staff']);
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password']; 
    $urole = $_POST['urole'];

    try {
        // เตรียมคำสั่งอัปเดต
        $query = "UPDATE user SET name_staff = :name_staff, lname_staff = :lname_staff, username = :username, urole = :urole";
        
        // เพิ่มรหัสผ่านในคำสั่งหากมีการป้อน
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query .= ", password = :password";
        }
        
        $query .= " WHERE User_ID = :User_ID";

        $stmt = $conn->prepare($query);

        // ผูกพารามิเตอร์
        $stmt->bindParam(':name_staff', $name_staff);
        $stmt->bindParam(':lname_staff', $lname_staff);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':urole', $urole);
        $stmt->bindParam(':User_ID', $User_ID);

        // ผูกรหัสผ่านหากมีการป้อน
        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password);
        }

        // รันคำสั่ง
        $stmt->execute();

        $_SESSION['success'] = "User updated successfully!";
        header("Location: staff.php"); 
        exit();
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error updating user: " . $e->getMessage();
        header("Location: editStaff.php?user_id=" . $User_ID); // เปลี่ยนเส้นทางกลับพร้อมข้อผิดพลาด
        exit();
    }
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
        <a class="navbar-brand ps-3" href="indexadmin.php">Admin C-TECH</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><hr class="dropdown-divider" /></li>
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
            <main>
                <div class="container-fluid px-4">
                    <ol class="breadcrumb mb-3">
                        <li class="breadcrumb-item active">เพิ่มเจ้าหน้าที่</li>
                    </ol>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form id="personal-info-form" class="g-2 mt-2" action="editStaff.php?user_id=<?php echo $user_id; ?>" method="post">
                                <div class="panel-heading">เพิ่มเจ้าหน้าที่</div>

                                <?php if (isset($_SESSION['error'])) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($_SESSION['success'])) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="col-md-4 mt-5 m-auto">
                                    <label class="form-label" for="name_staff">ชื่อ</label>
                                    <input type="text" id="name_staff" class="form-control" placeholder="ชื่อ" name="name_staff" value="<?php echo $staff["name_staff"]; ?>" required>
                                </div>

                                <div class="col-md-4 mt-5 m-auto">
                                    <label class="form-label" for="lname_staff">นามสกุล</label>
                                    <input type="text" id="lname_staff" class="form-control" placeholder="นามสกุล" name="lname_staff" value="<?php echo $staff["lname_staff"]; ?>" required>
                                </div>

                                <div class="col-md-4 mt-5 m-auto">
                                    <label class="form-label" for="username">Username</label>
                                    <input type="text" id="username" class="form-control" placeholder="Username" name="username" value="<?php echo $staff["username"]; ?>" required>
                                </div>

                                <div class="col-md-4 mt-5 m-auto">
                                    <label class="form-label" for="password">รหัสผ่าน (เว้นว่างไว้เพื่อใช้รหัสผ่านเดิม)</label>
                                    <input type="password" id="password" class="form-control" placeholder="ใส่รหัสผ่านใหม่" name="password">
                                </div>

                                <div class="col-md-4 mt-5 m-auto">
                                    <label class="form-label">Urole</label>
                                    <select name="urole" id="urole" class="form-control">
                                        <option value="staff" <?php echo $staff['urole'] == 'staff' ? 'selected' : ''; ?>>staff</option>
                                        <option value="admin" <?php echo $staff['urole'] == 'admin' ? 'selected' : ''; ?>>admin</option>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mt-5">
                                        <a href="staff.php" type="button" class="btn w-100 py-2 btn-1">
                                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                                        </a>
                                    </div>
                                    <div class="col-md-2 mt-5 ms-auto">
                                        <button type="submit" name="update" class="btn w-100 py-2 btn-1">บันทึก
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
