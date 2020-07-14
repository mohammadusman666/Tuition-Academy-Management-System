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

if(isset($_GET['course_id']) && !empty($_GET['course_id']))
{
    $course_id = $_GET['course_id'];

    // getting info. of a particular course
    $course = DB::query('SELECT course.code, course.title, course.description, course.fee
                            FROM course
                            WHERE course_id=:courseid;',
                            array(':courseid'=>$course_id))[0];
}
else
{
    // getting all courses
    $courses = DB::query('SELECT course.course_id, course.code, course.title
                            FROM course',
                            array());
    
    $Allcourses = '';
    foreach($courses as $course)
    {
        $Allcourses .= '<div class="col-lg-4 col-md-6 col-sm-12">
                            <a class="btn btn-default mybtn" href="course.php?course_id='.$course['course_id'].'">
                                <h3>'.$course['code'].'</h3>
                                <p>'.$course['title'].'</p>
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
        <title>Course - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <link rel="stylesheet" href="assets/css/course.css">
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
                                          <li class="active" role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php">Managers</a></li>
                                          <li role="presentation"><a href="administrator.php?admin_id='.$admin_id.'">Profile</a></li>';
                                else if ($usertype == "manager")
                                    echo '<li role="presentation"><a href="manager.php">Home</a></li>
                                          <li role="presentation"><a href="section.php">Sections</a></li>
                                          <li class="active" role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php?manager_id='.$manager_id.'">Profile</a></li>';
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
                if(isset($_GET['course_id']) && !empty($_GET['course_id']))
                {
                    if ($usertype == "administrator")
                    {
                        echo '<div class="login-clean">
                                <form role="form" method="POST">
                                    <div class="illustration"><i class="icon ion-ios-book-outline"></i></div>
                                    <div class="form-group">
                                        <p><b>Course Code:</b> '.$course['code'].'<p>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="code" placeholder="Course Code (8 chars.)">
                                        </div>
                                        <div id="msg1"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="codeupdate" name="'.$course_id.'">Update</button>

                                        <br>
                                        <p><b>Course Title:</b> '.$course['title'].'<p>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="title" placeholder="Course Title (10 - 50 chars.)">
                                        </div>
                                        <div id="msg2"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="titleupdate" name="'.$course_id.'">Update</button>
                                        
                                        <br>
                                        <p><b>Course Descripton:</b> '.$course['description'].'<p>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="desc" placeholder="Course Desc (100 - 255 chars.)">
                                        </div>
                                        <div id="msg3"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="descupdate" name="'.$course_id.'">Update</button>
                                    </div>
                                </form>
                              </div>';
                    }
                    else
                    {
                        echo '<div class="login-clean">
                                    <form role="form">
                                        <p><b>Course Code:</b> '.$course['code'].'</p>
                                        <p><b>Course Title:</b> '.$course['title'].'</p>
                                        <p><b>Course Description:</b> '.$course['description'].'</p>
                                        <p><b>Course Fee:</b> '.$course['fee'].'</p>
                                    </form>
                              </div>';
                    }
                }
                // displaying all the courses
                else
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
            ?>
        </div>

        <br>

        <!-- Footer -->
        <div class="footer-light navbar-fixed-bottom" style="position: relative">
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
                echo '<script src="assets/js/course.js"></script>';
            }
            else
                echo '<script src="assets/js/manager.js"></script>';
        ?>
    </body>
</html>