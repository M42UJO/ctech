<?php
session_start();
require_once("config/db.php");






?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<style>
    .centered-image {
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin: auto;
    }

    #center {
        text-align: center;
    }

    .marketing .col-lg-6 {
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .marketing .col-lg-6 p {
        margin-right: .75rem;
        margin-left: .75rem;
    }

    .featurette-divider {
        margin: 5rem 0;

    }

    .h1-center {
        text-align: center;

    }
.btn:hover {
    background-position: right center;
    
}

.btn-1 {
    background-image: linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%);
}
.title-section {
            background-image: url('./imagee/pic_ctech.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            position: relative;
        }
        .title-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6); /* Adjust overlay opacity */
            z-index: 1;
        }
        .title-content {
            position: relative;
            z-index: 2;
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin: 0;
        }
        .breadcrumb-item a {
            color: white;
            text-decoration: none;
        }
        .breadcrumb-item.active {
            color: orange;
        }


</style>

<body>
    <?php
    require_once("nav.php");
    ?>


<div class="title-section">
        <div class="title-content">
            <h1>หลักสูตร ที่ C-TECH เปิดรับ</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">C-TECH</li>
                </ol>
            </nav>
        </div>
    </div>


    <main>


        <div class="container marketing mt-5">


            <div class="row">
                <h1 class="h1-center mb-3"> หลักสูตร ภาคปกติ</h1>
                <!-- หลักสูตร ภาคปกติ -->
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวช. หลักสูตร ภาคปกติ</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.3 เข้าศึกษาต่อ ปวช. หลักสูตร ภาคปกติ<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนต้น เข้าศึกษาต่อ ปวช.หลักสูตร ภาคปกติ</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=1&level=1&subjectType=&major=">คุณวุฒิ ม.3 และ กศน. มัธยมศึกษาตอนต้น</a></p>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวส. หลักสูตร ภาคปกติ</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.6 เข้าศึกษาต่อ ปวส. หลักสูตร ภาคปกติ<br> - คุณวุฒิ ปวช. เข้าศึกษาต่อ ปวส. หลักสูตร ภาคปกติ<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนปลาย เข้าศึกษาต่อ ปวส. หลักสูตร ภาคปกติ</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=1&level=4&subjectType=&major=">คุณวุฒิ ม.6, ปวช. และ กศน. มัธยมศึกษาตอนปลาย</a></p>
                </div>
                <hr class="featurette-divider">

                <!-- หลักสูตร ภาคสมทบ -->
                <h1 class="h1-center mb-3"> หลักสูตร ภาคสมทบ</h1>
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวช. หลักสูตร ภาคสมทบ</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.3 เข้าศึกษาต่อ ปวช. หลักสูตร ภาคสมทบ<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนต้น เข้าศึกษาต่อ ปวช. หลักสูตร ภาคสมทบ</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=2&level=2&subjectType=&major=">คุณวุฒิ ม.3 และ กศน. มัธยมศึกษาตอนต้น</a></p>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวส. หลักสูตร ภาคสมทบ</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.6 เข้าศึกษาต่อ ปวส. หลักสูตร ภาคสมทบ<br> - คุณวุฒิ ปวช. เข้าศึกษาต่อ ปวส. หลักสูตร ภาคสมทบ<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนปลาย เข้าศึกษาต่อ ปวส. หลักสูตร ภาคสมทบ</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=2&level=5&subjectType=&major=">คุณวุฒิ ม.6, ปวช. และ กศน. มัธยมศึกษาตอนปลาย</a></p>
                </div>
                <hr class="featurette-divider">

                <!-- หลักสูตร ภาคทวิภาคี -->
                <h1 class="h1-center mb-3"> หลักสูตร ภาคทวิภาคี</h1>
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวช. ภาคทวิภาคี</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.3 เข้าศึกษาต่อ ปวช. ภาคทวิภาคี<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนต้น เข้าศึกษาต่อ ปวช. ภาคทวิภาคี</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=3&level=3&subjectType=&major=">คุณวุฒิ ม.3 และ กศน. มัธยมศึกษาตอนต้น</a></p>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-normal mt-5">เข้าศึกษาต่อ ปวส. ภาคทวิภาคี</h2>
                    <p>คุณวุฒิผู้สมัคร <br> - คุณวุฒิ ม.6 เข้าศึกษาต่อ ปวส. ภาคทวิภาคี<br> - คุณวุฒิ ปวช. เข้าศึกษาต่อ ปวส. ภาคทวิภาคี<br> - คุณวุฒิ กศน. มัธยมศึกษาตอนปลาย เข้าศึกษาต่อ ปวส. ภาคทวิภาคี</p>
                    <p><a class="btn btn-secondary" href="Form.php?courseType=3&level=6&subjectType=&major=">คุณวุฒิ ม.6, ปวช. และ กศน. มัธยมศึกษาตอนปลาย</a></p>
                </div>
                

            </div>







    </main>





    <?php
    require_once("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>