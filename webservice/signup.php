<?php   header('Access-Control-Allow-Origin: *'); 
include('con1.php');
include('function_file.php');

$inserttime=date("Y-m-d H:i:s");
   
if(!$_POST)
{
$record=array('success'=>'false',
 'msg' =>'Please use post method !!!'); 
$data = json_encode($record);
echo $data;
return;
}
 
if(empty($_POST['flag']))
{
$record=array('success'=>'false',
 'msg' =>'Please send flag!!'); 
$data = json_encode($record);
echo $data;
return;

}

if(empty($_POST['device_type']))
{
$record=array('success'=>'false',
 'msg' =>'Please send device type!'); 
$data = json_encode($record);
echo $data;
return;
}

if(empty($_POST['player_id']))
{
$record=array('success'=>'false',
 'msg' =>'Please send player_id!'); 
$data = json_encode($record);
echo $data;
return;
}

if(empty($_POST['email']))
{
$record=array('success'=>'false',
 'msg' =>'Please send email!!'); 
$data = json_encode($record);
echo $data;
return;
}

$device_type= $_POST['device_type'];
$player_id= $_POST['player_id'];


if($_POST['flag'] == 'app')
{
include("mailFunction.php");
  if(empty($_POST['password']))
    {
      $record=array('success'=>'false',
       'msg' =>'Please send password!!'); 
      $data = json_encode($record);
      echo $data;
      return;
    }
  $email= $_POST['email'];
  $email=strtolower($email);
  $password= $_POST['password'];
  $flag= $_POST['flag'];
  
  //---------------------------check email-----------------------------------------------
  $select= $mysqli->prepare("Select email from user_master where email=?");
  $select->bind_param("s", $email );
  $select->execute();
  $select->store_result();
  $select_check=$select->num_rows;
  if($select_check>0)
  {
  $record=array('success'=>'false','msg'=>'This email is already signup.');
  $data = json_encode($record);
  echo $data;
  return;
  }
  
    //---------------------------check email and deactive status-----------------------------------------------
  $deactive_account="yes";
  $check_user_status= $mysqli->prepare("Select email from user_master where email=? and deactive_account=?");
  $check_user_status->bind_param("ss", $email, $deactive_account);
  $check_user_status->execute();
  $check_user_status->store_result();
  $check_user_status_check=$check_user_status->num_rows;
  if($check_user_status_check>0)
  {
  $record=array('success'=>'false','msg'=>'This is Invalid signup.');
  $data = json_encode($record);
  echo $data;
  return;
  }
  else
  {

  //$select->bind_result($email);
  //$select->fetch();
 
   /*-------------------------------end----------------------------*/
$insert_user=$mysqli->prepare("INSERT INTO user_master(email,password,flag,insertime) VALUES(?,?,?,?)");
$insert_user->bind_param("ssss", $email, $password, $flag, $inserttime);
$insert_user->execute();
     $insert_user_check=$insert_user->affected_rows;
    if($insert_user_check>0){
        $email= $_POST['email'];
        $user_id= $mysqli->insert_id;
        $sentLink="https://connectd.eu/app/webservice";
        $link=$sentLink."/activate_account.php?user_id=".base64_encode($user_id);
        $fromName= "Connectd";
        $subject = "Connectd: Verify Your Email";
        $subject1 = "Connectd:User Signup Email";
      
        $mailBody = mailBodyMailverify($email,$link);
        $status = mailSend($email, $fromName, $subject, $mailBody);
        
        if( $status == 'yes' ) {
            
        //---------------------- store player id section --------------------
        $result = DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);
        if($result == 'no')
        {
          $record=array('success'=>'false', 'msg' =>'Internal server error, Please try again!!'); 
          $data = json_encode($record);
          echo $data;
          return;
        }

            $record=array('success'=>'true','msg'=>'Signup successfully.Check your email to activate your Account.'); 
            $data = json_encode($record);
            echo $data;
            return;
        }
        else {
        $record=array('success'=>'false','msg'=>'Signup successfully completed but mail could not be sent...'); 
            $data = json_encode($record);
            echo $data;
            return;
        }
        
    }
    else{
        $record=array('success'=>'false','msg'=>'Signup un-successfully try again.'); 
        $data = json_encode($record);
        echo $data;
        return;
    }
}
}
//---------------------------sign up with facebook---------------------------------

if($_POST['flag'] == 'facebook'){
  $email= $_POST['email'];
  $flag= $_POST['flag'];
  $active_flag= "yes";
  //------------------------------- check email --------------------------------------------
  $select= $mysqli->prepare("Select email from user_master where email=?");
  $select->bind_param("s", $email );
  $select->execute();
  $select->store_result();
  $select_check=$select->num_rows;
  if($select_check>0)
  {
  $record=array('success'=>'false','msg'=>'This email is already in use.');
  $data = json_encode($record);
  echo $data;
  return;
  }

    $insert_user= $mysqli->prepare("INSERT INTO user_master(email, flag, active_flag, insertime) VALUES (?,?,?,?)");
    $insert_user->bind_param("ssss", $email, $flag, $active_flag, $inserttime);
    $insert_user->execute();
    $insert_user_check=$mysqli->affected_rows;
    if($insert_user_check>0){
    $user_id= $mysqli->insert_id;
       
        
        //---------------------- store player id section --------------------
        $result = DeviceTokenStore_1_Signal($user_id, $device_type, $player_id);
        if($result == 'no')
        {
          $record=array('success'=>'false', 'msg' =>'Internal server error, Please try again!!'); 
          $data = json_encode($record);
          echo $data;
          return;
        }
        
        $record=array('success'=>'true','msg'=>'You have successfully signed up','user_id'=>$user_id); 
        $data = json_encode($record);
        echo $data;
        return;
      
    }
    else{
      $record=array('success'=>'false','msg'=>'Signup un-successfully try again.','user_id'=>$user_id); 
      $data = json_encode($record);
      echo $data;
      return;
    }
}
?>