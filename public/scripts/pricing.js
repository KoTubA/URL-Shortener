document.addEventListener("DOMContentLoaded", () => {
    const switch_input = document.querySelector(".switch-input");
    const pricing_switch_cost = document.querySelectorAll(".pricing-switch-cost-cnt");

    switch_input.addEventListener("click", () => {
        for (let ele of pricing_switch_cost) {
            ele.classList.toggle("isYearly");
        }
    });
});
