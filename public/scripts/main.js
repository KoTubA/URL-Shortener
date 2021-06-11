document.addEventListener("DOMContentLoaded", () => {
    const nav_toggler = document.querySelector(".mobile-nav-toogle"),
        nav = document.querySelector(".nav"),
        overlay = document.querySelector(".overlay");

    nav_toggler.addEventListener("click", function () {
        nav.classList.contains("nav-visible")
            ? (nav.classList.remove("nav-visible"), overlay.classList.remove("overlay-visible"), document.body.classList.remove("no-scroll"))
            : (nav.classList.add("nav-visible"), overlay.classList.add("overlay-visible"), document.body.classList.add("no-scroll"));
    });

    overlay.addEventListener("click", function () {
        nav.classList.remove("nav-visible");
        overlay.classList.remove("overlay-visible");
        document.body.classList.remove("no-scroll");
    });
});
