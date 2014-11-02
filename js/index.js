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

    $('.sectionTrigger').click('a', function(event) {
        var section = $(event.target).attr('href');

        page.showSection(section);
        page.setNav(section);

        localStorage.setItem('lastSection', section);
    });

    var lastSection = localStorage.getItem('lastSection');
	if(lastSection) {
        page.showSection(lastSection);
        page.setNav(lastSection);
    }

});

var page = {
    showSection: function (section) {
        $('.section').addClass('hidden');
        $(section).removeClass('hidden');
    },
    setNav: function (section) {
        $('.sectionTrigger li.active').removeClass('active');
        $('a[href="'+section+'"]').parent('li').addClass('active');
    }
};