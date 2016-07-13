<?php 
	include "../session-controller.php";
	$session_controller = new SESSION_CONTROLLER;
	$session_controller->start_session();
	$session_controller->stop_session();
	echo "READY";
?>