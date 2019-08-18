function sortColumn (columnName, columnOrder, source) {
	$.ajax ({
		url: "functions/sort_genres.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder + "&source" + source,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}