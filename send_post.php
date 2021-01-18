<?php include("./inc/connect.inc.php");
$post = $_POST['post'];
if($post != "") {
	$added_date=date("Y-m-d");
	$added_by="test123";
	$user_posted_to="test123";
	$sqlCommand="INSERT INTO posts VALUES('','$post','$added_date','$added_by','$user_posted_to')";
	$query=mysql_query($sqlCommand) or die (mysql_error());
}
else
{
	echo("<div 'error1'>You must enter something in the post field before you can send it ...</div>");
}
?>