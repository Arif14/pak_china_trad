<?php 

	function middleSelect(){
	$val = -1;

		if(isset($_GET['side_active'])){
			
			$val = $_GET['side_active'];
		}

		if(isset($_GET['create'])){
			
			$val = 4;
		}else if(isset($_GET['send_submit'])){
			$val = 5;
			
		}

		switch($val){
			case 0:
				include("./helper/dashboard_create.php");
				break;
			case 1:
				include("./helper/dashboard_search.php");
				break;
			case 2:
				include("./helper/dashboard_search.php");
				break;
			case 3:
				include("./helper/dashboard_send.php");
				break;
			case 4:
				include("./helper/dashboard_create_submit.php");
				break;
			case 5:
				include("./helper/dashboard_send_submit.php");
				break;
		}

	}
?>