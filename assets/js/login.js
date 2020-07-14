// function to display error message
function displayError(errorMsg)
{
    setTimeout(function() {
        var elem = document.getElementById('error');
        elem.innerHTML = "";
        elem.setAttribute("style", "visibility: hidden;");
    }, 2000);

    var elem = document.getElementById('error');
    elem.innerHTML = errorMsg;
    elem.setAttribute("style", "margin: 10px 0px 0px 0px; padding: 12px; color: #D8000C; background-color: #FFD2D2; text-align: center; visibility: visible;");
}

// function to redirect to the correct page
function redirectPage(usertype)
{
    switch(usertype)
    {
        case "student":
            window.location.replace("student.php");
            break;
        case "teacher":
            window.location.replace("teacher.php");
            break;
        case "manager":
            window.location.replace("manager.php");
            break;
        case "administrator":
            window.location.replace("administrator.php");
            break;
    }
}

$(document).ready(function()
{   
    // checking if session variables are already set which means the user is already logged in
    $.ajax({
        type: "GET",
        url: "api/auth",
        processData: false,
        contentType: "application/json",
        data: '',
        success: function(r)
        {
            console.log(r);
            var res = JSON.parse(r);
            res = res.Usertype;
            redirectPage(res); // redirect to correct page
        },
        error: function(r)
        {
            console.log(r);
        }
    });

    // if the login button is clicked
    $('#login').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/auth",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "'+$('#usertype option:selected').text()+'", "username": "'+ $("#username").val() +'", "password": "'+ $("#password").val() +'" }',
            success: function(r)
            {
                console.log(r);
                var res = JSON.parse(r);
                res = res.Usertype;
                redirectPage(res); // redirect to correct page
            },
            error: function(r)
            {
                r = r.responseText;
                var r = JSON.parse(r);
                var e = r.Error;

                // for invalid username
                if (e == "iu")
                {
                    displayError("Invalid Username!");
                }
                // for invalid password
                else if (e == "ip")
                {
                    displayError("Incorrect Password!");
                }

                console.log(r);
            }
        });
    });
});