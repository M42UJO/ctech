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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาบัญชี</h5>
                                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-green order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาคอมพิวเตอร์ธุรกิจ</h5>
                                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-yellow order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาเทคโนโลยีสารสนเทศ</h5>
                                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาเทคโนโลยีธุรกิจดิจิทัล</h5>
                                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาธุรกิจค้าปลีก</h5>
                                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-green order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาการจัดจารโลจิสติกส์</h5>
                                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-yellow order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาการตลาด</h5>
                                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i> <span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาช่างยนต์</h5>
                                    <h2 class="text-right"><i class="fa fa-credit-card f-left"></i> <span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาช่างไฟฟ้ากำลัง</h5>
                                    <h2 class="text-right"><i class="fa fa-cart-plus f-left"></i> <span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-green order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาช่างอิเล็กทรอนิกส์</h5>
                                    <h2 class="text-right"><i class="fa fa-rocket f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-yellow order-card">
                                <div class="card-block">
                                    <h5 class="m-b-20">จำนวนผู้สมัคร สาขาช่างก่อสร้าง</h5>
                                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span> 486</span></h2>
                                    <p class="m-b-0">Completed Approve<span class="f-right"> 351</span></p>
                                </div>
                            </div>
                        </div>

                       
                    </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-area me-1"></i> Area Chart Example
                                </div>
                                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Bar Chart Example
                                </div>
                                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
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