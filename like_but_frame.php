<?php 
session_start();
if(isset($_SESSION['user_login'])){
	$user=$_SESSION["user_login"];
}
else{
	$user="";
}

 ?>

<style>
	input[type='submit']{
		padding: 6px;
		background: #990000;
		border:1px solid #990000;
		color: white;
	}
	input[type='submit']:hover{
		background: #e6001a;
		border:1px solid #e6001a;
	}
</style>
<?php 
include('./inc/connect.inc.php');
$id="";
if (isset($_GET['uid'])){
	@$uid = mysql_real_escape_string($_GET['uid']);
	if(ctype_alnum(@$uid)){

$get_likes=mysql_query("SELECT * FROM likes WHERE uid='$uid'");
if(mysql_num_rows($get_likes)===1){
			@$get=mysql_fetch_assoc($get_likes);
			@$uid=$get['uid'];
			@$total_likes=$get['total_like'];
			@$total_likes=$total_likes+1;
			@$remove_likes=$total_likes-2;
	}
	else{
		die("Error ...");
	}
if(isset($_POST['likebutton_'])) {
$like=mysql_query("UPDATE likes SET total_like='$total_likes' WHERE uid='$uid'");
$user_likes=mysql_query("INSERT INTO user_likes VALUES ('','$user','$uid')");
header("Location:like_but_frame.php?uid=$uid");
}
if(isset($_POST['unlikebutton_'])) {
$like=mysql_query("UPDATE likes SET total_like='$remove_likes' WHERE uid='$uid'");
$remove_user=mysql_query("DELETE FROM user_likes WHERE username='$user' and uid='$uid'");
header("Location:like_but_frame.php?uid=$uid");
}

}
}
?>
<?php
//Check for Previous likes
$check_for_likes=mysql_query("SELECT * FROM user_likes WHERE username='$user' and uid='$uid'");
$numrows_likes=mysql_num_rows($check_for_likes);
if($numrows_likes>=1){
echo('<form action="like_but_frame.php?uid='.$uid.'" method="POST">
	<input type="submit" name="unlikebutton_'.$id.'" value="Unlike">
</form>
'.@$total_likes.' likes');
}
else if($numrows_likes==0){

echo('<form action="like_but_frame.php?uid='.@$uid.'" method="POST">
	<input type="submit" name="likebutton_'.$id.'" value="like">
</form>
'.@$total_likes.' likes');
}
?>