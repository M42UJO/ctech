<?php
session_start();
require_once("config/db.php");
?>


<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=IBM+Plex+Sans+Thai+Looped:wght@100;200;300;400;500;600;700&family=Itim&family=Mali:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600;1,700&family=Mitr:wght@200;300;400;500;600;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Thai:wght@100..900&family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>


<body>
<?php
    require_once("nav.php");
    ?>
    <main class="form-signup mt-5">
        <form method="post" action="config/insertregister.php">
            <img src="https://img5.pic.in.th/file/secure-sv1/c-techlogo.png" alt="Your Logo" width="150" height="32"><br><br>
            <h1 class="h3 mb-3 fw-normal">สมัครสมาชิก</h1>
            <img src="imagee/ktc-lost-thai.jpg" alt="" width="75%" class="mb-3">

            <?php if (isset($_SESSION['error'])) : ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])) : ?>
                <div class="alert alert-success" role="alert">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <div class="form-floating my-2">
                <input type="text" class="form-control" id="thai-id" name="id_card_number" required maxlength="17" oninput="formatThaiID(this); generateUsername();" placeholder="x-xxxx-xxxxx-xx-x">
                <label for="thai-id">กรอกเลขบัตรประชาชน</label>
            </div>
            <div class="form-floating my-2" style="display: none;">
  <input type="text" class="form-control" id="username" name="username" readonly>
  <label class="hidden" for="username">Username</label>
</div>

            <button class="btn btn-warning w-100 py-2 btn-custom" type="submit">ยืนยัน</button>
            <p class="mt-5 mb-3 text-body-secondary">ถ้าคุณมีบัญชีแล้ว <a style="color: orange;" href="login.php">คลิกที่นี่</a> เพื่อเข้าสู่ระบบ</p>
        </form>

    </main>
    <?php
    require_once("footer.php");
    ?>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function formatThaiID(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length > 1) {
                value = value.slice(0, 1) + '-' + value.slice(1);
            }
            if (value.length > 6) {
                value = value.slice(0, 6) + '-' + value.slice(6);
            }
            if (value.length > 12) {
                value = value.slice(0, 12) + '-' + value.slice(12);
            }
            if (value.length > 15) {
                value = value.slice(0, 15) + '-' + value.slice(15);
            }
            input.value = value.slice(0, 17);

            generateUsername();
        }

        function generateUsername() {
            let idCard = document.getElementById('thai-id').value.replace(/-/g, '');
            if (idCard.length === 13) {
                let username = Math.random().toString(36).substr(2, 8);
                document.getElementById('username').value = username;
            }
        }

        document.querySelector('form').addEventListener('submit', function(event) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('thai-id').value;
            const confirmation = confirm(`นี่คือ username ของคุณ: ${username}\n        password ของคุณ: ${password}\n\nคุณต้องการดำเนินการต่อหรือไม่?`);
            if (!confirmation) {
                event.preventDefault(); // ยกเลิกการส่งฟอร์มถ้าผู้ใช้ไม่ยืนยัน
            }
        });
    </script>
</body>

</html>