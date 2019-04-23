function sortColumn (columnName, currentOrder, artistID) {
	$.ajax ({
		url: "functions/sort_artistAlbums.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}