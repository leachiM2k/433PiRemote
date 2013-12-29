var ajaxUrl = 'doAction.php';

$(document).ready(function() {

	$('.switch').click(function(event) {
		event.preventDefault();

		var href = $(event.target).attr('href');

		$.getJSON(ajaxUrl + href , "", function(data) {
			var color = '#880000';
			if(data.result == "success") {
				var color = '#008800';
			}
			$('.container').parent().animate({backgroundColor:color}, 250).animate({backgroundColor:'transparent'}, 250);
		});
	});
	
});
