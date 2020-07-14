<?php

require_once("database.php");

$db = new DB("127.0.0.1", "TuitionAcademy", "root", "");

// for the GET request
if ($_SERVER['REQUEST_METHOD'] == "GET")
{
    // checking for the session
    if ($_GET['url'] == "auth")
    {
        // Start the session
        session_start();

        if (isset($_SESSION['usertype']) && isset($_SESSION['username']))
        {
            echo '{ "Success": "Session exist!", "Usertype": "'. $_SESSION['usertype'] .'" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Session does not exist!" }';
            http_response_code(401);
        }
    }
}
// for the POST request
else if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    // checking for the usertype
    if ($_GET['url'] == "check")
    {
        // Start the session
        session_start();

        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $usertype = $postBody->usertype; // getting the usertype

        // if the usertype designated for the page matches the usertype of the logged in user
        if ($_SESSION['usertype'] == $usertype)
        {
            echo '{ "Success": "Correct User!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Wrong User", "Usertype": "'. $_SESSION['usertype'] .'" }';
            http_response_code(401);
        }
    }
    // for the login
    else if ($_GET['url'] == "auth")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $usertype = $postBody->usertype;
        $username = $postBody->username;
        $password = $postBody->password;

        $username = test_input($username);
        $password = test_input($password);

        switch ($usertype)
        {
            case "Student":
                login("student", $username, $password);
                break;
            case "Teacher":
                login("teacher", $username, $password);
                break;
            case "Manager":
                login("manager", $username, $password);
                break;
            case "Administrator":
                login("administrator", $username, $password);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }
    // for the registration
    else if ($_GET['url'] == "users")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $usertype = $postBody->usertype;
        $name = $postBody->name;
        $username = $postBody->username;
        $email = $postBody->email;
        $password = $postBody->password;
        $contact = $postBody->contact;

        $name = test_input($name);
        $username = test_input($username);
        $email = test_input($email);
        $password = test_input($password);
        $contact = test_input($contact);

        switch ($usertype)
        {
            case "Student":
                register("student", $name, $username, $email, $password, $contact);
                break;
            case "Teacher":
                register("teacher", $name, $username, $email, $password, $contact);
                break;
            case "Manager":
                register("manager", $name, $username, $email, $password, $contact);
                break;
            case "Administrator":
                register("administrator", $name, $username, $email, $password, $contact);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }

    ///////////////////
    // User Updation //
    ///////////////////
    // for updating username
    else if ($_GET['url'] == "updateusername")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $usertype = $postBody->usertype;
        $user_id = $postBody->id;
        $username = $postBody->username;

        $username = test_input($username);

        switch ($usertype)
        {
            case "Student":
                updateUsername("student", "student_id",  $user_id, $username);
                break;
            case "Teacher":
                updateUsername("teacher", "teacher_id",  $user_id, $username);
                break;
            case "Manager":
                updateUsername("manager", "manager_id",  $user_id, $username);
                break;
            case "Administrator":
                updateUsername("administrator", "admin_id", $user_id, $username);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }
    // for updating name
    else if ($_GET['url'] == "updatename")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $usertype = $postBody->usertype;
        $user_id = $postBody->id;
        $name = $postBody->name;

        $name = test_input($name);

        switch ($usertype)
        {
            case "Student":
                updateName("student", "student_id",  $user_id, $name);
                break;
            case "Teacher":
                updateName("teacher", "teacher_id",  $user_id, $name);
                break;
            case "Manager":
                updateName("manager", "manager_id",  $user_id, $name);
                break;
            case "Administrator":
                updateName("administrator", "admin_id", $user_id, $name);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }
    // for updating contact
    else if ($_GET['url'] == "updatecontact")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $usertype = $postBody->usertype;
        $user_id = $postBody->id;
        $contact = $postBody->contact;

        $contact = test_input($contact);

        switch ($usertype)
        {
            case "Student":
                updateContact("student", "student_id",  $user_id, $contact);
                break;
            case "Teacher":
                updateContact("teacher", "teacher_id",  $user_id, $contact);
                break;
            case "Manager":
                updateContact("manager", "manager_id",  $user_id, $contact);
                break;
            case "Administrator":
                updateContact("administrator", "admin_id", $user_id, $contact);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }
    // for updating email
    else if ($_GET['url'] == "updateemail")
    {
        $postBody = file_get_contents("php://input");
        $postBody = json_decode($postBody);

        $usertype = $postBody->usertype;
        $user_id = $postBody->id;
        $email = $postBody->email;

        $email = test_input($email);

        switch ($usertype)
        {
            case "Student":
                updateEmail("student", "student_id",  $user_id, $email);
                break;
            case "Teacher":
                updateEmail("teacher", "teacher_id",  $user_id, $email);
                break;
            case "Manager":
                updateEmail("manager", "manager_id",  $user_id, $email);
                break;
            case "Administrator":
                updateEmail("administrator", "admin_id", $user_id, $email);
                break;
            default:
                echo '{ "Error": "iut" }';
                http_response_code(401);
        }
    }

    /////////////////////
    // Course Updation //
    /////////////////////
    // for updating course code
    else if ($_GET['url'] == "coursecodeupdate")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $course_id = $postBody->id;
        $code = $postBody->code;

        $code = test_input($code);
        
        updateCode($course_id, $code); // update code
    }
    // for updating course title
    else if ($_GET['url'] == "coursetitleupdate")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $course_id = $postBody->id;
        $title = $postBody->title;

        $title = test_input($title);
        
        updateTitle($course_id, $title); // update title
    }
    // for updating course description
    else if ($_GET['url'] == "coursedescupdate")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $course_id = $postBody->id;
        $desc = $postBody->desc;

        $desc = test_input($desc);
        
        updateDesc($course_id, $desc); // update description
    }

    /////////
    // Fee //
    /////////
    // for inserting fee record
    else if ($_GET['url'] == "addfee")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $enrollment_id = $postBody->id;
        $fee = $postBody->fee;

        $fee = test_input($fee);
        
        addFee($enrollment_id, $fee); // add fee
    }
    // for deleting fee record
    else if ($_GET['url'] == "deletefee")
    {
        $postBody = file_get_contents("php://input"); // Get JSON as a string
        $postBody = json_decode($postBody); // Get as an object

        $fee_id = $postBody->id;
        
        deleteFee($fee_id); // delete fee
    }
}
// for the DELETE request
else if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
    // for the logout
    if ($_GET['url'] == "auth")
    {
        // Start the session
        session_start();

        // Destroy the session
        session_destroy();

        echo '{ "Success": "Logout Successful!" }';
        http_response_code(200);
    }
}
else
{
    http_response_code(405);
}

