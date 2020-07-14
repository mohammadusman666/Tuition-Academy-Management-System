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
// selecting student id
else
{
    $student_id = DB::query('SELECT student.student_id
                            FROM student
                            WHERE username=:username;',
                            array(':username'=>$username))[0]['student_id'];
}

if(isset($_GET['enrollment_id']) && !empty($_GET['enrollment_id']))
{
    $enrollment_id = $_GET["enrollment_id"];
    $stdUsername = DB::query('SELECT student.username
                                FROM student
                                INNER JOIN enrollment
                                ON enrollment.student_id = student.student_id
                                WHERE enrollment.enrollment_id=:enrollmentid;',
                                array(':enrollmentid'=>$enrollment_id))[0]['username'];

    // if the logged in user is a student
    if ($usertype == "student")
    {
        // if a student tries to see some other student's marks
        if ($username != $stdUsername)
        {
            header('Location: student.php');
        }
    }
    // if the logged in user is a teacher
    else if ($usertype == "teacher")
    {
        $sids = DB::query('SELECT section.section_id
                            FROM section
                            WHERE section.teacher_id = (SELECT teacher.teacher_id
                                                        FROM teacher
                                                        WHERE teacher.username=:username);',
                            array(':username'=>$username));
        $section_id = DB::query('SELECT enrollment.section_id
                                    FROM enrollment
                                    WHERE enrollment.enrollment_id=:enrollmentid;',
                                    array(':enrollmentid'=>$enrollment_id))[0]['section_id'];

        // checking if the enrollment_id is one of the teacher's student
        $found = 0;
        foreach ($sids as $sid)
        {
            if ($sid['section_id'] == $section_id)
            {
                $found = 1;
                break;
            }
        }
        if (!$found)
        {
            header('Location: teacher.php');
        }
    }

    // getting marks related to a particular enrollment
    $course = DB::query('SELECT course.code, course.title, section.no
                            FROM course
                            INNER JOIN section
                            ON course.course_id = section.course_id
                                INNER JOIN enrollment
                                ON section.section_id = enrollment.section_id
                                WHERE enrollment.enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id));

    $quizzes = DB::query('SELECT quiz_id, quiz.no, quiz.marks
                            FROM quiz
                            WHERE quiz.enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id));

    $assignments = DB::query('SELECT assignment_id, assignment.no, assignment.marks
                            FROM assignment
                            WHERE assignment.enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id));

    $marks = DB::query('SELECT enrollment.midterm, enrollment.final, enrollment.grade
                        FROM enrollment
                        WHERE enrollment.enrollment_id=:enrollmentid;',
                        array(':enrollmentid'=>$enrollment_id));


    // if one of the quiz button is pressed
    if (isset($_POST['qb']))
    {
        $quiz_id = key($_POST['qb']);
        if ($_POST['qi'.$quiz_id] == NULL)
            $quiz_marks = NULL;
        else
            $quiz_marks = $_POST['qi'.$quiz_id];
        
        DB::query('UPDATE quiz
                    SET marks=:marks WHERE quiz_id=:quizid;',
                    array(':marks'=>$quiz_marks, ':quizid'=>$quiz_id));
    }

    // if one of the assignment button is pressed
    if (isset($_POST['ab']))
    {
        $assignment_id = key($_POST['ab']);
        if ($_POST['ai'.$assignment_id] == NULL)
            $assignment_marks = NULL;
        else
            $assignment_marks = $_POST['ai'.$assignment_id];

        DB::query('UPDATE assignment
                    SET marks=:marks WHERE assignment_id=:aid;',
                    array(':marks'=>$assignment_marks, ':aid'=>$assignment_id));
    }

    // if the midterm button is pressed
    if (isset($_POST['mb']))
    {
        if ($_POST['mi'] == NULL)
            $midterm_marks = NULL;
        else
            $midterm_marks = $_POST['mi'];

        DB::query('UPDATE enrollment
                    SET midterm=:marks WHERE enrollment_id=:enrollmentid;',
                    array(':marks'=>$midterm_marks, ':enrollmentid'=>$enrollment_id));
    }

    // if the final button is pressed
    if (isset($_POST['fb']))
    {
        if ($_POST['fi'] == NULL)
            $final_marks = NULL;
        else
            $final_marks = $_POST['fi'];

        DB::query('UPDATE enrollment
                    SET final=:marks WHERE enrollment_id=:enrollmentid;',
                    array(':marks'=>$final_marks, ':enrollmentid'=>$enrollment_id));
    }

    // if the grade button is pressed
    if (isset($_POST['gb']))
    {
        if ($_POST['gi'] == NULL)
            $grade = NULL;
        else
            $grade = strtoupper($_POST['gi']);

        DB::query('UPDATE enrollment
                    SET grade=:grade WHERE enrollment_id=:enrollmentid;',
                    array(':grade'=>$grade, ':enrollmentid'=>$enrollment_id));
    }
}
else
{
    if ($usertype == "administrator")
        header('Location: administrator.php');
    else if ($usertype == "manager")
        header('Location: manager.php');
    else if ($usertype == "teacher")
        header('Location: teacher.php');
    else
        header('Location: student.php');
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Marks - <?php echo $stdUsername; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <?php
            if ($usertype == "administrator" || $usertype == "manager")
                echo '<link rel="stylesheet" href="assets/css/marksAM.css">';
            else
                echo '<link rel="stylesheet" href="assets/css/marksTS.css">';
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
                                    echo '<li role="presentation"><a href="administrator.php">Home</a></li>
                                          <li class="active" role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php?manager_id='.$manager_id.'">Profile</a></li>';
                                else if ($usertype == "teacher")
                                    echo '<li role="presentation"><a href="teacher.php">Home</a></li>
                                          <li role="presentation"><a href="teacher.php?teacher_id='.$teacher_id.'">Profile</a></li>';
                                else if ($usertype == "student")
                                    echo '<li role="presentation"><a href="student.php">Home</a></li>
                                          <li role="presentation"><a href="student.php?student_id='.$student_id.'">Profile</a></li>';
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
        <div class="container content">
        <?php
        if(isset($_GET['enrollment_id']) && !empty($_GET['enrollment_id']))
        {
        ?>
            <!-- Displaying Course Info. -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>
                        <?php
                            echo $course[0]['code'].' - '.$course[0]['title'].' ('.$course[0]['no'].')';
                        ?>
                    </h1>
                </div>
            </div>
            <br>

            <!-- Displaying Quiz Marks -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="myh3">Quizzes</h3>
                </div>
            </div>
            <br>

            <div class="row">
            <?php
                if (!empty($quizzes))
                {
                    foreach($quizzes as $quiz)
                    {
                        // formatting marks
                        if ($quiz['marks'] == NULL)
                            $quizMarks = "Not yet graded";
                        else
                            $quizMarks = $quiz['marks'];

                        // preparing forms
                        if ($usertype == "teacher" || $usertype == "administrator")
                            $form = '<div class="login-clean">
                                        <form role="form" method="POST">
                                            <p><b>Quiz No:</b> '.$quiz['no'].'</p>
                                            <p><b>Quiz Marks:</b> '.$quizMarks.'</p>
                                            <input class="form-control" type="number" name="qi'.$quiz['quiz_id'].'" placeholder="(0-20)" min="0" max="20"><br>
                                            <input class="btn btn-block" name="qb['.$quiz['quiz_id'].']" type="submit" value="Add/Update">
                                        </form>
                                    </div>';
                        else
                            $form = '<div class="login-clean">
                                        <form role="form">
                                            <p><b>Quiz No:</b> '.$quiz['no'].'</p>
                                            <p><b>Quiz Marks:</b> '.$quizMarks.'</p>
                                        </form>
                                    </div>';

                        echo '<div class="col-lg-4">
                                '.$form.'
                            </div>';
                    }
                }
                else
                {
                    echo '<div class="col-lg-12">
                                <p class="myh3">No quizzes to show.</p>
                          </div>';
                }
            ?>
            </div>
            <br>

            <!-- Displaying Assignment Marks -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="myh3">Assignments</h3>
                </div>
            </div>
            <br>

            <div class="row">
            <?php
                if (!empty($assignments))
                {
                    foreach($assignments as $assignment)
                    {
                        // formatting marks
                        if ($assignment['marks'] == NULL)
                            $assignmentMarks = "Not yet graded";
                        else
                            $assignmentMarks = $assignment['marks'];

                        // preparing forms
                        if ($usertype == "teacher" || $usertype == "administrator")
                            $form = '<div class="login-clean">
                                        <form role="form" method="POST">
                                            <p><b>Assignment No:</b> '.$assignment['no'].'</p>
                                            <p><b>Assignment Marks:</b> '.$assignmentMarks.'</p>
                                            <input class="form-control" type="number" name="ai'.$assignment['assignment_id'].'" placeholder="(0-20)" min="0" max="20"><br>
                                            <input class="btn btn-block" name="ab['.$assignment['assignment_id'].']" type="submit" value="Add/Update">
                                        </form>
                                    </div>';
                        else
                            $form = '<div class="login-clean">
                                        <form role="form">
                                            <p><b>Assignment No:</b> '.$assignment['no'].'</p>
                                            <p><b>Assignment Marks:</b> '.$assignmentMarks.'</p>
                                        </form>
                                    </div>';
                        
                        echo '<div class="col-lg-4">
                                '.$form.'
                            </div>';
                    }
                }
                else
                {
                    echo '<div class="col-lg-12">
                                <p class="myh3">No assignments to show.</p>
                          </div>';
                }
            ?>
            </div>

            <!-- Displaying Midterm, Final Marks & Grade -->
            <?php
                // formatting marks
                if ($marks[0]['midterm'] == NULL)
                    $midtermMarks = "Not yet graded";
                else
                    $midtermMarks = $marks[0]['midterm'];

                if ($marks[0]['final'] == NULL)
                    $finalMarks = "Not yet graded";
                else
                    $finalMarks = $marks[0]['final'];

                if ($marks[0]['grade'] == NULL)
                    $grade = "Not yet uploaded";
                else
                    $grade = $marks[0]['grade'];

                // preparing forms
                if ($usertype == "teacher" || $usertype == "administrator")
                {
                    $midtermForm = '<div class="login-clean">
                                        <form role="form" method="POST">
                                            <h3>Midterm</h3>
                                            <p><b>Midterm Marks:</b> '.$midtermMarks.'</p>
                                            <input class="form-control" type="number" name="mi" placeholder="(0-50)" min="0" max="50">
                                            <input class="btn btn-block" name="mb" type="submit" value="Add/Update">
                                        </form>
                                    </div>';
                    $finalForm = '<div class="login-clean">
                                        <form role="form" method="POST">
                                            <h3>Final</h3>
                                            <p><b>Final Marks:</b> '.$finalMarks.'</p>
                                            <input class="form-control" type="number" name="fi" placeholder="(0-50)" min="0" max="50">
                                            <input class="btn btn-block" name="fb" type="submit" value="Add/Update">
                                        </form>
                                    </div>';
                    $gradeForm = '<div class="login-clean">
                                        <form role="form" method="POST">
                                            <h3>Grade</h3>
                                            <p><b>Course Grade:</b> '.$grade.'</p>
                                            <input class="form-control" type="text" name="gi" pattern="[a-fA-F]{1}" placeholder="(A-F)">
                                            <input class="btn btn-block" name="gb" type="submit" value="Add/Update">
                                        </form>
                                    </div>';
                }
                else
                {
                    $midtermForm = '<div class="login-clean">
                                        <form role="form">
                                            <h3>Midterm</h3>
                                            <p><b>Midterm Marks:</b> '.$midtermMarks.'</p>
                                        </form>
                                    </div>';
                    $finalForm = '<div class="login-clean">
                                        <form role="form">
                                            <h3>Final</h3>
                                            <p><b>Final Marks:</b> '.$finalMarks.'</p>
                                        </form>
                                  </div>';
                    $gradeForm = '<div class="login-clean">
                                        <form role="form">
                                            <h3>Grade</h3>
                                            <p><b>Course Grade:</b> '.$grade.'</p>
                                        </form>
                                  </div>';
                }

                echo '<div class="row">
                            <div class="col-lg-4">
                                '.$midtermForm.'
                            </div>
                            <div class="col-lg-4">
                                '.$finalForm.'
                            </div>
                            <div class="col-lg-4">
                                '.$gradeForm.'
                            </div>
                      </div>';
            ?>
        <?php
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
            else if ($usertype == "teacher")
                echo '<script src="assets/js/teacher.js"></script>';
            else
                echo '<script src="assets/js/student.js"></script>';
        ?>
    </body>
</html>