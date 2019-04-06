<?php

if (session_status() == PHP_SESSION_NONE) {

    session_start();
    
}




require_once 'mysqlconnect.php';
require_once 'apiKeys.php';
require_once 'vendor/autoload.php';

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

if($_SERVER['HTTP_HOST'] === "localhost"){

	$actual_link_fb =	"http://localhost/nest/redirect_fb.php";
}else{

	if( isset(	$_SERVER['HTTPS'] ) ){
		$actual_link_fb =	"https://$_SERVER[HTTP_HOST]/".'redirect_fb.php';
	}else{
		$actual_link_fb =	"http://$_SERVER[HTTP_HOST]/".'redirect_fb.php';
	}


	

}


// //echo ($actual_link_fb );


$redirect_fb_link = $actual_link_fb ;

$fb = new Facebook\Facebook([
  'app_id' => $FacebookApi['app_id'], // Replace {app-id} with your app id
  'app_secret' => $FacebookApi['app_secret'],
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();




try{




	if ($session = $helper->getAccessToken() ) {


		echo "token";

		$cookie_vale = $session->getValue();


		// header("location:index.php");
		 
		$response = $fb->get('/me?fields=id,name,picture,email', $cookie_vale );

		$user = $response->getGraphUser();

		$user_name_rd = ucwords( mysqli_real_escape_string ($conn , trim( strtolower( $user['name'] ) ) ) );
		$user_id_rd = mysqli_real_escape_string ($conn , trim( strtolower( $user['id'] ) ) );
		$user_id_email = mysqli_real_escape_string ($conn , trim( strtolower( $user['email'] ) ) );
		$user_id_image = mysqli_real_escape_string ($conn , trim( $user['picture']['url'] ) );



			$check_gl = $conn->query("SELECT * FROM users WHERE address='$user_id_email' ");

		  	if ($check_gl->num_rows != 0 && $user_id_email != ''){

		 	 	while ($row_gl = $check_gl->fetch_assoc() ) {

		 	 		$current_id = $row_gl['id'];
		 	 		
		 	 		 $sha_token = $row_gl['token'];


		 	 		 echo ("account_already_exist");

		 	 		 echo  "<br>";

		 	 		 echo  $sha_token;

		 	 		 echo  "<br>";

		 	 		 $update_data = $conn->query("UPDATE users SET  fb_id='$user_id_rd' , name='$user_name_rd' , address='$user_id_email' WHERE id='$current_id' ");

		 	 		 if ($sha_token === NULL || $sha_token === 'undefined' || $sha_token === ""  ) {

		 	 		 		 //echo ("token_empty");
		 	 		 		
		 	 		 		$cstrong = TRUE;
							$sha_token = bin2hex(openssl_random_pseudo_bytes(32,$cstrong)).$user_id_rd;
							$dislike_query = $conn->query("UPDATE users SET token = '$sha_token' WHERE id='$current_id' ");
		 	 		 }

		 	 	}

		 	 	$locaton_redirect_set = " index.php";

		 	 }else{


		 	 					//get a unique no based on user name
				$check_nou = $conn->query("SELECT * FROM users WHERE name='$user_name_rd' ");

				$full_name_filtered =   mysqli_real_escape_string ($conn , trim( strtolower( $user_name_rd ) ) ) ;

				$new_penname = str_replace(" ", '', $full_name_filtered)."".$check_nou->num_rows;

				$check_user_id_q = $conn->query("SELECT pen_name FROM users WHERE pen_name='$new_penname' ");

				if ($check_user_id_q->num_rows != 0){

			 	 	$new_penname = str_replace(" ", '', $full_name_filtered)."".$check_nou->num_rows."-".uniqid('',true);
			 	 	
			 	 }


			 	 		//upload image


		 	 			require_once 'parent_s3.php';
						// For this, I would generate a unqiue random string for the key name. But you can do whatever.

						$url = $new_penname.".jpg";

						$binary = file_get_contents($user_id_image);

					    // $filename = compress_image( $user_id_image, $_FILES["post_image"]["tmp_name"], 100 );

						$keyName = 'profile/' . $url;
						$pathInS3 = 'http://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
						// Add it to S3

						// echo"<br>". $user_id_image."<br>";
						try {
							// Uploaded:
							$file = $binary;
							$s3->putObject(
								array(
									'Bucket'=> $bucketName,
									'Key' =>  $keyName,
									'Body' => file_get_contents($user_id_image), // put the binary in the body
									'StorageClass' => 'REDUCED_REDUNDANCY'
								)
							);
						} catch (S3Exception $e) {
							die('Error:' . $e->getMessage());
						} catch (Exception $e) {
							die('Error:' . $e->getMessage());
						}

							$user_id_image = "https://s3.us-east-2.amazonaws.com/lluda-main/profile/".$url;




		 	 	 	 	$locaton_redirect_set = " index.php?setup=true";

		 	 	echo ("new_user");

		 	 	$cstrong = TRUE;

				$sha_token = bin2hex(openssl_random_pseudo_bytes(32,$cstrong)).$user_id_rd;

				$sqlAddition = "INSERT INTO users (fb_id , name ,pen_name ,type,address,last_seen, token,profile)
	                    	VALUES ( '$user_id_rd' , '$user_name_rd','$new_penname', '1','$user_id_email', now(),'$sha_token','$user_id_image')";

				if ($conn->query($sqlAddition) === TRUE) {

					echo ("account_created");

				}else{
					 echo "Error: " . $sql . "<br>" . $conn->error;
				}


		 	 }




			setcookie('lluda_token', $sha_token , time()+(86400 * 360), "/",NULL,NULL, TRUE);

			echo ("token_set");

			header("location:".$locaton_redirect_set);



	}




}catch (Facebook\FacebookRequestException $e){




	// //echo ($e);

}catch(\Exception $e){



	// //echo ($e);

}

// $_SESSION['FBRLH_state'] = $_GET['state'];



?>
