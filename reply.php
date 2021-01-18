<?php 
include('./inc/header.inc.php');
 ?>
 <?php
 if (isset($_GET['hack_book_user'])){
	$username = mysql_real_escape_string($_GET['hack_book_user']);
	if(ctype_alnum($username)){
		//check user exists
		$check =mysql_query("SELECT * FROM hsers WHERE username='$username'");
		if(mysql_num_rows($check)===1){
			$get=mysql_fetch_assoc($check);
			$username=$get['username'];
			//check the user isn't sending themself a private message
			if($username != $user){ 
				if(isset($_POST['send_message'])){
					$msg_body=strip_tags(@$_POST['message_body']);
					$msg_title=strip_tags(@$_POST['message_title']);
					$date=date("Y-m-d");
					$opened="no";
					$deleted="no";
					if(@$msg_title==""){
						echo("<div class='error1'>Please write something on the title field!</div>");
					}
					elseif(@$msg_body==""){
						echo("<div class='error1'>Please write something on the message field!</div>");
					}
					else{
						echo("<div class='error2'>Your message has been sent!</div>");
					}
					$send_msg_query=mysql_query("INSERT INTO pvt_messages VALUES ('','$user','$username','$msg_body','$date','$opened','$msg_title','$deleted')");
				}
				else{
				
				}
				$textarea='<textarea placeholder="You are sending a message to '.$username.'." name="message_body" title="You are sending a message to '.$username.'." alt="You are sending a message to '.$username.'."></textarea>';
				echo('
					<div id="messagefield">
					<form action="send_msg.php?hack_book_user='.$username.'" method="POST">
					<h2 style="font-size:14px;font-family:verdana,sans-serif;">You are sending a message to '.$username.'.</h2><br>
					<input type="text" onClick="value=""" name="message_title" placeholder="write your message title here."/><br><br>
					'.$textarea.'
					<input class="sendmsg msg" type="submit" name="send_message" value="Send"/>
                     </form></div>
					');
			}
            else{
				header('Location:profile.php');
              }


		}

	}
}

?>