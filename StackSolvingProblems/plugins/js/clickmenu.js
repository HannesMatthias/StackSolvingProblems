$(document).ready(function() {

		$(document).on('click', '#einloggen', function () {
			
			//box = $(this).closest('#einloggen').find('#loginBox');
			box = $("#loginBox");
			box.toggleClass("active");

		});


		$(document).on('click', '#profile', function () {
			
			box = $("#usermenu");
			box.toggleClass("active");

		});
});

