<?php 
	session_start();
	function wrongUsrnamPas(){
		header("location:./signin.php?login=1");
	}

	if(!isset($_SESSION["type"])){

	if(isset($_POST["username"]) && isset($_POST["password"])){

		$username = $_POST["username"];
		$password = $_POST["password"];

		$connection = mysql_connect("localhost","root","");

		$db_select = mysql_select_db("pak-china-trad",$connection);

		$sql = "SELECT o.type , o.id , o.location ,person_name,email,phone 
				FROM office o , employee e
				WHERE e.id = (SELECT employee_id
								FROM user_account
								WHERE username =  '{$username}'
								AND password =  '{$password}')
				AND o.id = (SELECT location_id
								FROM employee
								WHERE id = (SELECT employee_id
											FROM user_account
											WHERE username =  '{$username}'
											AND password =  '{$password}' ) ) ";

		$result = mysql_query($sql,$connection);

		if($result === FALSE) {
    			mysql_close($connection);
    			
    			wrongUsrnamPas();
		}else{

			$id = false;
			while ($row = mysql_fetch_array($result)) {
				$id = true;

				$_SESSION["type"] = $row["type"];
				$_SESSION["office_id"] = $row["id"];
				//$_SESSION["employee_id"] = $row["emp_id"];
				$_SESSION["location"] = $row["location"];
				$_SESSION["person_name"] = $row["person_name"];
				$_SESSION["email"] = $row["email"];
				$_SESSION["phone"] = $row["phone"];
			}

			if($id === false){
				wrongUsrnamPas();
			}

			mysql_close($connection);
		}

		
		
	}else{
		wrongUsrnamPas();
	}

}
 ?>