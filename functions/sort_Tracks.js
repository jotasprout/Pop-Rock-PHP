function sortColumn (columnName, currentOrder, artistSpotID) {
	$.ajax ({
		url: "functions/sort_Tracks.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistSpotID=" + artistSpotID,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}