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

if(isset($_GET['teacher_id']) && !empty($_GET['teacher_id']))
{
    $teacher_id = $_GET['teacher_id'];

    // getting info. of a particular teacher
    $teacher = DB::query('SELECT teacher.username, teacher.name, teacher.contact, teacher.email
                            FROM teacher
                            WHERE teacher_id=:teacherid;',
                            array(':teacherid'=>$teacher_id))[0];
    
    // if a teacher tries to see info. of other teachers
    if ($usertype == "teacher" && $username != $teacher['username'])
    {
        header('Location: teacher.php');
    }
}
else
{
    if ($usertype == "teacher")
    {
        $sections = DB::query('SELECT section.section_id, course.code, course.title, course.description, section.no
                        FROM section
                        INNER JOIN course
                        ON section.course_id = course.course_id
                            INNER JOIN teacher
                            ON section.teacher_id = teacher.teacher_id
                            WHERE teacher.teacher_id = (SELECT teacher.teacher_id
                                                        FROM teacher
                                                        WHERE username=:username);',
                        array(':username'=>$username));

        $Allsections = '';
        foreach($sections as $section)
        {
            $Allsections .= '<div class="col-lg-4 col-md-6 col-sm-12">
                                <a class="btn btn-default btn-block mybtn" href="section.php?section_id='.$section['section_id'].'">
                                    <h3>'.$section['code'].' ('.$section['no'].')</h3>
                                </a>
                                <p>'.$section['title'].'</p>
                                <p>'.$section['description'].'</p>
                             </div>';
        }
    }
    else if ($usertype == "administrator" || $usertype == "manager")
    {
        // getting all teachers
        $teachers = DB::query('SELECT teacher.teacher_id, teacher.name
                                FROM teacher',
                                array());
        $Allteachers = '';
        foreach($teachers as $teacher)
        {
            $Allteachers .= '<div class="col-lg-4 col-md-6 col-sm-12">
                                <a class="btn btn-default mybtn" href="teacher.php?teacher_id='.$teacher['teacher_id'].'">
                                    <h3>('.$teacher['teacher_id'].') '.$teacher['name'].'</h3>
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
        <title>Teacher - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <?php
            if ($usertype == "administrator" || $usertype == "manager")
                echo '<link rel="stylesheet" href="assets/css/teacherAM.css">';
            else
                echo '<link rel="stylesheet" href="assets/css/teacher.css">';
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
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li class="active" role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li role="presentation"><a href="manager.php">Managers</a></li>
                                          <li role="presentation"><a href="administrator.php?admin_id='.$admin_id.'">Profile</a></li>';
                                else if ($usertype == "manager")
                                    echo '<li role="presentation"><a href="manager.php">Home</a></li>
                                          <li role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
                                          <li role="presentation"><a href="student.php">Students</a></li>
                                          <li class="active" role="presentation"><a href="teacher.php">Teachers</a></li>
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
                // displaying info. about a particular teacher
                if(isset($_GET['teacher_id']) && !empty($_GET['teacher_id']))
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
                                          <p><b>Username:</b> '.$teacher['username'].'</p>
                                          <input class="form-control" type="text" id="username" placeholder="Username (3 - 32 chars.)">
                                      </div>
                                      <div id="msg1"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updateusernameT" name="'.$teacher_id.'">Update</button>
    
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Name:</b> '.$teacher['name'].'</p>
                                          <input class="form-control" type="text" id="name" placeholder="Name (3 - 255 chars.)">
                                      </div>
                                      <div id="msg2"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updatenameT" name="'.$teacher_id.'">Update</button>
                                      
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Contact Number:</b> '.$teacher['contact'].'</p>
                                          <input class="form-control" type="text" id="contact" placeholder="Contact (0321-1234567)">
                                      </div>
                                      <div id="msg3"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updatecontactT" name="'.$teacher_id.'">Update</button>
                                      
                                      <br>
                                      <div class="input-div animated fadeIn">
                                          <p><b>Email:</b> '.$teacher['email'].'</p>
                                          <input class="form-control" type="email" id="email" placeholder="Email (abc@tuitionacademy.com)">
                                      </div>
                                      <div id="msg4"></div>
                                      <button class="btn btn-block animated fadeIn" type="button" id="updateemailT" name="'.$teacher_id.'">Update</button>
                                  </div>
                              </form>
                            </div>';
                    }
                    else
                    {
                        echo '<div class="login-clean">
                                    <form role="form">
                                        <p><b>Username:</b> '.$teacher['username'].'</p>
                                        <p><b>Name:</b> '.$teacher['name'].'</p>
                                        <p><b>Contact Number:</b> '.$teacher['contact'].'</p>
                                        <p><b>Email:</b> '.$teacher['email'].'</p>
                                    </form>
                              </div>';
                    }
                }
                else
                {
                    // displaying all the courses
                    if ($usertype == "teacher")
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
                    // displaying all the teachers
                    else if ($usertype == "administrator" || $usertype == "manager")
                    {
                        echo '<div class="row">
                                    <div class="col-lg-12">
                                        <h1>Teachers</h1>
                                    </div>
                              </div>
                              <br>
                              <div class="row">'
                                    .$Allteachers.
                              '</div>';
                    }
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
                echo '<script src="assets/js/update.js"></script>';
            }
            else if ($usertype == "manager")
                echo '<script src="assets/js/manager.js"></script>';
            else
                echo '<script src="assets/js/teacher.js"></script>';
        ?>
    </body>
</html>