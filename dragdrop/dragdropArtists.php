<?php 
    //require "functions/class.artist.php";
    require_once '../data_text/artists_groups.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Drag-n-Drop</title>

    <script src='https://code.jquery.com/jquery-3.3.1.min.js'></script>
    <script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
    <script src='https://d3js.org/d3.v4.min.js'></script>

    <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>   
    <link rel='stylesheet' href='dragDrop.css'>
	<link rel='stylesheet' href='lineGraphStyles.css'>
</head>

<body>

<h3>From Here</h3>
<div id="dragFrom"></div> <!-- close dragFrom -->

<h3>To Here</h3>
<div id="dropTo"></div> <!-- close dropTo -->

<script>

d3.json("getChoices.php", function (dataset) {
    console.log("hi");
    console.log(dataset);
});

</script>





<script src="https://www.roxorsoxor.com/poprock/dragdrop/dragdrop.js"></script>
</body>
</html>