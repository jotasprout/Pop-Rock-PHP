<?php
	$conn = mysqli_connect("localhost", "root", "", "blog_samples");
	
	$orderBy = "post_at";
	$order = "asc";
	
	if(!empty($_POST["orderby"])) {
		$orderBy = $_POST["orderby"];
	}
	if(!empty($_POST["order"])) {
		$order = $_POST["order"];
	}
	
	$postTitleNextOrder = "asc";
	$descriptionNextOrder = "asc";
	$postAtNextOrder = "desc";
	
	if($orderBy == "post_title" and $order == "asc") {
		$postTitleNextOrder = "desc";
	}
	if($orderBy == "description" and $order == "asc") {
		$descriptionNextOrder = "desc";
	}
	if($orderBy == "post_at" and $order == "desc") {
		$postAtNextOrder = "asc";
	}

	$sql = "SELECT * from posts ORDER BY " . $orderBy . " " . $order;
	$result = mysqli_query($conn,$sql);
?>
<?php if(!empty($result))	 { ?>
<table class="table-content">
	<thead>
		<tr>
		  <th width="30%" onClick="orderColumn('post_title','<?php echo $postTitleNextOrder; ?>')"><span>Post Title</span></th>
		  <th width="50%" onClick="orderColumn('description','<?php echo $descriptionNextOrder; ?>')"><span>Description</span></th>
		  <th width="20%" onClick="orderColumn('post_at','<?php echo $postAtNextOrder; ?>')"><span>Post Date</span></th>	  
		</tr>
	</thead>
	<tbody>
	<?php
		while($row = mysqli_fetch_array($result)) {
	?>
		<tr>
			<td><?php echo $row["post_title"]; ?></td>
			<td><?php echo $row["description"]; ?></td>
			<td><?php echo $row["post_at"]; ?></td>
		</tr>
	<?php
		}
	?>
	<tbody>
</table>
<?php } ?>