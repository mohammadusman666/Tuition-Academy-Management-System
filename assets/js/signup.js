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
                console.log(r);
                window.location.replace("login.html"); // redirect to login page
            },
            error: function(r)
            {
                r = r.responseText;
                var r = JSON.parse(r);
                var e = r.Error;

                // for name length
                if(e == "nl")
                {
                    displayError("Name should be between 3 and 255 characters!");
                }
                // for invalid name
                else if(e == "in")
                {
                    displayError("Name should only contain letters and spaces!");
                }
                // for username taken
                else if(e == "ut")
                {
                    displayError("Username is taken!");
                }
                // for username length
                else if(e == "ul")
                {
                    displayError("Username should be between 3 and 32 characters!");
                }
                // for invalid username
                else if(e == "iu")
                {
                    displayError("Username should only contain letters, numbers or underscores!");
                }
                // for invalid email
                else if(e == "ie")
                {
                    displayError("Invalid Email!");
                }
                // for password length
                else if(e == "et")
                {
                    displayError("Email is taken!");
                }
                // for password length
                else if(e == "pl")
                {
                    displayError("Password should be between 6 and 60 characters!");
                }
                // for contact length
                else if(e == "cl")
                {
                    displayError("Contact should be 12 characters!");
                }
                // for invalid contact
                else if(e == "ic")
                {
                    displayError("Invalid Contact");
                }
                // for contact taken
                else if(e == "ct")
                {
                    displayError("Contact is taken!");
                }

                console.log(r);
            }
        });
    });
});