console.log ("I am in the javascript sorting file")

function sortColumn (columnName, columnOrder) {
	console.log("I am inside the function");
	$.ajax ({
		url: "functions/sortTheseTracks.php",
		data: "sortBy=" + columnName + "&order=" + columnOrder,
		type: "POST",
		success: function (data) {
			$("#tableotracks").html(data);
		}
	});
}