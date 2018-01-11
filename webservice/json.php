<?php
include "db.php";
header('Access-Control-Allow-Origin: *'); 
$data=array();
$q=mysqli_query($con,"select * from `course_details`");
while ($row=mysqli_fetch_object($q)){
 $data[]=$row;
}
echo json_encode($data);
?>