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

    // if a student tries to see other student's info
    if ($usertype == "student")
    {
        if ($username != $stdUsername)
        {
            header('Location: student.php');
        }
    }

    // getting the due fee
    $due_fee = DB::query('SELECT due_fee
                            FROM enrollment
                            WHERE enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id))[0]['due_fee'];

    // getting course info. related to a particular enrollment
    $course = DB::query('SELECT course.code, course.title, course.fee, section.no
                            FROM course
                            INNER JOIN section
                            ON course.course_id = section.course_id
                                INNER JOIN enrollment
                                ON section.section_id = enrollment.section_id
                                WHERE enrollment.enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id))[0];

    // getting fees info. related to a particular enrollment
    $fees = DB::query('SELECT fee_id, amount, date
                            FROM fee
                            WHERE enrollment_id=:enrollmentid;',
                            array(':enrollmentid'=>$enrollment_id));

    // if one of fee delete button is pressed
    if (isset($_POST['fdb']))
    {
        $fee_id = key($_POST['fdb']);

        // getting current fee amount
        $fee_amount = DB::query('SELECT amount
                                        FROM fee
                                        WHERE fee_id=:feeid;',
                                        array(':feeid'=>$fee_id))[0]['amount'];
        
        DB::query('DELETE FROM fee
                    WHERE fee_id=:feeid;',
                    array(':feeid'=>$fee_id));

        // updating due fee
        $due_fee = $due_fee + $fee_amount;
        DB::query('UPDATE enrollment
                        SET due_fee=:duefee
                        WHERE enrollment_id=:enrollmentid;',
                        array('duefee'=>$due_fee, ':enrollmentid'=>$enrollment_id));
    }
}
else
{
    if ($usertype == "administrator")
        header('Location: administrator.php');
    else if ($usertype == "manager")
        header('Location: manager.php');
    else
        header('Location: student.php');
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fees - <?php echo $stdUsername; ?></title>
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
        if(isset($_GET['enrollment_id']) && !empty($_GET['enrollment_id']))
        {
        ?>
            <!-- Displaying Course Info. -->
            <div class="row">
                <div class="col-lg-12">
                    <h1>
                        <?php
                            echo $course['code'].' - '.$course['title'].' ('.$course['no'].')';
                        ?>
                    </h1>
                </div>
            </div>
            <br>
            <!-- Displaying Fees -->
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="myh3">Fees</h3>
                </div>
            </div>
            <br>
            <!-- Displaying Due Fee -->
            <div class="row">
                <div class="col-lg-12">
                    <p class="myh3"><b>Amount Due: </b><?php echo $due_fee; ?></p>
                </div>
            </div>
            <br>

            <!-- Insert Fee Form -->
            <?php
                // if the user is an administrator
                if ($usertype == "administrator")
                {
                    if ($due_fee > 0)
                    {
                        // fee add form
                        echo '<div class="row">
                                <div class="col-lg-12">
                                    <div class="login-clean">
                                        <form role="form" method="POST">
                                            <div class="form-group">
                                                <p><b>Fee Amount</b></p>
                                                <div class="input-div animated fadeIn">
                                                    <input class="form-control" type="number" id="fee" placeholder="Amount (1-'.$due_fee.')" min="1" max="'.$due_fee.'">
                                                </div>
                                                <div id="msg"></div>
                                                <button class="btn btn-block animated fadeIn" type="button" id="addfee" name="'.$enrollment_id.'">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                              </div>';
                    }
                }
            ?>

            <!-- Displaying Fee Records -->
            <div class="row">
            <?php
                if (!empty($fees))
                {
                    foreach($fees as $fee)
                    {
                        // if the user is an administrator
                        if ($usertype == "administrator")
                        {
                            // fee record deletion form
                            echo '<div class="col-lg-4">
                                        <div class="login-clean">
                                            <form role="form" method="POST">
                                                <p><b>Date:</b> '.$fee['date'].'</p>
                                                <p><b>Fee Amount:</b> '.$fee['amount'].'</p>
                                                <input class="btn btn-block" name="fdb['.$fee['fee_id'].']" type="submit" value="Delete">
                                            </form>
                                        </div>
                                  </div>';
                        }
                        else
                        {
                            // display fee records
                            echo '<div class="col-lg-4">
                                        <div class="login-clean">
                                            <form role="form">
                                                <p><b>Date:</b> '.$fee['date'].'</p>
                                                <p><b>Amount Paid:</b> '.$fee['amount'].'</p>
                                            </form>
                                        </div>
                                  </div>';
                        }
                    }
                }
                else
                {
                    echo '<div class="col-lg-12">
                                <p class="myh3">No fee records to show.</p>
                          </div>';
                }
            ?>
            </div>
        <?php
        }
        ?>
        </div>

        <br>
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
                echo '<script src="assets/js/student.js"></script>';
        ?>
        <script src="assets/js/fees.js"></script>
    </body>
</html>