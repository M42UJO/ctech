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

    .featurette-divider {
        margin: 5rem 0;
        /* Space out the Bootstrap <hr> more */
    }

    /* CUSTOMIZE THE CAROUSEL
-------------------------------------------------- */

    /* Carousel base class */
    .carousel {
        margin-bottom: 4rem;
    }

    /* Since positioning the image, we need to help out the caption */
    .carousel-caption {
        bottom: 3rem;
        z-index: 10;
    }

    /* Declare heights because of positioning of img element */
    .carousel-item {
        height: 36rem;
    }


    /* MARKETING CONTENT
-------------------------------------------------- */

    /* Center align the text within the three columns below the carousel */
    .marketing .col-lg-4 {
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .marketing .col-lg-4 p {
        margin-right: .75rem;
        margin-left: .75rem;
    }


    /* Featurettes
------------------------- */

    .featurette-divider {
        margin: 5rem 0;
        /* Space out the Bootstrap <hr> more */
    }

    /* Thin out the marketing headings */

    /* RESPONSIVE CSS
-------------------------------------------------- */

    @media (min-width: 40em) {

        /* Bump up size of carousel content */
        .carousel-caption p {
            margin-bottom: 1.25rem;
            font-size: 1.25rem;
            line-height: 1.4;
        }

        .featurette-heading {
            font-size: 50px;
        }
    }

    @media (min-width: 62em) {
        .featurette-heading {
            margin-top: 7rem;
        }
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
            <h1>ระบบรับสมัครนักศึกษา ที่ C-TECH</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">C-TECH</li>
                </ol>
            </nav>
        </div>
    </div>


    <main>

        <div id="myCarousel" class=" container carousel slide mb-6 " data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="สไลด์ 1"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="สไลด์ 2"></button>
                <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="สไลด์ 3" class="active" aria-current="true"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item ">
                    <img src="imagee/pic_ctech.jpg" class="d-block  centered-image" alt="..." style="width: 100%; height: auto;">
                    
                </div>
                <div class="carousel-item">
                    <img src="imagee/ระบบรับสมัครนักศึกษา C-TECH.jpg" class="d-block  centered-image" alt="..." style="width: 100%; height: auto;">
                    
                </div>
                <div class="carousel-item active">
                    <img src="imagee/b_02.jpg" class="d-block  centered-image " alt="..." style="width: 100%; height: auto;">
                    
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">ก่อนหน้า</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">ถัดไป</span>
            </button>
        </div>

        <div class="container marketing mt-5">
            

        



            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">เปิดรับ ปวส. เรียนที่ซีเทค "เรียนด้วย ทำงานด้วย รายได้ดี"<span class="text-body-secondary"> วัยรุ่น Y2K </span></h2>
                    <p class="lead">มาแล้วววว ปวส. ที่หนูอยากเรียน!! เรียนที่ซีเทค "เรียนด้วย ทำงานด้วย รายได้ดี" วัยรุ่น Y2K อย่างเราต้องมาสมัครแล้วป่ะ.</p>
                </div>
                <div class="col-md-5">
                    <img src="imagee/128.jpg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="...">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7 order-md-2">
                    <h2 class="featurette-heading fw-normal lh-1">เปิดรับ ปวช. เรียนที่ซีเทค "เรียนฟรี มีงานทำ มีรายได้" <span class="text-body-secondary"> ห้ามพลาด </span></h2>
                    <p class="lead">มาแล้วววว ปวช. ที่หนูอยากเรียน!! คลิ๊กเลยย เรียนที่ซีเทค "เรียนด้วย ทำงานด้วย รายได้ดี" วัยรุ่น Y2K อย่างเราต้องมาสมัครแล้วป่ะ</p>
                </div>
                <div class="col-md-5 order-md-1">
                    <img src="imagee/129.jpg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="...">
                </div>
            </div>

            <hr class="featurette-divider">

            <div class="row featurette">
                <div class="col-md-7">
                    <h2 class="featurette-heading fw-normal lh-1">หางานให้ มีรายได้อีก <span class="text-body-secondary"> ให้ขนาดนี้ต้องซีเทคแล้วป่ะ </span></h2>
                    <p class="lead">หางานให้ รายได้ดี รับผู้จบ ม.3 / ม.6 / กศน. มีเรียนวันหยุด สามารถสอบเข้าทำงานหน่วยงานรัฐวิสาหกิจทุกที่</p>
                </div>
                <div class="col-md-5">
                    <img src="imagee/130.jpg" class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" alt="...">
                </div>
            </div>

            

        </div>
    </main>





    <?php
    require_once("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>