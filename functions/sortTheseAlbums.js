function sortColumn (columnName, currentOrder, artistID) {
	$.ajax ({
		url: "functions/sortTheseAlbums.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}