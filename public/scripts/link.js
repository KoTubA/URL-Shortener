document.addEventListener("DOMContentLoaded", () => {
    const panel_result_feedback = document.querySelectorAll(".panel-result-feedback"),
        panel_result_empty = document.querySelector(".panel-result-empty"),
        panel_result_error = document.querySelector(".panel-result-error"),
        panel_result_cnt = document.querySelector(".panel-result-cnt"),
        panel_result_loader = document.querySelector(".panel-result-loader"),
        panel_error = document.querySelector(".panel-error");

    function fetch_links() {
        for (let ele of panel_result_feedback) {
            ele.classList.remove("panel_result_feedback-visible");
        }
        panel_result_loader.classList.remove("panel-result-loader-invisible");
        panel_error.innerText = "";

        fetch("../controllers/getLink.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then((res) => {
                console.log(res);
                panel_result_loader.classList.add("panel-result-loader-invisible");
                if (res.success) {
                    panel_result_cnt.innerHTML = res["data"];
                    panel_result_cnt.classList.add("panel-result-feedback-visible");
                } else {
                    if (res.hasOwnProperty("error")) {
                        panel_result_error.classList.add("panel-result-feedback-visible");
                        panel_error.innerText = res["error"];
                    } else {
                        panel_result_empty.classList.add("panel-result-feedback-visible");
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }
    fetch_links();
});
