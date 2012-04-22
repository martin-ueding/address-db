// Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

var moving = false;
var hidden = true;

var speed = 200;

var pictureMouseClick = function () {
	console.log("pictureMouseEnter()");
	if (moving) {
		return;
	}
	if (hidden) {
		moveLeft(function () { show(moveRight); }); 
	}
	else {
		moveLeft(function () { hide(moveRight); }); 
	}
};

var show = function(callback) {
	console.log("show()");
	hidden = false;
	$('#pers_bild').animate({
		'z-index': 1000,
	}, 0, callback);
};

var hide = function(callback) {
	console.log("hide()");
	hidden = true;
	$('#pers_bild').animate({
		'z-index': 10,
	}, 0, callback);
};

var moveLeft = function(callback) {
	moving = true;
	console.log("moveLeft()");
	$('#pers_bild').animate({
		left: "1000px",
	}, speed, callback);
};

var leftPos = 0;

var moveRight = function(callback) {
	console.log("moveRight()");
	console.log(leftPos);
	$('#pers_bild').animate({
		left: leftPos+'px',
	}, speed, moveDone);
};

var moveDone = function () {
	moving = false;
};


var pictureMain = function() {
	leftPos = $('#pers_bild').position().left;
	console.log("pictureMain()");1
	$('#pers_bild').click(pictureMouseClick);
};

$(pictureMain);
