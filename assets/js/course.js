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
    // if the course code update button is clicked
    $('#codeupdate').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/coursecodeupdate",
            processData: false,
            contentType: "application/json",
            data: '{ "id": "'+$("#codeupdate").attr("name")+'", "code": "'+$('#code').val()+'" }',
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

    // if the course title update button is clicked
    $('#titleupdate').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/coursetitleupdate",
            processData: false,
            contentType: "application/json",
            data: '{ "id": "'+$("#titleupdate").attr("name")+'", "title": "'+$("#title").val()+'" }',
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

    // if the course desc. update button is clicked
    $('#descupdate').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/coursedescupdate",
            processData: false,
            contentType: "application/json",
            data: '{ "id": "'+$("#descupdate").attr("name")+'", "desc": "'+$("#desc").val()+'" }',
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
});