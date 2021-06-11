var user = null;
var parentDiv = document.getElementById("locations");

window.onload = function () {

    user = localStorage.getItem("user");

    if (user == null)
        window.open('login.html', target = '_self');

    sendPostRequest();
};

function sendPostRequest() {

    var userSend = JSON.parse(user);

    $.ajax({
        url: "http://127.0.0.1:8000/api/bookings",
        type: "GET",
        dataType: 'json',
        contentType: 'application/json',
        data: userSend,
        success: function (result) {
            addLocations(result);
        },
        error: function (error) {
            createMessage();
        }
    })
}
function createMessage() {
    const div = document.createElement('div');

    const h2 = document.createElement('h2');
    h2.innerHTML = "Nemate ništa bukirano";
    h2.style.color = '#111111';

    const a = document.createElement('a');
    a.href = "index.html";
    a.innerHTML = "Bukirajte ovde";

    div.append(h2);
    div.append(a);

    div.style.gridRow = 1;
    div.style.gridColumn = 1;

    locations.append(div);
}
function addLocations(locations) {
    price = locations.message;
    locations = locations.data;

    var welcome = document.getElementById('welcome');
    var p = document.createElement('p');
    p.innerHTML = price;
    welcome.append(p);


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
    button.innerHTML = "Otkaži";
    button.id = element.id;
    button.onclick = deleteBooking;

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

function deleteBooking() {

    var booking = {
        "user_id": JSON.parse(user).id,
        "location_id": this.id,
        "start_date": "2021-02-02"
    };

    $.ajax({
        url: "http://127.0.0.1:8000/api/bookings",
        type: "DELETE",
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(booking),
        success: function (result) {
            window.open('bookings.html', target = "_self");
        },
        error: function (error) {
            alert(error.responseJSON.message);
        }
    })
}