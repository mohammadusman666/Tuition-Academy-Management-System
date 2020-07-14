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

if(isset($_GET['student_id']) && !empty($_GET['student_id']))
{
    $student_id = $_GET['student_id'];

    // getting info. of a particular student
    $student = DB::query('SELECT student.username, student.name, student.contact, student.email
                            FROM student
                            WHERE student_id=:studentid;',
                            array(':studentid'=>$student_id))[0];
    
    // if a student tries to see info. of other students
    if ($usertype == "student" && $username != $student['username'])
    {
        header('Location: student.php');
    }
}
else
{
    if ($usertype == "student")
    {
        $student_id = DB::query('SELECT student.student_id
                                    FROM student
                                    WHERE username=:username;',
                                    array(':username'=>$username))[0]['student_id'];

        $courses = DB::query('SELECT enrollment.enrollment_id, course.code, course.title, course.description, section.no
                                FROM course
                                INNER JOIN section
                                ON course.course_id = section.course_id
                                    INNER JOIN enrollment
                                    ON section.section_id = enrollment.section_id
                                    WHERE enrollment.student_id = (SELECT student.student_id
                                                                    FROM student
                                                                    WHERE username=:username);',
                                array(':username'=>$username));
        $Allcourses = '';
        foreach($courses as $course)
        {
            $Allcourses .= '<div class="col-lg-4 col-md-6 col-sm-12">
                                <a class="btn btn-default btn-block mybtn">
                                    <h3>'.$course['code'].' ('.$course['no'].')</h3>
                                </a>
                                <a class="btn btn-default btn-block mybtn" href="marks.php?enrollment_id='.$course['enrollment_id'].'">Marks</a>
                                <a class="btn btn-default btn-block mybtn" href="fees.php?enrollment_id='.$course['enrollment_id'].'">Fees</a>
                                <p>'.$course['title'].'</p>
                                <p>'.$course['description'].'</p>
                            </div>';
        }
    }
    else if ($usertype == "administrator" || $usertype == "manager")
    {
        // getting all students
        $students = DB::query('SELECT student.student_id, student.name
                                FROM student',
                                array());
        $Allstudents = '';
        foreach($students as $student)
        {
            $Allstudents .= '<div class="col-lg-4">
                                <a class="btn btn-default mybtn" href="student.php?student_id='.$student['student_id'].'">
                                    <h3>('.$student['student_id'].') '.$student['name'].'</h3>
                                </a>
                             </div>';
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <?php
            if ($usertype == "administrator" || $usertype == "manager")
                echo '<link rel="stylesheet" href="assets/css/studentAM.css">';
            else
                echo '<link rel="stylesheet" href="assets/css/student.css">';
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
                                          <li role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li class="active" role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php">Managers</a></li>
                                          <li role="presentation"><a href="administrator.php?admin_id='.$admin_id.'">Profile</a></li>';
                                else if ($usertype == "manager")
                                    echo '<li role="presentation"><a href="manager.php">Home</a></li>
                                          <li role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li class="active" role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php?manager_id='.$manager_id.'">Profile</a></li>';
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
        <div class="container">
            <?php
                // displaying info. about a particular student
                if(isset($_GET['student_id']) && !empty($_GET['student_id']))
                {
                    // if the user is an administrator
                    if ($usertype == "administrator")
                    {
                        // Updation Form
                        echo '<div class="login-clean">
                              <form role="form" method="POST">
                                  <div class="illustration"><i class="icon ion-ios-person-outline"></i></div>
                                  <div class="form-group">
                                      <div class="input-div animated fadeIn">
                                          <p><b>Username:</b> '.$student['username'].'</p>
                                          <input class="form-control" type="text" id="username" placeholder="Username (3 - 32 chars.)">
                                      </div>
                                      <div id="msg1"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updateusernameS" name="'.$student_id.'">Update</button>
    
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Name:</b> '.$student['name'].'</p>
                                          <input class="form-control" type="text" id="name" placeholder="Name (3 - 255 chars.)">
                                      </div>
                                      <div id="msg2"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updatenameS" name="'.$student_id.'">Update</button>
                                      
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Contact Number:</b> '.$student['contact'].'</p>
                                          <input class="form-control" type="text" id="contact" placeholder="Contact (0321-1234567)">
                                      </div>
                                      <div id="msg3"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updatecontactS" name="'.$student_id.'">Update</button>
                                      
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Email:</b> '.$student['email'].'</p>
                                          <input class="form-control" type="email" id="email" placeholder="Email (abc@tuitionacademy.student.com)">
                                      </div>
                                      <div id="msg4"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updateemailS" name="'.$student_id.'">Update</button>
                                  </div>
                              </form>
                            </div>';
                    }
                    else
                    {
                        echo '<div class="login-clean">
                                    <form role="form">
                                        <p><b>Username:</b> '.$student['username'].'</p>
                                        <p><b>Name:</b> '.$student['name'].'</p>
                                        <p><b>Contact Number:</b> '.$student['contact'].'</p>
                                        <p><b>Email:</b> '.$student['email'].'</p>
                                    </form>
                              </div>';
                    }
                }
                else
                {
                    // displaying all the courses
                    if ($usertype == "student")
                    {
                        echo '<div class="row">
                                    <div class="col-lg-12">
                                        <h1>Courses</h1>
                                    </div>
                              </div>
                              <br>
                              <div class="row">'
                                .$Allcourses.
                             '</div>';
                    }
                    // displaying all the students
                    else if ($usertype == "administrator" || $usertype == "manager")
                    {
                        echo '<div class="row">
                                    <div class="col-lg-12">
                                        <h1>Students</h1>
                                    </div>
                              </div>
                              <br>
                              <div class="row">'
                                    .$Allstudents.
                              '</div>';
                    }
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
            {
                echo '<script src="assets/js/administrator.js"></script>';
                echo '<script src="assets/js/update.js"></script>';
            }
            else if ($usertype == "manager")
                echo '<script src="assets/js/manager.js"></script>';
            else
                echo '<script src="assets/js/student.js"></script>';
        ?>
    </body>
</html>