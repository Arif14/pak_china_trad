<?php 

	function middleSelect(){
	$val = -1;

		if(isset($_GET['side_active'])){
			$val = $_GET['side_active'];
		}else if(isset($_GET['update_status'])){
			$val = 3;
		}else if(isset($_GET['send_submit'])){
			$val = 5;
			
		}

		

		switch($val){
			case 0:
				include("./helper/dashboard_update_status.php");
				break;
			case 1:
				include("./helper/dashboard_delivery_status.php");
				break;
			case 2:
				include("./helper/dashboard_send.php");
				break;
			case 3:
				include("./helper/dashboard_update_status_submit.php");
				break;
			case 5:
				include("./helper/dashboard_send_submit.php");
				break;
			
		}

	}
?>