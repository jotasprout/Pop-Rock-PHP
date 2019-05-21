function sortColumn (columnName, currentOrder, artistSpotID, source) {
	$.ajax ({
		url: "functions/sort_artistTracksLastFM.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistSpotID=" + artistSpotID + "&source=" + source,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}