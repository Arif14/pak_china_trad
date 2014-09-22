<?php 
	

	include("./helper_functions.php"); 

	function &createNewMap(){
	

	//	$map = "";

	//	$file = fopen("../database_input/map_input.txt","r");

		$map = array();

		$conn = mysql_connect("localhost","root","");
		mysql_select_db("pak-china-trad",$conn);

		$sql = "SELECT * 
				FROM office_map";
		$result =  mysql_query($sql,$conn);

		while($row = mysql_fetch_array($result)){
			$from = $row['from_location'];
			$to = $row['to_location'];

			if(!isset($map[$from])){
				$map[$from] = array(
					'vertex' => $from,
					'visited' => false,
					'sides' => array()
					);
			}
			array_push($map[$from]['sides'],$to);
		}

		return $map;
	}

	/*

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
		fclose($file);

		return $map;
	}

	*/
	
	$map =& createNewMap();

	//print_r($map);

	foreach ($map as $key => $value) {
		echo "key : " . $key . "value : " . print_r($value) ." </br>";
	}

	echo "<h1>Working</h1>";

	$path =& createPath($map,76,70);

	print_r($path); 
	

/*
	$map = array();

	$map[20] = "hello";
	$map[50] = "world";

	if(isset($map[80])){
		echo "set";
	}else{
		echo "unset";
	}

	print_r($map);	
*/
?>
