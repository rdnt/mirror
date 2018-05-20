$(window).on("load", function() {
    asyncFormSubmission("#update", "https://api.wunderground.com/api/0bf2659b77990290/conditions/q/GR/Kerkyra.json", potato, potato, 500, 1200);



});


var slider = document.getElementById("slider");
var mirror = document.getElementById("mirror");

var time = document.getElementById("time");
var date = document.getElementById("date");

function potato(data) {
    console.log(data);
}

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
    time.innerHTML = ("0"+d.getHours()).slice(-2) + ":" + ("0"+d.getMinutes()).slice(-2);
    date.innerHTML = day[d.getDay()] + "<br>" + month[d.getMonth()] + " " + d.getDate();
}

//update();
window.setInterval(function(){
    update();
    console.log("updated");



}, 1000);
/*
$.ajax({
                url: "https://api.wunderground.com/api/0bf2659b77990290/conditions/q/GR/Kerkyra.json",
                dataType: 'jsonp',
                success: function(results) {
                    //console.log(results);
                    console.log(results);
                    var temp = results.current_observation.temp_c;
                    document.getElementById("temp").innerHTML = temp + '°';
                    var date = new Date();
                    var hour = date.getHours();
                    var icon = results.current_observation.icon;
                    if (hour > 6 && hour < 21) {
                        document.getElementById("icon").src = '/weather/day/' + icon + '.png';
                    } else {
                        document.getElementById("icon").src = '/weather/night/' + icon + '.png';
                    }
                }
            });
*/
