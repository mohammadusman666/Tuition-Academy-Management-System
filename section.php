<?php
include('./classes/database.php');

session_start();

$usertype = $_SESSION["usertype"];
$username = $_SESSION["username"];

// selecting administrator id
if ($usertype == "administrator")
{
    $admin_id = DB::query('SELECT administrator.admin_id
                            FROM administrator
                            WHERE username=:username;',
                            array(':username'=>$username))[0]['admin_id'];
}
// selecting manager id
else if ($usertype == "manager")
{
    $manager_id = DB::query('SELECT manager.manager_id
                                FROM manager
                                WHERE username=:username;',
                                array(':username'=>$username))[0]['manager_id'];
}
// selecting teacher id
else if ($usertype == "teacher")
{
    $teacher_id = DB::query('SELECT teacher.teacher_id
                            FROM teacher
                            WHERE username=:username;',
                            array(':username'=>$username))[0]['teacher_id'];
}

if(isset($_GET['section_id']) && !empty($_GET['section_id']))
{
    $section_id = $_GET["section_id"];

    if ($usertype == "teacher")
    {
        $sids = DB::query('SELECT section.section_id
                            FROM section
                            WHERE section.teacher_id = (SELECT teacher.teacher_id
                                                        FROM teacher
                                                        WHERE teacher.username=:username);',
                            array(':username'=>$username));

        // checking if the section_id is of the loggedin teacher
        $found = 0;
        foreach ($sids as $sid)
        {
            if ($sid['section_id'] == $section_id)
            {
                $found = 1;
            }
        }
        if (!$found)
        {
            header('Location: teacher.php');
        }
    }

    // getting teacher name
    $teacher = DB::query('SELECT teacher.name
                            FROM teacher
                            WHERE teacher.teacher_id = (SELECT section.teacher_id
                                                    FROM section
                                                    WHERE section.section_id=:sectionid);',
                            array(':sectionid'=>$section_id))[0]['name'];

    // getting all of the students in a particular section
    $students = DB::query('SELECT student.student_id, student.name, enrollment.enrollment_id, section.section_id
                            FROM student
                            INNER JOIN enrollment
                            ON enrollment.student_id = student.student_id
                                INNER JOIN section
                                ON enrollment.section_id = section.section_id
                                WHERE section.section_id=:sectionid;',
                            array(':sectionid'=>$section_id));

    // if add quiz button is clicked
    if (isset($_POST['aq']))
    {
        // getting old quiz no
        $oldQuizNo = DB::query("SELECT MAX(DISTINCT quiz.no) as no
                                FROM quiz
                                INNER JOIN enrollment
                                ON enrollment.enrollment_id = quiz.enrollment_id
                                    INNER JOIN section
                                    ON enrollment.section_id = section.section_id
                                    WHERE section.section_id=:sectionid;",
                                array(':sectionid'=>$section_id))[0]['no'];
        // new quiz no
        $no = $oldQuizNo + 1;

        // for each student of the current section
        foreach($students as $student)
        {
            $enrollment_id = $student['enrollment_id'];
            DB::query("INSERT INTO quiz (enrollment_id, no)
                        VALUES (:enrollmentid, :no);",
                        array(':enrollmentid'=>$enrollment_id, ':no'=>$no));
        }
    }

    // if add assignment button is clicked
    if (isset($_POST['aa']))
    {
        // getting old assignment no
        $oldAssignmentNo = DB::query("SELECT MAX(DISTINCT assignment.no) as no
                                        FROM assignment
                                        INNER JOIN enrollment
                                        ON enrollment.enrollment_id = assignment.enrollment_id
                                            INNER JOIN section
                                            ON enrollment.section_id = section.section_id
                                            WHERE section.section_id=:sectionid;",
                                        array(':sectionid'=>$section_id))[0]['no'];
        // new assignment no
        $no = $oldAssignmentNo + 1;

        // for each student of the current section
        foreach($students as $student)
        {
            $enrollment_id = $student['enrollment_id'];
            DB::query("INSERT INTO assignment (enrollment_id, no)
                        VALUES (:enrollmentid, :no);",
                        array(':enrollmentid'=>$enrollment_id, ':no'=>$no));
        }
    }
}
else
{
    // if a teacher tries to acess this page
    if ($usertype == "teacher")
    {
        header('Location: teacher.php');
    }

    // getting all sections
    $sections = DB::query('SELECT section.section_id, course.code, course.title, course.description, section.no
                            FROM section
                            INNER JOIN course
                            ON section.course_id = course.course_id;',
                            array());
    
    $Allsections = '';
    foreach($sections as $section)
    {
        $Allsections .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <a class="btn btn-default mybtn" href="section.php?section_id='.$section['section_id'].'">
                                    <h3>'.$section['code'].' ('.$section['no'].')</h3>
                                    <p>'.$section['title'].'</p>
                                </a>
                         </div>';
    }
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Section - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <?php
            if ($usertype == "administrator" || $usertype == "manager")
                echo '<link rel="stylesheet" href="assets/css/sectionAM.css">';
            else
                echo '<link rel="stylesheet" href="assets/css/sectionTS.css">';
        ?>
    </head>

    <body>
        <!-- Header -->
        <div>
            <nav class="navbar navbar-default navigation-clean-button">
                <div class="container">
                    <div class="navbar-header">
                        <a class="navbar-brand">Tuition Academy</a>
                        <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                    </div>
                    <div class="collapse navbar-collapse" id="navcol-1">
                        <ul class="nav navbar-nav">
                            <?php
                                if ($usertype == "administrator")
                                    echo '<li role="presentation"><a href="administrator.php">Home</a></li>
                                          <li class="active" role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php">Managers</a></li>
                                          <li role="presentation"><a href="administrator.php?admin_id='.$admin_id.'">Profile</a></li>';
                                else if ($usertype == "manager")
                                    echo '<li role="presentation"><a href="manager.php">Home</a></li>
                                          <li class="active" role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php?manager_id='.$manager_id.'">Profile</a></li>';
                                else if ($usertype == "teacher")
                                    echo '<li role="presentation"><a href="teacher.php">Home</a></li>
                                          <li role="presentation"><a href="teacher.php?teacher_id='.$teacher_id.'">Profile</a></li>';
                            ?>
                        </ul>
                        <p class="navbar-text navbar-right actions">
                            <button class="btn btn-default action-button animated fadeIn" id="logout" type="button">Log Out</button>
                        </p>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="container">
            <?php
                if(isset($_GET['section_id']) && !empty($_GET['section_id']))
                {
                    if ($usertype == "teacher")
                    {
                        // quiz and assignment creation forms
                        echo '<div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="login-clean">
                                        <form role="form" method="POST">
                                            <h3>Create New Quiz</h3>
                                            <input class="btn btn-block" name="aq" type="submit" value="Create">
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <div class="login-clean">
                                        <form role="form" method="POST">
                                            <h3>Create New Assignment</h3>
                                            <input class="btn btn-block" name="aa" type="submit" value="Create">
                                        </form>
                                    </div>
                                </div>
                              </div>';
                    }

                    echo '<div class="row">
                                <div class="col-lg-12">
                                    <h1>Students</h1>
                                </div>
                          </div>
                          <div class="row">';
                    // displaying all the students of a particular section
                    foreach($students as $student)
                    {
                        echo '<div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="login-clean">
                                        <form role="form">
                                            <h3 class="myh3">('.$student['student_id'].') '.$student['name'].'</h3>
                                            <a class="btn btn-default mybtn" href="marks.php?enrollment_id='.$student['enrollment_id'].'">Marks</a>';
                                            if ($usertype != "teacher")
                                                echo '<a class="btn btn-default mybtn" href="fees.php?enrollment_id='.$student['enrollment_id'].'">Fees</a>';
                        echo '          </form>
                                    </div>
                              </div>';
                    }
                    echo '</div>';
                }
                // displaying all the sections
                else
                {
                    echo '<div class="row">
                            <div class="col-lg-12">
                                <h1>Sections</h1>
                            </div>
                          </div>
                          <br>
                          <div class="row">'
                                .$Allsections.
                         '</div>';
                }
            ?>
        </div>

        <br>

        <!-- Footer -->
        <div class="footer-light navbar-fixed-bottom" style="position: relative;">
            <footer>
                <div class="container">
                    <p class="copyright">Tuition Academy© 2018</p>
                </div>
            </footer>
        </div>

        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <?php
            if ($usertype == "administrator")
                echo '<script src="assets/js/administrator.js"></script>';
            else if ($usertype == "manager")
                echo '<script src="assets/js/manager.js"></script>';
            else
                echo '<script src="assets/js/teacher.js"></script>';
        ?>
    </body>
</html>