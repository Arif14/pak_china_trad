<?php

		include("../../helper_functions.php");
	
		$conn = checkSessionStatus_and_connect();
		if(!$conn){
			die("session not connected");
		}


		function createQuery($location_name,$office_type){

			$sql = 'SELECT *
					FROM office o 
					WHERE ';
			$where = "TRUE";
			
			if(strcmp($location_name,"")){
				$where .= " AND location =  '{$location_name}'";
			}
			if(strcmp($office_type,"")){
				$where .= " AND type =  '{$office_type}'";
			}

			$sql .= $where;
			echo $sql."</br>";
			return $sql;

		}

?>


<div class="middle">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Id</th>
				<th>Location</th>
				<th>Office Type</th>
				<th>Map Coordinate</th>
				<?php 
					if(isset($_POST['delete'])){
				?>

				<th>Delete</th>

				<?php
					}
				?>
			</tr>
		</thead>
		<tbody>
			
				<?php 
					
					$sql = createQuery($_POST['location_name'],$_POST['office_type']);

					$result = mysql_query($sql,$conn);


					while($row = mysql_fetch_array($result)){
						$html =  " <tr> 
										<td>{$row['id']}</td>
										<td>{$row['location']}</td>
										<td>{$row['type']}</td>
										<td>{$row['map_cord']}
								   </td>";
						if(isset($_POST['delete'])){

						$html .= '<td><button type="button" my_id = '.$row['id'].' class="btn btn-danger del_btn">Delete</button></td>';

						}
						$html .= "</tr>";

						echo $html;
						
					}
				?>
			
		</tbody>
	</table>

	
</div>

<script>
	$(".del_btn").on("click",function(e){
		e.preventDefault();
		var id =  $(this).attr('my_id');
		
		console.log($(this).parent().parent().remove());

		$.post( "http://localhost/pak_china_template/helper/admin/office/delete_office_submit.php", {my_id: id} );
	});

</script>