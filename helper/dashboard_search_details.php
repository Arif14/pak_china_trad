<?php
	include("helper_functions.php");
	
		$conn  =& db_connect_header();
		if(!$conn){
			die("session not connected");
		}

		$id = 0;

		if(!$_GET['transport_id']){
			die("transport_id not found");
		}else{
			$id = $_GET['transport_id'];
		}

?>



<script>
var map;

function initialize()
{
		var mapProp = {
		  center:new google.maps.LatLng(39.962625, 79.047010),
		  zoom:5,
		  mapTypeId:google.maps.MapTypeId.ROADMAP
		  };
		map=new google.maps.Map(document.getElementById("googleMap")
		  ,mapProp);
}

		//google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="middle">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>From Location</th>
					<th>To Location</th>
					<th>Start Date</th>
					<th>End Date</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$sql = "SELECT t.date_send, t.date_recieved, s.location start_loc, r.location end_loc
							FROM truck t, office s, office r
							WHERE t.id
							IN (SELECT truck_id
								FROM truck_transport_rel
								WHERE transport_id ={$id})
							AND s.id = t.from_id
							AND r.id = t.to_id";

					$result =  mysql_query($sql,$conn);

					while($row = mysql_fetch_array($result)){
						echo "<tr>".
							"<td> {$row['start_loc']} </td>".
							"<td> {$row['end_loc']} </td>".
							"<td> {$row['date_send']} </td>".
							"<td> {$row['date_recieved']} </td>".
							"</tr>";
					}
				?>			
			</tbody>

		</table>

	<div id="googleMap" style="width:500px;height:380px;"></div>	
</div>
<h1 id="data" class="hidden" >hello</h1>

<script>

	
	
	 $("#data").load("gdata.js",function(){
	 	initialize();
		    	var str = $("#data").text();
		    	json =  $.parseJSON(str); 	
	
		    	//console.log("json : "+ json['a']);
		    	var tr = $("tr");
				$.each(tr,function(i,v){

					
					//console.log(i+":"+$(v).text());

					if(i>0){
						if(i==1){
								console.log("1");
						}
						$.each($($(v).html()),function(index,value){
							if(i==1 && index == 0){
								console.log($(value).text().trim());
								console.log("createMarker : "+ json[$(value).html().trim()]);
								var loc = $(value).html().trim()
								var jsonArr = json[loc];
								createMarker(jsonArr,loc);
								//createMarker(json[$(value).html()])
							}else if(index == 1){
								console.log("createMarker 1 : "+json[$(value).html().trim()]);
								var loc = $(value).html().trim();
								var jsonArr = json[loc];
								createMarker(jsonArr,loc);
							}
							//console.log(index +":"+ $(value).html());
						});
					}

				

				});
		    	
	    });

	function createMarker(jsonArr,loc){
		var marker=new google.maps.Marker({
										  position:new google.maps.LatLng(jsonArr[0],jsonArr[1]),
										  });

										marker.setMap(map);
		var infowindow = new google.maps.InfoWindow({
			  content:loc
			  });

			infowindow.open(map,marker);
	}



	 

	
	
</script>