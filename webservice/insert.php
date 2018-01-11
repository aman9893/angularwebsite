<?php
header('Access-Control-Allow-Origin: *'); 
include "db.php";

 
if(!$_POST)
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

 $title   =  $_POST['title'];
 $duration=  $_POST['duration'];
 $price   =  $_POST['price'];

 $insert_user =$con->prepare("insert into course_details(title ,duration,price) VALUES (?,?,?)");
 $insert_user->bind_param("sss",$title,$duration,$price);
 $insert_user->execute();
 $insert_user_check=$mysqli->affected_rows;
 
if($insert_user_check>0){
        $record=array('success'=>'true','msg'=>'You have successfully signed up','user_id'=>$user_id); 
        $data = json_encode($record);
        echo $data;
        return;
}else{
        $record=array('success'=>'false','msg'=>'Signup un-successfully try again.','user_id'=>$user_id); 
      $data = json_encode($record);
      echo $data;
      return;
}





