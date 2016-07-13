<?php 
	include "database.php";
	include "assets/db-controller.php";
	include "assets/session-controller.php";

	$db_controller = new DB_CONTROLLER( $server_name, $db_name, $db_user, $db_pass );

	$session_controller = new SESSION_CONTROLLER;
	$session_controller->start_session();

	$user_id = $_SESSION[ "user_id" ];
	$user_nickname = $_SESSION[ "user_nickname" ];
	$user_email = $_SESSION[ "user_email" ];
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
	<h1>Hello, <?php echo $user_nickname ?>!</h1>
	<div id="user-box" class="section">
		<h2 class="user-info">ID: <?php echo $user_id; ?></h2>
		<h2 class="user-info">Nickname: <?php echo $user_nickname; ?></h2>
		<h2 class="user-info">Email: <?php echo $user_email; ?></h2>
		<button id="logout-button" class="logged-button">Logout</button>
	</div>
</body>
</html>