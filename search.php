<?php
include('inc/connect.inc.php');
echo('<script src="js/jquery-1.8.0.min.js" type="text/javascript"></script>');
if($_POST)
{
$q=$_POST['searchword'];
$sql_res=mysql_query("SELECT * FROM hsers WHERE username LIKE '%$q%' OR email LIKE '%$q%' ORDER BY id LIMIT 8");
while($row=mysql_fetch_array($sql_res))
{
$first_name=$row['first_name'];
$last_name=$row['last_name'];
$profile_pic=$row['profile_pic'];
$work=$row['work'];
$country=$row['country'];
$username=$row['username'];
$b_firstname='<b>'.$q.'</b>';
$b_lastname='<b>'.$q.'</b>';
$final_firstname = str_ireplace($q, $b_firstname, $first_name);
$final_lastname = str_ireplace($q, $b_lastname, $last_name);
?>
<div class="display_box" align="left">
<?php
if($work==""){

}
else{
	$work= "Work at: ".$work;
}
$a="<br/>";
if($profile_pic==""){
echo('<a href="'.$username.'"><img src="./img/ethiopia.png" style="width:40px; height:40px; padding:3px; background:white;border:0.1px solid white; float:left; margin-right:2px;" /></a>');
}
else{
echo('<a href="'.$username.'"><img src="./userdata/profile_pics/'.$profile_pic.'" style="width:40px; height:40px; padding:3px; background:white;border:0.1px solid white; float:left; margin-right:2px;" /></a>');
}
?>
<a title="<?php echo($username.' ('.$first_name.' '.$last_name.')'.', '. $work); ?>" href="<?php echo($username); ?>"><span class="name"><?php echo($final_firstname.' '.$final_lastname); ?><br/>
<span style="font-size:13px; font-family:verdana,sans-serif,arial;color:#999999"><?php echo($work);
 ?><br/></span> 
<span style="font-size:10px; font-family:verdana,sans-serif,arial;color:#999999"><?php echo $country; ?></span></a></div><hr>
<?php
}
}
?>
