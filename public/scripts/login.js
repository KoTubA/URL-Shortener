document.addEventListener("DOMContentLoaded", () => {
    const form_login = document.querySelector("#form-login"),
        name = document.querySelector("[name='username']"),
        password = document.querySelector("[name='password']"),
        error_message = document.querySelectorAll(".error-message"),
        form_feedback = document.querySelector(".form-feedback");

    form_login.addEventListener("submit", (e) => {
        e.preventDefault();

        for (let ele of error_message) {
            ele.classList.remove("error-message-visible");
            ele.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.previousElementSibling.previousElementSibling.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.innerText = "";
        }

        form_feedback.classList.remove("form-feedback-error", "form-feedback-success");
        form_feedback.innerText = "";

        fetch("/controllers/login.php", {
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
                if (res.success) {
                    window.location.href = "panel";
                } else {
                    if (res.data.hasOwnProperty("error")) {
                        form_feedback.classList.add("form-feedback-error");
                        form_feedback.innerText = res.data["error"];
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
                }
            })
            .catch((error) => {
                console.log(error);
            });
    });
});
