/**
* Author: TripleP
* Target: apply.php
* Purpose: Count down clock
* Last updated: 19 May 2023
* Credits:
*/

function randomProfileImage() {
    var profileImage = document.getElementById("profile-image");
    var random = getRndInteger(1, 5);
    if (profileImage) {
        profileImage.src = `images/MyPhoto${random}.jpg`;
    }
}

function getRndInteger(min, max) {
    // https://www.w3schools.com/js/js_random.asp
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

//------------------------------

// https://codepen.io/timjackleus/pen/rjmxpW
const countDownClock = (number = 100, format = "seconds") => {
    const hoursElement = document.getElementById("hours");
    const minutesElement = document.getElementById("minutes");
    const secondsElement = document.getElementById("seconds");
    let countdown;
    convertFormat(format);
    
    function convertFormat(format) {
        switch (format) {
            case "seconds":
                return timer(number);
            case "minutes":
                return timer(number * 60);
            case "hours":
                return timer(number * 60 * 60);
        }
    }
  
    function timer(seconds) {
        const now = Date.now();
        const then = now + seconds * 1000;

        countdown = setInterval(() => {
            const secondsLeft = Math.round((then - Date.now()) / 1000);

            if (secondsLeft <= 0) {
                clearInterval(countdown);

                window.location = "index.php";
                return;
            };

            displayTimeLeft(secondsLeft);
        }, 1000);
    }
  
    function displayTimeLeft(seconds) {
        if (secondsElement) {
            let hoursValue = Math.floor((seconds % 86400) / 3600);
            let minutesValue = Math.floor((seconds % 86400) % 3600 / 60);
            let secondsValue = seconds % 60;

            hoursElement.textContent = hoursValue < 10 ? `0${hoursValue}` : hoursValue;
            minutesElement.textContent = minutesValue < 10 ? `0${minutesValue}` : minutesValue;
            secondsElement.textContent = secondsValue < 10 ? `0${secondsValue}` : secondsValue;
        }
    }
}

var prevHandler = window.onload;
window.onload = function () {
    if (prevHandler) {
        prevHandler();
    }
    
    randomProfileImage();

    /*
    start countdown
    enter number and format
    hours, minutes or seconds
    */
    countDownClock(10, "minutes");
};