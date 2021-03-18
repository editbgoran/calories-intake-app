function deleteUser(userID) {
    fetch("http://laravel.loc/users/" + userID, {
        method: 'DELETE',
    })
        .then((res) => res.text())
        .then(res => changeUsersTable(JSON.parse(res)));
}

function addNewUser() {
    document.querySelector(".card").innerHTML = '<form><label for="name">Name:</label><br> <input type="text" id="name" name="name" required><br> <label for="email">Email:</label><br> <input type="email" id="email" name="email"><br><label>Password</label><br><input name="password" id="password" type="password"><br><label for="role">Choose a role:</label><br><select id="role" name="role"><option value="admin">Admin</option><option value="manager">Manager</option><option value="user">User</option></select><br><br><input type="button" onclick="validateForm()" value="Submit"></form>'
}


function editUser(userID) {
    fetch("http://laravel.loc/users/" + userID, {
        method: 'GET',
    })
        .then((res) => res.text())
        .then(res => {
            document.querySelector(".card").innerHTML = '<form><label for="name">Name:</label><br> <input type="text"  id="name" name="name"  value=' + JSON.parse(res)[0].name + '><br> <label for="email">Email:</label><br> <input type="email" id="email" name="email" value=' + JSON.parse(res)[0].email + '><br><label for="role">Choose a role:</label><br><select id="role" name="role"><option value="admin">Admin</option><option value="manager">Manager</option><option value="user">User</option></select><br><br><input type="button" onclick="updateUser(' + userID + ')" value="Submit"></form>'
        })
}


function updateUser(userID) {
    let name = document.getElementById("name").value
    let email = document.getElementById("email").value
    let role = document.getElementById("role").value
    let data = {name: name,email: email,role: role}
    fetch("/users/" + userID, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    })
        .then((res) => res.text())
        .then(function (res) {
            document.querySelector('.card').innerHTML = "<table id='users-table'></table>"
            changeUsersTable(JSON.parse(res))
        });
}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function validateForm() {
    let name = document.getElementById("name").value
    let password = document.getElementById("password").value
    let email = document.getElementById("email").value
    let role = document.getElementById("role").value

    if(name === '') {
        alert("Please fill out name field!")
    }
    else if(password === '') {
        alert("Please fill out password field")
    }
    else if(password.length < 8) {
        alert("Password must contain at least 8 characters!")
    }
    else if(email === '') {
        alert("Please fill out email field!")
    }
    else if(!validateEmail(email)) {
        alert("Email is not valid!")
    }
    else {
        sendFormDataToController()
    }

}

function sendFormDataToController() {
    let name = document.getElementById("name").value
    let password = document.getElementById("password").value
    let email = document.getElementById("email").value
    let role = document.getElementById("role").value
    let data = {name: name,email: email,password: password,role: role}
    fetch("/users", {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    })
        .then((res) => res.text())
        .then(function (res) {
            document.querySelector('.card').innerHTML = "<table id='users-table'></table>"
            changeUsersTable(JSON.parse(res))
        });
}


function changeUsersTable(array) {
    let x = document.querySelectorAll(".user-data");
    Array.prototype.forEach.call(x, function (node) {
        node.parentNode.removeChild(node);
    });

    let test = document.querySelector('#users-table')

    test.innerHTML = ''

    let q = "<tr><th>Name</th><th>Email</th><th>Role</th></tr>"
    test.innerHTML = q

    for (let i = 0; i < array.length; i++) {

        let p = "<tr  class='user-data'><th>" + array[i].name + "</th><th>" + array[i].email + "</th><th>" + array[i].role + "</th><th><button id='edit-user' onclick='editUser(" + array[i].id + ")'>edit</button></th><th><button id='delete-user' onclick='deleteUser(" + array[i].id + ")'>delete</button></th></tr>"
        test.innerHTML += p
    }
}