///////////////////////////////
// helper function for login //
///////////////////////////////
function login($usertype, $username, $password)
{
    global $db;
    
    $sql = "SELECT username FROM $usertype WHERE BINARY username=:username";
    if ($db->query($sql, array(':username'=>$username)))
    {
        $sql = "SELECT password FROM $usertype WHERE username=:username";
        if (password_verify($password, $db->query($sql, array(':username'=>$username))[0]['password']))
        {
            // Start the session
            session_start();

            // Set session variables
            $_SESSION["usertype"] = $usertype;
            $_SESSION["username"] = $username;

            echo '{ "Success": "Login Successful!", "Usertype": "'. $usertype .'" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "ip" }';
            http_response_code(401);
        }
    }
    else
    {
        echo '{ "Error": "iu" }';
        http_response_code(401);
    }
}

//////////////////////////////////////
// helper function for registration //
//////////////////////////////////////
function register($usertype, $name, $username, $email, $password, $contact)
{
    global $db;
    
    if (strlen($name) >= 3 && strlen($name) <= 255)
    {
        if (preg_match('/^[a-zA-Z ]*$/', $name))
        {
            $sql = "SELECT username FROM $usertype WHERE BINARY username=:username";
            if (!$db->query($sql, array(':username'=>$username)))
            {
                if (strlen($username) >= 3 && strlen($username) <= 32)
                {
                    if (preg_match('/^[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)?$/', $username))
                    {
                        if (filter_var($email, FILTER_VALIDATE_EMAIL))
                        {
                            $sql = "SELECT email FROM $usertype WHERE BINARY email=:email";
                            if (!$db->query($sql, array(':email'=>$email)))
                            {
                                if (strlen($password) >= 6 && strlen($password) <= 60)
                                {
                                    if (strlen($contact) == 12)
                                    {
                                        if(preg_match('/^[0-9]{4}-[0-9]{7}$/', $contact))
                                        {
                                            $sql = "SELECT contact FROM $usertype WHERE BINARY contact=:contact";
                                            if (!$db->query($sql, array(':contact'=>$contact)))
                                            {
                                                $sql = "INSERT INTO $usertype VALUES ('', :username, :password, :name, :contact, :email)";
                                                $db->query($sql, array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':name'=>$name, ':contact'=>$contact, ':email'=>$email));
                                                
                                                if ($usertype == "student")
                                                {
                                                    $sql = "SELECT student_id FROM student WHERE BINARY username=:username";
                                                    $student_id = $db->query($sql, array(':username'=>$username))[0]['student_id'];

                                                    $sql = "INSERT INTO admission VALUES ('', :studentid, :date, :fees)";
                                                    $db->query($sql, array(':studentid'=>$student_id, ':date'=>date("Y-m-d"), ':fees'=>'10000'));
                                                }
                                                
                                                echo '{ "Success": "Registration Successful!" }';
                                                http_response_code(200);
                                            }
                                            else
                                            {
                                                echo '{ "Error": "Contact Number is taken!" }'; // contact taken
                                                http_response_code(409);
                                            }
                                        }
                                        else
                                        {
                                            echo '{ "Error": "Invalid Contact Number" }'; // invalid contact
                                            http_response_code(409);
                                        }
                                    }
                                    else
                                    {
                                        echo '{ "Error": "Contact Number should be 12 characters long!" }'; // contact length
                                        http_response_code(409);
                                    }
                                }
                                else
                                {
                                    echo '{ "Error": "Password should be between 6 and 60 characters!" }'; // password length
                                    http_response_code(409);
                                }
                            }
                            else
                            {
                                echo '{ "Error": "Email is taken!" }'; // email taken
                                http_response_code(409);
                            }
                        }
                        else
                        {
                            echo '{ "Error": "Invalid Email!" }'; // invalid email
                            http_response_code(409);
                        }
                    }
                    else
                    {
                        echo '{ "Error": "Username should only contain letters, numbers or underscores!" }'; // invalid username
                        http_response_code(409);
                    }
                }
                else
                {
                    echo '{ "Error": "Username should be between 3 and 32 characters!" }'; // username length
                    http_response_code(409);
                }
            }
            else
            {
                echo '{ "Error": "Username is taken!" }'; // username taken
                http_response_code(409);
            }
        }
        else
        {
            echo '{ "Error": "Name should only contain letters and spaces!" }'; // invalid name
            http_response_code(409);
        }
    }
    else
    {
        echo '{ "Error": "Name should be between 3 and 255 characters!" }'; // name length
        http_response_code(409);
    }
}

