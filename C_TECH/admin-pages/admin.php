<?php
session_start();
require_once("../config/db.php");


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
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="script.js">

</head>




<body>


    <!-- login -->



    <main class="form-signin mt-5 col-md-12">
        <form>
            <img src="https://img5.pic.in.th/file/secure-sv1/c-techlogo.png" alt="Your Logo" width="150" height="32"><br><br>


            <h2 class="h3 mb-3 fw-normal">Administrator</h2>
            <h2 class="h4 mb-3 fw-normal">กรุณาเข้าสู่ระบบ</h2>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="floatingInput" placeholder="">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating my-2">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">Remember me</label>
            </div>


            <button class="btn btn-warning w-100  btn-custom" type="submit">เข้าสู่ระบบ</button>
            <!-- <p class="mt-5 mb-3 text-body-secondary">ถ้าไม่มีบัญชี <a style="color: orange;" href="register.php">คลิกที่นี่</a> เพิ่อสมัคร</p> -->

        </form>
    </main>

    <br><br><br>

    <!-- end login -->

    







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js " integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL " crossorigin="anonymous "></script>
</body>

</html>