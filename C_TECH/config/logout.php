<?php
session_start();

// ทำการลบข้อมูลเซสชันทั้งหมด
session_unset();
session_destroy();

// เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
header('Location: ../login.php');
exit(); // เพิ่ม exit() เพื่อหยุดการทำงานของสคริปต์
?>
