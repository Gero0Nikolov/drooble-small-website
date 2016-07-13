<?php 
	include "database.php";
	include "assets/db-controller.php";
	include "assets/session-controller.php";

	$db_controller = new DB_CONTROLLER( $server_name, $db_name, $db_user, $db_pass );

	// Initialize database
	$table_ = "users";
	$columns_ = array(
			"nickname" => "LONGTEXT",
			"email" => "LONGTEXT",
			"password" => "LONGTEXT"
		);
	$db_controller->create_table( $table_, $columns_ );

	$session_controller = new SESSION_CONTROLLER;
	$session_controller->start_session();

	if ( !empty( $_SESSION[ "user_id" ] ) && isset( $_SESSION[ "user_id" ] ) ) { header( "Location: logged.php" ); }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Small Website Demo</title>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="assets/js-scripts.js"></script>
	<link href='assets/styles/style.css' rel='stylesheet' type='text/css' media='screen' />
</head>
<body>
	<h1>Small Website Demo</h1>
	<div id="register-box" class="section separate">
		<h2 class="section-title">Register</h2>
		<div class="form">
			<input type="text" id="nickname" placeholder="Nickname...">
			<input type="text" id="email" placeholder="E-mail...">
			<input type="password" id="password" placeholder="Password...">
			<button id="register-button" class="submit-button">Submit</button>
		</div>
	</div>
	<div id="login-box" class="section separate">
		<h2 class="section-title">Login</h2>
		<div class="form">
			<input type="text" id="email" placeholder="E-mail...">
			<input type="password" id="password" placeholder="Password...">
			<button id="login-button" class="submit-button">Login</button>
		</div>
	</div>
</body>
</html>