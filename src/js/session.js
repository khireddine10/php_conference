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
    const createAccountForm = document.querySelector("#createConf");

    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("blur", e => {
            if (e.target.id === "confName" && e.target.value.length == 0) {
                setInputError(inputElement, "conference name must be added");
            }
            if(e.target.id === "confDomain" && e.target.value.length == 0){
                setInputError(inputElement, "conference domain must be added");
            }
            if(e.target.id === "confLieu" && e.target.value.length == 0){
                setInputError(inputElement, "conference lieu must be added");
            }
            if(e.target.id === "email" && e.target.value.length == 0){
                setInputError(inputElement, "conference email must be added");
            }
        });

        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        });
    });
    createAccountForm.addEventListener("submit", e => {
        e.preventDefault();
        var sessionName = document.getElementById("sessionName").value;
        var sDate = document.getElementById("sDate").value;
        var eDate = document.getElementById("eDate").value;
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('confid');
        var xmlhttp = new XMLHttpRequest();   // new HttpRequest instance 
        var theUrl = "http://localhost:8000/api/v1/create/createsession.php";
        xmlhttp.open("POST", theUrl);
        var mydata = {
            "sessionName": sessionName,
            "confID": id,
            "sDate": sDate,
            "eDate": eDate
        }
        console.log(mydata);
        xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xmlhttp.onload  = function() {
            var jsonResponse = xmlhttp.response;
            if(!(jsonResponse.includes("true"))){
                setFormMessage(createAccountForm, "error", "session creating conference")
            };
            createAccountForm.reset();
        };
        xmlhttp.send(JSON.stringify(mydata));

        setFormMessage(createAccountForm, "success", "session created successfuly");
    });
});