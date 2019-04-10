function sortColumn (columnName, currentOrder, artistID) {
	$.ajax ({
		url: "functions/sort_Tracks.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}