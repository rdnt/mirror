var slider = document.getElementById("slider");
var mirror = document.getElementById("mirror").style;

// Update the current slider value (each time you drag the slider handle)
slider.oninput = function() {
    mirror.setProperty("font-size", (this.value/100) + "em");
}
