function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sortTheseArtists.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}