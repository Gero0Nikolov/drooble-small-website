<?php 
	include "../../database.php";
	include "../db-controller.php";

	$db_controller = new DB_CONTROLLER( $server_name, $db_name, $db_user, $db_pass );

	$nickname_ = strtolower( $_POST[ "nickname" ] );
	$email_ = strtolower( $_POST[ "email" ] );
	$password_ = crypt( $_POST[ "password" ], "$1$". $email_ ."$" );

	$flag_ = 0;
	$response_ = "READY";

	if ( empty( $nickname_ ) ) {
		$flag_ = 1;
		$response_ = "Provide a valid nickname.";
	} else if ( empty( $email_ ) ) {
		$flag_ = 1;
		$response_ = "Provide a valid email.";
	} else if ( empty( $password_ ) ) {
		$flag_ = 1;
		$response_ = "Provide a valid password.";
	}

	if ( $flag_ == 0 ) {
		$current_users_with_email = $db_controller->select_from( "users", array( "email" ), "email='$email_'" );
		if ( !empty( $current_users_with_email ) ) {
			$flag_ = 1;
			$response_ = "There is a user with this e-mail already.";
		}

		if ( $flag_ == 0 ) {
			$cols_vals = array(
					"nickname" => $nickname_,
					"email" => $email_,
					"password" => $password_
				);
			$db_controller->insert_to( "users", $cols_vals );
		}
	}

	// Return response
	echo $response_;
?>