function sortColumn (columnName, currentOrder, artistID) {
	$.ajax ({
		url: "functions/sort_Tracks2.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}