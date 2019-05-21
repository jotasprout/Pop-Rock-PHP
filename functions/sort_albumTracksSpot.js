function sortColumn (columnName, currentOrder, albumSpotID, source) {
	$.ajax ({
		url: "functions/sort_albumTracksSpot.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&albumSpotID=" + albumSpotID + "&source=" + source,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}