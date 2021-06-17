document.addEventListener("DOMContentLoaded", () => {
    const add_link = document.querySelector("#short-link"),
        long_url = document.querySelector("[name='long-url']"),
        error_message = document.querySelector(".error-message-absolute"),
        shorten_link_input_field = document.querySelector("#shorten-link-input-field"),
        shorten_link_result_cnt = document.querySelector(".shorten-link-result-cnt");

    add_link.addEventListener("submit", (e) => {
        e.preventDefault();

        error_message.classList.remove("error-message-visible");
        error_message.previousElementSibling.classList.remove("form-shorten-error");
        error_message.innerText = "";

        fetch("/controllers/addLink.php", {
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
                    shorten_link_input_field.value = "";
                    result_link_section(res.data["long-url"], res.data["short-url"]);
                } else {
                    error_message.classList.add("error-message-visible");
                    error_message.previousElementSibling.classList.add("form-shorten-error");
                    if (res.data.hasOwnProperty("error")) {
                        error_message.innerText = res.data["error"];
                    } else {
                        error_message.innerText = res.data["data-error-add"];
                    }
                }
            })
            .catch((error) => {
                console.log(error);
            });
    });

    function result_link_section(long_url_value, short_url_value) {
        const fragment = document.createDocumentFragment();

        let shorten_link_result_row = document.createElement("div");
        shorten_link_result_row.classList.add("shorten-link-result-row");

        let shorten_link_result_data = document.createElement("div");
        shorten_link_result_data.classList.add("shorten-link-result-data");

        let shorten_link_result_span_long = document.createElement("span");
        shorten_link_result_span_long.classList.add("shorten-link-result-data-span");
        shorten_link_result_span_long.innerText = long_url_value;
        shorten_link_result_data.appendChild(shorten_link_result_span_long);

        let shorten_link_result_short_link_data = document.createElement("div");
        shorten_link_result_short_link_data.classList.add("shorten-link-result-data", "shorten-link-result-short-link-data");

        let shorten_link_result_span = document.createElement("span");
        shorten_link_result_span.classList.add("shorten-link-result-data-span");
        shorten_link_result_span.innerText = short_url_value;
        shorten_link_result_short_link_data.appendChild(shorten_link_result_span);

        let shorten_link_result_copy = document.createElement("div");
        shorten_link_result_copy.classList.add("shorten-link-result-copy");

        let shorten_link_result_btn = document.createElement("button");
        shorten_link_result_btn.classList.add("main-btn", "shorten-link-result-btn");
        shorten_link_result_btn.addEventListener("click", copy_to_clipboard);
        shorten_link_result_btn.setAttribute("data-clipboard-text", short_url_value);
        shorten_link_result_btn.innerText = "Copy";

        shorten_link_result_copy.appendChild(shorten_link_result_btn);

        shorten_link_result_row.appendChild(shorten_link_result_data);
        shorten_link_result_row.appendChild(shorten_link_result_short_link_data);
        shorten_link_result_row.appendChild(shorten_link_result_copy);

        fragment.appendChild(shorten_link_result_row);

        let header = document.querySelector(".shorten-link-title-result");
        shorten_link_result_cnt.insertBefore(fragment, header.nextSibling);

        let old_element = document.querySelectorAll(".shorten-link-result-row");
        if (old_element.length > 3) {
            old_element[old_element.length - 1].lastChild.firstChild.removeEventListener("click", copy_to_clipboard);
            old_element[old_element.length - 1].remove();
        }
    }

    function copy_to_clipboard() {
        if (!this.classList.contains("shorten-link-result-btn-copied")) {
            this.classList.add("shorten-link-result-btn-copied");
            this.innerText = "Copied!";
        }

        const text = this.getAttribute("data-clipboard-text");
        var input = document.createElement("textarea");
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand("Copy");
        input.remove();
    }
});
