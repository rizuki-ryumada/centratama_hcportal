// // Ryu Development Area
$(document).ready(function () {
	$(document).on('mouseenter', '#myTask-list', function () {
		$(this).find("#myTask-button").show();
	}).on('mouseleave', '#myTask-list', function () {
		$(this).find("#myTask-button").hide();
	});
});