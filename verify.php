

<?php

require 'vendor/autoload.php';
require_once 'mysqlconnect.php';



	if(!isset($_COOKIE['lluda_token'])) {

		 header('location: index.php?user=0');

	}


	$token_login = $_COOKIE['lluda_token'];

	$check_cookie = $conn->query("SELECT * FROM users WHERE token='$token_login' ");


		while ($row = $check_cookie->fetch_assoc() ) {
				
				$Users_name = $row['name'];

				$Users_name_id = $row['id'];
				$Usr_pen_name =  $row['pen_name'] ;
				$usr_seen = $row["last_seen"];
				$Usr_pen_email = $row["address"];
				$Usr_pen_pass = $row["password"];
				$Usr_pen_bio =  $row["bio"];
				$Usr_pen_hash =  $row["hash"];
				$Usr_pen_pro =  $row["profile"];
		}




if(isset($_GET['pen']) && !empty($_GET['pen']) && isset($_GET['hash']) && !empty($_GET['hash'])){

	$token_login = $_GET['hash'];
	$token_pen = $_GET['pen'];

	$check_cookie = $conn->query("SELECT * FROM users WHERE hash='$token_login' AND pen_name='$token_pen'");

	if($check_cookie->num_rows === 0) {

		echo "<h3>Invalid request</h3>";

	}else{

		while ($row = $check_cookie->fetch_assoc() ) {

			$current_id = $row['id'];
			$check_cookie = $conn->query("UPDATE users SET type = '1' WHERE id='$current_id' ");

			header("location: index.php?setup=true");

			setcookie('lluda_token', $row['token'], time()+(86400 * 360), "/",NULL,NULL, TRUE);
		}

	}


}else if( isset ( $_GET['resend'] ) ){


				$to = $_GET['resend']; // Send email to our user
				$check_cookie = $conn->query("UPDATE users SET address = '$to' WHERE id='$Users_name_id' ");

				$Usr_pen_email = $to;

				$subject = 'nest | Verification'; // Give the email a subject 
				$message = '

				



			


			<div style="    padding: 1vw;
    background: linear-gradient(55deg,#ec7b6f,#F44336);
    width: 98%;
    height: 5vw;
    display: inline-block;" >

			<img style="height: 5vw; float: left; width: 5vw;" src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">

			<a href="'.$main_domain.'" style="    text-decoration: none;
    font-size: 4vw;
    margin-left: 1vw;
    font-family: roboto;
    font-weight: 900;
        font-family: Passion One;
    color: #fff;" >nest</a>

			</div>

		
				 
				
		<h1>Hello!, '.$Users_name.'</h1>
		
		<br><br>
				 
				<a style="
    font-size: 1.8vw;
    text-decoration: none;
    font-weight: 900;
    background: #121313;
    padding: 1.5vw;
    border-radius: 0.5vw;
    color: #fff;
" id="signupButton" href="'.$main_domain.'/verify.php?&hash='.$Usr_pen_hash.'&pen='.$Usr_pen_name.' "> Confirm my email </a>


<br><br><br>
	
				 
				'; // Our message above including the link
				                     






				 // Send our email






$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("noreply@".$main_domain);
$email->setSubject($subject);
$email->addTo($to);

$email->addContent( "text/html", $message
);

$sendgrid = new \SendGrid( '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' );

try {

    $response = $sendgrid->send($email);

    if ($response->statusCode() === 200  || $response->statusCode() === 201 || $response->statusCode() === 202) {
    		

    	echo("<h3>Mail sent</h3>");


    }else{

    	echo("<h3>Mail not send</h3>");

    }

} catch (Exception $e) {

    echo 'Caught exception: ',  $e->getMessage(), "\n";
}



   
}


if($_SERVER['HTTP_HOST'] === "localhost"){

echo '<h3><a id="signupButton" href="'.$main_domain.'/verify.php?&hash='.$Usr_pen_hash.'&pen='.$Usr_pen_name.' "> Confirm my email </a></h3>';

}

// email testing

?>

<!DOCTYPE html>
<html>
<head>


	  <meta name="mobile-web-app-capable" content="yes">

	  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >

	  <link rel="icon" href="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke_logo.png" sizes="16x16" type="image/png">

	  <meta charset="UTF-8">



	<title>nest | verify</title>
</head>

<link rel="stylesheet" type="text/css" href="spare.css">

<body>

</body>
</html>

	<main>
	<img src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">
	<medium>nest</medium>
	</main>

<div>
	
	<h1>Check your email</h1>
	<span>please confirm your email address by the link we have sent you at <b><?php echo $Usr_pen_email; ?></b> </span>
	<br>


	<form action="" method="get">
		<input type="text" id='resend_input' name="resend" value="<?php echo $Usr_pen_email; ?>">
		<input type="submit" id='resend_submit' value="Resend"><br><br>	<br>	
	</form>

</div>