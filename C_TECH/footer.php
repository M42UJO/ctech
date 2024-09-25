<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
</head>

<style>
html, body {
    height: 100%;
    margin: 0;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* ทำให้ความสูงอย่างน้อยเท่ากับความสูงของหน้าจอ */
}

.footer_area {
    margin-top: auto; /* ดัน footer ให้ไปอยู่ล่างสุดของ content */
    background-color: orange;
    padding: 10px;
    width: 100%;
}



</style>

<body>
    <footer class="footer_area mt-5">
        <div class="container">
            <div class="footer_row row">
                <div class="col-md-4 col-sm-6 footer_about">
                    <h2 class="fw-bold">ABOUT OUR C-TECH</h2><br>
                    <img src="https://img5.pic.in.th/file/secure-sv1/c-techlogo.png" alt="">
                    <br>
                    <br>
                    <p>อัตลักษณ์&nbsp;:&nbsp;ทักษะดี มีงานทำ<br> เอกลักษณ์&nbsp;:&nbsp;สร้างคน ตรงงาน<br> อัตลักษณ์คุณธรรม&nbsp;:&nbsp;รับผิดชอบ มีวินัย ใจอาสา<br> ปรัชญา&nbsp;:&nbsp;ทักษะเยี่ยม เปี่ยมคุณธรรม</p>
                </div>


                <div class="col-md-5 col-sm-6 footer_about">
                    <h2 id="contact" class="fw-bold">CONTACT US</h2>
                    <address>
                        <p>วิทยาลัยเทคโนโลยีชนะพลขันธ์ นครราชสีมา ยินดีต้อนรับทุกท่าน<br> สนใจติดต่อหรือสอบถามข้อสงสัย :</p>
                        <ul class="my_address">

                            <li><a style="color: black;" href="#"><i  class="fa fa-phone" aria-hidden="true"></i> 044-465168-9</a></li>
                            <li><a style="color: black;" href="contact.php"><i class="fa fa-map-signs" aria-hidden="true"></i> แผนที่วิทยาลัย</a></li>
                            <li><a style="color: black;" href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><span> 77/1 หมู่ 4 ตำบลบ้านใหม่ อำเภอเมือง จังหวัดนครราชสีมา 30000</span></a></li>
                        </ul>
                    </address>
                    <div class="fb-page fb_iframe_widget" style="width:100%" data-href="https://www.facebook.com/C-tech-Plus-1447069838849548/?fref=ts" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" fb-xfbml-state="rendered" fb-iframe-plugin-query="adapt_container_width=true&amp;app_id=&amp;container_width=360&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FC-tech-Plus-1447069838849548%2F%3Ffref%3Dts&amp;locale=th_TH&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false"><span style="vertical-align: bottom; width: 340px; height: 130px;"><iframe name="f3232efca36b7b6f8" width="1000px" height="1000px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v2.5/plugins/page.php?adapt_container_width=true&amp;app_id=&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df8aad36634e407d8f%26domain%3Dwww.c-tech.ac.th%26is_canvas%3Dfalse%26origin%3Dhttp%253A%252F%252Fwww.c-tech.ac.th%252Ffb41e50f41a7bfef7%26relation%3Dparent.parent&amp;container_width=360&amp;hide_cover=false&amp;href=https%3A%2F%2Fwww.facebook.com%2FC-tech-Plus-1447069838849548%2F%3Ffref%3Dts&amp;locale=th_TH&amp;sdk=joey&amp;show_facepile=true&amp;small_header=false" style="border: none; visibility: visible; width: 340px; height: 130px;" class=""></iframe></span></div>
                </div>
                <div class="col-md-3 col-sm-6 footer_about">
                    <h2 class="fw-bold">LOCATION</h2>
                    <p> เป็นสถาบันที่มีเนื้อที่กว้างขวางประมาณ 39.5 ไร่ ปลูกต้นไม้นานาพันธุ์ อาทิเช่น ประดู่ ปีบ ปาริชาติ ชัยพฤกษ์ ฯลฯ อาคารแบ่งออกได้ 4 ส่วน ดังนี้ <br>1. อาคารเรืองวิชา 6 ชั้น 100 ห้องเรียน <br>2. อาคารโรงฝึกงานแยกออกเป็นสัดส่วนเฉพาะงาน
                        <br>3. อาคารปกครองอยู่ส่วนหน้าสุด <br>4. อาคารเก็บกาญจนา
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>