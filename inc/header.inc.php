<?php 
$name2='';
include ("./inc/connect.inc.php"); 
include('./inc/config.php');
session_start();
if(isset($_SESSION['user_login'])){
	$user=$_SESSION["user_login"];
}
else{
	$user="";
}
if (!isset($_SESSION["user_login"])) {
$username="";
}
else
{
	$username=$_SESSION["user_login"];
}
echo('<link  rel="icon" class="titlepic" type="image/ico" href="'.@$profile_pic.'"/>');

@$check =mysql_query("SELECT * FROM hsers WHERE username='$username'");
if(mysql_num_rows($check)===1){
			@$get=mysql_fetch_assoc(@$check);
			@$username=$get['username'];
			@$firstname=$get['first_name']; 
			@$lastname=$get['last_name'];
			@$id=$get['id'];
		}
?>
<?php
if($username !=$user){
@$name1=''.$firstname.' '.$lastname.'';
echo("<title>$name1</title>");
}
else{
@$name2=''.$firstname.' '.$lastname.'';
echo("<title>$name2</title>");
}
?>

<!doctype html>
<html>
   <head>
   	<link rel="stylesheet" type="text/css" href="./css/style.css">
<script src="js/main.js?<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/jquery-1.8.0.min.js?<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/jquery-2.1.4.js?<?php echo time(); ?>" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js?<?php echo time(); ?>" type="text/javascript"></script>

<script>
        $(document).ready(function(){
          $( ".block1" ).mouseover(function() {
            $(this).addClass( "blur" );
          });
          $( ".block1" ).mouseout(function() {
            $(this).removeClass( "blur" );
          });
          $().UItoTop({ easingType: 'easeOutQuart' });
        }) 
     </script>
<script>
	$(document).ready(function(){
$(".search").keyup(function()
{
var searchbox = $(this).val();
var dataString = 'searchword='+ searchbox;
if(searchbox=='')
{}
else
{
$.ajax({
type: "POST",
url: "search.php",
data: dataString,
cache: false,
success: function(html)
{
$("#display").html(html).show();
}
});
}return false;
});
});
</script>

</head>
<body>
	<?php
	$count_poke=mysql_query("SELECT * FROM pokes WHERE user_to='$username'");
	$get_poke=mysql_fetch_assoc($count_poke);
	$get_num_poke=mysql_num_rows($count_poke);
	if(@$get_num_poke==0){
	$b="";
	}
	else{
	$b="<sup>$get_num_poke</sup>";
	}
	$get_unread_query=mysql_query("SELECT opened FROM pvt_messages WHERE user_to='$user' && opened='no' && deleted='no'");
	$get_unread=mysql_fetch_assoc($get_unread_query);
	$unread_numrows=mysql_num_rows($get_unread_query);
	if(@$unread_numrows==0){
	$a="";
	}
	else{
		$a="<sup>$unread_numrows</sup>";
	}
	?> 
	<div class="headerMenu">
		<div class="logo">
				<a href="<?php echo($username);?>" title="Hackbook find and meet hackers" alt="logo"><h1>Hack|book</h1></a>
		</div>
		<?php
$check_pic=mysql_query("SELECT profile_pic FROM hsers WHERE username='$username'");
$get_pic_row=mysql_fetch_assoc($check_pic);
$profile_pic_db=$get_pic_row['profile_pic'];
if($profile_pic_db==""){
 	$profile_pic="img/ethiopia.png";
}
else{
 	$profile_pic="userdata/profile_pics/".$profile_pic_db;
}
?>
		<?php 
		if(!$user){
		echo('<form class="form1" action="index.php" method="POST">
			<div class="username1"><input type="text" name="user_login" placeholder="User Name" title="Please enter the username (for example: Michael)"/></div>
			<div class="password1"><input type="password" name="password_login" placeholder="Password" title="Please enter your password"/></div>
            <div class="login1"><input type="submit" name="login" value="Login" title="Please click this to login"/></div>
		</form>');	
		}
		else{
		}
		 ?>		
		 <?php
			if (!$username){
			} else {
				echo('
		<div class="fnav">
			<a title="'.$username.', Do you want to loged out." class="flink" href="./logout.php">Logout</a>
		</div>
		<div class="fnav">
			<a title="'.$username.', this is your Pokes." class="flink" href="./pokes.php">Pokes '.$b.'</a>
		</div>
		<div class="fnav">
			<a class="flink" href="account_settings.php">Settings</a>
		</div>
		<div class="fnav">
			<a class="flink" href="./inbox.php">Inbox '.$a.'</a>
		</div>
		<div class="fnav">
			<a class="flink" title="'.$username.'\'s Profile" href="'.$username.'"><div  id="smallprofileimg"><img src="'.$profile_pic.'"></div>'.$username.'</a>
		</div><!-- end fnav -->
		<div class="fnav">
			<a class="flink" href="./home.php">Home</a>
		</div>
');
}
?>


		<?php if(!$username){

		}
		else{
			echo('<div class="search_box">
				<form action="" method="POST" id="search">
				<input type="text" class="search" id="searchbox" name="q" placeholder="Search ..." />	
				</form><div id="display"></div>
			</div>');
		}
		?>

		<a style="margin-right: -555px; right: 50%; display: block;" href="#" id="toTop"> <div style="opacity: 0;" id="toTopHover"></div></a>
		<!--end fnav feat -->	
			</div>
			<?php
			if(!$username){
			
			}
			else{
			echo('<div id="wrapper">');
			}
			?>
