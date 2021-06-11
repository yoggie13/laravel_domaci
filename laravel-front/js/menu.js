var homepage = document.getElementById('homepage');
var bookings = document.getElementById('bookings');
var logout = document.getElementById('logout');

homepage.addEventListener('click', function () {
    window.open('index.html', target = "_self");
});

bookings.addEventListener('click', function () {
    window.open('bookings/html', target = "_self");
});

logout.addEventListener('click', function () {

    $.ajax({
        url: "http://127.0.0.1:8000/api/logout",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: localStorage.getItem("user"),
        success: function (result) {
            localStorage.clear();
            window.open('login.html', target = "_self");
        },
        error: function (error) {

            alert(error.responseJSON.message);
        }
    });

});