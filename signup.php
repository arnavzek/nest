<?php 

require_once 'mysqlconnect.php';


	if(isset($_COOKIE['lluda_token'])) {

		 header('location: index.php?user=0');

	}


if (isset($_POST['submit']) ) {


	if( $_POST['fullname'] && $_POST['email'] && $_POST['password'] ){

	

	$email =  mysqli_real_escape_string ($conn , trim( strtolower( $_POST['email'] ) ) );
	$full_name =  ucwords( mysqli_real_escape_string ($conn , trim( strtolower( $_POST['fullname'] ) ) ) ) ;
	$user_id = str_replace(" ", '_', $full_name)."_".uniqid('',true);
	$password =  mysqli_real_escape_string ($conn , $_POST['password'] ) ;


if (filter_var($email, FILTER_VALIDATE_EMAIL)) {





	$check = $conn->query("SELECT address FROM users WHERE address='$email'");


  	if ($check->num_rows != 0)
 	 {

      echo "<h3> Account already exist </h3>";

 	 } else {

 	 		$hashed = password_hash($password, PASSWORD_BCRYPT);

			$check_nou = $conn->query("SELECT * FROM users WHERE name='$full_name' ");

			$full_name_filtered =   mysqli_real_escape_string ($conn , trim( strtolower( $full_name ) ) ) ;

			$new_penname = str_replace(" ", '', $full_name_filtered).$check_nou->num_rows;

			$check_user_id_q = $conn->query("SELECT pen_name FROM users WHERE pen_name='$new_penname' ");

				if ($check_user_id_q->num_rows != 0){

			 	 	$new_penname = str_replace(" ", '', $full_name_filtered)."".$check_nou->num_rows."-".uniqid('',true);
			 	 	
			 	 }

			 	 $user_id = $new_penname;


		 	 	$cstrong = TRUE;

				$sha_token = bin2hex(openssl_random_pseudo_bytes(32,$cstrong)).$user_id;

				$hash_token = bin2hex(openssl_random_pseudo_bytes(16,$cstrong)).$user_id;

				$sqlAddition = "INSERT INTO users (name, pen_name ,address, last_seen, token,hash,profile ,password)
	                    	VALUES (  '$full_name', '$new_penname','$email', now(),'$sha_token','$hash_token','','$hashed')";


		if ($conn->query($sqlAddition) === TRUE) {

				setcookie('lluda_token', $sha_token, time()+(86400 * 360), "/",NULL,NULL, TRUE);

	
				    // new user message on the main page.

				    // echo($_SERVER["HTTP_REFERER"]);

				     // if ($_SERVER["HTTP_REFERER"]) {

				    	// header('location: '.$_SERVER["HTTP_REFERER"]);
				    	
				     // }else{

				    	header('location: verify.php?resend='.$email);

				     // }	


				




   		    


		}else {
    	echo "Error: " . $sql . "<br>" . $conn->error;
		}
 	 }


} else {
  echo("<h3> $email is not a valid email address </h3>");
}


}else{
	 echo("<h3> Fill up everything! </h3>");
}

}

//}

?>

<!DOCTYPE html>
<html>
<head>


	  <meta name="mobile-web-app-capable" content="yes">

	  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >

	  <link rel="icon" href="images/logo.png" sizes="16x16" type="image/png">

	  <meta charset="UTF-8">


	<link rel="stylesheet" type="text/css" href="spare.css">

	<style type="text/css">
		


		h3{
			text-align: center;
			font-family: fontey;
		    padding: 1vw;
		    font-size: 2.5vw;
		    color: #1001016b;
		    background: tomato;
		}



		input{
			border: none;
		    background: transparent;
		    border-radius: 0.5vw;
		    padding: 1vw;
		    width: 58%;
		    font-size: 1.5vw;
		    border: 0.1vw solid;
		}


		#signupButton{
			background: linear-gradient(-15deg,#ffe364,55%,#fe7ea1);
		    border-radius: 0.5vw;
		    padding: 1vw 2vw;
		    font-size: 2vw;
		    color: #fff;
		    width: 62%;
		    cursor: pointer;
		}

	</style>
	<title>Sign Up</title>
</head>
<body>


	<main>
		<img src="images/logo.png">
		<medium>nest</medium>
	</main>


	<div>

		<center>
		<h1> Join nest </h1>
		<form action="signup.php" method="post">
        <input type="text" name="fullname" placeholder="Full Name" id="Textboxes" maxlength="30"><br><br>
        <input type="text" name="email"   placeholder="Email" id="Textboxes" maxlength="50"><br><br>
        <input type="password" name="password" placeholder="Password" id="Textboxes" maxlength="15"><br><br>
        <input id="signupButton" type="submit" name="submit" value="Join fleeke" >
        </form>
	</center>

	</div>

</body>
</html>
