function sortColumn (columnName, columnOrder) {
	$.ajax ({
		url: "functions/sort_genresMBLastFM.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableoartists").html(data);
		}
	});
}