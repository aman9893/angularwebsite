<?php
	require_once("db.php");
	 header('Access-Control-Allow-Origin: *'); 
	if (isset($_POST['submit'])) {		

      $sql = $con->prepare("UPDATE course_details SET title=? , duration=? , price=?
	  WHERE id=?");
	  
        $title=$_POST['title'];
        $duration = $_POST['duration'];
		$price= $_POST['price'];

		$sql->bind_param("sssi",$title, $duration, $price,$_GET["id"]);	

		if($sql->execute()) {
			$success_message = "Edited Successfully";
		} else {
			$error_message = "Problem in Editing Record";
		}

	}

	$sql = $con->prepare("SELECT * FROM course_details WHERE id=?");

	$sql->bind_param("i",$_GET["id"]);

	$sql->execute();

	$result = $sql->get_result();


	if ($result->num_rows > 0) 
	{		
		$row = $result->fetch_assoc();
	}

	$con->close();
?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />

<title>employee edit </title>
</head>
<body>
<?php if(!empty($success_message)) { ?>
<div class="success message"><?php echo $success_message; ?></div>
<?php } if(!empty($error_message)) { ?>
<div class="error message"><?php echo $error_message; ?></div>
<?php } ?>
<form name="frmUser" method="post" action="">
<div class="button_link"><a href="view.php" >Back to List </a></div>
<table border="2" cellpadding="10"  cellspacing="0" width="500" align="center" class="tbl-qa">
	<thead>
		<tr>
			<th colspan="2" class="table-header">Employee Edit</th>
		</tr>
	</thead>
	<tbody>
		<tr class="table-row">
			<td><label>Department</label></td>
			<td><input type="text" name="title" class="txtField" value="<?php echo $row["title"]?>"></td>
		</tr>
		<tr class="table-row">
			<td><label>Name</label></td>
			<td><input type="text" name="duration" class="txtField" value="<?php echo $row["duration"]?>"></td>
		</tr>
		<tr class="table-row">
			<td><label>Email</label></td>
			<td><input type="text" name="price" class="txtField" value="<?php echo $row["price"]?>"></td>
		</tr>
		<tr class="table-row">
			<td colspan="2"><input type="submit"  name="submit" value="Submit" class="demo-form-submit"></td>
		</tr>
	</tbody>	
</table>
</form>
</body>
</html>

<html>
<head>
