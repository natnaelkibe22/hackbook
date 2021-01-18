<?php include ("./inc/header.inc.php"); 
echo('<title>'.$username.'</title>');
?>
<?php
if(!$username){
header("Location:index.php");
}
?>
<?php
if (isset($_GET['hack_book_user'])){
	$username = mysql_real_escape_string($_GET['hack_book_user']);
	if(ctype_alnum($username)){
		//check user exists
		$check =mysql_query("SELECT * FROM hsers WHERE username='$username'");
		if(mysql_num_rows($check)===1){
			$get=mysql_fetch_assoc($check);
			@$username=$get['username'];
			$firstname=$get['first_name'];
			$lastname=$get['last_name'];
			@$friendpic=$get['profile_pic'];
			$uid=$get['id'];
		}
		else
		{
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/m/hackbook/index.php\" />";
			exit();
		}
	}
}
 $post = @$_POST['post'];
if($post != "") {
	$added_date=date("Y-m-d-H-i-s A");
	$added_by=$user;
	$user_posted_to=$username;
	$sqlCommand="INSERT INTO posts VALUES('','$post','$added_date','$added_by','$user_posted_to')";
	$query=mysql_query($sqlCommand) or die (mysql_error());
}
	//Check wheather the user uploaded the picture or not
 $check_pic=mysql_query("SELECT profile_pic FROM hsers WHERE username='$username'");
 $get_pic_row=mysql_fetch_assoc($check_pic);
 $profile_pic_db=$get_pic_row['profile_pic'];
 if($profile_pic_db==""){
 	$profile_pic="img/ethiopia.png";
 }
 else{
 	$profile_pic="userdata/profile_pics/".$profile_pic_db;
 }
 echo('<link  rel="icon" class="titlepic" type="image/ico" href="'.$profile_pic.'"/>');
?>

<div class="middlecontent">
	<?php
	echo("<p class='postpara'>Write your post here $user.</p><img id='postimg1' src='$profile_pic' alt='$user pic'>");
	?>
<div class="postForm">
<form action="<?php $username; ?>" method="POST" class="posttext">
	<textarea id="post" name="post" placeholder="<?php 
if($username!=$user){
	echo('Please leave your post on '.$firstname.' '.$lastname.' timeline ...');
}
else{
	echo('What\'s Up '.$firstname.' '.$lastname.'?');
}
	?>"></textarea>
	<input type="submit" name="send" value="Post"/>
</form>

</p></p>
</div>
<?php

