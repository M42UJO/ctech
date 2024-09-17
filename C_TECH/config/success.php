<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'ข้อมูลถูกบันทึกเรียบร้อย',
                text: 'คุณกรอกข้อมูลครบถ้วนแล้ว คุณสามารถเลือกหลักสูตรที่ต้องการสมัครและไปที่สมัครเรียน',
                icon: 'success',
                confirmButtonText: 'ยืนยัน',
                timer: 5000,
                timerProgressBar: true
            }).then(() => {
                window.location.href = 'apply.php'; // Change to your desired page
            });
        });
    </script>
</body>
</html>
