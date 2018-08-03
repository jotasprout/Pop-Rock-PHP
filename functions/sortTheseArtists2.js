function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sortTheseArtists2.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}