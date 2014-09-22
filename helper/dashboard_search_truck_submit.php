<?php

include("helper_functions.php");
	
		$conn  =& db_connect_header();
		if(!$conn){
			die("session not connected");
		}

		//echo "post length " . print_r($_POST);

		

		function getTruckSearchResults($sql,$conn){

			

			$results =  mysql_query($sql,$conn);

				while($row = mysql_fetch_array($results)){
					echo " <tr>
							<td>{$row['id']}</td>
							<td>{$row['from_id']}</td>
							<td>{$row['to_id']}</td>
							<td>{$row['date_send']}</td>
							<td>{$row['date_recieved']}</td>
						   </tr>								
						";
				}

		}

		function createQuery($from_location,$to_location,$date_send,$date_recieved){
			$sql = 'SELECT t.id,o1.location "from_id" ,o2.location "to_id",t.date_send,t.date_recieved 
					FROM truck t,office o1,office o2 
					WHERE o1.id = t.from_id
					AND o2.id = t.to_id';

			$where = "";

			if(strcmp($from_location,"none")){				
					$where .= " AND t.from_id =  (SELECT id FROM office WHERE location = '{$from_location}' )";
			}
			if(strcmp($to_location,"none")){
				$where .= " AND t.to_id =  (SELECT id FROM office WHERE location = '{$to_location}' )";
			}
			if(strcmp($date_send,"")){
				$where .= " AND t.date_send =  '{$date_send}'";
			}
			if(strcmp($date_recieved,"")){
				$where .= " AND t.date_recieved =  '{$date_recieved}'";
			}

			$sql .= $where;

			return $sql;

		}


		

?>


<div class="middle">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Truck Id</th>
				<th>From Location</th>
				<th>To Location</th>
				<th>Send Date</th>
				<th>Recieved Date</th>
			</tr>
		</thead>
		<tbody>
			
				<?php 
					$sql = createQuery($_POST['from_location'],$_POST['to_location'],$_POST['send_date'],$_POST['recieve_date']);

					//echo "sql statement {$sql} </br>";

					getTruckSearchResults($sql,$conn);
				?>
			
		</tbody>
	</table>
</div>