////////////////////////////////////////
// helper functions for user updation //
////////////////////////////////////////
// helper function to update username
function updateUsername($usertype, $colname, $user_id, $username)
{
    global $db;

    $sql = "SELECT username FROM $usertype WHERE BINARY username=:username";
    if (!$db->query($sql, array(':username'=>$username)))
    {
        if (strlen($username) >= 3 && strlen($username) <= 32)
        {
            if (preg_match('/^[a-zA-Z0-9]+(?:_[a-zA-Z0-9]+)?$/', $username))
            {
                // update username
                $sql = "UPDATE $usertype SET username=:username WHERE $colname=:userid";
                $db->query($sql, array(':username'=>$username, ':userid'=>$user_id));
                echo '{ "Success": "Username Updated Successfully!" }';
                http_response_code(200);
            }
            else
            {
                echo '{ "Error": "Username should only contain letters, numbers or underscores!" }'; // invalid username
                http_response_code(409);
            }
        }
        else
        {
            echo '{ "Error": "Username should be between 3 and 32 characters!" }'; // username length
            http_response_code(409);
        }
    }
    else
    {
        echo '{ "Error": "Username is taken!" }'; // username taken
        http_response_code(409);
    }
}
// helper function to update name
function updateName($usertype, $colname, $user_id, $name)
{
    global $db;

    if (strlen($name) >= 3 && strlen($name) <= 255)
    {
        if (preg_match('/^[a-zA-Z ]*$/', $name))
        {
            // update name
            $sql = "UPDATE $usertype SET name=:name WHERE $colname=:userid";
            $db->query($sql, array(':name'=>$name, ':userid'=>$user_id));
            echo '{ "Success": "Name Updated Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Name should only contain letters and spaces!" }'; // invalid name
            http_response_code(409);
        }
    }
    else
    {
        echo '{ "Error": "Name should be between 3 and 255 characters!" }'; // name length
        http_response_code(409);
    }
}
// helper function to update contact
function updateContact($usertype, $colname, $user_id, $contact)
{
    global $db;

    if (strlen($contact) == 12)
    {
        if(preg_match('/^[0-9]{4}-[0-9]{7}$/', $contact))
        {
            $sql = "SELECT contact FROM $usertype WHERE BINARY contact=:contact";
            if (!$db->query($sql, array(':contact'=>$contact)))
            {
                // update contact
                $sql = "UPDATE $usertype SET contact=:contact WHERE $colname=:userid";
                $db->query($sql, array(':contact'=>$contact, ':userid'=>$user_id));
                echo '{ "Success": "Contact Number Updated Successfully!" }';
                http_response_code(200);
            }
            else
            {
                echo '{ "Error": "Contact Number is taken!" }'; // contact taken
                http_response_code(409);
            }
        }
        else
        {
            echo '{ "Error": "Invalid Contact Number" }'; // invalid contact
            http_response_code(409);
        }
    }
    else
    {
        echo '{ "Error": "Contact Number should be 12 characters long!" }'; // contact length
        http_response_code(409);
    }
}
// helper function to update email
function updateEmail($usertype, $colname, $user_id, $email)
{
    global $db;

    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $sql = "SELECT email FROM $usertype WHERE BINARY email=:email";
        if (!$db->query($sql, array(':email'=>$email)))
        {
            // update email
            $sql = "UPDATE $usertype SET email=:email WHERE $colname=:userid";
            $db->query($sql, array(':email'=>$email, ':userid'=>$user_id));
            echo '{ "Success": "Email Updated Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Email is taken!" }'; // email taken
            http_response_code(409);
        }
    }
    else
    {
        echo '{ "Error": "Invalid Email!" }'; // invalid email
        http_response_code(409);
    }
}

