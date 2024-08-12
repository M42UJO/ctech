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
                <form id="personal-info-form" class="row g-2 mt-2">
                    <div class="panel-heading">ต้องการศึกษา</div>
                    <label class="form-label">ต้องการศึกษา <span class="required">**</span></label>
                    <div class="row">
                        <div class="col-md-3">
                            <select id="CourseType_Name" name="CourseType_Name" class="form-control" required>
                                <option value="">เลือกประเภทของหลักสูตร</option>
                            </select>
                        </div>
                        <div class="col-md-3">

                            <select id="Level_Name" name="Level_Name" class="form-control" required>
                                <option value="">เลือกระดับการศึกษา</option>
                            </select>
                        </div>
                        <div class="col-md-3">

                            <select id="Type_Name" name="Type_Name" class="form-control col-md-3" required>
                                <option value="">เลือกประเภทวิชา</option>
                            </select>
                        </div>
                        <div class="col-md-3">

                            <select id="Major_Name" name="Major_Name" class="form-control col-md-3" required>
                                <option value="">เลือกสาขาวิชา</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 mt-5">
                        <button type="button" class="btn btn-warning w-100 py-2 btn-custom" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> ย้อนกลับ
                        </button>
                    </div>
                    <div class="col-md-8 mt-5"></div>
                    <div class="col-md-2 mt-5">
                        <button type="submit" name="submit" class="btn btn-warning w-100 py-2 btn-custom">ถัดไป
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once("footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="script.js"></script>

    <script>
        // ส่งข้อมูลจาก PHP ไปยัง JavaScript
        const courseTypes = <?php echo json_encode($courseTypes); ?>;
        const levels = <?php echo json_encode($levels); ?>;
        const subjectTypes = <?php echo json_encode($subjectTypes); ?>;
        const majors = <?php echo json_encode($majors); ?>;

        document.addEventListener('DOMContentLoaded', function() {
            const courseTypeSelect = document.getElementById('CourseType_Name');
            const levelSelect = document.getElementById('Level_Name');
            const subjectTypeSelect = document.getElementById('Type_Name');
            const majorSelect = document.getElementById('Major_Name');

            function populateSelect(selectElement, data, valueKey, textKey) {
                selectElement.innerHTML = '<option value="">เลือกตัวเลือก</option>'; // Clear existing options
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item[valueKey];
                    option.textContent = item[textKey];
                    selectElement.appendChild(option);
                });
            }

            function clearSelect(selectElement) {
                selectElement.innerHTML = '<option value="">เลือกตัวเลือก</option>';
            }

            // เตรียม dropdowns
            populateSelect(courseTypeSelect, courseTypes, 'CourseType_ID', 'CourseType_Name');

            courseTypeSelect.addEventListener('change', function() {
                const selectedCourseType = this.value;
                const filteredLevels = levels.filter(level => level.CourseType_ID == selectedCourseType);
                populateSelect(levelSelect, filteredLevels, 'Level_ID', 'Level_Name');
                clearSelect(subjectTypeSelect);
                clearSelect(majorSelect);
            });

            levelSelect.addEventListener('change', function() {
                const selectedLevel = this.value;
                const filteredSubjectTypes = subjectTypes.filter(subjectType => subjectType.Level_ID == selectedLevel);
                populateSelect(subjectTypeSelect, filteredSubjectTypes, 'Type_ID', 'Type_Name');
                clearSelect(majorSelect);
            });

            subjectTypeSelect.addEventListener('change', function() {
                const selectedSubjectType = this.value;
                const filteredMajors = majors.filter(major => major.Type_ID == selectedSubjectType);
                populateSelect(majorSelect, filteredMajors, 'Major_ID', 'Major_Name');
            });
        });
    </script>
</body>

</html>