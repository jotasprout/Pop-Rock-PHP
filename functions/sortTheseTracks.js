function sortColumn (columnName, columnOrder, artistID) {
	$.ajax ({
		url: "functions/sortTheseTracks.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}