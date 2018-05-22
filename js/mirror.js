$(window).on("load", function() {
    pass = true;
    asyncFormSubmission("#refresh", "/backend/refresh", init, refreshWeatherData, 0, 0);
    window.setInterval(function(){
        updateTimeAndDate();
    }, 1000);

    window.setInterval(function(){
        $("#refresh-btn").click();
    }, 60000);

    window.setTimeout(function(){
        $("#mirror").addClass("cursor-less");
        window.onmousemove = function(e){
            $("#mirror").removeClass("cursor-less");
        }
    }, 1000);

});

function init() {}

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function refreshWeatherData(data) {
    console.log(data);
    if (data['response'] === "SUCCESS") {
        $("#location").html(data['data']['location']);
        $("#weather-icon").attr("src", "/images/weather/" + data['data']['icon'] + ".png");
        $("#temperature").html(data['data']['temperature']);

        var temp;
        if (data['data']['celsious']) {
            temp = data['data']['temperature']  - 273.15;
        }
        else {
            temp = data['data']['temperature'] * 9/5 - 459.67;
        }
        $("#temperature").html(temp + "°");

        var today = data['data']['day1'];
        var tomorrow = data['data']['day2'];
        var phrase;
        if (today == tomorrow) {
            phrase = ucfirst(today) + " tonight and tomorrow morning";
        }
        else {
            phrase = ucfirst(today) + " tonight and " + tomorrow + " tomorrow morning";
        }
        $("#weather-status").html(phrase);
        $("#precipitation").html(data['data']['humidity'] + "%");

        var date = new Date();
        var diff = parseInt(((date.getTime()/1000) - data['data']['last-checked'])/60);
        var minutes = " minutes";
        if (diff == 0) {
            $("#last-updated").html("Last updated: just now");
        }
        else if (diff == 1) {
            $("#last-updated").html("Last updated: 1 minute ago");
        }
        else {
            $("#last-updated").html("Last updated: " + parseInt(diff) + " minutes ago");
        }
    }

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

function updateTimeAndDate() {
    var date = new Date();
    $("#time").html(("0"+date.getHours()).slice(-2) + ":" + ("0"+date.getMinutes()).slice(-2));
    $("#date").html(day[date.getDay()] + "<br>" + month[date.getMonth()] + " " + date.getDate());
}
