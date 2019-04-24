function sortColumn (columnName, currentOrder, artistID, source) {
	$.ajax ({
		url: "functions/sort_artistAlbums.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistID=" + artistID + "&source=" + source,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}