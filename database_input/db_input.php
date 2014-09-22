<?php


	function insertIntoOffice($conn){
		//Delete previous
		$sql = "DELETE FROM office ";

		mysql_query($sql,$conn);

		$file = fopen("office_input.txt","r");

		while(!feof($file)){
			$line =  fgets($file);
			$location = explode("#",$line);

			$sql = "INSERT INTO office (id,location,type) values('$location[0]' , '$location[1]','$location[2]' )";

			mysql_query($sql,$conn);

		}

		fclose($file);
	}


	function insertIntoOfficeMap($conn){
		$sql = "DELETE FROM office_map ";

		mysql_query($sql,$conn);

		$file = fopen("map_input.txt","r");

		while(!feof($file)){
			$line =  fgets($file);
			$location = explode("->",$line);

			$from = $location[0];
			$to_array = explode("#", $location[1]);
			foreach ($to_array as $key => $value) {
				$sql = "INSERT INTO office_map (from_location ,to_location ) values('$from','$value')";
				mysql_query($sql,$conn);
			}

			
		}

		fclose($file);
	}

		function createMap(){

		$file = fopen("map_input.txt","r");

		$map = array();

		while(!feof($file)){
			$line =  fgets($file);
			$location = explode("->",$line);

			$from = $location[0];
			$to_array = explode("#", $location[1]);
			$map[$from] = array(
				'vertex' => $from,
				'visited' => false,
				'sides' => array()
				);
			foreach ($to_array as $key => $value) {
				array_push($map[$from]['sides'],$value);
			}

			
		}

		echo print_r($map);

		fclose($file);
	}

	echo "working";


	createMap();


	
?>