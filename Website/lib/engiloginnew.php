<?php
class UserNotRegisteredException extends Exception {}
function engi_user($email) {
	require_once("constants.php");

	// 1. Create a database connection
	$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
	if (!$connection) {
			die("Database connection failed: " . mysql_error());
	}

	// 2. Select a database to use 
	$db_select = mysql_select_db(DB_NAME,$connection);

	if (!$db_select) {
			die("Database selection failed: " . mysql_error());
	}

	$user_query = sprintf("SELECT users.Email, `First Name`, `Last Name`, Active FROM users JOIN individual ON users.Email=individual.email WHERE users.Email='%s' AND individual.event='subevent-57' ",
		mysql_real_escape_string($email));
	$user = mysql_query($user_query, $connection) or die(mysql_error());
	$foundUser = mysql_num_rows($user);
	if ($foundUser) {

		$row = mysql_fetch_row($user);

		$result = array();

		$result['email'] = $row[0];
		$result['fullname'] = trim($row[1] . ' ' . $row[2]);
	} else {
              
		throw new UserNotRegisteredException();
               //redirect('game');
	
	}

	return $result;
}



