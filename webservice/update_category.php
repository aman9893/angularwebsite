<?php  header('Access-Control-Allow-Origin: *'); 
include('con1.php');
include('mailFunction.php');
include('function_file.php');

if(!$_GET)
{
$record=array('success'=>'false',
 'msg' =>'Please use get method !!!'); 
$data = json_encode($record);
echo $data;
return;
}
if(empty($_GET['user_id']))
{
$record=array('success'=>'false',
 'msg' =>'Please send user_id!!'); 
$data = json_encode($record);
echo $data;
return;
}
if(empty($_GET['user_id']))
{
$record=array('success'=>'false',
 'msg' =>'Please send user_id!!'); 
$data = json_encode($record);
echo $data;
return;
}
if(empty($_GET['category_name']))
{
$record=array('success'=>'false',
 'msg' =>'Please send category_name!!'); 
$data = json_encode($record);
echo $data;
return;
}

$user_id=$_GET['user_id'];
$category_name=$_GET['category_name'];
$inserttime=date("Y-m-d H:i:s"); 


//-------------------check user id----------------------------------------------
$select= $mysqli->prepare("Select user_id from user_master where user_id=?");
$select->bind_param("i", $user_id );
$select->execute();
$select->store_result();
$select_check=$select->num_rows;
if($select_check<0)
{
$record=array('success'=>'false','msg'=>'User Id does not exists.');
$data = json_encode($record);
echo $data;
return;
}

//delete category from user category master
$stmt=$mysqli->prepare("delete from user_category_master WHERE `user_id` = ?"); 
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt=$mysqli->affected_rows;
if($stmt>0)
{
//insert into user_image_master
$insert= $mysqli->prepare("INSERT INTO user_category_master(user_id,category_name,inserttime) VALUES (?,?,?)");
$insert->bind_param("iss", $user_id,$category_name,$inserttime);
$insert->execute();
$insert_check=$mysqli->affected_rows;
if($insert_check>0)
{
    $record=array('success'=>'false','msg'=>'Category updated successfully.'); 
    $data = json_encode($record);
    echo $data;
    return;
}
else
{
    $record=array('success'=>'true','msg'=>'Category not updated successfully.'); 
    $data = json_encode($record);
    echo $data;
    return;
}

}
