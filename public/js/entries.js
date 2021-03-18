function addNewEntry() {
    document.querySelector("#entries-table").innerHTML = '<form><label for="user_id">User ID</label><br><input type="text" id="user_id"><br><label for="text">Text:</label><br><input type="text" id="text" name="text" required><br><label for="numberOfCalories">Number of calories:</label><br><input type="text" name="numberOfCalories" id="numberOfCalories"><br><br><input type="button" onclick="sendEntryDataToBackend()" value="Submit"></form>'

}

function sendEntryDataToBackend() {
    let user_id = document.getElementById("user_id").value
    let text = document.getElementById("text").value
    let numberOfCalories = document.getElementById("numberOfCalories").value

    if(user_id && text && numberOfCalories) {
        let data = {user_id,text,numberOfCalories}
        fetch("/entries", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        })
            .then((res) => res.text())
            .then((res) => changeEntriesTable(JSON.parse(res)));
    }
}

function editEntry(id) {
    fetch("http://laravel.loc/entries/" + id, {
        method: 'GET',
    })
        .then((res) => res.text())
        .then(res => {
            document.querySelector("#entries-table").innerHTML = '<form><label for="user_id">User ID</label><br><input type="text" id="user_id" value=' + JSON.parse(res)[0].user_id + '><br><label for="text">Text:</label><br><input type="text" id="text" name="text" value=' + JSON.parse(res)[0].text + '><br><label for="numberOfCalories">Number of calories:</label><br><input type="text" name="numberOfCalories" id="numberOfCalories" value=' + JSON.parse(res)[0].numberOfCalories + '><br><br><input type="button" onclick="updateEntry(' + id + ')" value="Submit"></form>'
        })
}

function updateEntry(id) {
    let user_id = document.getElementById("user_id").value
    let text = document.getElementById("text").value
    let numberOfCalories = document.getElementById("numberOfCalories").value

    if (user_id && text && numberOfCalories) {
        let data = {user_id, text, numberOfCalories}
        fetch('http://laravel.loc/entries/' + id, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        })
            .then(res => res.text())
            .then(res => changeEntriesTable(JSON.parse(res)))
    }
}


function deleteEntry(entryID) {
    fetch("http://laravel.loc/entries/" + entryID, {
        method: 'DELETE',
    })
        .then((res) => res.text())
        .then(res => changeEntriesTable(JSON.parse(res)));
}

function changeEntriesTable(array) {
    let x = document.querySelectorAll(".entry-data");
    Array.prototype.forEach.call(x, function (node) {
        node.parentNode.removeChild(node);
    });

    let test = document.querySelector('#entries-table')

    test.innerHTML = ''

    let q = "<tr><th>UserID</th><th>Date</th><th>Time</th><th>Text</th><th>Number of Calories</th></tr>"
    test.innerHTML = q
    for (let i = 0; i < array.length; i++) {

        let p = "<tr  class='entry-data'><th>" + array[i].user_id + "</th><th>" + array[i].date + "</th><th>" + array[i].time + "</th><th>" + array[i].text + "</th><th>" + array[i].numberOfCalories + "</th><th><button id='edit-entry' onclick='editEntry(" + array[i].id + ")'>edit</button></th><th><button id='delete-entry' onclick='deleteEntry(" + array[i].id + ")'>delete</button></th></tr>"
        test.innerHTML += p
    }
}
