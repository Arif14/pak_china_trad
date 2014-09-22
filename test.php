
<html>
	
	<body>
	<?php
		$map = array(
			1 => array(
				'vertex' => 1,
				'visited' => false,
				'sides' => array(2)
				),
			2 => array(
				'vertex' => 2,
				'visited' => false,
				'sides' => array(1,3,4)
				),
			3 => array(
				'vertex' => 3,
				'visited' => false,
				'sides' => array(2)
				),
			4 => array(
				'vertex' => 4,
				'visited' => false,
				'sides' => array(2,5,7)
				),
			5 => array(
				'vertex' => 5,
				'visited' => false,
				'sides' => array(4,6)
				),
			6 => array(
				'vertex' => 6,
				'visited' => false,
				'sides' => array(5)
				),
			7 => array(
				'vertex' => 7,
				'visited' => false,
				'sides' => array(4,8)
				),
			8 => array(
				'vertex' => 8,
				'visited' => false,
				'sides' => array(7,10,9)
				),
			9 => array(
				'vertex' => 9,
				'visited' => false,
				'sides' => array(8)
				),
			10 => array(
				'vertex' => 10,
				'visited' => false,
				'sides' => array(8,11)
				),
			11 => array(
				'vertex' => 11,
				'visited' => false,
				'sides' => array(10)
				)
		);
	

	function &createMap(){
		$map = "";

		$file = fopen("./database_input/map_input.txt","r");

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
	}

	$found = false;
	
		function dfs($node,$list,$item){
			global $found;
			if(!$node['visited']){
				

				if($node['vertex'] == $item){
					echo "true"."</br>";
					$found = true;
				}
					
					$list[$node['vertex']]['visited'] = true;
					foreach ($node['sides'] as $side) {
						if($found===true){
								
								return;
							}
						//echo print_r($list[(int)$side]) . "<br/>";
							
						if(!$list[(int)$side]['visited'] ){


							dfs($list[(int)$side],$list,$item);
						}
					}

				
			}
			if($found){
			echo $node['vertex']."</br>";
			}
		}
/*
		foreach ($map as $key => $value) {
			echo "key" . $key . " : " . print_r($value) ."<br/>";
		}

		echo "<br/><br/>";
		$map =& createMap();
		foreach ($map as $key => $value) {
			echo "key" . $key . " : " . print_r($value) ."<br/>";
		}
*/

		$map =& createMap();
	//	echo print_r($map[2]);
		dfs($map[1],$map,9);
		//echo $map[1]['visited'] . "</br>";
	?>
	</body>
</html>