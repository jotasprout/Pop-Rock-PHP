function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "sortTheseAlbums.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}