var user = null;

window.onload = function () {

    user = localStorage.getItem("user");

    if (user != null)
        window.open('index.html', target = '_self');

};


var form = document.getElementsByTagName('form');

form[0].addEventListener('submit', function (e) {

    e.preventDefault();

    var fields = document.getElementsByTagName('input');
    var loginCredentials = {
        "email": fields[0].value,
        "password": fields[1].value
    };

    $.ajax({
        url: "http://127.0.0.1:8000/api/login",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(loginCredentials),
        success: function (result) {

            localStorage.setItem("user", JSON.stringify(result.data));

            window.open('index.html', target = "_self");
        },
        error: function (error) {
            alert(error.responseJSON.message);
        }
    })
});