document.addEventListener("DOMContentLoaded", () => {
    const panel_result_feedback = document.querySelectorAll(".panel-result-feedback"),
        panel_result_empty = document.querySelector(".panel-result-empty"),
        panel_result_error = document.querySelector(".panel-result-error"),
        panel_result_cnt = document.querySelector(".panel-result-cnt"),
        panel_result_loader = document.querySelector(".panel-result-loader"),
        panel_error = document.querySelector(".panel-error"),
        overlay_notification = document.querySelector(".overlay-notification"),
        overlay_panel = document.querySelector(".overlay-panel"),
        delete_feedback_error = document.querySelector(".delete-feedback-error"),
        edit_link_cnt = document.querySelector(".edit-link"),
        add_section = document.querySelector(".add-link"),
        add_link = document.querySelector("#add-link"),
        long_url = document.querySelector("[name='long-url']");

    //Dynamic fetch links
    function fetch_links() {
        for (let ele of panel_result_feedback) {
            ele.classList.remove("panel-result-feedback-visible");
        }
        panel_result_loader.classList.remove("panel-result-loader-invisible");
        panel_error.innerText = "";

        //Remove all event listeners from all children
        const old_element = document.querySelector(".panel-result-links-wrapper");
        if (old_element != null) {
            let new_element = old_element.cloneNode(true);
            old_element.parentNode.replaceChild(new_element, old_element);
            //Remove children
            new_element.remove();
            document.querySelector(".panel-result-counter").remove();
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
                        main_link_clear_all = document.querySelector(".main-link-clear-all"),
                        panel_result_link_data_btn_edit = document.querySelectorAll(".panel-result-link-data-btn-edit");

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

                    for (let ele of panel_result_link_data_btn_edit) {
                        ele.addEventListener("click", function () {
                            let data = this.parentElement.parentElement.children[2].innerText;
                            let l_url = this.parentElement.parentElement.children[1].innerText;
                            let s_url = this.parentElement.parentElement.children[0].innerText.split("/");
                            let o_url = this.getAttribute("data-original-url");
                            edit_link_section(data, l_url, s_url[1], o_url);
                        });
                    }
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
        overlay_notification.classList.add("overlay-visible");

        overlay_notification.addEventListener("click", remove_notification, { once: true });
    }

    function remove_notification() {
        //Remove all event listeners from all children
        let old_element = document.querySelector(".delete-link-notification");
        if (old_element != null) {
            let new_element = old_element.cloneNode(true);
            old_element.parentNode.replaceChild(new_element, old_element);

            //Remove parent
            new_element.remove();
        }
        overlay_notification.classList.remove("overlay-visible");
    }

    function feedback_error() {
        delete_feedback_error.classList.remove("delete-feedback-error-visible");
    }

    //Server error - feedback msg
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

    ////Dynamic delete all links
    function delete_all_links(e) {
        e.preventDefault();
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

    function edit_link_section(created_value, long_url_value, short_url_value, original_url_value) {
        const fragment = document.createDocumentFragment();

        let edit_link_form = document.createElement("form");
        edit_link_form.classList.add("form-panel", "form-system", "form-edit-link");
        edit_link_form.method = "POST";
        edit_link_form.id = "edit-link";
        edit_link_form.addEventListener("submit", edit_link);

        let edit_link_title = document.createElement("h2");
        edit_link_title.classList.add("edit-link-title");
        edit_link_title.innerText = "Edit Link";

        let edit_link_form_fileds = document.createElement("div");
        edit_link_form_fileds.classList.add("form-fileds");

        let edit_link_data = document.createElement("div");
        edit_link_data.classList.add("edit-link-data");
        edit_link_data.innerText = created_value;

        let edit_link_feedback = document.createElement("div");
        edit_link_feedback.classList.add("form-feedback", "form-feedback-edit");

        let edit_link_label_long_url = document.createElement("label");
        edit_link_label_long_url.for = "long-url";
        edit_link_label_long_url.classList.add("form-label", "form-label-with-feedback");
        edit_link_label_long_url.innerText = "Long URL";

        let edit_link_input_long_url = document.createElement("input");
        edit_link_input_long_url.type = "text";
        edit_link_input_long_url.disabled = "disabled";
        edit_link_input_long_url.name = "long-url";
        edit_link_input_long_url.autocorrect = "off";
        edit_link_input_long_url.classList.add("form-control");
        edit_link_input_long_url.value = long_url_value;

        let edit_link_label_short_url = document.createElement("label");
        edit_link_label_short_url.for = "short-url";
        edit_link_label_short_url.classList.add("form-label", "form-label-with-info");
        edit_link_label_short_url.innerText = "Short URL";

        let edit_link_info_short_url = document.createElement("span");
        edit_link_info_short_url.classList.add("form-info");
        edit_link_info_short_url.innerText = "Allowed characters: a-z A-Z 0-9";

        let edit_link_input_short_url = document.createElement("input");
        edit_link_input_short_url.type = "text";
        edit_link_input_short_url.name = "short-url";
        edit_link_input_short_url.autocorrect = "off";
        edit_link_input_short_url.classList.add("form-control");
        edit_link_input_short_url.value = short_url_value;

        let edit_link_error_short_url = document.createElement("span");
        edit_link_error_short_url.classList.add("error-message", "data-error-edit");

        let edit_link_input_hidden = document.createElement("input");
        edit_link_input_hidden.type = "hidden";
        edit_link_input_hidden.name = "url";
        edit_link_input_hidden.value = original_url_value;

        let form_action_buttons = document.createElement("div");
        form_action_buttons.classList.add("form-action-buttons");

        let discard_button = document.createElement("button");
        discard_button.classList.add("main-btn", "form-btn", "panel-btn", "no-fill-btn", "edit-link-disable");
        discard_button.type = "button";
        discard_button.innerText = "Discard";
        discard_button.addEventListener("click", remove_edit);
        discard_button.addEventListener("click", () => {
            add_section.classList.remove("add-link-visible");
        });

        let delete_button = document.createElement("button");
        delete_button.classList.add("main-btn", "form-btn", "panel-btn");
        delete_button.innerText = "Edit";

        form_action_buttons.appendChild(discard_button);
        form_action_buttons.appendChild(delete_button);

        edit_link_form_fileds.appendChild(edit_link_data);
        edit_link_form_fileds.appendChild(edit_link_feedback);
        edit_link_form_fileds.appendChild(edit_link_label_long_url);
        edit_link_form_fileds.appendChild(edit_link_input_long_url);
        edit_link_form_fileds.appendChild(edit_link_label_short_url);
        edit_link_form_fileds.appendChild(edit_link_info_short_url);
        edit_link_form_fileds.appendChild(edit_link_input_short_url);
        edit_link_form_fileds.appendChild(edit_link_error_short_url);
        edit_link_form_fileds.appendChild(edit_link_input_hidden);

        edit_link_form.appendChild(edit_link_title);
        edit_link_form.appendChild(edit_link_form_fileds);
        edit_link_form.appendChild(form_action_buttons);

        fragment.appendChild(edit_link_form);
        edit_link_cnt.appendChild(fragment);

        edit_link_cnt.classList.add("edit-link-visible");
        overlay_panel.classList.add("overlay-visible");

        overlay_panel.addEventListener("click", remove_edit, { once: true });
    }

    function remove_edit() {
        edit_link_cnt.classList.remove("edit-link-visible");
        add_section.classList.remove("add-link-visible");
        setTimeout(() => {
            //Remove overlay only when button or succesful edit link (because the overlay has this already implemented)
            if (!this.classList.contains("overlay")) overlay_panel.classList.remove("overlay-visible");

            //Remove all event listeners from all children
            let old_element = document.querySelector(".form-edit-link");
            if (old_element != null) {
                let new_element = old_element.cloneNode(true);
                old_element.parentNode.replaceChild(new_element, old_element);
                //Remove parent
                new_element.remove();
            }
        }, 500);
    }

    function edit_link(e) {
        e.preventDefault();

        const short_url = document.querySelector("[name='short-url']"),
            original_url = document.querySelector("[name='url']"),
            error_message = document.querySelectorAll(".error-message-visible"),
            form_feedback = document.querySelector(".form-feedback-edit");

        for (let ele of error_message) {
            ele.classList.remove("error-message-visible");
            ele.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.innerText = "";
        }

        form_feedback.classList.remove("form-feedback-error", "form-feedback-success");
        form_feedback.innerText = "";

        fetch("../controllers/editLink.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                short_url: short_url.value,
                original_url: original_url.value,
            }),
        })
            .then((res) => res.json())
            .then((res) => {
                if (res.success) {
                    remove_edit.call(this);
                    fetch_links();
                } else {
                    if (res.data.hasOwnProperty("error")) {
                        let form_feedback_edit = document.querySelector(".form-feedback-edit");
                        form_feedback_edit.classList.add("form-feedback-error");
                        form_feedback_edit.innerText = res.data["error"];
                    } else {
                        for (var key in res.data) {
                            document.querySelector("." + key).classList.add("error-message-visible");
                            document.querySelector("." + key).previousElementSibling.classList.add("form-control-error");
                            document
                                .querySelector("." + key)
                                .previousElementSibling.previousElementSibling.previousElementSibling.classList.add("form-label-error");
                            document.querySelector("." + key).innerText = res.data[key];
                        }
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }

    //Dynamic add link
    add_link.addEventListener("submit", (e) => {
        e.preventDefault();

        const error_message = document.querySelectorAll(".error-message-visible"),
            form_feedback = document.querySelector(".form-feedback-add");

        for (let ele of error_message) {
            ele.classList.remove("error-message-visible");
            ele.previousElementSibling.classList.remove("form-control-error");
            ele.previousElementSibling.previousElementSibling.previousElementSibling.classList.remove("form-label-error");
            ele.innerText = "";
        }

        form_feedback.classList.remove("form-feedback-error", "form-feedback-success");
        form_feedback.innerText = "";

        fetch("../controllers/addLink.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                long_url: long_url.value,
            }),
        })
            .then((res) => res.json())
            .then((res) => {
                if (res.success) {
                    long_url.value = "";
                    fetch_links();
                    edit_link_section(res.data["date"], res.data["long-url"], res.data["short-url"], res.data["original-url"]);
                } else {
                    if (res.data.hasOwnProperty("error")) {
                        let form_feedback_edit = document.querySelector(".form-feedback-add");
                        form_feedback_edit.classList.add("form-feedback-error");
                        form_feedback_edit.innerText = res.data["error"];
                    } else {
                        for (var key in res.data) {
                            document.querySelector("." + key).classList.add("error-message-visible");
                            document.querySelector("." + key).previousElementSibling.classList.add("form-control-error");
                            document
                                .querySelector("." + key)
                                .previousElementSibling.previousElementSibling.previousElementSibling.classList.add("form-label-error");
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
