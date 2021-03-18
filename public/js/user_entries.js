function addNewEntry() {
        document.querySelector("#entries-table").innerHTML = '<form><label for="text">Text:</label><br><input type="text" id="text" name="text" required><br><label for="numberOfCalories">Number of calories:</label><br><input type="text" name="numberOfCalories" id="numberOfCalories"><br><br><input type="button" onclick="sendEntryDataToBackend()" value="Submit"></form>'
}

function sendEntryDataToBackend() {
    let text = document.getElementById("text").value
    let numberOfCalories = document.getElementById("numberOfCalories").value
    let data = {text: text,numberOfCalories: numberOfCalories}
    fetch("/user/entries", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    })
        .then((res) => res.text())
        .then((res) => changeEntriesTable(JSON.parse(res)));
}

function editEntry(id) {
    fetch("http://laravel.loc/user/entries/" + id, {
        method: 'GET',
    })
        .then((res) => res.text())
        .then(res => {
            document.querySelector("#entries-table").innerHTML = '<form><label for="text">Text:</label><br><input type="text" id="text" name="text" value=' + JSON.parse(res)[0].text + '><br><label for="numberOfCalories">Number of calories:</label><br><input type="text" name="numberOfCalories" id="numberOfCalories" value=' + JSON.parse(res)[0].numberOfCalories + '><br><br><input type="button" onclick="updateEntry(' + id + ')" value="Submit"></form>'
        })
}



function updateEntry(id) {
    let text = document.getElementById("text").value
    let numberOfCalories = document.getElementById("numberOfCalories").value

    let data = {text,numberOfCalories}

    fetch('http://laravel.loc/user/entries/' + id, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    })
        .then(res => res.text())
        .then(res => changeEntriesTable(JSON.parse(res)))
}

function deleteEntry(entryID) {
    fetch("http://laravel.loc/user/entries/" + entryID, {
        method: 'DELETE',
    })
        .then((res) => res.text())
        .then(res => changeEntriesTable(JSON.parse(res)));
}

function changeEntriesTable(array) {
    let x = document.querySelectorAll(".entry-data");
    if(x.length > 0) {
        Array.prototype.forEach.call(x, function (node) {
            node.parentNode.removeChild(node);
        });
    }
    let test = document.querySelector('#entries-table')

    test.innerHTML = ''

    let q = "<tr><th>Date</th><th>Time</th><th>Text</th><th>Number of Calories</th></tr>"
    test.innerHTML = q

    for (let i = 0; i < array.length; i++) {

        let p = "<tr  class='entry-data'><th>" + array[i].date + "</th><th>" + array[i].time + "</th><th>" + array[i].text + "</th><th>" + array[i].numberOfCalories + "</th><th><button id='edit-entry' onclick='editEntry(" + array[i].id + ")'>edit</button></th><th><button id='delete-entry' onclick='deleteEntry(" + array[i].id + ")'>delete</button></th></tr>"
        test.innerHTML += p
    }
}


function filterTableByDatetime() {
    let fromDate = document.getElementById("from-date").value
    let toDate = document.getElementById("to-date").value
    let fromHour = document.getElementById("from-hour").value
    let toHour = document.getElementById("to-hour").value

    let data = {fromDate,toDate,fromHour,toHour}
    if(fromDate && toDate && fromHour && toHour) {
        fetch("http://laravel.loc/user/filterEntries", {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            },
        })
            .then((res) => res.text())
            .then(res => changeEntriesTable(JSON.parse(res)));
    }
}

function checkCalories() {

    if(document.getElementById("excepted-number-of-calories").value) {
        if(!isNaN(document.getElementById("excepted-number-of-calories").value)) {
            fetch('http://laravel.loc/user/calories')
                .then(response => response.json())
                .then(data => compareCaloriesWithExpected(data[0].calories));
        }
        else {
            alert("Input must be an number!")
        }
    }
}

function compareCaloriesWithExpected(numberOfCalories) {
    if(numberOfCalories === null) {
        alert("you did not added the number of calories for today!")
    }
    else {
        if (parseInt(document.getElementById("excepted-number-of-calories").value) >= numberOfCalories) {
            document.getElementById("excepted-number-of-calories").className = "green"
            alert("Calorie intake for today did not exceed the expected daily intake and that ratio amounts to " + numberOfCalories + "/" + document.getElementById("excepted-number-of-calories").value)
        } else {
            document.getElementById("excepted-number-of-calories").className = "red"
            alert("Calorie intake for today exceed the expected daily intake and that ratio amounts to " + numberOfCalories + "/" + document.getElementById("excepted-number-of-calories").value)
        }
    }
}

