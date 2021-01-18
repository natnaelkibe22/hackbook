<?php 
include('./inc/header.inc.php');
 ?>
 <?php 

$check_for_pokes=mysql_query("SELECT * FROM pokes WHERE user_to='$user'");
$poke=mysql_fetch_assoc($check_for_pokes);
	$user_to=$poke['user_to'];
	$user_from=$poke['user_from'];
	if(@$_POST["poke_$user_from"]){
		$delete_poke=mysql_query("DELETE FROM pokes WHERE user_from='$user_from' && user_to='$user_to'");
		$create_new_poke=mysql_query("INSERT INTO pokes VALUES ('','$user','$user_from')");
		header("Location:pokes.php");

 echo("You just poked $user_from");
 } 
 if(@$poke==''){
 	echo('You have no poke.');
 }
 else{
 echo("
		<form action='pokes.php' method='POST'>
		You have been poked by $user_from &nbsp;
		<input type='submit' name='poke_$user_from' value='Poke Back'>
		</form>");

 }
	  ?>
