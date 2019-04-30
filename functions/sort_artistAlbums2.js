function sortColumn (columnName, currentOrder, artistSpotID) {
	$.ajax ({
		url: "functions/sort_artistAlbums2.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistSpotID=" + artistSpotID,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}