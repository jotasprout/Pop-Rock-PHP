function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "sortTheseArtists.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}