function sortColumn (columnName, currentOrder, albumMBID, source) {
	$.ajax ({
		url: "functions/sort_albumTracksLastFM.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&albumMBID=" + albumMBID + "&source=" + source,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}