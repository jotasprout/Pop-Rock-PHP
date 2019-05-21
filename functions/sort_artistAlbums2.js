function sortColumn (columnName, currentOrder, artistSpotID, source) {
	$.ajax ({
		url: "functions/sort_artistAlbums2.php",
		data: "columnName=" + columnName + "&artistSpotID=" + artistSpotID + "&currentOrder=" + currentOrder + "&source=" + source,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
	//console.log("column is " + columnName + " and current order is " + currentOrder + " and artistSpotID is " + artistSpotID)
}