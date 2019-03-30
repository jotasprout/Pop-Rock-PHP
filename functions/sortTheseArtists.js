function sortColumn (columnName, currentOrder) {
	console.log ("Column name is " + columnName + " and the current order is " + currentOrder);
	$.ajax ({
		url: "functions/sortTheseArtists.php",
		data: "columnName=" + columnName + "&currentOrder=" + currentOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}