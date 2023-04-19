function clock() {
    var today = new Date();
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }
    document.getElementById("header__navbar-time").innerHTML = hours + ":" + minutes + ":" + seconds;
    setTimeout("clock()", 1000);
}

// mp3
document.getElementById('autoplay').play();




var contactSend = document.getElementById("contact-send");
// console.log(helpCenter);
contactSend.onclick = function () {
    alert("Thanks for contacting. We will process your request as soon as possible!");
}

var helpCenter = document.getElementById("footer-item__link-help");
// console.log(helpCenter);
helpCenter.onclick = function () {
    alert("Please connect to Facebook or send a message!");
}


var recruit = document.getElementById("footer-item-recruit");
recruit.onclick = function () {
    alert("Currently there is no information about recruitment!");
}

var rules = document.getElementById("footer-item-rules");
rules.onclick = function () {
    alert("Work hard, play hard!");
}



// UI Moblie ~ iphone 12pro, iphone 6-7-8plus ...vv

var header = document.getElementById('header__height');
console.log(header);


var mobileMenu = document.getElementById('mobile-menu');
console.log(mobileMenu);


var headerHeight = header.clientHeight;
//Dong/mo mobile menu
mobileMenu.onclick = function () {
    var isClosed = header.clientHeight === headerHeight;
    if (isClosed) {
        header.style.height = 'auto';
    }
    else {
        header.style.height = null;
    }
}


//Tu dong dong khi chon menu
var menuItems = document.querySelectorAll('#header__height  li a[href*="#"]');
// console.log(menuItems)
for (var i = 0; i < menuItems.length; i++) {
    var menuItem = menuItems[i];
    // console.log(menuItem);
    menuItem.onclick = function () {
        header.style.height = null;
    }
}