?>
<div class="mtop">
	<div class="profilePosts">
	<?php

	$getposts=mysql_query("SELECT * FROM posts WHERE user_posted_to='$username' ORDER BY id DESC LIMIT 20") or die(mysql_error());
	while ($row = mysql_fetch_assoc($getposts)){
		$id=$row['id'];
		$body=$row['body'];
		$added_date=$row['added_date'];
		$added_by=$row['added_by'];
	$get_user_info=mysql_query("SELECT * FROM hsers WHERE username='$added_by'");
	$get_info=mysql_fetch_assoc($get_user_info);
	$profilepic_info=$get_info['profile_pic'];
	$firstname_info=$get_info['first_name'];
	$lastname_info=$get_info['last_name'];
		echo('<script language="javascript">
function toggle'.$id.'(){
var ele = document.getElementById("togglecomment'.$id.'");
var text = document.getElementById("displayComment'.$id.'");
if(ele.style.display == "block"){
	ele.style.display="none";
}
else{
	ele.style.display="block";
}
}
</script>');
		echo "<div class='middlethings'><div class='postimg'><a href='$added_by'><img src='userdata/profile_pics/$profilepic_info'></a>
		</div><div class='posted_by'><a href='$added_by'>$firstname_info $lastname_info</a></div><p style='background:#fbfbfb;'></p><p style='background:#fbfbfb;'></p>
		<div class='postedtext'>$body </p><p>$added_date</p></div></div><div class='commentbox' style='background:#fbfbfb;'><a href='#' style='background:#fbfbfb;'>
		<img src='./img/heart1.png' style='background:#fbfbfb;'>Like</a><a class='comment' href='javascript:toggle$id();' type='hidden' style='color:#990000;' id='displayComment$id' title='leave your comment here'>Comment</a>
		<a href='#' class='Share' title='share this '>Share</a>
		</div></p>
		";
		echo("<div id='togglecomment$id' class='togglecomment' type='hidden'><textarea placeholder='Write a comment ...'></textarea></div>");
	}

	if($row!=0){
		foreach ($body as $key1 => $value1) {
			# code...
			$getpostquery=mysql_query("SELECT * FROM posts WHERE username='$value1' LIMIT 1");
			$getpostrow=mysql_fetch_assoc($getpostquery);
			$getpost=$getpostrow['body'];
		}
	}
?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php @$userpic=@$userpic;
$userpic=$profile_pic;
 ?>
<div class="leftsidewrapper">
	<div class="profile">
<img class="profileimg" src="<?php echo($profile_pic); ?>" alt="<?php echo $username; ?>'s Profile" title="<?php echo $username; ?>'s Profile" /></div>
</p>
<div class="Addfriend">
<form action="<?php echo($username); ?>" method="POST">
</p>
<?php
if(isset($_POST['addfriend'])){
	$friend_request=@$_POST['addfriend'];
	$user_to=$user;
	$user_from=$username;
	$create_request=mysql_query("INSERT INTO friend_request VALUES ('','$user_to','$user_from')");
	}
?>
<?php

$friendsArray="";
$countFriends="";
$friendsArray12="";
@$selectFriendsQuery = mysql_query("SELECT friend_array FROM hsers WHERE username='$username'");
@$friendRow = mysql_fetch_assoc($selectFriendsQuery);
@$friendArray = $friendRow['friend_array'];
@$check_friend_request_hasbeensent1=mysql_query("SELECT * FROM friend_request WHERE user_to='$username' && user_from='$user'");
@$num_friendrequest_found1=mysql_num_rows(@$check_friend_request_hasbeensent1);

if($friendArray != ""){
	$friendArray = explode(",", $friendArray);
	$countFriends = count($friendArray);
	$friendArray12 = array_slice($friendArray, 0,9);
$i = 0;
if (in_array (@$user, $friendArray)) 
{
	$addAsFriend = '<input type="submit" name="removefriend" value="UnFriend" style="width:100px;margin-left:35px;"/><p></p>';
	echo @$addAsFriend;
}
else{
	if(@$username!=$user and $num_friendrequest_found1==0){
	$addAsFriend='<input id="addasfriend" type="submit" name="addfriend" value="Add Friend" style="width:100px;margin-left:35px;"/><p><p/>';
	echo(@$addAsFriend);
	}
	elseif(@$username != $user and $num_friendrequest_found1==1){
	$frsented2="<div id='frsented'><h3>Friend Request has been sent</h3></div></p>";
	echo(@$frsented2);
	}
}
}
else{
	if(@$username!=$user and $num_friendrequest_found1==0){
	$addAsFriend='<input type="submit" id="addasfriend" name="addfriend" value="Add Friend" style="width:100px;margin-left:35px;"/><p><p/>';
	echo @$addAsFriend;
	}
	elseif(@$username != $user and $num_friendrequest_found1==1){
	$frsented2="<div id='frsented'><h3>Friend Request has been sent</h3></div></p>";
	echo(@$frsented2);
	}
}

//$user equal to logged in user
//$username equal to user who owns profile
if(@$_POST['removefriend']){
//friend array for logged in user
$add_friend_check=mysql_query("SELECT friend_array FROM hsers WHERE username='$user'");
$get_friend_row=mysql_fetch_assoc($add_friend_check);
@$friend_array=$get_friend_row['friend_array'];
$friend_array_explode=explode(",", $friend_array);
$friend_array_count=count($friend_array_explode);

//friend array for the user who owns the profile
$add_friend_check_username=mysql_query("SELECT friend_array FROM hsers WHERE username='$username'");
$get_friend_row_username=mysql_fetch_assoc($add_friend_check_username);
@$friend_array_username=@$get_friend_row_username['friend_array'];
$friend_array_explode_username=explode(",", $friend_array_username);
$friend_array_count=count($friend_array_explode_username);

@$usernameComma=",".$username;
@$usernameComma2=@$username.",";

@$userComma=",".$user;
@$userComma2=@$user.",";
if(strstr(@$friend_array,$usernameComma)){
@$friend1=str_replace("$usernameComma", "",@$friend_array);
}
elseif(strstr(@$friend_array,$usernameComma2)){
@$friend1=str_replace("$usernameComma2", "",@$friend_array);
}
elseif(strstr(@$friend_array,$username)){
@$friend1=str_replace("$username", "",@$friend_array);
}
//Remove logged in user form other person array
if(strstr(@$friend_array_username,$userComma)){
@$friend2=str_replace("$userComma", "",@$friend_array_username);
}
elseif(strstr(@$friend_array_username,$userComma2)){
@$friend2=str_replace("$userComma2", "",@$friend_array_username);
}
elseif(strstr(@$friend_array_username,$user)){
@$friend2=str_replace("$user", "",@$friend_array_username);
}
@$removeFriendQuery=mysql_query('UPDATE hsers SET friend_array="'.@$friend1.'" WHERE username="'.$user.'"');
@$removeFriendQuery2=mysql_query('UPDATE hsers SET friend_array="'.@$friend2.'" WHERE username="'.$username.'"');
echo "<meta http-equiv=\"refresh\" content=\"0; url=https://localhost/m/hackbook/$username \" />";
}
if(isset($_POST['sendmsg'])){
			echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/m/hackbook/send_msg.php?hack_book_user=$username \" />";
}
echo(@$errorMsg); 
echo(@$successMsg);
?>
&gl;iframe src"https://localhost/m/hackbook/like_but_frame.php?uid=0e4bc7718ed095a6efdb1db2965132c5" style="border:0px; width:100px; height:23px;"&gt;&gl;/iframe&gt; 
<?php
//This is a Poke code 
if(@$_POST['poke']){
	$check_if_poked=mysql_query("SELECT * FROM pokes WHERE user_to='$username' && user_from='$user'");
	$num_poked_found=mysql_num_rows($check_if_poked);
	if($num_poked_found==1){
	echo("You must wait to be poked back.");
	}
	elseif($username!=$user){
	$poke_user=mysql_query("INSERT INTO pokes VALUES ('','$user','$username')");
    echo("<p>$username has been poked.</p>");
	}
}
else{
}
if($username!=$user){
$messagebutton='<input type="submit" name="sendmsg" value="Send" style="width:44px;float:left;margin-left:40px;"/>';
echo($messagebutton);
}
if($username!=$user){
$pokebutton='<div id="pokebutton"><input type="submit" name="poke" value="Poke" style="width:40px; "/></div>';
 echo($pokebutton);
}
    ?>
</form>
</p>

<div class="textHeader">Profile</div>
<?php 
$about_query=mysql_query("SELECT bio FROM hsers WHERE username='$username'");
$get_result=mysql_fetch_assoc($about_query);
$about_the_user=$get_result['bio'];
echo $about_the_user;

?>
</p></p></p></p></p></p></p></p></p></p></p></p></p></p></p></p></p>
<div class="profileLeftSideContent">

</div>
<div class="textHeader"><a id="fra" href="#">Friends</a> <a id="franum" title="<?php echo $firstname.' '.$lastname; ?> have <?php echo $countFriends; ?> Friends(to see his friend click this link)" href="#"><?php echo(@$countFriends); ?></a></div>
<div class="profileLeftSideContent" style="background:#fbfbfb;">
	<div id="friendpic">
<?php
	if($countFriends!=0){
	foreach ($friendArray12 as $key => $value){
		$i++;
		$getFriendquery=mysql_query("SELECT * FROM hsers WHERE username='$value' LIMIT 1");
		$getFriendRow=mysql_fetch_assoc($getFriendquery);
		$friendUsername=$getFriendRow['username'];
		$friendfirstname=$getFriendRow['first_name'];
		$friendlastname=$getFriendRow['last_name'];
		$friendProfilepic=$getFriendRow['profile_pic'];
		//we are showing default profilepic or the user uploaded profilepic
		if($friendProfilepic == ""){
		echo('<a href="'.$friendUsername.'"><img src="img/ethiopia.png" alt="'.$friendUsername.'\'s Profile" title="'.$friendUsername.'\'s Profile" height="100" width=100 /></a>');
		}
		else{
            echo('<ul id="ul_fl" style="list-style:none;"><li><a href="'.$friendUsername.'"><img src="./userdata/profile_pics/'.$friendProfilepic.'" alt="'.$friendUsername.'\'s Profile" title="'.$friendUsername.'\'s Profile" height="100" width="100" /></a></li></ul>');
		}
	}
	}
	else{
		echo($username." has no friends yet");
	}
?>	
</div>
</div>
</div>
</div>
