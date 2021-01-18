<?php
/**
 * Connect to mysql server
 * @param bool
 * @use true to connect false to close
 */
function dbConnect($close=true){

	if (!$close) {
		mysql_close($link);
		return true;
	}

	$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to MySQL DB ') . mysql_error();
	if (!mysql_select_db(DB_NAME, $link))
		return false;
}

/**
 * gravatar Image
 * @see http://en.gravatar.com/site/implement/images/
 */
function avatar($mail, $size = 60){
	$url = "http://www.gravatar.com/avatar/";
	$url .= md5( strtolower( trim( $mail ) ) );
	// $url .= "?d=" . urlencode( $default );
	$url .= "&s=" . $size;
	return $url;
}



?>