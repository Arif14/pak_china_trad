<?php 

		include("helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}


		function updateTable(&$conn){
		$from_id = $_SESSION["office_id"];
		$to_ids = getToIds($from_id,$conn);
		

		foreach ($to_ids as $key => $to_id) {
			
			$sql = "SELECT count(a.transport_id), b.location , a.truck_id
					from truck_transport_rel a , office b 
					 WHERE a.truck_id = (select id 
					 					from truck 
					 					where from_id =  {$from_id} 
					 					and to_id = {$to_id} 
					 					and date_send is null) 
					and b.id = {$to_id} 
					group by b.location";

			$result = mysql_query($sql,$conn);
			while($row = mysql_fetch_array($result)){
				echo "<tr><td>{$row['location']}</td>
					<td>{$row['count(a.transport_id)']}</td>" .
					'<td><form method="post" id="send_form" action="' .
					"http://localhost/pak_china_template/helper/dashboard_send_submit.php?truck_id={$row['truck_id']}" .
					'"><button class="btn btn-default" id="send_btn" type="submit">
					 Send</button></form></td></tr>';

			}
		}


		}

?>

<div class="middle">
	<table class="table table-striped table-bordered">
		<tr>
			<th>To Location</th>
			<th>Items</th>
			<th>Send</th>			
		</tr>
		 

			<?php 
			global $conn;
			updateTable($conn);?>
			
		
	</table>
</div>

<script>

	$("#send_btn").click(function(e){
		e.preventDefault();

		var url = $("#send_form").attr("action");
		
		$(".main").load(url);

	});

</script>