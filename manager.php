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

if(isset($_GET['manager_id']) && !empty($_GET['manager_id']))
{
    $manager_id = $_GET['manager_id'];

    // getting info. of a particular manager
    $manager = DB::query('SELECT manager.username, manager.name, manager.contact, manager.email
                            FROM manager
                            WHERE manager_id=:managerid;',
                            array(':managerid'=>$manager_id))[0];
    
    // if a manager tries to see info. of other managers
    if ($usertype == "manager" && $username != $manager['username'])
    {
        header('Location: manager.php');
    }
}
else
{
    if ($usertype == "administrator")
    {
        // getting all managers
        $managers = DB::query('SELECT manager.manager_id, manager.name
                                FROM manager',
                                array());
        $Allmanagers = '';
        foreach($managers as $manager)
        {
            $Allmanagers .= '<div class="col-lg-4">
                                <a class="btn btn-default mybtn" href="manager.php?manager_id='.$manager['manager_id'].'">
                                    <h3>('.$manager['manager_id'].') '.$manager['name'].'</h3>
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
        <title>Manager - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <link rel="stylesheet" href="assets/css/manager.css">
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
                                          <li role="presentation"><a href="teacher.php">Teachers</a></li>
                                          <li class="active" role="presentation"><a href="manager.php">Managers</a></li>
                                          <li role="presentation"><a href="administrator.php?admin_id='.$admin_id.'">Profile</a></li>';
                                else if ($usertype == "manager")
                                    echo '<li role="presentation"><a href="manager.php">Home</a></li>
                                          <li role="presentation"><a href="section.php">Sections</a></li>
                                          <li role="presentation"><a href="course.php">Courses</a></li>
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
                // displaying info. about a particular manager
                if(isset($_GET['manager_id']) && !empty($_GET['manager_id']))
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
                                            <p><b>Username:</b> '.$manager['username'].'</p>
                                            <input class="form-control" type="text" id="username" placeholder="Username (3 - 32 chars.)">
                                        </div>
                                        <div id="msg1"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="updateusernameM" name="'.$manager_id.'">Update</button>

                                        <br>
                                        <div class="input-div animated fadeIn">
                                            <p><b>Name:</b> '.$manager['name'].'</p>
                                            <input class="form-control" type="text" id="name" placeholder="Name (3 - 255 chars.)">
                                        </div>
                                        <div id="msg2"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="updatenameM" name="'.$manager_id.'">Update</button>
                                        
                                        <br>
                                        <div class="input-div animated fadeIn">
                                            <p><b>Contact Number:</b> '.$manager['contact'].'</p>
                                            <input class="form-control" type="text" id="contact" placeholder="Contact (0321-1234567)">
                                        </div>
                                        <div id="msg3"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="updatecontactM" name="'.$manager_id.'">Update</button>
                                        
                                        <br>
                                        <div class="input-div animated fadeIn">
                                            <p><b>Email:</b> '.$manager['email'].'</p>
                                            <input class="form-control" type="email" id="email" placeholder="Email (abc@tuitionacademy.com)">
                                        </div>
                                        <div id="msg4"></div>
                                        <button class="btn btn-block animated fadeIn" type="button" id="updateemailM" name="'.$manager_id.'">Update</button>
                                    </div>
                                </form>
                            </div>';
                    }
                    else
                    {
                        echo '<div class="login-clean">
                                    <form role="form">
                                        <p><b>Username:</b> '.$manager['username'].'</p>
                                        <p><b>Name:</b> '.$manager['name'].'</p>
                                        <p><b>Contact Number:</b> '.$manager['contact'].'</p>
                                        <p><b>Email:</b> '.$manager['email'].'</p>
                                    </form>
                              </div>';
                    }
                }
                else
                {
                    // displaying all the managers
                    if ($usertype == "administrator")
                    {
                        echo '<div class="row">
                                    <div class="col-lg-12">
                                        <h1>Managers</h1>
                                    </div>
                              </div>';
                        echo $Allmanagers;
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
            else
                echo '<script src="assets/js/manager.js"></script>';
        ?>
    </body>
</html>