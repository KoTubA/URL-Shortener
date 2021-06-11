document.addEventListener("DOMContentLoaded", () => {
    const rescources_items_filter_element = document.querySelectorAll(".rescources-items-filter-element");
    const resources_item = document.querySelectorAll(".resources-item");

    for (let ele of rescources_items_filter_element) {
        ele.addEventListener("click", filter_element);
    }

    function filter_element() {
        let classItem = "-" + this.className.split(" ")[1];

        for (let ele of resources_item) {
            ele.classList.add("resources-item-section-invisible");
        }

        if (classItem === "-all-types") classItem = "";
        console.log(".resources-item" + classItem);

        const resources_items = document.querySelectorAll(".resources-item" + classItem);
        for (let ele of resources_items) {
            ele.classList.remove("resources-item-section-invisible");
        }
    }
});
