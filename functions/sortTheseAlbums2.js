function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sortTheseAlbums2.php",
		data: "sortThisColumn=" + columnName + "&currentOrder=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}