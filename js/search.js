// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

$(document).ready(function() {
	$("#suche").keyup(handleSearchKeyUp);
});
function handleSearchKeyUp() {
	if (this.value != '') {
		// add some division after the search box to display the results
		// but only add, if not already there
		if ($('#searchhints').size() == 0) {
			$('#suche').parent().after('<div id="searchhints"></div>');
			var offset = $('#suche').offset();
			offset.top += $('#suche').outerHeight(true);
			$('#searchhints').offset(offset);
			$('#searchhints').hide().slideDown(300);
		}
		term = this.value;
		$.post('js/searchhints.php', {query: term}, insertHints);
	}
	else {
		$('#searchhints').slideUp(300, function() {$('#searchhints').remove();});
	}
}
function insertHints(data) {
	$('#searchhints').slideUp(200, function() {
		$('#searchhints').contents().replaceWith(data);
		$('#searchhints').slideDown(200);
	});
}
