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
            background-image: url('./imagee/pic_ctech.jpg');
            /* Replace with your image path */
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
            background-color: rgba(0, 0, 0, 0.6);
            /* Adjust overlay opacity */
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

        .progress-vertical-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            /* Adjust height as needed */
        }

        .progress-vertical {
            position: relative;
            width: 100%;
            max-width: 600px;
        }

        .progress-vertical .step {
            position: relative;
            padding: 20px 0;
            text-align: center;
        }

        .progress-vertical .step::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            height: 100%;
            width: 2px;
            background-color: #f68c2e;
            /* สีส้ม */
            transform: translateX(-50%);
            z-index: 0;
        }

        .progress-vertical .step:last-child::before {
            height: 50%;
        }

        .progress-vertical .step-number {
            position: relative;
            width: 50px;
            height: 50px;
            background-color: #f68c2e;
            /* สีส้ม */
            color: white;
            text-align: center;
            line-height: 50px;
            border-radius: 50%;
            margin: 0 auto;
            z-index: 1;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .progress-vertical .step-content {
            margin-left: 0;
            /* ลบระยะห่างซ้าย */
            padding: 15px;
            position: relative;
            z-index: 1;
            text-align: center;
            /* จัดตำแหน่งข้อความให้อยู่กลาง */
            background-color: #e4e2e2;
            /* สีพื้นหลังที่กำหนด */
            border-radius: 4px;
            /* เพิ่มความนุ่มนวลที่มุม */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            /* เพิ่มเงาเบา */
        }


        .progress-vertical .step-content::before {
            content: '';
            position: absolute;
            left: -15px;
            top: 20px;
            border: 15px solid transparent;
            border-right-color: #e4e2e2;
            /* ใช้สีพื้นหลังเดียวกัน */
        }


        @media (max-width: 768px) {
            .progress-vertical .step-content {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <?php require_once("nav.php"); ?>

    <div class="title-section">
        <div class="title-content">
            <h1>ขั้นตอนการสมัครเรียน ที่ C-TECH</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">C-TECH</li>
                </ol>
            </nav>
        </div>
    </div>

    <style>
        .text-orange {
            color: #fd7e14;
            /* สีส้มของ Bootstrap */
        }
    </style>

    <main class="container">
        <div class="progress-vertical-container">
            <div class="progress-vertical">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h5>เข้าสู่ระบบ</h5>
                        <p>เริ่มต้นด้วยการเข้าสู่ระบบบัญชีผู้ใช้ของคุณโดยใช้อีเมลและรหัสผ่านที่ลงทะเบียนไว้. หากคุณยังไม่มีบัญชีผู้ใช้, กรุณา<a href="register.php" class="text-orange">ลงทะเบียน</a>เพื่อสร้างบัญชีใหม่ก่อน.</p>
                        <a href="login.php" class="text-orange">เข้าสู่ระบบ</a>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h5>กรอกข้อมูลส่วนตัว</h5>
                        <p>หลังจากเข้าสู่ระบบ, คุณจะต้องกรอก ข้อมูลส่วนตัว,ที่อยู่ปัจจุบัน,ข้อมูลการศึกษา,ข้อมูลบิดา,ข้อมูลมารดา,ข้อมูลผู้ปกครอง</p>
                        <a href="Personal_info.php" class="text-orange">กรอกข้อมูลส่วนตัว</a>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h5>เลือกหลักสูตร</h5>
                        <p>เลือกหลักสูตรที่คุณต้องการสมัครจากรายการหลักสูตรที่มีอยู่. คุณสามารถดูรายละเอียดของแต่ละหลักสูตร เช่น ค่าใช้จ่าย, และเนื้อหาหลักสูตร เพื่อช่วยในการตัดสินใจ.</p>
                        <a href="apply.php" class="text-orange">เลือกหลักสูตร</a>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h5>หลักฐานที่ใช้ในการสมัคร</h5>
                        <p>อัพโหลดเอกสารที่จำเป็นสำหรับการสมัคร เช่น สำเนาบัตรประชาชน, สำเนาใบรบ, สำเนาทะเบียนบ้าน, และหลักฐานการชำระ. ตรวจสอบให้แน่ใจว่าเอกสารทั้งหมดอ่านได้ชัดเจนและครบถ้วน.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h5>ตรวจสอบความถูกต้อง</h5>
                        <p>ตรวจสอบข้อมูลทั้งหมดที่คุณกรอกและเอกสารที่อัพโหลดให้แน่ใจว่าถูกต้องและครบถ้วน. คุณสามารถกลับไปแก้ไขข้อมูลก่อนที่จะส่งใบสมัครได้.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">6</div>
                    <div class="step-content">
                        <h5>ยืนยันการสมัคร</h5>
                        <p>ทำการยืนยันการสมัครของคุณ. ตรวจสอบให้แน่ใจว่าคุณได้ปฏิบัติตามทุกขั้นตอนและส่งใบสมัครแล้ว. รอการตอบรับจากระบบหรือการติดต่อจากเจ้าหน้าที่เพื่อยืนยันการสมัครของคุณ.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">7</div>
                    <div class="step-content">
                        <h5>ตรวจสอบสถานะ</h5>
                        <p>ตรวจสอบสถานะของใบสมัครของคุณเพื่อดูความคืบหน้าหรือการอัพเดตจากระบบ. คุณจะได้รับข้อมูลเกี่ยวกับสถานะการสมัครของคุณผ่านหน้าเว็บนี้.</p>
                        <a href="checkstatus.php" class="text-orange">ตรวจสอบสถานะ</a>
                    </div>
                </div>
            </div>
        </div>
    </main>




    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>