function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sortTheseArtistsGenres.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}