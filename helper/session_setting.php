<?php

	function checkSessionStatus_and_connect(&$conn){
	session_start();

	if(isset($_SESSION["office_id"])){
		
		return true;
	}
		return false;
	}
?>