/////////////////////
// Course Updation //
/////////////////////
// helper function to update course code
function updateCode($course_id, $code)
{
    global $db;

    if (strlen($code) == 8)
    {
        if (preg_match('/^[a-zA-z]{4}[ ][0-9]{3}$/', $code))
        {
            // update course code
            $db->query("UPDATE course SET code=:code WHERE course_id=:courseid", array(':code'=>strtoupper($code), ':courseid'=>$course_id));
            echo '{ "Success": "Course Code Updated Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Invalid Course Code!" }'; // invalid code
            http_response_code(401);
        }
    }
    else
    {
        echo '{ "Error": "Course Code should be 8 characters long!" }'; // code length
        http_response_code(401);
    }
}
// helper function to update course title
function updateTitle($course_id, $title)
{
    global $db;

    if (strlen($title) >= 10 && strlen($title) <= 50)
    {
        if (preg_match('/^[a-zA-Z ]*$/', $title))
        {
            // update course title
            $db->query("UPDATE course SET title=:title WHERE course_id=:courseid", array(':title'=>$title, ':courseid'=>$course_id));
            echo '{ "Success": "Course Title Updated Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Course Title should only contain letters and spaces!" }'; // invalid title
            http_response_code(401);
        }
    }
    else
    {
        echo '{ "Error": "Course Title should be between 10 and 50 characters!" }'; // title length
        http_response_code(401);
    }
}
// helper function to update course description
function updateDesc($course_id, $desc)
{
    global $db;

    if (strlen($desc) >= 100 && strlen($desc) <= 255)
    {
        if (preg_match('/^[a-zA-Z ]*$/', $desc))
        {
            // update course title
            $db->query("UPDATE course SET description=:desc WHERE course_id=:courseid", array(':desc'=>$desc, ':courseid'=>$course_id));
            echo '{ "Success": "Desc. Updated Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Course Description should only contain letters and spaces!" }'; // invalid description
            http_response_code(401);
        }
    }
    else
    {
        echo '{ "Error": "Course Description should be between 100 and 255 characters!" }'; // description length
        http_response_code(401);
    }
}

////////////////
// Fee Record //
////////////////
// helper function to insert fee record
function addFee($enrollment_id, $fee)
{
    global $db;

    if (preg_match('/^[1-9][0-9]*$/', $fee))
    {
        $sql = "SELECT due_fee FROM enrollment WHERE enrollment_id=:enrollmentid";
        $due_fee = $db->query($sql, array(':enrollmentid'=>$enrollment_id))[0]['due_fee'];

        if ($fee <= $due_fee)
        {
            // insert fee record
            $sql = "INSERT INTO fee VALUES ('', :enrollmentid, :amount, :date)";
            $db->query($sql, array(':enrollmentid'=>$enrollment_id, ':amount'=>$fee, ':date'=>date("Y-m-d")));

            // updating due fee
            $due_fee = $due_fee - $fee;
            $sql = "UPDATE enrollment SET due_fee=:duefee WHERE enrollment_id=:enrollmentid";
            $db->query($sql, array('duefee'=>$due_fee, ':enrollmentid'=>$enrollment_id));

            echo '{ "Success": "Fee Record Inserted Successfully!" }';
            http_response_code(200);
        }
        else
        {
            echo '{ "Error": "Fee Amount should be less or equal to '.$due_fee.'!" }'; // invalid description
            http_response_code(401);
        }
    }
    else
    {
        echo '{ "Error": "Fee Amount should be an integer and greater than 0!" }'; // fee integer
        http_response_code(401);
    }
}

// function to remove spaces, backward slashes & special characters from the input
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>