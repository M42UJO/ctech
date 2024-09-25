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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->

</head>




<body>
    <!-- nav -->
    <?php
    require_once("nav.php");
    ?>

    <!-- end nav -->

    <!-- login -->
    <main class="form-signin mt-5 col-md-12">
        <form action="config/insertlogin.php" method="post">
            <img src="https://img5.pic.in.th/file/secure-sv1/c-techlogo.png" alt="Your Logo" width="150" height="32"><br><br>


            <h2 class="h3 mb-5 fw-normal">กรุณาเข้าสู่ระบบ</h2>
            <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>

            <div class="form-floating">
            <input type="text" class="form-control" id="idCardNumber" name="id_card_number" required placeholder="ID Card Number" maxlength="17">
                <label for="floatingInput">ID Card Number</label>
            </div>
            <button class="btn btn-warning w-100  btn-custom mt-4" name="login" type="submit">เข้าสู่ระบบ</button>

        </form>
    </main>

    <?php
    require_once("footer.php");
    ?>




    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL " crossorigin="anonymous "></script>
    <script>
    document.getElementById('idCardNumber').addEventListener('input', function (e) {
        var value = e.target.value.replace(/\D/g, ''); // ลบตัวอักษรที่ไม่ใช่ตัวเลขออก
        if (value.length > 13) {
            value = value.slice(0, 13); // จำกัดความยาวที่ 13 ตัวเลข
        }

        var formattedValue = '';
        if (value.length > 0) {
            formattedValue += value.substring(0, 1); // x
        }
        if (value.length > 1) {
            formattedValue += '-' + value.substring(1, 5); // xxxx
        }
        if (value.length > 5) {
            formattedValue += '-' + value.substring(5, 10); // xxxxx
        }
        if (value.length > 10) {
            formattedValue += '-' + value.substring(10, 12); // xx
        }
        if (value.length > 12) {
            formattedValue += '-' + value.substring(12, 13); // x
        }

        e.target.value = formattedValue;
    });
</script>
</body>

</html>