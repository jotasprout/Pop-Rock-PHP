function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sortTheseAlbums.php",
		data: "sortThisColumn=" + columnName + "&currentOrder=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}