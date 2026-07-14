document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector(".weather-slider");

    if (slider) {
        slider.addEventListener("wheel", e => {
            e.preventDefault();
            slider.scrollLeft += e.deltaY;
        });
    }
});
