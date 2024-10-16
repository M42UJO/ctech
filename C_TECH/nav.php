<?php
require_once("config/db.php");

// ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
$isLoggedIn = isset($_SESSION['user_login']);

if ($isLoggedIn) {
    $user_id = $_SESSION['user_login'];
    try {
        // เตรียมและดำเนินการคำสั่ง SQL
        $stmt = $conn->prepare("SELECT * FROM user WHERE User_ID = ?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลเป็น associative array
    } catch (PDOException $e) {
        $errorMessage = "Error: " . htmlspecialchars($e->getMessage()); // ใช้ htmlspecialchars() เพื่อป้องกัน XSS
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome สำหรับไอคอน -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: orange; /* สีที่คุณต้องการ */
        }
        .navbar-custom .nav-link {
            color: #000000; /* สีข้อความ */
        }
        .navbar-custom .nav-link:hover {
            color: #f0e68c; /* สีข้อความเมื่อ hover */
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <!-- โลโก้ของ Navbar -->
        <a href="index.php" class="navbar-brand me-5">
            <img src="https://img5.pic.in.th/file/secure-sv1/c-techlogo.png" alt="Your Logo" width="150" height="32">
        </a>

        <!-- ปุ่มสำหรับเปิด/ปิดเมนู -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- เมนูของ Navbar -->
        <div class="collapse navbar-collapse justify-content-center " id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="index.php" class="nav-link link-dark fw-bold">หน้าหลัก</a>
                </li>
                <li class="nav-item">
                    <a href="http://c-tech.ac.th/branch.php" target="_blank" class="nav-link link-dark fw-bold">สาขาที่เปิดสอน</a>
                </li>
                <li class="nav-item">
                    <a href="process.php" class="nav-link link-dark fw-bold">ขั้นตอนการสมัครเรียน</a>
                </li>
                <li class="nav-item">
                    <a href="apply.php" class="nav-link link-dark fw-bold">สมัครเรียน</a>
                </li>
                <?php if ($isLoggedIn) : ?>
                    <li class="nav-item">
                        <a href="Personal_info.php" class="nav-link link-dark fw-bold">กรอกข้อมูลส่วนตัว</a>
                    </li>
                    <li class="nav-item">
                        <a href="checkstatus.php" class="nav-link link-dark fw-bold">ตรวจสอบสถานะ</a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- เมนู Login/Logout จะอยู่ในแฮมเบอร์เกอร์ในมือถือ -->
            <ul class="navbar-nav d-lg-none">
                <?php if ($isLoggedIn) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMobile" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMobile">
                            <!-- <li><hr class="dropdown-divider" /></li>                           -->
                            <li><a class="dropdown-item" href="config/logout.php">Logout</a></li>
                            
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link link-dark fw-bold">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="d-none d-lg-flex">
            <ul class="navbar-nav">
                <?php if ($isLoggedIn) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><hr class="dropdown-divider" /></li>
                            <p class="dropdown-item"><?php echo $row["id_card_number"]; ?> </p>

                            <li><a class="dropdown-item" href="personal_info.php">กรอกข้อมูลส่วนตัว</a></li>
                            <li><a class="dropdown-item" href="checkstatus.php">ตรวจสอบสถานะ</a></li>

                            <li><a class="dropdown-item" href="config/logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-outline-dark me-2 fw-bold">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS และ dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

</body>

</html>
