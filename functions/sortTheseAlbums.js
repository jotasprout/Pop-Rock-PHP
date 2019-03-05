function sortColumn (columnName, columnOrder, artistID) {
	$.ajax ({
		url: "functions/sortTheseAlbums.php",
		data: "sortThisColumn=" + columnName + "&currentOrder=" + columnOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}