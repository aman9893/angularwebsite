<?php
header('Access-Control-Allow-Origin: *');
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

$user_id=$_GET['user_id'];

$result = UpdateActiveTime($user_id);

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
//---------------------get user details----------------------------

$select_info= $mysqli->prepare(
  "Select name,email,age,gender,image,online_status,location,latitude,longitude from user_master where user_id=?");

$select_info->bind_param("i", $user_id );
$select_info->execute();
$select_info->store_result();
$select_info_check=$select_info->num_rows;
if($select_info_check>0)
{
  $select_info->bind_result
  ($name,$email,$age,$gender,$image,$online_status,$location,$latitude,$longitude);
  $select_info->fetch();

  if($name=='')
  {
    $name='NA';
  }
  if($age=='')
  {
    $age='NA';
  }
  if($gender=='')
  {
    $gender='NA';
  }
  if($online_status=='')
  {
    $online_status='NA';
  }
  if($location=='')
  {
    $location='NA';
  }
  if($latitude=='')
  {
    $latitude='NA';
  }
  if($longitude=='')
  {
    $longitude='NA';
  }
  if($image=='')
  {
    $image='NA';
 }
    $onlinestatus=get_user_online_status($user_id);
    $connectdstatus=get_user_connectd_status($user_id);
    $distancestatus=get_user_distance_status($user_id);
    $userblockstatus=CheckBlockUser($user_id);
    if($userblockstatus=='yes')
    {
        $user_block_status='block';
    }
    else
    {
        $user_block_status='unblock';
        
    }
    if($onlinestatus=='yes')
    {
    $online_status='online';
    
    }
    else
    {
    $online_status='offline';
    }
  $personal_detail_arr=array('name'=>$name,'email'=>$email,'age'=>$age,'gender'=>$gender,'image'=>$image,'latitude'=>$latitude,'longitude'=>$longitude,'location'=>$location,'online_status'=>$online_status,'connectd_status'=>$connectdstatus,'distance_status'=>$distancestatus,'block_status'=>$user_block_status);
}
else
{
$personal_detail_arr="NA";
}
//-------------------get about---------------
$select_about= $mysqli->prepare("Select user_about_id,about,hashtag from user_about_master where user_id=?");
$select_about->bind_param("i", $user_id );
$select_about->execute();
$select_about->store_result();
$select_about_check=$select_about->num_rows;
if($select_about_check>0)
{
  $select_about->bind_result($user_about_id,$about,$hashtag);
  $select_about->fetch();
  if($about=='')
  {
    $about='NA';
  }
  if($hashtag=='')
  {
    $hashtag='NA';
  }
$about_detail_arr=array('about'=>$about,'hashtag'=>$hashtag);
}
else
{
$about_detail_arr="NA";
}

//get details
$select_details= $mysqli->prepare("select body_type,body_shape,height,hair_color,eye_color,relationship_status,intention,orientation,school,occupation,income,children,ethnicity,religion,sign,smokes,drinks,drugs from user_detail_master where user_id=?");
$select_details->bind_param("i", $user_id );
$select_details->execute();
$select_details->store_result();
$select_details_check=$select_details->num_rows;
if($select_details_check>0)
{
$select_details->bind_result($body_type,$body_shape,$height,$hair_color,$eye_color,
  $relationship_status,$intension,$orientation,$school,$occupation,$income,$children,$ethnicity,$religion,$sign,$smokes,$drinks,$drugs);
$select_details->fetch();
if($body_type=='')
{
  $body_type="NA";
}
if($body_shape=='')
{
  $body_type="NA";
}
if($height=='')
{
  $height="NA";
}
if($hair_color=='')
{
  $hair_color="NA";
}
if($eye_color=='')
{
  $eye_color="NA";
}
if($relationship_status=='')
{
  $relationship_status="NA";
}
if($intension=='')
{
  $intension="NA";
}
if($orientation=='')
{
  $orientation="NA";
}
if($school=='')
{
  $school="NA";
}
if($occupation=='')
{
  $occupation="NA";
}
if($income=='')
{
  $income="NA";
}
if($children=='')
{
  $children="NA";
}
if($ethnicity=='')
{
  $ethnicity="NA";
}
if($religion=='')
{
  $religion="NA";
}
if($sign=='')
{
  $sign="NA";
}
if($smokes=='')
{
  $smokes="NA";
}
if($drinks=='')
{
  $drinks="NA";
}
if($drugs=='')
{
  $drugs="NA";
}
$user_detail_arr=array('bodytype'=>$body_type,'bodyshape'=>$body_shape,'height'=>$height,'haircolor'=>$hair_color,'eyecolor'=>$eye_color,'relationship_status'=>$relationship_status,'intension'=>$intension,'orientation'=>$orientation,'school'=>$school,'occupation'=>$occupation,'income'=>$income,'children'=>$children,'ethnicity'=>$ethnicity,'religion'=>$religion,'sign'=>$sign,'smoke'=>$smokes,'drink'=>$drinks,'drug'=>$drugs);
}
else
{
$user_detail_arr="NA";
}
//get user interests

//$select_user_interest= $mysqli->prepare("Select interest_detail_id,interest_detail,idm.interest_id,interests from interest_detail_master idm inner join interests_master im on im.interest_id=idm.interest_id where idm.user_id=?");
$select_user_interest= $mysqli->prepare("Select interest_detail_id,interest_detail,idm.interest_id,interests from interest_detail_master idm inner join interests_master im on im.interest_id=idm.interest_id where idm.user_id=?");
$select_user_interest->bind_param("i", $user_id );
$select_user_interest->execute();
$select_user_interest->store_result();
$select_user_interest_check=$select_user_interest->num_rows;
if($select_user_interest_check>0)
{
$select_user_interest->bind_result($interest_detail_id,$interest_detail,$interest_id,$interests);
while($select_user_interest->fetch())
{
/*echo $interest_detail;
echo $interest_id;
echo $interests;*/

$interest_arr[]=array('interests'=>$interests,'interest_detail'=>$interest_detail); 
}
}

else
{
  $interest_arr='NA';
}
//social_link
$select_social_link= $mysqli->prepare("Select social_image_id,snapchat_link,twitter_link,instragram_link from social_image_master where user_id=? order by social_image_id desc");
$select_social_link->bind_param("i", $user_id );
$select_social_link->execute();
$select_social_link->store_result();
$select_social_link_check=$select_social_link->num_rows;
if($select_social_link_check>0)
{
$select_social_link->bind_result($social_image_id,$snapchat_image,$twitter_image,$instragram_image);
$select_social_link->fetch();

$social_arr=array('snapchat_link'=>$snapchat_image,'twitter_link'=>$twitter_image,'instagram_link'=>$instragram_image); 

}
else
{
  $social_arr='NA';
}




$record=array('success'=>'true','msg'=>'data found','personal_detail'=>$personal_detail_arr,
  'about_detail'=>$about_detail_arr,'user_detail'=>$user_detail_arr,'interests'=>$interest_arr,'social_link'=>$social_arr);
$data = json_encode($record);
echo $data;
return;

?>