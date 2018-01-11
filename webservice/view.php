
<?php 
require_once("db.php");

$sql = "SELECT * FROM course_details";
$result = $con->query($sql);	
$con->close();		
?>

<html>
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="button_link"><a href="add.php">Add New</a></div>
	<table class="jumbotron continer">	
		<thead>
			 <tr>
				<th class="table-header" width="20%">Department </th>
				<th class="table-header" width="20%"> Name </th>
				<th class="table-header" width="20%"> Email </th>
				<th class="table-header" width="20%" colspan="2">Action</th>
			  </tr>
		</thead>
		<tbody>		
			<?php
				if ($result->num_rows > 0) {		
					while($row = $result->fetch_assoc()) {
			?>
			<tr class="table-row" id="row-<?php echo $row["id"]; ?>"> 
				<td class="table-row"><?php echo $row["title"]; ?></td>
				<td class="table-row"><?php echo $row["duration"]; ?></td>
				<td class="table-row"><?php echo $row["price"]; ?></td>
				<!-- action -->
				<td class="table-row" colspan="2">

					<a href="update2.php?id=<?php echo $row["id"]; ?>" class="link"><img title="Edit" src="icon/edit.png"/></a>

					 <a href="delete.php?id=<?php echo $row["id"]; ?>" class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png"/></a></td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</body>
</html>