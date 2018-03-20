<?php
	$conn = mysqli_connect("localhost", "root", "", "blog_samples");
	
	$orderBy = "post_at";
	$order = "asc";
	
	$sql = "SELECT * from posts ORDER BY post_at desc";
	$result = mysqli_query($conn,$sql);
?>
<html>
	<head>
    <title>jQuery Ajax Column Sort</title>		
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<style>
	.table-content{border-top:#CCCCCC 4px solid; width:50%;}
	.table-content th {padding:5px 20px; background: #F0F0F0;vertical-align:top;cursor:pointer;} 
	.table-content td {padding:5px 20px; border-bottom: #F0F0F0 1px solid;vertical-align:top;} 
	.column-title {text-decoration:none; color:#09f;}
	</style>
	</head>
	
	<body>
    <div class="demo-content">
		<h2 class="title_with_link">jQuery Ajax Column Sort</h2>
  <div id="demo-order-list">
	 
<?php if(!empty($result))	 { ?>
<table class="table-content">
          <thead>
        <tr>
          <th width="30%" onClick="orderColumn('post_title','asc')"><span>Post Title</span></th>
		  <th width="50%" onClick="orderColumn('description','asc')"><span>Description</span></th>          
		  <th width="20%" onClick="orderColumn('post_at','asc')"><span>Post Date</span></th>	  	  
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
  </div>
  </div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function orderColumn(column_name,column_order) {
	$.ajax({
		url: "order-column.php",
		data:'orderby='+column_name+'&order='+column_order,
		type: "POST",
		/*beforeSend: function(){
			$('#links-'+id+' .btn-votes').html("<img src='LoaderIcon.gif' />");
		},*/
		success: function(data){	
			$('#demo-order-list').html(data);
		}
	});
}
</script>  
</body></html>
