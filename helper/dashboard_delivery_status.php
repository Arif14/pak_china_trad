
<?php
	
	include("helper_functions.php");
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}

	function dateWiseUpdate(&$conn,$office_id){

		$date = date("y-m-d");

		$sql = "SELECT id,customer_name,from_location,to_location,size,status
				FROM transport
				WHERE to_location = (SELECT location 
									 FROM office
									 WHERE id = {$office_id})
				AND end_date = '{$date}'";

		$result =  mysql_query($sql,$conn);

		while($row = mysql_fetch_array($result)){
			//echo print_r($row);

			$html = "<tr>
						<td>{$row['id']}</td>
						<td>{$row['customer_name']}</td>
						<td>{$row['from_location']}</td>
						<td>{$row['to_location']}</td>
						<td>{$row['size']}</td>
						<td>{$row['status']}</td>
					</tr>";
			echo $html;
		}

	}
	function idWiseUpdate($transport_id,&$conn){

	}

	function updateDeliveryStatus(&$conn){



			if(isset($_POST['transport_id'])){				
				idWiseUpdate($_POST['transport_id'],$conn);
			}else{				
				dateWiseUpdate($conn,$_SESSION["office_id"]);
			}

	}
?>

<div class="middle">

	<form class="form-horizontal" method="post" action="./dashboard.php?side_active=1">
		<div class="form-group">
			<label class="col-sm-3 control-label">Enter Transport Id</label>
			<div class="col-sm-3">
				<input class="form-control" name="transport_id" type="text" placeholder="id" />
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-3">
				<button type="submit" class="btn btn-default">Search</button>
			</div>
		</div>
	</form>

	<table class="table table-striped table-bordered">
		<tr>
			<th>id</th>
			<th>Customer Name</th>
			<th>From</th>
			<th>To</th>
			<th>Size</th>
			<th>Status</th>			
		</tr>

		<?php 
			global $conn; 
			updateDeliveryStatus($conn); 
		?>
	</table>
</div>