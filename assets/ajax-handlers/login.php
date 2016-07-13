<?php 
	include "../../database.php";
	include "../db-controller.php";
	include "../session-controller.php";

	$db_controller = new DB_CONTROLLER( $server_name, $db_name, $db_user, $db_pass );
	$session_controller = new SESSION_CONTROLLER;

	$email_ = strtolower( $_POST[ "email" ] );
	$password_ = crypt( $_POST[ "password" ], "$1$". $email_ ."$" );

	$flag_ = 0;
	$response_ = "READY";

	if ( empty( $email_ ) ) {
		$flag_ = 1;
		$response_ = "Provide a valid email.";
	} else if ( empty( $password_ ) ) {
		$flag_ = 1;
		$response_ = "Provide a valid password.";
	}

	if ( $flag_ == 0 ) {
		$user_ = $db_controller->select_from( "users", array( "id", "nickname", "email", "password" ), "email='$email_' AND password='$password_'" );
		if ( empty( $user_ ) ) {
			$flag_ = 1;
			$response_ = "Your email or password are wrong.";
		}

		if ( $flag_ == 0 ) {
			$session_controller->start_session();
			$session_controller->set_variable( "user_id", $user_[0][ "id" ] );
			$session_controller->set_variable( "user_nickname", $user_[0][ "nickname" ] );
			$session_controller->set_variable( "user_email", $user_[0][ "email" ] );
		}
	}

	// Return response
	echo $response_;
?>