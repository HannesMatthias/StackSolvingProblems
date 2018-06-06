$(document).ready(function() {

		$(document).on('click', '#einloggen', function () {
			
			box = $("#loginBox");
			box.toggleClass("active");
		});


		$(document).on('click', '#profile', function () {
			
			box = $("#usermenu");
			box.toggleClass("active");

		});
});

