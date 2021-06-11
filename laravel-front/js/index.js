var parentDiv = document.getElementById("locations");
var user = null;

window.onload = function () {
    user = localStorage.getItem("user");

    if (user == null)
        window.open('login.html', target = '_self');
};

$(document).ready(function () {
    $.ajax({
        url: "http://127.0.0.1:8000/api/",
        type: "GET",
        success: function (result) {
            addLocations(result.data);
        },
        error: function (error) {
            console.log(error);
        }
    })
});

function addLocations(locations) {
    var id = 0;
    locations.forEach(element => {
        createDiv(element, id);
        id++;
    });
}

function createDiv(element, id) {

    const div = document.createElement('div');

    const h2 = document.createElement('h2');
    h2.innerHTML = element.name;

    const desc = document.createElement('p');
    desc.innerHTML = element.description;

    const price = document.createElement('p');
    price.innerHTML = "Cena: " + element.price;

    const button = document.createElement('button');
    button.innerHTML = "Zakaži";
    button.id = element.id;
    button.onclick = saveBooking;

    div.append(h2);
    div.append(desc);
    div.append(price);
    div.append(button);

    div.className = "location";
    parentDiv.append(div);

    var row = Math.floor(id / 3) + 1;
    var column = (id + 1) % 3;

    if (column === 0)
        column = 3;

    div.style.gridRow = row
    div.style.gridColumn = column;

    div.style.backgroundImage = `url('${element.picture_url}')`;
    div.style.backgroundSize = 'cover';
    div.style.backgroundRepeat = 'no-repeat';
}

function saveBooking() {

    var booking = {
        "user_id": JSON.parse(user).id,
        "location_id": this.id,
        "start_date": "2021-02-02"
    };

    $.ajax({
        url: "http://127.0.0.1:8000/api/bookings",
        type: "POST",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(booking),
        success: function (result) {
            alert(result.message);
        },
        error: function (error) {
            alert(error.responseJSON.message);
        }
    })
}