<?php
session_start();
require_once("config/db.php");

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
}

try {
    // ดึงข้อมูลจากฐานข้อมูล
    $stmtCourseType = $conn->query("SELECT * FROM coursetype");
    $courseTypes = $stmtCourseType->fetchAll(PDO::FETCH_ASSOC);

    $stmtLevel = $conn->query("SELECT * FROM educationlevel");
    $levels = $stmtLevel->fetchAll(PDO::FETCH_ASSOC);

    $stmtSubjectType = $conn->query("SELECT * FROM subjecttype");
    $subjectTypes = $stmtSubjectType->fetchAll(PDO::FETCH_ASSOC);

    $stmtMajor = $conn->query("SELECT * FROM major");
    $majors = $stmtMajor->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$courseType = isset($_GET['courseType']) ? $_GET['courseType'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';
$subjectType = isset($_GET['subjectType']) ? $_GET['subjectType'] : '';
$major = isset($_GET['major']) ? $_GET['major'] : '';
?>

<?php
// ตรวจสอบว่า guardian_name มีข้อมูลหรือไม่
$stmtGuardian = $conn->prepare("SELECT guardian_name FROM parent_info WHERE User_ID = :user_id");
$stmtGuardian->bindParam(':user_id', $user_id);
$stmtGuardian->execute();
$guardian = $stmtGuardian->fetch(PDO::FETCH_ASSOC);

$guardianMissing = empty($guardian['guardian_name']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C-TECH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>
<style>
    .btn {
    flex: 1 1 auto;
    margin: 10px;
    padding: 30px;
    text-align: center;
    text-transform: uppercase;
    transition: 0.5s;
    background-size: 200% auto;
    color: white;
    text-shadow: 0px 0px 10px rgba(0,0,0,0.2);
    box-shadow: 0 0 20px #eee;
    border-radius: 10px;
}

.btn:hover {
    background-position: right center;
    
}

.btn-1 {
    background-image: linear-gradient(to right, #f6d365 0%, #fda085 51%, #f6d365 100%);
}

</style>

<body>
    <?php require_once("nav.php"); ?>

    <div class="container mt-5">
        <section class="step-wizard">
            <ul class="step-wizard-list">
                <li class="step-wizard-item current-item">
                    <span class="progress-count">1</span>
                    <span class="progress-label">ต้องการศึกษา</span>
                </li>
                <li class="step-wizard-item">
                    <span class="progress-count">2</span>
                    <span class="progress-label">หลักฐานการสมัคร</span>
                </li>
            </ul>
        </section>

        <div class="panel panel-default">
            <div class="panel-body">
                <form id="personal-info-form" class="row g-2 mt-2" action="config/insertForm.php" method="post">
                    <div class="panel-heading">ต้องการศึกษา</div>

                    <div class="row mt-5">
                        <div class="col-lg-3">
                            <label class="form-label">ประเภทของหลักสูตร <span class="required">**</span></label>
                            <select id="CourseType_Name" name="CourseType_Name" class="form-control" required>
                                <option value="">เลือกประเภทของหลักสูตร</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">ระดับการศึกษา <span class="required">**</span></label>
                            <select id="Level_Name" name="Level_Name" class="form-control" required>
                                <option value="">เลือกระดับการศึกษา</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">ประเภทวิชา <span class="required">**</span></label>
                            <select id="Type_Name" name="Type_Name" class="form-control" required>
                                <option value="">เลือกประเภทวิชา</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">สาขาวิชา <span class="required">**</span></label>
                            <select id="Major_Name" name="Major_Name" class="form-control" required>
                                <option value="">เลือกสาขาวิชา</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <a href="index.php" type="button" class="btn  w-100 py-2 btn-1">
                        <i class="fa-solid fa-angles-left"></i> ย้อนกลับ
                        </a>
                    </div>
                    <div class="col-md-8">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="submit" class="btn  w-100 py-2 btn-1">ถัดไป
                        <i class="fa-solid fa-angles-right"></i>
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseTypeSelect = document.getElementById('CourseType_Name');
            const levelSelect = document.getElementById('Level_Name');
            const subjectTypeSelect = document.getElementById('Type_Name');
            const majorSelect = document.getElementById('Major_Name');

            const levels = <?php echo json_encode($levels); ?>;
            const subjectTypes = <?php echo json_encode($subjectTypes); ?>;
            const majors = <?php echo json_encode($majors); ?>;

            // Populate initial dropdowns
            populateSelect(courseTypeSelect, <?php echo json_encode($courseTypes); ?>, 'CourseType_ID', 'CourseType_Name');

            // Event handler for changing courseType
            courseTypeSelect.addEventListener('change', function() {
                const selectedCourseType = this.value;
                const filteredLevels = levels.filter(level => level.CourseType_ID == selectedCourseType);
                populateSelect(levelSelect, filteredLevels, 'Level_ID', 'Level_Name');
                clearSelect(subjectTypeSelect);
                clearSelect(majorSelect);
            });

            // Event handler for changing level
            levelSelect.addEventListener('change', function() {
                const selectedLevel = this.value;
                const filteredSubjectTypes = subjectTypes.filter(type => type.Level_ID == selectedLevel);
                populateSelect(subjectTypeSelect, filteredSubjectTypes, 'Type_ID', 'Type_Name');
                clearSelect(majorSelect);
            });

            // Event handler for changing subjectType
            subjectTypeSelect.addEventListener('change', function() {
                const selectedSubjectType = this.value;
                const filteredMajors = majors.filter(major => major.Type_ID == selectedSubjectType);
                populateSelect(majorSelect, filteredMajors, 'Major_ID', 'Major_Name');
            });

            // Set initial values
            courseTypeSelect.value = '<?php echo $courseType; ?>';
            const initialLevels = levels.filter(level => level.CourseType_ID == courseTypeSelect.value);
            populateSelect(levelSelect, initialLevels, 'Level_ID', 'Level_Name');
            levelSelect.value = '<?php echo $level; ?>';
            const initialSubjectTypes = subjectTypes.filter(type => type.Level_ID == levelSelect.value);
            populateSelect(subjectTypeSelect, initialSubjectTypes, 'Type_ID', 'Type_Name');
            subjectTypeSelect.value = '<?php echo $subjectType; ?>';
            const initialMajors = majors.filter(major => major.Type_ID == subjectTypeSelect.value);
            populateSelect(majorSelect, initialMajors, 'Major_ID', 'Major_Name');
            majorSelect.value = '<?php echo $major; ?>';
        });

        function populateSelect(selectElement, data, valueKey, textKey) {
            selectElement.innerHTML = '<option value="">= เลือกตัวเลือก =</option>'; // Clear existing options
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[textKey];
                selectElement.appendChild(option);
            });
        }

        function clearSelect(selectElement) {
            selectElement.innerHTML = '<option value="">= เลือกตัวเลือก =</option>';
        }
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($guardianMissing): ?>
                Swal.fire({
                    icon: 'warning',
                    title: 'กรอกข้อมูลส่วนตัวไม่ครบถ้วน',
                    text: 'กรุณากรอกข้อมูลส่วนตัวให้ครบถ้วน จึงสมัครเรียนได้',
                    confirmButtonText: 'ตกลง',
                    willClose: () => {
                        window.location.href = 'Personal_info.php';
                    }
                });
            <?php endif; ?>
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>