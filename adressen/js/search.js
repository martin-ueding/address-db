$(document).ready(function() {
	$("#suche").keyup(handleSearchKeyUp);
});

function handleSearchKeyUp() {
	if (this.value != '') {
		// add some division after the search box to display the results
		// but only add, if not already there
		if ($('#searchhints').size() == 0)
			$('#suche').parent().after('<div id="searchhints">Trying to load hints</div>').hide().slideDown(200);
		term = this.value;
		$.post('js/searchhints.php', {query: term}, insertHints);
	}
	else {
		$('#searchhints').slideUp(300);
		setTimeout(function() {$('#searchhints').remove();}, 300);
	}
}

function insertHints(data) {
	$('#searchhints').contents().replaceWith(data);
}
