<?php 
class SESSION_CONTROLLER {
	function __construct() {}
	function __destruct() {}

	/*
	*	Start Session function.
	*	Purpose:
	*	- Starts session.
	*	Variables:
	*	- $session_id: This variable is used to set session id.
	 */
	function start_session( $session_id = "" ) {
		session_start( $session_id );
	}

	/*
	*	Stop Session function.
	*	Purpose:
	*	- Stops & removes the currently opened session.
	*	 */
	function stop_session() {
		session_unset();
		session_destroy();
	}

	/*
	*	Set Variable function.
	*	Purpose:
	*	- Sets a variable into the currently opened session.
	*	Variables:
	*	- $name_: This is the name of the new $_SESSION variable.
	*	- $value_: This is the value of the new $_SESSION variable.
	 */
	function set_variable( $name_, $value_ ) { $_SESSION[ $name_ ] = $value_; }

	/*
	*	Unser Variable.
	*	Purpose:
	*	- Unsets a variable into the currently opened session.
	*	Variables:
	*	- $name_: This is the name of the variable which we are going to UNSET.
	 */
	function unset_variable( $name_ ) { unset( $_SESSION[ $name_ ] ); }
};
?>