<?php
include('./classes/database.php');

session_start();

$usertype = $_SESSION["usertype"];
$username = $_SESSION["username"];

$admin_id = DB::query('SELECT administrator.admin_id
                        FROM administrator
                        WHERE username=:username;',
                        array(':username'=>$username))[0]['admin_id'];

if(isset($_GET['admin_id']) && !empty($_GET['admin_id']))
{
    $a_id = $_GET['admin_id'];

    // getting info. of a particular administrator
    $admin = DB::query('SELECT administrator.username, administrator.name, administrator.contact, administrator.email
                            FROM administrator
                            WHERE admin_id=:aid;',
                            array(':aid'=>$a_id))[0];
    
    // if a administrator tries to see info. of other administrators
    if ($usertype == "administrator" && $username != $admin['username'])
    {
        header('Location: administrator.php');
    }
}

?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adminstrator - <?php echo $username; ?></title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap3.3.7.min.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/footer.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="assets/css/animate.css">
        <link rel="stylesheet" href="assets/css/login.css">
        <link rel="stylesheet" href="assets/css/administrator.css">
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
                            <li role="presentation"><a href="administrator.php">Home</a></li>
                            <li role="presentation"><a href="section.php">Sections</a></li>
                            <li role="presentation"><a href="course.php">Courses</a></li>
                            <li role="presentation"><a href="student.php">Students</a></li>
                            <li role="presentation"><a href="teacher.php">Teachers</a></li>
                            <li role="presentation"><a href="manager.php">Managers</a></li>
                            <li role="presentation"><a href="administrator.php?admin_id=<?php echo $admin_id; ?>">Profile</a></li>
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
                if(isset($_GET['admin_id']) && !empty($_GET['admin_id']))
                {
                    // Updation Form
                    echo '<div class="login-clean">
                          <form role="form" method="POST">
                              <div class="illustration"><i class="icon ion-ios-person-outline"></i></div>
                              <div class="form-group">
                                  <div class="input-div animated fadeIn">
                                      <p><b>Username:</b> '.$admin['username'].'</p>
                                      <input class="form-control" type="text" id="username" placeholder="Username (3 - 32 chars.)">
                                  </div>
                                  <div id="msg1"></div>
                                  <button class="btn btn-block animated fadeIn" type="button" id="updateusernameA" name="'.$admin_id.'">Update</button>

                                  <br>
                                  <div class="input-div animated fadeIn">
                                      <p><b>Name:</b> '.$admin['name'].'</p>
                                      <input class="form-control" type="text" id="name" placeholder="Name (3 - 255 chars.)">
                                  </div>
                                  <div id="msg2"></div>
                                  <button class="btn btn-block animated fadeIn" type="button" id="updatenameA" name="'.$admin_id.'">Update</button>
                                  
                                  <br>
                                  <div class="input-div animated fadeIn">
                                      <p><b>Contact Number:</b> '.$admin['contact'].'</p>
                                      <input class="form-control" type="text" id="contact" placeholder="Contact (0321-1234567)">
                                  </div>
                                  <div id="msg3"></div>
                                  <button class="btn btn-block animated fadeIn" type="button" id="updatecontactA" name="'.$admin_id.'">Update</button>
                                  
                                  <br>
                                  <div class="input-div animated fadeIn">
                                      <p><b>Email:</b> '.$admin['email'].'</p>
                                      <input class="form-control" type="email" id="email" placeholder="Email (abc@tuitionacademy.com)">
                                  </div>
                                  <div id="msg4"></div>
                                  <button class="btn btn-block animated fadeIn" type="button" id="updateemailA" name="'.$admin_id.'">Update</button>
                              </div>
                          </form>
                        </div>';
                }
                else
                {
                    // Registration Form
                    echo '<div class="login-clean">
                                <form role="form" method="POST">
                                    <div class="illustration"><i class="icon ion-ios-person-outline"></i></div>
                                    <div class="form-group">
                                        <div class="input-div animated fadeIn">
                                            <select class="form-control" id="usertype">
                                                <option val="S">Student</option>
                                                <option val="T">Teacher</option>
                                                <option val="M">Manager</option>
                                                <option val="A">Administrator</option>
                                            </select>
                                        </div>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="name" name="name" placeholder="Name (3 - 255 chars.)">
                                        </div>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="username" name="username" placeholder="Username (3 - 32 chars.)">
                                        </div>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="email" id="email" name="email" placeholder="Email (abc@tuitionacademy.com)">
                                        </div>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="password" id="password" name="password" placeholder="Password (6 - 60 chars.)">
                                        </div>
                                        <div class="input-div animated fadeIn">
                                            <input class="form-control" type="text" id="contact" name="contact" placeholder="Contact (0321-1234567)">
                                        </div>

                                        <div id="msg"></div>

                                        <div class="animated fadeIn">
                                            <button class="btn btn-block animated fadeIn" type="button" id="signup" name="signup">Register</button>
                                        </div>
                                    </div>
                                </form>
                          </div>';
                }
            ?>
        </div>

        <!-- Footer -->
        <div class="footer-light navbar-fixed-bottom" style="position: relative">
            <footer>
                <div class="container">
                    <p class="copyright" style="color: #333;">Tuition Academy© 2018</p>
                </div>
            </footer>
        </div>

        <script src="assets/js/jquery-3.3.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/administrator.js"></script>
        <script src="assets/js/update.js"></script>
    </body>
</html>