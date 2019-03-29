function sortColumn (columnName, currentOrder) {
	$.ajax ({
		url: "functions/sortTheseArtists.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}