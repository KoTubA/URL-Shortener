document.addEventListener("DOMContentLoaded", () => {
    const main_btn_add = document.querySelector(".main-btn-add"),
        add_link = document.querySelector(".add-link"),
        add_link_disable = document.querySelector(".add-link-disable"),
        account_settings_toogle = document.querySelector(".account-settings-toogle"),
        account_settings = document.querySelector(".account-settings"),
        overlay = document.querySelector(".overlay");

    main_btn_add.addEventListener("click", function () {
        add_link.classList.add("add-link-visible");
        document.body.classList.add("no-scroll");
        overlay.classList.add("overlay-visible");
    });

    add_link_disable.addEventListener("click", function () {
        add_link.classList.remove("add-link-visible");
        document.body.classList.remove("no-scroll");
        overlay.classList.remove("overlay-visible");
    });

    account_settings_toogle.addEventListener("click", function () {
        account_settings.classList.contains("account-settings-visible")
            ? (this.classList.remove("account-settings-toogle-visible"),
              overlay.classList.remove("overlay-visible"),
              account_settings.classList.remove("account-settings-visible"),
              add_link.classList.remove("add-link-visible"),
              document.body.classList.remove("no-scroll"))
            : (this.classList.add("account-settings-toogle-visible"),
              overlay.classList.add("overlay-visible"),
              account_settings.classList.add("account-settings-visible"),
              document.body.classList.add("no-scroll"));
    });

    overlay.addEventListener("click", function () {
        account_settings_toogle.classList.remove("account-settings-toogle-visible");
        account_settings.classList.remove("account-settings-visible");
        add_link.classList.remove("add-link-visible");
        document.body.classList.remove("no-scroll");
        this.classList.remove("overlay-visible");
    });
});
