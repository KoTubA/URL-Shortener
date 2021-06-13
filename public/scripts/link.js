document.addEventListener("DOMContentLoaded", () => {
    const panel_result_feedback = document.querySelectorAll(".panel-result-feedback"),
        panel_result_empty = document.querySelector(".panel-result-empty"),
        panel_result_error = document.querySelector(".panel-result-error"),
        panel_result_cnt = document.querySelector(".panel-result-cnt"),
        panel_result_loader = document.querySelector(".panel-result-loader"),
        panel_error = document.querySelector(".panel-error"),
        overlay = document.querySelector(".overlay-notification"),
        delete_feedback_error = document.querySelector(".delete-feedback-error");

    //Dynamic fetch links
    function fetch_links() {
        for (let ele of panel_result_feedback) {
            ele.classList.remove("panel_result_feedback-visible");
        }
        panel_result_loader.classList.remove("panel-result-loader-invisible");
        panel_error.innerText = "";

        //Remove events and children (panel_result_cnt)
        const panel_result_link_data_btn_cpy = document.querySelectorAll(".panel-result-link-data-btn-cpy");
        for (let ele of panel_result_link_data_btn_cpy) {
            ele.removeEventListener("click", copy_to_clipboard);
        }

        while (panel_result_cnt.firstChild) {
            panel_result_cnt.removeChild(panel_result_cnt.lastChild);
        }

        fetch("../controllers/getLink.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then((res) => {
                panel_result_loader.classList.add("panel-result-loader-invisible");
                if (res.success) {
                    panel_result_cnt.innerHTML = res["data"];
                    panel_result_cnt.classList.add("panel-result-feedback-visible");

                    //Add events (copy/delete/delete all)
                    const panel_result_link_data_btn_cpy = document.querySelectorAll(".panel-result-link-data-btn-cpy"),
                        panel_result_link_data_btn_delete = document.querySelectorAll(".panel-result-link-data-btn-delete"),
                        main_link_clear_all = document.querySelector(".main-link-clear-all");

                    for (let ele of panel_result_link_data_btn_cpy) {
                        ele.addEventListener("click", copy_to_clipboard);
                    }
                    for (let ele of panel_result_link_data_btn_delete) {
                        ele.addEventListener("click", function () {
                            let des = "Are you sure you want to delete this link?";
                            let form_id = "delete-link";
                            delete_link_notification(des, form_id, this);
                        });
                    }

                    main_link_clear_all.addEventListener("click", function () {
                        let des = "Are you sure you want to delete all links?";
                        let form_id = "delete-all-links";
                        delete_link_notification(des, form_id, this);
                    });
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

    //Clipboard
    function copy_to_clipboard() {
        const text = this.getAttribute("data-clipboard-text");
        var input = document.createElement("textarea");
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand("Copy");
        input.remove();
    }

    //Delete notification
    function delete_link_notification(des, form_id, e) {
        const fragment = document.createDocumentFragment();

        let link_notification = document.createElement("section");
        link_notification.classList.add("delete-link-notification");

        let link_notification_form = document.createElement("form");
        link_notification_form.classList.add("delete-link-notification-form", "form-system");
        link_notification_form.method = "POST";
        link_notification_form.id = form_id;

        //Add dynamic delete links
        form_id === "delete-link"
            ? link_notification_form.addEventListener("submit", delete_link)
            : link_notification_form.addEventListener("submit", delete_all_links);

        let link_notification_title = document.createElement("h2");
        link_notification_title.classList.add("panel-title");
        link_notification_title.innerText = "Attention";

        let link_notification_description = document.createElement("p");
        link_notification_description.classList.add("panel-description", "panel-description-notification");
        link_notification_description.innerText = des;

        let link_notification_input;
        if (form_id === "delete-link") {
            link_notification_input = document.createElement("input");
            link_notification_input.type = "hidden";
            link_notification_input.name = "url";
            link_notification_input.value = e.getAttribute("data-original-url");
        }

        let form_action_buttons = document.createElement("div");
        form_action_buttons.classList.add("form-action-buttons", "form-action-buttons-notification");

        let discard_button = document.createElement("button");
        discard_button.classList.add("main-btn", "form-btn", "panel-btn", "no-fill-btn", "delete-link-disable");
        discard_button.type = "button";
        discard_button.innerText = "Discard";
        discard_button.addEventListener("click", remove_notification);

        let delete_button = document.createElement("button");
        delete_button.classList.add("main-btn", "form-btn", "panel-btn");
        delete_button.innerText = "Delete";

        form_action_buttons.appendChild(discard_button);
        form_action_buttons.appendChild(delete_button);

        link_notification_form.appendChild(link_notification_title);
        link_notification_form.appendChild(link_notification_description);
        if (link_notification_input) link_notification_form.appendChild(link_notification_input);
        link_notification_form.appendChild(form_action_buttons);

        link_notification.appendChild(link_notification_form);

        fragment.appendChild(link_notification);
        document.querySelector(".main-panel").appendChild(fragment);
        overlay.classList.add("overlay-visible");

        overlay.addEventListener("click", remove_notification, { once: true });
    }

    function remove_notification() {
        //Remove all event listeners from all children
        let old_element = document.querySelector(".delete-link-notification");
        let new_element = old_element.cloneNode(true);
        old_element.parentNode.replaceChild(new_element, old_element);

        //Remove parent
        new_element.remove();
        overlay.classList.remove("overlay-visible");
    }

    function feedback_error() {
        delete_feedback_error.classList.remove("delete-feedback-error-visible");
    }

    //Error feedback msg
    let feedback;

    //Dynamic delete single link
    function delete_link(e) {
        e.preventDefault();

        const url = document.querySelector("[name='url']");
        clearTimeout(feedback);
        feedback_error();

        fetch("../controllers/deleteLink.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                original_url: url.value,
            }),
        })
            .then((res) => res.json())
            .then((res) => {
                panel_result_loader.classList.add("panel-result-loader-invisible");
                if (res.success) {
                    remove_notification();
                    fetch_links();
                } else {
                    feedback = setTimeout(feedback_error, 4000);
                    delete_feedback_error.classList.add("delete-feedback-error-visible");
                    delete_feedback_error.innerText = res["error"];
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }

    function delete_all_links(e) {
        e.preventDefault();

        const url = document.querySelector("[name='url']");
        clearTimeout(feedback);
        feedback_error();

        fetch("../controllers/deleteAllLinks.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
        })
            .then((res) => res.json())
            .then((res) => {
                panel_result_loader.classList.add("panel-result-loader-invisible");
                if (res.success) {
                    remove_notification();
                    fetch_links();
                } else {
                    feedback = setTimeout(feedback_error, 4000);
                    delete_feedback_error.classList.add("delete-feedback-error-visible");
                    delete_feedback_error.innerText = res["error"];
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }
});
