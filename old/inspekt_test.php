<?php require_once('../lib/inspekt/Inspekt.php'); 

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


$name = "";
$email = "";
$website = "";
$comment = "";


$validated = TRUE;
$name_valid = true;
$email_valid = true;
$website_valid = true;
$gender_valid = true;

array("name" => array("isAlpha" => $val))
array("name" => true)


function validateAlpha()


if ($_SERVER["REQUEST_METHOD"] == "POST") {



  $name = test_input($_POST["name"]);
  if(!Inspekt::isAlpha($name)){
  		$name_valid = false;
  		$validated = false;
  	}
  $email = test_input($_POST["email"]);
  if(!Inspekt::isEmail($email)){
  	$email_valid = false;
  	$validated = false;
  }
  $website = test_input($_POST["website"]);

  if(!Inspekt::isUri($website)){
  	$website_valid = false;
  	$validated = false;
  }
  $comment = test_input($_POST["comment"]);
  if(isset($_POST["gender"])){
  		$gender = test_input($_POST["gender"]);
	}else{
		$gender_valid = false;
		$validated = false;
	}
}

	
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
	<?php if(!$name_valid){ echo "<h1> name is invalid </h1>";} ?>
	<label>Enter Name :</label>
	<input type="text" name="name" value"<?php echo $name; ?>"></br>
	<?php if(!$email_valid){ echo "<h1> email is invalid </h1>";} ?>
	<label>Enter Email :</label>
	<input type="email" name="email"></br>
	<?php if(!$website_valid){ echo "<h1> website is invalid </h1>";} ?>
	<label>Enter Website :</label>
	<input type="url" name="website"></br>
	<label>Enter Comment :</label>
	<textarea name="comment"></textarea></br>
	<?php if(!$gender_valid){ echo "<h1> invalid gender </h1>";} ?>
	<input type="radio" name="gender" value="Male">Male</br>
	<input type="radio" name="gender" value="Female">Female</br>
	<input type="submit" value="submit">
</form>



<?php

	function Validate($dataArray){
		//  save each value in variable;
		//  get validated one by one.  
		//  if any false then show the form

	}

?>