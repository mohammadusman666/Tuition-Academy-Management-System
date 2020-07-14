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
    // if the add fee button is clicked
    $('#addfee').click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/addfee",
            processData: false,
            contentType: "application/json",
            data: '{ "id": "'+$("#addfee").attr("name")+'", "fee": "'+$('#fee').val()+'" }',
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

    // if the delete fee button is clicked
    $(".deletefee").click(function()
    {
        $.ajax({
            type: "POST",
            url: "api/deletefee",
            processData: false,
            contentType: "application/json",
            data: '{ "id": "'+$(this).attr("name")+'" }',
            success: function(r)
            {
                // display success message
                r = JSON.parse(r);
                displaySuccess("msg"+$(this).attr("name"), r.Success);
            },
            error: function(r)
            {
                // display error message
                r = r.responseText;
                var r = JSON.parse(r);
                displayError("msg"+$(this).attr("name"), r.Error);

                console.log(r);
            }
        });
    });
});