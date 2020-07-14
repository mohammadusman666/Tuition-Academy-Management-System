// function to display error message
function displayError(errorMsg)
{
    setTimeout(function() {
        var elem = document.getElementById('msg');
        elem.innerHTML = "";
        elem.setAttribute("style", "visibility: hidden;");
    }, 2000);

    var elem = document.getElementById('msg');
    elem.innerHTML = errorMsg;
    elem.setAttribute("style", "margin: 10px 0px 0px 0px; padding: 12px; color: #D8000C; background-color: #FFD2D2; text-align: center; visibility: visible;");
}
// function to display success message
function displaySuccess(successMsg)
{
    setTimeout(function() {
        var elem = document.getElementById('msg');
        elem.innerHTML = "";
        elem.setAttribute("style", "visibility: hidden;");
    }, 2000);

    var elem = document.getElementById('msg');
    elem.innerHTML = successMsg;
    elem.setAttribute("style", "margin: 10px 0px 0px 0px; padding: 12px; color: green; background-color: #ACFC9C; text-align: center; visibility: visible;");
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
        data: '{ "usertype": "administrator" }',
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

    // if the signup button is clicked
    $('#signup').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/users",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "'+$('#usertype option:selected').text()+'", "name": "'+ $("#name").val() +'", "username": "'+ $("#username").val() +'", "password": "'+ $("#password").val() +'", "email": "'+ $("#email").val() +'", "contact": "'+ $("#contact").val() +'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg", r.Error);

                console.log(r);
            }
        });
    });
});