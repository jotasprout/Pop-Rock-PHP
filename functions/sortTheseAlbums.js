console.log ("I am in the sorting Albums JS file")

function sortColumn (columnName, columnOrder, artistID) {
	console.log("I am in the sorting Albums JS function and the artist is " + artistID);
	$.ajax ({
		url: "functions/sortTheseAlbums.php",
		data: "sortThisColumn=" + columnName + "&currentOrder=" + columnOrder + "&artistID=" + artistID,
		type: "POST",
		success: function (data) {
			$("#recordCollection").html(data);
		}
	});
}