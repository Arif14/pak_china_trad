<?php
	
	

	//$conn = "";

	function checkSessionStatus_and_connect(){
			session_start();
			
			if(isset($_SESSION["type"])){
				$conn =& db_connect_header();
				
				return $conn;
			}
		return false;
	}

	function &db_connect_header(){
		$conn = mysql_connect("localhost","root","");
		mysql_select_db("pak-china-trad",$conn);
		//echo $conn;
		return $conn;
	}


	function db_connect_footer(&$conn){		
		mysql_close($conn); 
	}
	
		function test_input($data) {
		  $data = trim($data);
		  $data = stripslashes($data);
		  $data = htmlspecialchars($data);
		  return $data;
		}


	//
	

	function &createMap(){
	
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
	
		/*
		$map = "";

		$file = fopen("../database_input/map_input.txt","r");

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
		fclose($file);

		return $map;
		*/


	}


	function &createPath($map,$from_location,$to_location_id){

		dfs($map[$from_location],$map,$to_location_id);
		global $path;
		
		return $path;
	}


	$found = false;
	$path = array();
		function dfs($node,$list,$item){
			global $found;
			global $path;
			
			if(!$node['visited']){
				

				if($node['vertex'] == $item){
					
					$found = true;
				}
					
					$list[$node['vertex']]['visited'] = true;
					print_r($list[$node['vertex']]);
					foreach ($node['sides'] as $side) {
						if($found===true){
							array_unshift($path,$node['vertex']);
							//echo "before return ". $node['vertex'] . "<br/>";
								return;
							}
							
						if(!$list[(int)$side]['visited'] ){
							//echo "side " . $side . "<br/>";

							dfs($list[(int)$side],$list,$item);
						}
					}

				
			}
			if($found){
			array_unshift($path,$node['vertex']);
			//echo $node['vertex'] . '</br>';
			}
		}

	

	function getToIds($from_id,&$conn){
		

		$sql = "SELECT to_location FROM office_map WHERE from_location = $from_id";

		$result = mysql_query($sql,$conn);

		$to_ids = array();

		while($row = mysql_fetch_array($result)){
			array_push($to_ids,$row['to_location']);
		}

		

		return $to_ids;
	}

	function getToLocations($to_ids,&$conn){
		

		
		$to_locations = array();

		foreach ($to_ids as $key => $id) {
				$sql = "SELECT location FROM OFFICE WHERE id = {$id}";
				$result =  mysql_query($sql,$conn);
				
				while($row  = mysql_fetch_array($result)){
					array_push($to_locations, $row['location']);
				}

		}

		
		return $to_locations;		

	}


	function getLocations(&$conn){
		$locations = array();

		$sql = "SELECT location FROM office";
		$result = mysql_query($sql);

		while($row = mysql_fetch_array($result)){
			array_push($locations,$row['location']);
		}

		return $locations;
	}

	/// insert into Truck

	function insertToTruck($transport_id,$from_id,&$conn){

		$to_ids = getToIds($from_id,$conn);

		

		$sql = "SELECT path FROM transport WHERE id = $transport_id ";

		$result =  mysql_query($sql,$conn);

		$path = "";

		while($row = mysql_fetch_array($result)){
			$path = $row['path'];
		}

		$path = explode("#", $path);

		foreach ($to_ids as $key => $value) {

		//echo "from id " . $from_id . "<br/>";
		//	echo "to id " . $value . "<br/>";
		//echo "array_search(from_id,path) : ".  array_search($from_id,$path) . "<br/>";
		//echo "array_search(value,path) : ".  array_search($value,$path) . "<br/>";
		


			if(!is_bool(array_search($from_id,$path)) && !is_bool(array_search($value,$path))){
				if(array_search($from_id,$path)>array_search($value,$path)){
					//echo "inside if true" . "<br/>";
					continue;
				}
			}else{
				//echo "inside if else" . "<br/>";
				continue;
			}

			$sql = "SELECT id FROM truck WHERE from_id = $from_id AND to_id = $value AND date_send is null";

			$result = mysql_query($sql,$conn);

	//		echo $sql . "<br/>";

			if(mysql_num_rows($result)){

				//echo "true if";

				while($row = mysql_fetch_array($result)){

					


					$sql = " INSERT INTO 
					truck_transport_rel (truck_id,transport_id) 
					VALUES({$row['id']},$transport_id) 
					";

				//	echo $sql . "<br/>";

					mysql_query($sql,$conn);
				}

			}else{

				//echo "true else";


				$sql = "INSERT INTO truck(from_id,to_id) VALUES($from_id,$value)";

				$result = mysql_query($sql,$conn);

				$sql = "SELECT id FROM truck where from_id = $from_id && to_id = $value";

				$result = mysql_query($sql,$conn);

				while($row = mysql_fetch_array($result)){
					$sql = " INSERT INTO 
					truck_transport_rel (truck_id,transport_id) 
					VALUES({$row['id']},$transport_id) 
					";
					mysql_query($sql,$conn);
				}
			}
		}



	//	mysql_close($conn);

	}


	function getOfficeType($id,&$conn){

		

		$sql = "SELECT type FROM office WHERE id = {$id}";

		$result = mysql_query($sql,$conn);

		$type = "";

		while($row = mysql_fetch_array($result)){
			$type = $row['type'];
		}

		return $type;

	}

?>