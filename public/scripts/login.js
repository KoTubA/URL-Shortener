document.addEventListener("DOMContentLoaded", () => {
    const form_login = document.querySelector("#form-login"),
        name = document.querySelector("[name='username']"),
        email = document.querySelector("[name='email']"),
        password = document.querySelector("[name='password']"),
        error_message = document.querySelectorAll(".error-message"),
        form_control = document.querySelectorAll(".form-control");

    form_login.addEventListener("submit", (e) => {
        e.preventDefault();

        for (let ele of error_message) {
            ele.classList.remove("error-message-visible");
            ele.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.innerText = "";
        }

        fetch("../validations/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                name: name.value,
                email: email.value,
                password: password.value,
            }),
        })
            .then((res) => res.json())
            .then((res) => {
                console.log(res);
                if (res.success) {
                    if (res.data.hasOwnProperty("success")) {
                        console.log(res.data["success"]);
                    } else {
                        for (var key in res.data) {
                            document.querySelector("." + key).classList.add("error-message-visible");
                            document.querySelector("." + key).previousElementSibling.classList.add("form-control-error");
                            document.querySelector("." + key).previousElementSibling.previousElementSibling.classList.add("form-label-error");
                            document.querySelector("." + key).innerText = res.data[key];
                        }
                    }
                } else {
                    console.log(res.data["error"]);
                }
            })
            .catch((error) => {
                console.log(error);
            });
    });

    for (let ele of error_message) {
        ele.classList.remove("error-message-visible");
        ele.previousElementSibling.classList.remove("form-control-error");
        ele.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
        ele.innerText = "";
    }

    for (let ele of form_control) {
        ele.addEventListener("click", remove_error);
    }

    function remove_error() {
        this.classList.remove("form-control-error");
        this.previousElementSibling.classList.remove("form-label-error");
    }
});
