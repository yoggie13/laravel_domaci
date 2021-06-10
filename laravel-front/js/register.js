var user = null;

window.onload = function () {

    user = localStorage.getItem("user");

    if (user != null)
        window.open('/laravel-front', target = '_self');

};


var form = document.getElementsByTagName('form');

form[0].addEventListener('submit', function (e) {

    e.preventDefault();

    var fields = document.getElementsByTagName('input');
    var registerCredentials = {
        "name": fields[0].value,
        "email": fields[1].value,
        "password": fields[2].value
    };

    console.log(registerCredentials);

    $.ajax({
        url: "http://127.0.0.1:8000/api/register",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(registerCredentials),
        success: function (result) {

            localStorage.setItem("user", JSON.stringify(result.data));

            window.open('/laravel-front', target = "_self");
        },
        error: function (error) {
            alert(error.responseJSON.message);
        }
    })
});