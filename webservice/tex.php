<?php
header('Access-Control-Allow-Origin: *'); 
 include "db.php";

 if(isset($_POST['insert']))
 {
 $title=$_POST['title'];
 $duration=$_POST['duration'];
 $price=$_POST['price'];

  $insert_user=$mysqli->prepare("insert into course_details(title ,duration,price) VALUES (?,?,?)");
  $insert_user->bind_param("sss",$title,$duration,$price);

$insert_user->execute();
 if($insert_user)
  echo "success";
 else
  echo "error";
 }

 ?>
 $(document).ready(function()
 {
 $("#insert").click(function(){

 var title=$("#title").val();
 var duration=$("#duration").val();
 var price=$("#price").val();


 var dataString="title="+title+"&duration="+duration+"&price="+price+"&insert=";

 if($.trim(title).length>0 & $.trim(duration).length>0 & $.trim(price).length>0)
 {
 $.ajax({
 type: "POST",
 url:"insert.php",
 data: dataString,
 crossDomain: true,
 cache: false,

 success: function(data){

 alert("inserted"+data);
// $("#insert").val('submit');

 }
 });

 });
 });<?php
 include "db.php";
 if(isset($_POST['insert']))
 {
 $title=$_POST['title'];
 $duration=$_POST['duration'];
 $price=$_POST['price'];
 $q=mysqli_query($con,"INSERT INTO `course_details` (`title`,`duration`,`price`)

  VALUES

  ('$title','$duration','$price')");


 if($q)
  echo "success";
 else
  echo "error";
 }
 ?>

$data=array();
$q=mysqli_query($con,"select * from `course_details`");


while ($row=mysqli_fetch_object($q)){


 $data[]=$row;
}

echo json_encode($data);

?>

$inserttime=date("Y-m-d H:i:s");



if(!$_POST){
{
  $record=array('success'=>'false',
 'msg' =>'Please use post method !!!'); 
  $data = json_encode($record);
  echo $data;
  return;
}
 
if(empty($_POST['title']))
{
$record=array('success'=>'false',
 'msg' =>'Please send title!!'); 
$data = json_encode($record);
echo $data;
return;
}

if(empty($_POST['duration']))
{
$record=array('success' =>'false',
'msg'=>'Please send the duration');
$data=json_encode($record);
echo "$data";
return;

}
if(empty($_POST['price'])){

	$record = array('success' => 'false',
	'msg'=> 'plese send the price' );
	$data=json_encode($record);
	echo "$data";
	return;
}
}



<?php 
require_once("db.php");
 header('Access-Control-Allow-Origin: *'); 
$sql = "SELECT * FROM course_details";
$result = $con->query($sql);	
$con->close();		
?>

<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<title>Employee</title>
</head>
<body>
	<div class="button_link"><a href="add.php">Add New</a></div>
	<table class="tbl-qa">	
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

					<a href="update2.php?id=<?php echo $row["id"]; ?>" 
						class="link">

						<img title="Edit" src="icon/edit.png"/></a>

					 <a href="delete.php?id=<?php echo $row["id"]; ?>"
					  class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm('Are you sure you want to delete?')" src="icon/delete.png"/></a></td>
			</tr>
			<?php
					}
				}
			?>
		</tbody>
	</table>
</body>
</html


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
