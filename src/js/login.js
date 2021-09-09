function setFormMessage(formElement, type, message) {
    const messageElement = formElement.querySelector(".form__message");

    messageElement.textContent = message;
    messageElement.classList.remove("form__message--success", "form__message--error");
    messageElement.classList.add(`form__message--${type}`);
}

function setInputError(inputElement, message) {
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
    inputElement.classList.remove("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("form--hidden");
        createAccountForm.classList.remove("form--hidden");
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });

    loginForm.addEventListener("submit", e => {
        e.preventDefault();

        // Perform your AJAX/Fetch login

        setFormMessage(loginForm, "error", "Invalid username/password combination");
    });

    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("blur", e => {
            if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 5) {
                setInputError(inputElement, "Username must be at least 10 characters in length");
            }
            if(e.target.id === "email" && e.target.value.length > 0 && e.target.value.length < 5 ){
                setInputError(inputElement, "enter valid email");
            }
            if(e.target.id === "password1" && e.target.value.length > 0 && e.target.value.length < 10 ){
                setInputError(inputElement, "min password is 10 chars");
            }
            if(e.target.id === "password2" && e.target.value.length > 0 && e.target.value.length < 10){
                setInputError(inputElement, "min password is 10 chars");
            }
        });

        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        });
    });
    createAccountForm.addEventListener("submit", e => {
        e.preventDefault();
        var username = document.getElementById("signupUsername").value;
        var email = document.getElementById("email").value;
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;
        var lname =  document.getElementById("lname").value;
        var fname =  document.getElementById("fname").value;
        var confID =  document.getElementById("confID").value;
        var sessionID = document.getElementById("sessionID").value;
        var compID = document.getElementById("compID").value;

        var role =  document.getElementById("role").value;
        
        var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
        var theUrl = "http://localhost:8000/api/v1/create/createuser.php";
        xmlhttp.open("POST", theUrl);
        var mydata = {
            "fName": fname,
            "lName": lname,
            "username": username,
            "email": email,
            "passwordHash": password1,
            "compID": compID,
            "confID": confID, 
            "sessionID": sessionID,
            "role": role
        }
        console.log(mydata);
        xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xmlhttp.onload  = function() {
            var jsonResponse = xmlhttp.response;
            if(!(jsonResponse.includes("true"))){
                setFormMessage(createAccountForm, "error", "user already exists")
            };
            createAccountForm.reset();
            
        };
        xmlhttp.send(JSON.stringify(mydata));

        setFormMessage(createAccountForm, "success", "User created successfuly");
    });
});