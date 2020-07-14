// function to display error message
function displayError(errorId, errorMsg)
{
    setTimeout(function() {
        var elem = document.getElementById(errorId);
        elem.innerHTML = "";
        elem.setAttribute("style", "visibility: hidden;");
    }, 2000);

    var elem = document.getElementById(errorId);
    elem.innerHTML = errorMsg;
    elem.setAttribute("style", "margin: 10px 0px 0px 0px; padding: 12px; color: #D8000C; background-color: #FFD2D2; text-align: center; visibility: visible;");
}

// function to display success message
function displaySuccess(successId, successMsg)
{
    setTimeout(function() {
        var elem = document.getElementById(successId);
        elem.innerHTML = "";
        elem.setAttribute("style", "visibility: hidden;");
    }, 2000);

    var elem = document.getElementById(successId);
    elem.innerHTML = successMsg;
    elem.setAttribute("style", "margin: 10px 0px 0px 0px; padding: 12px; color: green; background-color: #ACFC9C; text-align: center; visibility: visible;");
}

$(document).ready(function()
{
    ///////////////////
    // ADMINISTRATOR //
    ///////////////////
    // if the administrator username update button is clicked
    $('#updateusernameA').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateusername",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Administrator", "id": "'+$("#updateusernameA").attr("name")+'", "username": "'+$('#username').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg1", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg1", r.Error);

                console.log(r);
            }
        });
    });

    // if the administrator name update button is clicked
    $('#updatenameA').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatename",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Administrator", "id": "'+$("#updatenameA").attr("name")+'", "name": "'+$('#name').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg2", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg2", r.Error);

                console.log(r);
            }
        });
    });

    // if the administrator contact update button is clicked
    $('#updatecontactA').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatecontact",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Administrator", "id": "'+$("#updatecontactA").attr("name")+'", "contact": "'+$('#contact').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg3", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg3", r.Error);

                console.log(r);
            }
        });
    });

    // if the administrator email update button is clicked
    $('#updateemailA').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateemail",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Administrator", "id": "'+$("#updateemailA").attr("name")+'", "email": "'+$('#email').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg4", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg4", r.Error);

                console.log(r);
            }
        });
    });

    /////////////
    // MANAGER //
    /////////////
    // if the manager username update button is clicked
    $('#updateusernameM').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateusername",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Manager", "id": "'+$("#updateusernameM").attr("name")+'", "username": "'+$('#username').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg1", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg1", r.Error);

                console.log(r);
            }
        });
    });

    // if the manager name update button is clicked
    $('#updatenameM').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatename",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Manager", "id": "'+$("#updatenameM").attr("name")+'", "name": "'+$('#name').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg2", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg2", r.Error);

                console.log(r);
            }
        });
    });

    // if the manager contact update button is clicked
    $('#updatecontactM').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatecontact",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Manager", "id": "'+$("#updatecontactM").attr("name")+'", "contact": "'+$('#contact').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg3", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg3", r.Error);

                console.log(r);
            }
        });
    });

    // if the manager email update button is clicked
    $('#updateemailM').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateemail",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Manager", "id": "'+$("#updateemailM").attr("name")+'", "email": "'+$('#email').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg4", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg4", r.Error);

                console.log(r);
            }
        });
    });

    /////////////
    // TEACHER //
    /////////////
    // if the teacher username update button is clicked
    $('#updateusernameT').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateusername",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Teacher", "id": "'+$("#updateusernameT").attr("name")+'", "username": "'+$('#username').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg1", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg1", r.Error);

                console.log(r);
            }
        });
    });

    // if the teacher name update button is clicked
    $('#updatenameT').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatename",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Teacher", "id": "'+$("#updatenameT").attr("name")+'", "name": "'+$('#name').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg2", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg2", r.Error);

                console.log(r);
            }
        });
    });

    // if the teacher contact update button is clicked
    $('#updatecontactT').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatecontact",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Teacher", "id": "'+$("#updatecontactT").attr("name")+'", "contact": "'+$('#contact').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg3", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg3", r.Error);

                console.log(r);
            }
        });
    });

    // if the teacher email update button is clicked
    $('#updateemailT').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateemail",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Teacher", "id": "'+$("#updateemailT").attr("name")+'", "email": "'+$('#email').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg4", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg4", r.Error);

                console.log(r);
            }
        });
    });

    /////////////
    // STUDENT //
    /////////////
    // if the student username update button is clicked
    $('#updateusernameS').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateusername",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Student", "id": "'+$("#updateusernameS").attr("name")+'", "username": "'+$('#username').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg1", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg1", r.Error);

                console.log(r);
            }
        });
    });

    // if the student name update button is clicked
    $('#updatenameS').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatename",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Student", "id": "'+$("#updatenameS").attr("name")+'", "name": "'+$('#name').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg2", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg2", r.Error);

                console.log(r);
            }
        });
    });

    // if the student contact update button is clicked
    $('#updatecontactS').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updatecontact",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Student", "id": "'+$("#updatecontactS").attr("name")+'", "contact": "'+$('#contact').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg3", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg3", r.Error);

                console.log(r);
            }
        });
    });

    // if the student email update button is clicked
    $('#updateemailS').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/updateemail",
            processData: false,
            contentType: "application/json",
            data: '{ "usertype": "Student", "id": "'+$("#updateemailS").attr("name")+'", "email": "'+$('#email').val()+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg4", r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg4", r.Error);

                console.log(r);
            }
        });
    });
});