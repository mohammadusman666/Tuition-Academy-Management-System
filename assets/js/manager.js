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
        },
        error: function(r)
        {
            window.location.replace("login.html");
            console.log(r);
        }
    });

    // checking if usertype is correct
    $.ajax({
        type: "POST",
        url: "api/check",
        processData: false,
        contentType: "application/json",
        data: '{ "usertype": "manager" }',
        success: function(r)
        {
            console.log(r);
        },
        error: function(r)
        {
            console.log(r);
            r = r.responseText;
            r = JSON.parse(r);
            var res = r.Usertype;
            redirectPage(res); // redirect to correct page
        }
    });

    // if the logout button is clicked
    $('#logout').click(function()
    {
        $.ajax({
            type: "DELETE",
            url: "api/auth",
            processData: false,
            contentType: "application/json",
            data: '',
            success: function(r)
            {
                window.location.replace("login.html");
                console.log(r);
            },
            error: function(r)
            {
                console.log(r);
            }
        });
    });
});