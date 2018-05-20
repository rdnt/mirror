var slider = document.getElementById("slider");
var mirror = document.getElementById("mirror");

var time = document.getElementById("time");
var date = document.getElementById("date");


slider.oninput = function() {
    mirror.style.setProperty("font-size", (this.value/100) + "em");
}

var day = new Array(7);
day[0] =  "Sunday";
day[1] = "Monday";
day[2] = "Tuesday";
day[3] = "Wednesday";
day[4] = "Thursday";
day[5] = "Friday";
day[6] = "Saturday";

var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";

function update() {
    var d = new Date();
    time.innerHTML = d.getHours() + ":" + d.getMinutes();
    date.innerHTML = day[d.getDay()] + "<br>" + month[d.getMonth()] + " " + d.getDate();
}

update();
window.setInterval(function(){
    update();
}, 1000);
