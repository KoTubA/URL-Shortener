document.addEventListener("DOMContentLoaded", () => {
    const form_login = document.querySelector("#form-login"),
        name = document.querySelector("[name='username']"),
        password = document.querySelector("[name='password']"),
        error_message = document.querySelectorAll(".error-message"),
        form_control = document.querySelectorAll(".form-control"),
        form_feedback = document.querySelector(".form-feedback");

    form_login.addEventListener("submit", (e) => {
        e.preventDefault();

        for (let ele of error_message) {
            ele.classList.remove("error-message-visible");
            ele.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.innerText = "";
        }

        form_feedback.classList.remove("form-feedback-error", "form-feedback-success");
        form_feedback.innerText = "";

        fetch("../controllers/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                name: name.value,
                password: password.value,
            }),
        })
            .then((res) => res.json())
            .then((res) => {
                console.log(res);
                if (res.success) {
                    if (res.data.hasOwnProperty("success")) {
                        window.location.href = "panel";
                    } else {
                        for (var key in res.data) {
                            document.querySelector("." + key).classList.add("error-message-visible");
                            document.querySelector("." + key).previousElementSibling.classList.add("form-control-error");
                            document.querySelector("." + key).previousElementSibling.previousElementSibling.classList.add("form-label-error");
                            document
                                .querySelector("." + key)
                                .previousElementSibling.previousElementSibling.previousElementSibling.classList.add("form-control-error");
                            document
                                .querySelector("." + key)
                                .previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.classList.add(
                                    "form-label-error"
                                );
                            document.querySelector("." + key).innerText = res.data[key];
                        }
                    }
                } else {
                    form_feedback.classList.add("form-feedback-error");
                    form_feedback.innerText = res.data["error"];
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
        ele.addEventListener("focus", remove_error);
    }

    function remove_error() {
        this.classList.remove("form-control-error");
        this.previousElementSibling.classList.remove("form-label-error");
    }
});
