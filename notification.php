<?php 
			require_once 'mysqlconnect.php';

	  // if(isset($_COOKIE['user_token'])) {

	  		 include_once("pannel.php");
		// }else{
			// header('location: index.php');
		// }


		function timeAgo($time_ago)
		{
		    $time_ago = strtotime($time_ago);
		    $cur_time   = time();
		    $time_elapsed   = $cur_time - $time_ago;
		    $seconds    = $time_elapsed ;
		    $minutes    = round($time_elapsed / 60 );
		    $hours      = round($time_elapsed / 3600);
		    $days       = round($time_elapsed / 86400 );
		    $weeks      = round($time_elapsed / 604800);
		    $months     = round($time_elapsed / 2600640 );
		    $years      = round($time_elapsed / 31207680 );
		    // Seconds
		    if($seconds <= 60){
		        return "just now";
		    }
		    //Minutes
		    else if($minutes <=60){
		        if($minutes==1){
		            return "one minute ago";
		        }
		        else{
		            return "$minutes minutes ago";
		        }
		    }
		    //Hours
		    else if($hours <=24){
		        if($hours==1){
		            return "an hour ago";
		        }else{
		            return "$hours hrs ago";
		        }
		    }
		    //Days
		    else if($days <= 7){
		        if($days==1){
		            return "yesterday";
		        }else{
		            return "$days days ago";
		        }
		    }
		    //Weeks
		    else if($weeks <= 4.3){
		        if($weeks==1){
		            return "a week ago";
		        }else{
		            return "$weeks weeks ago";
		        }
		    }
		    //Months
		    else if($months <=12){
		        if($months==1){
		            return "a month ago";
		        }else{
		            return "$months months ago";
		        }
		    }
		    //Years
		    else{
		        if($years==1){
		            return "one year ago";
		        }else{
		            return "$years years ago";
		        }
		    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Responses</title>
</head>
<body>

	<div id="content">
		<center>
			<div id='div_head'><div id='heading'>Responses</div></div>

			<div id='notif_pack'>

			<?php 

			$check_notif = $conn->query("SELECT notifications.sender,notifications.post_id ,notifications.type, notifications.sender ,notifications.created_at,posts.title FROM notifications INNER JOIN posts ON notifications.post_id = posts.id WHERE notifications.receiver='$Users_name_id' AND notifications.sender!='$Users_name_id' ORDER BY notifications.created_at DESC LIMIT 30");

				while($res = $check_notif->fetch_assoc()) {
					// notification data
					$send_usr = $res['sender'];
					$post_num = $res['post_id'];
					// $comment_info = $res['comment'];
					$posted_date = $res['created_at'];
					$posted_title = $res['title'];

					$check_name = $conn->query("SELECT * FROM users WHERE id='$send_usr' ");

					

					while($usr_row = $check_name->fetch_assoc()) {

							// getting the name

							$time_elapsed = timeAgo( $posted_date );


						/*	if($res['seen'] == 'false'){
								$seen_type = 'indivisual_not';
							}else{
								$seen_type = 'indivisual_note';
							}*/

							if( strtotime($posted_date) <= strtotime($usr_seen) ){
								$seen_type = 'indivisual_note';
							}else{
								$seen_type = 'indivisual_not';
							}



						if($res['type'] === 'like'){

							echo "<a href='post.php?id=".$post_num."'> <div  id='".$seen_type."'><span> ".$usr_row['name']."</span> elevated your story '".$posted_title."'.<div id='time_age'>".$time_elapsed." </div> </div> </a>";


						}else if($res['type'] === 'follow'){

							echo "<a href='user.php?profile=".$send_usr."'> <div id='".$seen_type."'><span>  ".$usr_row['name']." offered you a handshake  </span> <div id='time_age'>".$time_elapsed." </div> </div> </a>";


						}else if($res['type'] === 'reading'){

							echo "<a href='post.php?id=".$post_num."'> <div id='".$seen_type."'><span>  ".$usr_row['name']." found and read your story '".$posted_title."'.</span> <div id='time_age'>".$time_elapsed." </div> </div> </a>";


						}

					}
					
					
				}

				// update the last seen of the logged user for comparasion and extraction of notifications
				$update_last_seen = $conn->query("UPDATE users SET last_seen = CURRENT_TIMESTAMP() WHERE id = '$Users_name_id' ");

			?>

		</div>
			
		</center>
	</div>

</body>
</html>