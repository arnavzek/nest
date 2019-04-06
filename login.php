	


<?php

	require_once 'mysqlconnect.php';

	if(isset($_COOKIE['lluda_token'])) {

		 header('location: index.php?user=0');

	}

	

	if(isset($_POST['email'])){

	    	
	        $email = mysqli_real_escape_string ($conn , strtolower( $_POST['email']) );
    		$password = mysqli_real_escape_string ($conn , $_POST['password'] );

    		$authen = $conn->query("SELECT id, password , name, token FROM users WHERE address ='$email' OR pen_name='$email' ");

    		//echo $authen;

    		if ($authen->num_rows === 1) {

    			    while($row = $authen->fetch_assoc()) {

		 			$hashed_password = $row["password"];

		 			$id_string = $row["id"];

		 			$result = password_verify( $password ,$hashed_password );

			 			if ($result === TRUE) {


								$token = $row["token"];

								if($token === ''){	// if in some case token in the database is modified

									$cstrong = TRUE;
 
                                	$token = bin2hex( openssl_random_pseudo_bytes(64,$cstrong) );
 
                                	$sha_token = $token;
 
                                	$sqlAddition = "UPDATE users SET token = '$sha_token' WHERE id = '$id_string'";
                                	                                
                                	    if ($conn->query($sqlAddition) === TRUE) {
 
                                    		setcookie('lluda_token', $token, time()+(86400 * 360), "/",NULL,NULL, TRUE);
 
                                    		 header('location: index.php?user=0');
                                 
                                			}

								}else{


			    				setcookie('lluda_token', $token, time()+(86400 * 360), "/",NULL,NULL, TRUE);

			    					 // if ($_SERVER["HTTP_REFERER"]) {
								    	// header('location: '.$_SERVER["HTTP_REFERER"]);
								     // }else{
								    	header('location: index.php');
								     // }
			    			}

			    			// azad chowk misar tola infront chandra shekhar azad 
			 				
			 			}else{
			 				echo("<h3> Wrong password ".$row["name"]."</h3>");
			 			}

					}


    		}else{
    			echo("<h3>! Wrong Email</h3>");
    		}

	}

?>

<!DOCTYPE html>
<html>

<head>

	
	  <meta name="mobile-web-app-capable" content="yes">

	  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >

	  <link rel="icon" href="images/logo.png" sizes="16x16" type="image/png">

	  <meta charset="UTF-8">



	<title>
		nest | login
	</title>

	<link rel="stylesheet" type="text/css" href="spare.css">

	<style type="text/css">
	

		/*warning*/

		input{
			border: none;
		    background: transparent;
		    border-radius: 0.5vw;
		    padding: 1vw;
		    width: 58%;
		    font-size: 1.5vw;
		    border: 0.1vw solid;
		}




	</style>
	<title>Sign Up</title>
</head>
<body>

		<main>
		<img src="images/logo.png">
		<medium>fleeke</medium>
	</main>


	<div>

			<center>
			
				<h1>Login</h1>
				<form  action="login.php" method="post">
		        <input type="text" name="email"   placeholder="Email" id="Textboxes" maxlength="50"><br><br>
		        <input type="password" name="password" placeholder="Password" id="Textboxes" maxlength="15"><br><br><br>
		        <input id="signupButton" type="submit" name="submit" value="Log me in" >
		        </form>

			</center>

		</div>

</body>
</html>
