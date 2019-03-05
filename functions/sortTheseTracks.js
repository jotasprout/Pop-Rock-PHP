console.log ("I am in the sorting Tracks JS file")

function sortColumn (columnName, columnOrder, artistID) {
	console.log("I am in the sorting Tracks JS function");
	$.ajax ({
		url: "functions/sortTheseTracks.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}