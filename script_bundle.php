<?php


require_once 'function_collection.php';					

//echo 'Thank you '. $_POST['firstname'] . ' ' . $_POST['lastname'] . ', says the PHP file';

//echo $_POST['pen_name']."A";


	// $query = @unserialize (file_get_contents('http://ip-api.com/php/'));
	
	// 	if ($query && $query['status'] == 'success') {

	// 		$location = $query['city'] ;

	// 	}else{

			$location = "";
		// }


		$creator_pen_name = "";


if( isset($_COOKIE['lluda_token']) ){ // if user is logged in 






		if ( isset($_GET['setup']) ) {

			

						echo  '

						<center>


							<div id="setup_form">

							 '.$profile_image.'

							 <label class="image_upload" id="profile_setup_text" for="profile_setup_image">'.$Users_name.'<br><small>Update profile</small></label>
	  						
							 <input id="profile_setup_image" accept="image/*" onchange="send_profile_img(this);" type="file" name="post_image" style="display: none;">
    
							</form>

							

							<input type="text" name="fullname" placeholder="Full Name" value="'. $Users_name.'" id="fullname" maxlength="30">

							<input type="text" name="profile_img" placeholder="Profile Image" value="'. $Usr_pen_pro.'" id="setup_img" maxlength="300">

					        <input type="text" name="penname_id" placeholder="Pen Name" value="'. $Usr_pen_name.'" id="penname_id" maxlength="30">
					        <input type="text" name="email"  placeholder="Email" value="'. $Usr_pen_email.'" id="email" maxlength="50">
					        <input type="password" name="password" placeholder="********" value="" id="password" maxlength="15">

					        <input type="text" name="bio"  placeholder="Bio" value="'.$Usr_pen_bio.'" id="bio" maxlength="50"><br><br><br>

					        <input onclick="set_up()" id="signupButton" type="submit" name="submit" value="Save" ><br><br><br>
					    

					        </div>

						</center>

						';

		}

			


	
		

	//echo $creator_pen_name;


		// login

	//echo "Error: " . $sql . "<br>" . $conn->error;



		// setyp

if (isset($_POST['bio_st']) || isset($_POST['fullname_st']) || isset($_POST['email_st']) || isset($_POST['penname_id_st']) ) {


		if (isset($_POST['bio_st']) && $_POST['fullname_st'] && $_POST['email_st'] && $_POST['penname_id_st'] ) {


			$email =  mysqli_real_escape_string ($conn , trim( strtolower( $_POST['email_st'] ) ) );
			$full_name =  ucwords( mysqli_real_escape_string ($conn , trim( strtolower( $_POST['fullname_st'] ) ) ) ) ;
			$user_id =  mysqli_real_escape_string ($conn , trim( strtolower( $_POST['penname_id_st'] ) ) );
			$password =  mysqli_real_escape_string ($conn , $_POST['password_st'] ) ;
			$bio =  mysqli_real_escape_string ($conn , $_POST['bio_st'] ) ;

			$stp_image =  mysqli_real_escape_string ($conn , $_POST['profile_img'] );

			$hashed = password_hash($password, PASSWORD_BCRYPT);

			if ( $password === "" ) {
				$pass_ql = "";
			}else{
				$pass_ql = ", password='$hashed'";
			}


			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

				$pen_data = $conn->query("SELECT pen_name FROM users WHERE pen_name='$user_id' AND id != '$Users_name_id' ");

				if ($pen_data->num_rows === 0) {

		 			$update_data = $conn->query("UPDATE users SET pen_name='$user_id', name='$full_name' ,bio='$bio' , address='$email',profile ='$stp_image' ".$pass_ql." WHERE pen_name='$Usr_pen_name' ");

		 			if ($update_data) { echo "done"; }else{echo"Error: " .  $conn->error;}

				}else{echo "Pen name already taken";}

			}else{echo(" $email is not a valid email address ");}

		}else{echo "Fill up everything!";}

	}



	if ( isset($_GET['notification_type']) ) {


		$btn_type = $_GET['notification_type'];

		if ($btn_type === "2") {


			$check_notif = $conn->query("SELECT posts.image, notifications.sender,notifications.post_id ,notifications.type, notifications.sender ,notifications.created_at,posts.title FROM notifications INNER JOIN posts ON notifications.post_id = posts.id WHERE notifications.receiver='$Users_name_id' AND notifications.sender!='$Users_name_id' ORDER BY notifications.created_at DESC LIMIT 10");


			$notif_data  = '';

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

	

				


					$notifier = "<a   >".$usr_row['name']."</a>";


						if($res['type'] === 'like'){

							$msg_notif = $notifier." appreciated your story ".$time_elapsed;

						}else if($res['type'] === 'follow'){

							$msg_notif = $notifier." offered you a handshake".$time_elapsed;						

						}else if($res['type'] === 'reading'){

							$msg_notif = $notifier." read your story ".$time_elapsed;
														
						}else if($res['type'] === 'write_back'){

							$msg_notif = $notifier." wrote back on your story ".$time_elapsed;
														
						}else if($res['type'] === 'report'){

							$msg_notif = "Your story was reported ".$time_elapsed;
														
						}



						$profile_image = $usr_row['profile'];

						if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){

							$image_pic = '<img id="image" src="images/default.svg">';

						}else{

							$image_pic = '<img id="image" src='.$profile_image.'>';

						}

						if ($res['image'] && $res['image'] != '' && $res['image'] != null && $res['image'] != 'undefined') {

							$extra_image = "<img src='".parseVideos($res['image'])."'>";

						}else{

							$extra_image ='';

						}


						$notif_data .= " <div class='notification_note'  data-set='".$usr_row['pen_name']."' type='user' onclick='pages_guider(this);' id='".$seen_type."'> ".$image_pic."<medium> <large>".$msg_notif ."</large> ".$extra_image ." </medium> </div>";

	

					}



					
					
				}


				$profile_id = $Users_name_id;

							$follow_q = $conn->query("SELECT * FROM notifications WHERE receiver='$profile_id' AND type='follow' AND liked='true' ");
							$follow_count = $follow_q->num_rows;

							$following_q = $conn->query("SELECT * FROM notifications WHERE sender='$profile_id' AND type='follow' AND liked='true' ");
							$following_count = $following_q->num_rows;

							//	Get the followers
							$read_q = $conn->query("SELECT * FROM posts WHERE creator='$profile_id' AND visible='4' ");
							$read_count = $read_q->num_rows;

							$write_q = $conn->query("SELECT * FROM posts WHERE creator='$profile_id' AND title != '' ");
							$write_count = $write_q->num_rows;






echo "<h1> 


<div data-set='".$Usr_pen_name."' type='user' onclick='pages_guider(this);' id='user' > ".get_pfimage($Usr_pen_pro)." 


</div> 


<div id='option_section'>
	
	<medium data-set='".$Usr_pen_name."' type='user' onclick='pages_guider(this);' id='user'  >".$Users_name."</medium>




<button data-set='".$Usr_pen_name."' type='user' onclick='pages_guider(this);' id='user' >

			

<svg >
    <path d='M19,3H5C3.895,3,3,3.895,3,5v14c0,1.105,0.895,2,2,2h14c1.105,0,2-0.895,2-2V5C21,3.895,20.105,3,19,3z M12,6 c1.7,0,3,1.3,3,3s-1.3,3-3,3s-3-1.3-3-3S10.3,6,12,6z M18,18H6c0,0,0-0.585,0-1c0-1.571,2.722-3,6-3s6,1.429,6,3 C18,17.415,18,18,18,18z'></path>
</svg>

<large>My page</large>
				

	</button>

	</div>

				 		<div id='data_user'>
					 		
					 			<span> <b>".$write_count."</b> Creates</span>

					 			<span> <b>".$read_count."</b>Albums</span>

					 			<span> <b>".$follow_count."</b> Followers</span>

					 			<span> <b>".$following_count."</b> Following</span>

					 			
					 			
					 		</div>

				 			</h1>


							
					 		
					 		<div id='notif_data'>".$notif_data."</div>";

				// update the last seen of the logged user for comparasion and extraction of notifications
				$update_last_seen = $conn->query("UPDATE users SET last_seen = CURRENT_TIMESTAMP() WHERE id = '$Users_name_id' ");
			# code...
		}else{

			

			$check_notif = $conn->query("SELECT * FROM ( SELECT post_id , created_at FROM response  WHERE receiver='$Users_name_id' or sender='$Users_name_id' ORDER BY created_at DESC ) AS sub GROUP BY post_id ORDER BY created_at DESC LIMIT 10");


			$message_set = '';

			while($usr_row = $check_notif->fetch_assoc()) {

				$post_num = $usr_row['post_id'];
				$createdat_num = $usr_row['created_at'];


				#

				

					$story_get = "SELECT posts.id, posts.rank, posts.url, posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.id='$post_num'";

					$output =  echo_post_data($story_get,'out',''); 

						// $check_occur2 = $conn->query("SELECT post_id FROM response  WHERE receiver='$Users_name_id' AND sender != '$Users_name_id' AND  seen='n' AND post_id ='$post_num' ");


						$message_set .= "<div id='indivisual_msg' > ".$output."</div>";
					
			}

			echo '<button id="new_messgae" type="write_message"  onclick="pages_guider(this)">+ New Discussion</button>'.$message_set;

		}

	}


		if(	isset($_GET['notif_limit']) ){

			$check_occur2 = $conn->query("SELECT post_id , created_at FROM response  WHERE receiver='$Users_name_id' AND sender!='$Users_name_id'  AND seen='n' ");

				if($check_occur2->num_rows === 0 ){
						$notif2 = '';
				}else{
						$notif2 = $check_occur2->num_rows;
				}



				$check_occur = $conn->query("SELECT * FROM notifications WHERE receiver='$Users_name_id' AND created_at >= '$usr_seen'  AND sender!='$Users_name_id' ");

					if($check_occur->num_rows === 0 ){
						$notif = '';
					}else{
						$notif = $check_occur->num_rows;
					}



					$array['message'] = $notif2;
					$array['notifications'] = $notif;

					echo( json_encode($array) );
			

	}


	//create write story

	if(isset($_POST['post_title']) && trim($_POST['post_title']) !== "" ){

		$update_id = $_POST['post_id'];
		
		if( isset($_POST['image_tempo']) ){

			$image_cod_name = $_POST['image_tempo'];

		}

	

		$title =    mysqli_real_escape_string ($conn , strip_tags($_POST['post_title'])  ) ;
		$text =   strip_tags( mysqli_real_escape_string ($conn , $_POST['post_text'] ), '<p><br><b><i><a><img><iframe>');


		if ( $update_id != 'null'){

			$update_quatitiy = $conn->query(" SELECT id,url,visible FROM posts WHERE creator='$Users_name_id' AND url='$update_id' ");

			if ($update_quatitiy->num_rows != 0) {

					while($rrow = $update_quatitiy->fetch_assoc()) {

						$update_cre = $rrow['url'];
						$postid = $rrow['id'];
						$update_cre_vis = $rrow['visible'];
						
					}

				// echo("no opps!");

				$update_up = "UPDATE posts SET title = '$title', content = '$text', region = '$location', image = '$image_cod_name',visible = '$update_cre_vis' WHERE url='$update_id' ";

				$update = $conn->query($update_up);

				if($update){


					$string_hash = $text." ".$title;


					preg_match_all("/@(\w+)/", $string_hash, $men);

					    foreach ($men[1] as $men_id) {

						$comment_rece = $conn->query("SELECT id FROM users WHERE pen_name='$men_id' ");

						while($rec= $comment_rece->fetch_assoc()) {
							$receiver = $rec['id'];

							$upload_comment = $conn->query("INSERT INTO response (receiver,post_id,sender,type) VALUES ('$receiver', '$postid', '$Users_name_id','mention'); ");
						}

    				}


					echo $update_cre;

				}

			}else{
				echo("opps!");
			}

		}else{
			# code...





		$visiblity = $_POST['visible'];
	

		

		


		$story_quatitiy = $conn->query("SELECT id FROM posts WHERE creator='$Users_name_id' ");

		

	if($visiblity === '2' || $visiblity === '1' ){

      $url_q = $Usr_pen_name."-story".$story_quatitiy->num_rows;



    }else{

      $slug = strtolower( preg_replace('/[^A-Za-z0-9-]+/', '-', trim( $title) ));

      $url_q = $slug;
    }


	$ref_name = NULL;

	$url_quatitiy = $conn->query("SELECT * FROM posts WHERE url='$url_q' ");

	if ($url_quatitiy->num_rows != 0) {
		
		echo("Opps! Title and story already exist");

	}else{



	if ( isset($_POST['refer']) && $_POST['refer'] != 'null') {

		$ref_name = $_POST['refer'];

		$update_quatitiy = $conn->query(" SELECT id FROM posts WHERE  url='$ref_name' ");
		
				while($rrow = $update_quatitiy->fetch_assoc()) {

					$ref_name = $rrow['id'];
						
				}

		$query_up = "INSERT INTO posts (title,content,visible,creator,region,image,url,ref) VALUES ('$title','$text','$visiblity','$Users_name_id','$location','$image_cod_name','$url_q','$ref_name' ); ";

	}else{
		$query_up = "INSERT INTO posts (title,content,visible,creator,region,image,url,ref) VALUES ('$title','$text','$visiblity','$Users_name_id','$location','$image_cod_name','$url_q', NULL ); ";
	}





		$upload = $conn->query($query_up);

				if($upload){

					$string_hash = $text." ".$title;


					preg_match_all("/@(\w+)/", $string_hash, $men);
    				preg_match_all("/#(\w+)/", $string_hash, $m);

    				// print_r($m[1]);

    				$comment_rece = $conn->query("SELECT id FROM posts WHERE url='$url_q' ");

						while($rec= $comment_rece->fetch_assoc()) {

							$postid = $rec['id'];

					}

    				foreach ($m[1] as $search_id) {

    					$search_id = strtolower( trim($search_id ) );
    					$upload_occ = $conn->query("SELECT * FROM trending WHERE term='$search_id'");
						if ($upload_occ->num_rows === 0) {
							$upload = $conn->query("INSERT INTO trending (term) VALUES ('$search_id'); ");
						}else{
							$upload = $conn->query("UPDATE trending SET count = count + 1 WHERE term = '$search_id' " );
						}
    				}


    				foreach ($men[1] as $men_id) {

						$comment_rece = $conn->query("SELECT id FROM users WHERE pen_name='$men_id' ");

						while($rec= $comment_rece->fetch_assoc()) {
							$receiver = $rec['id'];

							$upload_comment = $conn->query("INSERT INTO response (receiver,post_id,sender,type) VALUES ('$receiver', '$postid', '$Users_name_id','mention'); ");
						}

    				}


    		// 			if ( isset($_POST['refer']) && $_POST['refer'] != null ) {

						// 	$ref_name = $_POST['refer'];
						// 	$check_rece = $conn->query("SELECT creator FROM posts WHERE url='$ref_name' ");

						// 	while($rec= $check_rece->fetch_assoc()) {
								
						// 		$receiver = $rec['creator'];

						// 		$write_back = $conn->query("INSERT INTO notifications (receiver,post_id,sender,type,liked) VALUES ('$receiver', '$postid', '$Users_name_id','write_back','true'); ");

						// 	}

							

						// 	$story_get = "SELECT posts.id, posts.rank, posts.url, posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile  FROM posts INNER JOIN users ON posts.creator = users.id WHERE url='$url_q' ";

						// 	$output =  echo_post_data($story_get,'in',''); 

						// 	echo($output);

						// }else{
							echo $url_q;
						// }

    				

					

					// echo "true";

				}else{
					echo"Error: " . $conn->error;
				}

	}//url not exist

    // echo $title ;

    		}

		}	

	

// likes 

			if(isset($_POST['delete_post'])){

				$postid = $_POST['delete_post'];

				$check_rece = $conn->query("UPDATE posts SET title = '', content = '' ,image = '' WHERE url='$postid' AND creator='$Users_name_id' ");

				if ($check_rece) {

					$update_quatitiy = $conn->query(" SELECT id FROM posts WHERE  url='$postid' ");
			
					while($rrow = $update_quatitiy->fetch_assoc()) {

						$ref_name = $rrow['id'];
						$upload_comment = $conn->query(" DELETE FROM response WHERE post_id='$ref_name' ");
					}

					echo("true");

				}else{
					echo("false");
				}
			}


			if(isset($_POST['report_post'])){

				$postid = $_POST['report_post'];

				// insert into notification

			$check_rece = $conn->query("SELECT * FROM posts WHERE url='$postid' ");

			while($rec= $check_rece->fetch_assoc()) {
				$receiver = $rec['creator'];
				$postid = $rec['id'];

				$upload_like = $conn->query("INSERT INTO notifications (receiver,post_id,sender,type,liked) VALUES ('$receiver', '$postid', '$Users_name_id','report','true'); ");
			}


				if ($upload_like) {
					echo("true");
				}else{
					echo("false");
				}
			}

	if(isset($_POST['likeid'])){

		$postid = $_POST['likeid'];
		$userid = $Users_name_id;
		//$receiver = $_POST['post_owner'];

		//get the receiver
		$check_rece = $conn->query("SELECT * FROM posts WHERE url='$postid' ");

		while($rec= $check_rece->fetch_assoc()) {
			$receiver = $rec['creator'];
			$postid = $rec['id'];
			$ranking_time = $row['created_at'];
			$ranking_rank = $row['likes'];
		}


		$check_occur = $conn->query("SELECT * FROM notifications WHERE post_id='$postid' AND sender='$userid' AND type='like' ");




		if ($check_occur->num_rows === 0) {

			$upload_like = $conn->query("INSERT INTO notifications (receiver,post_id,sender,type,liked) VALUES ('$receiver', '$postid', '$userid','like','true'); ");

			if($upload_like){

				$like_query = $conn->query("UPDATE posts SET likes = likes + 1 WHERE id = '$postid' ");

				if($like_query){
					echo "done";
				}else{
					echo "Error: " . $sql . "<br>" . $conn->error;
				}


			}else{
				echo "Error: " . $sql . "<br>" . $conn->error;
			}


		}else{
		 	
		 	while($row = $check_occur->fetch_assoc()) {

		 		$liked = $row["liked"];
		 		$current_id = $row["id"];

		 		if ($liked === 'true') {

		 			// it's an unlike request

					$dislike_query = $conn->query("UPDATE notifications SET liked = 'false' WHERE id='$current_id' ");

					if($dislike_query){
					
						$like_minus = $conn->query("UPDATE posts SET likes = likes - 1 WHERE id = '$postid' ");

						if($like_minus){
							echo "done";
						}else{
						echo "Error: " . $sql . "<br>" . $conn->error;
						}
						
					}else{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}
				

		 		}else{

		 			// it's a like request

					$like_true = $conn->query("UPDATE notifications SET liked = 'true' WHERE id='$current_id' ");

					if($like_true){

						$like_add = $conn->query("UPDATE posts SET likes = likes + 1 WHERE id = '$postid' ");

						if($like_add){
							echo "done";
						}else{
						echo "Error: " . $sql . "<br>" . $conn->error;
						}

					}else{
						echo "Error: " . $sql . "<br>" . $conn->error;
					}

				

		 		}

			}

		}


			$delta_time = time() - strtotime( $ranking_time );

			$ranking_data = round ( log( $ranking_rank +1,10) / ($delta_time / 10800) , 7);

			$rank_query = "UPDATE posts SET rank = '$ranking_data' WHERE id = '$postid' ";


			//trending

			$check_trend = $conn->query("SELECT created_at FROM notifications WHERE post_id='$postid' AND sender != '$userid' AND type='like' ");

			if ($check_occur->num_rows != 0) {

				while($row = $check_trend->fetch_assoc()) {
					$recent_like = $row['created_at'];
					$recent_time = time() - strtotime( $recent_like );
					$ranking_data = $ranking_data * (1/$recent_time);
				}

			}





	}





	if(isset($_POST['commentid'])){

		$postid = $_POST['commentid'];
		$userid = $Users_name_id;
		//$receiver = $_POST['post_owner'];

		$ajax_content = mysqli_real_escape_string ($conn , strip_tags( trim($_POST['post_content']) )  ) ;
		// $ajax_content = $_POST['post_content'];

		$comment_rece = $conn->query("SELECT * FROM posts WHERE url='$postid' ");

			while($rec= $comment_rece->fetch_assoc()) {

				$receiver = $rec['creator'];
				$postid = $rec['id'];

			}


				$upload_comment = $conn->query("INSERT INTO response (receiver,post_id,sender,type,comment) VALUES ('$receiver', '$postid', '$userid','comment','$ajax_content');  ");

				if($upload_comment){




							$check = $conn->query(" SELECT id FROM response WHERE receiver='$Users_name_id' AND  post_id='$postid' ");

								if ($check->num_rows === 0){

									$upload_mention = $conn->query("INSERT INTO response (receiver,post_id,sender,type,seen) VALUES ('$Users_name_id', '$postid', '$Users_name_id','mention','y'); ");

								}




							preg_match_all("/@(\w+)/", $ajax_content, $men);

							    foreach ($men[1] as $men_id) {

								$comment_rece = $conn->query("SELECT id FROM users WHERE pen_name='$men_id' ");

								while($rec= $comment_rece->fetch_assoc()) {

									$receiver = $rec['id'];


									$check = $conn->query("SELECT id FROM response WHERE receiver='$receiver' AND  post_id='$postid' ");

									if ($check->num_rows === 0){

										$upload_mention = $conn->query("INSERT INTO response (receiver,post_id,sender,type) VALUES ('$receiver', '$postid', '$Users_name_id','mention'); ");

									}


								}

		    				}


		    				$check_lastpostid = $conn->query(" SELECT id FROM response WHERE sender='$userid' AND  post_id='$postid' ");


		    				while($rec = $check_lastpostid->fetch_assoc()) {
		    					$lstrow_id = $rec['id'] ;
		    				}



							$comment_text =  get_meta( $ajax_content);

							$array[ $_POST['refid'] ] =  array($comment_text,$lstrow_id) ;

					      	$mention_seen = $conn->query( "UPDATE response SET seen = 'n' , created_at = CURRENT_TIMESTAMP() WHERE type='mention' AND post_id='$postid' ");


						// }

						echo json_encode($array);



				}else{
					echo "Error:" . $conn->error;
				}


		

	}

	if(	isset($_GET['comment-no']) ){

					$comment_id_post_ol = $_GET['comment-no'];

					$comment_id_post = $_GET['comment-no'];

					if ( isset($_GET['last_post']) ) {

						$grater = '>';
						$last_id_post = $_GET['last_post'];

						if ($last_id_post === '0') {
							$grate_vis = '';
						}else{
							$grate_vis = "AND response.sender != ".$Users_name_id;
						}

					}else{
						$grater = '<';
						$last_id_post = $_GET['start_post'];
						$grate_vis = '';
					}

					

					$array = array();
					$array[$comment_id_post_ol] = array();

					// $array[$comment_id_post_ol]['sql'] = 'empty';

							$comment_rece = $conn->query("SELECT * FROM posts WHERE url='$comment_id_post' ");

							while($rec= $comment_rece->fetch_assoc()) {

								$comment_id_post = $rec['id'];

							}

							$check_occur2 = $conn->query("SELECT created_at FROM response  WHERE receiver='$Users_name_id'AND sender!='$Users_name_id' AND seen='n' AND post_id ='$comment_id_post' ORDER BY created_at DESC");

									if( $check_occur2->num_rows > 5 ){

										$chat_limit = $check_occur2->num_rows;

									}else{

										$chat_limit = '5';

									}

					$array[$comment_id_post_ol]['lastpost']['value'] = $last_id_post;

					$mention_seen = $conn->query( "UPDATE response SET seen = 'y' WHERE type='mention' AND seen = 'n' AND post_id='$comment_id_post' AND receiver='$Users_name_id'  ");


					$check_comment = $conn->query("SELECT response.created_at ,response.id,response.seen, response.comment , response.receiver ,response.sender, users.name, users.pen_name, users.profile FROM response INNER JOIN users ON response.sender = users.id WHERE response.post_id='$comment_id_post' AND response.type='comment' AND response.id ".$grater." '$last_id_post' ".$grate_vis." ORDER BY response.created_at DESC LIMIT ".$chat_limit  );

						if($check_comment){

								$comment_data = '';

								if( $check_comment->num_rows === 0){
										$comment_data = '';

								}else{

									
									$comment_data = '';

									while($row_com = $check_comment->fetch_assoc() ) {

										$commentor_name = "@".$row_com['pen_name'];
										$comment_text = $row_com['comment'];
										// $comment_text_r = $row_com['seen'];

										$comment_text =  get_meta($comment_text);

										// if( preg_match($prg, $comment_text, $url) )

										// 	{
										// 	   $comment_text = preg_replace( $prg, "<a target='_blank' href=http://$url[0]>{$url[0]}</a>", $comment_text );
										// 	}





										$profile_image = $row_com['profile'];
										$id_image = $row_com['id'];
										$posted_age = $row_com['created_at'];
										$phpdate = strtotime( $posted_age );
										$credit = date( 'd M', $phpdate );
										// $comment_text = $row_com['comment']." ".$comment_text_r." ".$id_image;


										$profile_sender = $row_com['receiver'];

										if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){
											$image_pic = '<img src="images/default.svg">';
										}else{

											$image_pic = '<img src='.$profile_image.'>';

										}


										if( $row_com['sender'] === $Users_name_id ){


											// grater is  actuated when the post request is for the old ones

											if ($last_id_post === '0' || $grater === '<') {

												$value = " 

														<span> ".$comment_text."<span> 

														<img class='tick' src='images/tick.svg' > 

														<small>".$credit."</small> 

												";

												$array[$comment_id_post_ol][$id_image]['value'] = $value;
												$array[$comment_id_post_ol][$id_image]['user'] = 'two_comment';
											}else{

												$value = '';
											// 	// echo('$last_id_post ');
												
											}

											
											// <div data-id='".$id_image."' class='comment_parent' > 

											// <div id='one_comment'>

										}else{
											$value = "

											<div id='sender_iden'>".$image_pic." <large>".$commentor_name." <small>".$credit."</small>  </large> </div>

											 <span> ".$comment_text."</span> 
										";

											$array[$comment_id_post_ol][$id_image]['value'] = $value;
											$array[$comment_id_post_ol][$id_image]['user'] = 'one_comment';
										}



								

										if ($Users_name_id === $profile_sender) {


											$dislike_query = $conn->query("UPDATE response SET seen = 'y' WHERE id='$id_image' ");

												if($dislike_query){
													// echo "done";
												}

										}

										
									}

									
								}

						echo json_encode($array);

						}else{
							echo"Error:" . $conn->error;;
						}

	}




	// profile upload




// follow 

	if(isset($_POST['followid'])){

		$postid = $_POST['followid'];
		$userid = $Users_name_id;
		//$receiver = $_POST['post_owner'];

		//get the receiver
		$check_rece = $conn->query("SELECT * FROM users WHERE pen_name='$postid' ");

		while($rec= $check_rece->fetch_assoc()) {

			$follow_man = $rec['id'];
		}

		// echo $follow_man;


		$check_occur = $conn->query("SELECT * FROM notifications WHERE receiver='$follow_man' AND sender='$userid' AND type='follow' ");

		if ($check_occur->num_rows === 0) {

			$upload_like = $conn->query("INSERT INTO notifications (receiver,sender,type,liked) VALUES ('$follow_man', '$userid','follow','true'); ");

			if($upload_like){

			 	echo "done";

			}


		}else{
		 	
		 	while($row = $check_occur->fetch_assoc()) {

		 		$liked = $row["liked"];
		 		$current_id = $row["id"];

		 		if ($liked === 'true') {

		 			// it's an unlike request

					$dislike_query = $conn->query("UPDATE notifications SET liked = 'false' WHERE id='$current_id' ");

					if($dislike_query){
						echo "done";
					}

				

		 		}else{

		 			// it's a like request

					$like_true = $conn->query("UPDATE notifications SET liked = 'true' WHERE id='$current_id' ");

					if($like_true){
						echo "done";
					}
				

		 		}

			}

		}


	}

// if user is logged in 

}



	if( isset($_FILES) && isset($_FILES['post_image']['tmp_name']) ){

		require_once 'parent_s3.php';

		$img_tmpname = $_FILES['post_image']['tmp_name'];
		$img_name = $_FILES['post_image']['name'];
		$img_type = $_FILES['post_image']['type'];
		$img_size = $_FILES['post_image']['size'];
		$img_error = $_FILES['post_image']['error'];

		if(!$img_error){
			$img_array = explode('.', $img_name);
			$img_ext = strtolower(end($img_array));

			$allowed_type = array('png','gif','jpeg','jpg');

			if(in_array($img_ext,$allowed_type )){
					// if($img_size < 1000000){
						
					    $url = uniqid().'.jpg';

					    $filename = compress_image( $_FILES["post_image"]["tmp_name"] , $_FILES["post_image"]["tmp_name"], 100 );
						
						// For this, I would generate a unqiue random string for the key name. But you can do whatever.
						$keyName = 'stories/' . $url;
						$pathInS3 = 'http://s3.us-east-2.amazonaws.com/' . $bucketName . '/' . $keyName;
						// Add it to S3
						try {
							// Uploaded:
							$file = $filename;
							$s3->putObject(
								array(
									'Bucket'=>$bucketName,
									'Key' =>  $keyName,
									'SourceFile' => $file,
									'StorageClass' => 'REDUCED_REDUNDANCY'
								)
							);
						} catch (S3Exception $e) {
							die('Error:' . $e->getMessage());
						} catch (Exception $e) {
							die('Error:' . $e->getMessage());
						}

							echo $pathInS3;

				}else{
					echo "Incorrect file type";
				}

		}else{
			echo "Upload error";
		}

	}






if( isset($_GET['featured_length']) ){

	return;

	// $fr_len = $_GET['featured_length']; 

	// $sql_feature = "SELECT posts.id,posts.image, posts.rank, posts.url,posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name,users.profile, users.pen_name  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.visible = '0' AND posts.title != '' ORDER BY posts.created_at DESC LIMIT ".$fr_len; 

		

	// 	echo echo_mini($sql_feature,'2'); 

}


if( isset($_GET['content_offset']) ){


	$Usr_pen_name = $creator_pen_name; 

		$follow_array = $conn->query("SELECT * FROM notifications WHERE sender='$Users_name_id' AND type='follow' AND liked='true' ");

				$follow_count = $follow_array->num_rows;

				if ($follow_count > 0) {

					while($fowe = $follow_array->fetch_assoc() ){

					$followings[] = $fowe['receiver'] ;

					}

					$follow_IN = join("','",$followings);



				}else{
					$follow_IN ="";
				}


	

	$item_off = $_GET['content_offset'];

	$offset_sql = $item_off * 6;

	$item_type = $_GET['content_type'];


	if ( $item_type === 'main' ) {

		$content_type = '';

	}else if( $item_type === 'story' ){

		$content_type = "AND posts.visible = '0'";

	}else if( $item_type === 'chat' ){

		$content_type = "AND posts.visible = '2'";

	}else if( $item_type === 'photo' ){

		$content_type = "AND posts.visible = '4'";

	}else{
		$content_type = '';
	}


// 	if( $item_type === 'photo' ){


// 		$sql_arrange = $conn->query("SELECT series.image,series.type,series.post_id,posts.url,posts.title FROM posts INNER JOIN series  ON posts.id = series.category_id WHERE series.type = 'image' ORDER BY posts.rank DESC LIMIT 3 OFFSET ".$offset_sql);

// 		// $sql_arrange = $conn->query("SELECT series.image,series.type,series.post_id FROM posts INNER JOIN series  ON posts.id = series.category_id WHERE posts.creator IN('$follow_IN') ORDER BY posts.rank DESC LIMIT 3 OFFSET ".$offset_sql);

// 		while($r_row = $sql_arrange->fetch_assoc() ) {

// 										if ($r_row['type'] === 'image') {

// 											$s_inert = ' <img  src="'.parseVideos( $r_row['image'] ).'" > ';

// 											$array = $r_row['image'];
											
// 										}else{


// 											$pos_id = $r_row['post_id'];

// 											$selp_img = $conn->query(" SELECT image FROM posts WHERE id='$pos_id' ");

// 											while($s_row = $selp_img->fetch_assoc() ) {


												

// 												if ($s_row['image'] != 'undefined') {
// 													# code...

// 													$s_inert = ' <img  src="'.parseVideos( $s_row['image'] ).'" > ';

// 													$array = $s_row['image'];


// 												}

// 											}

// 										}


										
// 												echo '<div id="seires_image" onclick="expand_image(this)" >'.$s_inert.'

// 												<h4 data-set="'.$r_row['url'].'" type="story" onclick="pages_guider(this)" > 

// 												<large>'.$r_row['title'].'</large>

// 												<button onclick="go_back()" > 

// 												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1">
// <g id="surface1">
// <path style=" " d="M 8.71875 7.28125 L 7.28125 8.71875 L 14.5625 16 L 7.28125 23.28125 L 8.71875 24.71875 L 16 17.4375 L 23.28125 24.71875 L 24.71875 23.28125 L 17.4375 16 L 24.71875 8.71875 L 23.28125 7.28125 L 16 14.5625 Z "></path>
// </g>
// </svg>

//  </button>

// 												</h4> 

// 												 </div>';
										

										

// 								}

// 	}else{

	for ($x = 1; $x <= 3; $x++) {

			if($x == 3){// treding story

			$offset_sql = $_GET['content_offset'] * 3;

			$sql_arrange = "SELECT posts.id, posts.rank, posts.url ,posts.title, posts.content, posts.region , posts.visible,posts.created_at,posts.likes, posts.ref, posts.creator, users.name,users.profile , users.pen_name ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.creator NOT IN('$follow_IN') AND posts.ref IS NULL AND posts.visible != '1' AND posts.visible != '4'  ".$content_type." ORDER BY posts.rank DESC LIMIT 4 OFFSET ".$item_off*4;


			echo '<acronym class="type" >	Top rank </acronym>';

			}else if($x == 2){// Local stories

			$offset_sql = $_GET['content_offset'] * 3;

			#posts.creator NOT IN('$follow_IN') AND

			$sql_arrange = "SELECT posts.id, posts.rank, posts.title, posts.url, posts.content, posts.region , posts.visible, posts.created_at,  posts.likes, posts.creator, posts.ref, users.name,users.profile, users.pen_name ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.creator NOT IN('$follow_IN') AND posts.creator != '$Users_name_id' AND  posts.ref IS NULL AND posts.region='$location' AND posts.visible != '1'  ".$content_type." AND posts.visible != '4' ORDER BY posts.created_at DESC LIMIT 6 OFFSET ".$offset_sql;


			echo '<acronym class="type" > Local </acronym>';

			}else if($x == 1){//following stories

				echo '<acronym class="type" > follow </acronym>';

				// references from the followed users will be visible 

				$sql_arrange = "SELECT posts.id, posts.rank, posts.title, posts.url, posts.content, posts.region , posts.visible, posts.created_at, posts.likes, posts.creator, posts.ref,users.profile , users.name, users.pen_name ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.visible != '1'  ".$content_type."  AND posts.creator != '$Users_name_id' AND posts.creator IN('$follow_IN') ORDER BY posts.created_at DESC LIMIT 6 OFFSET ".$offset_sql;

			}



			if($x != 2){

					$output = echo_post_data($sql_arrange,'out','');

					echo($output);	

			}
		

			 





	}

// }

}


	if(	isset($_GET['reference']) ){






					$refid_post = $_GET['reference'];

					$comment_rece = $conn->query("SELECT id,visible FROM posts WHERE url='$refid_post' ");

					while($rec= $comment_rece->fetch_assoc()) {

						$refid_post = $rec['id'];

						$out_putprivate = '';
					

						if ($rec['visible'] === '1') {

							
							$check_notif = $conn->query("SELECT * FROM ( SELECT post_id , created_at FROM response  WHERE receiver='$Users_name_id' or sender='$Users_name_id' ORDER BY created_at DESC ) AS sub GROUP BY post_id ORDER BY created_at DESC ");


								while($usr_row = $check_notif->fetch_assoc()) {

									$post_num = $usr_row['post_id'];
									$createdat_num = $usr_row['created_at'];


									#

									

										$story_get = "SELECT posts.id, posts.rank, posts.url, posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile  FROM posts INNER JOIN users ON  posts.creator = users.id WHERE posts.id='$post_num' ";

										$output =  echo_post_data($story_get,'out',''); 

											// $check_occur2 = $conn->query("SELECT post_id FROM response  WHERE receiver='$Users_name_id' AND sender != '$Users_name_id' AND  seen='n' AND post_id ='$post_num' ");


										$out_putprivate .= "<div id='indivisual_msg' > ".$output."</div>";
										
								}

								echo '<h4 class="_main" ><large>Messages</large></h4>'.$out_putprivate;


							# code...
						}else{

								$check_ref= "SELECT posts.id, posts.rank, posts.url, posts.title, posts.content, posts.region , posts.visible, posts.created_at, posts.likes, posts.ref, posts.creator,users.profile , users.name, users.pen_name ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.ref='$refid_post' ORDER BY posts.created_at DESC";

					 
								 $output = echo_post_data($check_ref,'in','');

								 if ( $output === '') {
								 	 $output = '<h4>No threads yet<h4>';
								 }

								 $two_liners = '<h4 class="_main">

	

									<button  data-type="write_message" alt ="anonymous" onclick="ref_write(this)">Share reply</button>

									<button  data-type="write_story" alt ="anonymous" onclick="ref_write(this)">Reply by story</button>


									</h4>';

								 echo $two_liners."<div id='line_reference'>".$output."</div>";



						}

					}






	}


	if(	isset($_GET['sr_ref']) ){

			$refid_post = $_GET['sr_ref'];

	 		$search_string = trim( strtolower($refid_post) );

	 		// $acc = 'SELECT * FROM notifications WHERE sender='$Users_name_id' AND type='follow' AND liked='true' '

	 		// $sql_arrange = $conn->query("SELECT * FROM ( SELECT * FROM notifications WHERE sender='$Users_name_id' ) AS sub WHERE pen_name LIKE '%{$search_string}%' OR name LIKE '%{$search_string}%' GROUP BY receiver ORDER BY COUNT(receiver) DESC  ");
						
			$sql_arrange = $conn->query("SELECT * FROM users INNER JOIN notifications ON users.id = notifications.receiver 

				WHERE ( users.pen_name LIKE '%{$search_string}%' OR users.name LIKE '%{$search_string}%')

				AND (notifications.sender = '$Users_name_id')

				GROUP BY notifications.receiver ORDER BY COUNT(notifications.receiver) DESC LIMIT 10 ");


			// $sql_arrange = $conn->query("SELECT * FROM users WHERE pen_name LIKE '%{$search_string}%' OR name LIKE '%{$search_string}%' LIMIT 10 ");



				while ($row = $sql_arrange->fetch_assoc() ) {


							$profile_image =  $row["profile"];

							if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){

									$profile_image = '<img src="images/default.svg">';
										
							}else{

									$profile_image = '<img src='.$profile_image.'>';

							}

						echo "<button onclick='add_sugg(this)' data-set='".$row['pen_name']."' >".$profile_image."<medium>".$row['name']." <small>@".$row['pen_name']."</small></medium></button>";
				}

	}





		if(	isset($_GET['men_ref']) ){
	

	 		echo get_userlist("SELECT * FROM users INNER JOIN notifications ON users.id = notifications.receiver 

				WHERE 

				notifications.sender = '$Users_name_id'

				GROUP BY notifications.receiver ORDER BY COUNT(notifications.receiver) DESC LIMIT 10 ",'function');
						
			

	}


		if(	isset($_GET['addto_series']) ){

			$title = $_GET['create_series'];

			if ($title != 'null') {

				$url_q = $Usr_pen_name."-series-".strtolower( preg_replace('/[^A-Za-z0-9-]+/', '-', trim( $title) ));

		      	$query_up = "INSERT INTO posts (title,visible,creator,url,ref) VALUES ('$title','4','$Users_name_id','$url_q', NULL ); ";

		      	$check = $conn->query($query_up);

		      	if ($check) {

		      		$series_id = $url_q;

		      	}else{
		      		return;
		      	}

			}else{
				$series_id = $_GET['addto_series'];
			}

			$story_id = $_GET['storyid_series'];

			$type_id = $_GET['type_series'];

			if ($type_id === 'image') {

				$type_id === 'image';
				$image_link = $story_id;

			}else{

				$type_id = 'tag';
				$image_link = '';

			}

			$check_up = $conn->query(" SELECT id,title FROM posts WHERE creator='$Users_name_id' AND url='$series_id' ");

			while($row = $check_up->fetch_assoc()) {

				$series_id = $row['id'];
				$series_title = $row['title'];
				$comment_rece = $conn->query("SELECT id FROM posts WHERE url='$story_id' ");

			

				if ($comment_rece->num_rows > 0) {
									
						while($rec= $comment_rece->fetch_assoc()) {

							$story_id_p = $rec['id'];

						}

					$query_up = "INSERT INTO series (category_id,post_id,type,image) VALUES ('$series_id','$story_id_p','$type_id','$image_link'); ";

				}else{

					$query_up = "INSERT INTO series (category_id,post_id,type,image) VALUES ('$series_id',null,'$type_id','$image_link'); ";
				}




		      	

			    $check = $conn->query($query_up);

			      	if ($check) {

			      		echo 'Added to your '.$series_title.' Album';

			      	}else{

						echo "Error: ".$conn->error;

			      	}

		      }

			}


	if(	isset($_GET['series_list']) ){


		$check_ref= "SELECT * FROM posts WHERE creator='$Users_name_id' AND visible='4' ";

		$check = $conn->query($check_ref);
					 
		while($row = $check->fetch_assoc()) {

			$ps = $row['id'];

			// $conn->query(" ")->num_rows


							$select_img = $conn->query(" SELECT image, type FROM series WHERE category_id='$ps' limit 1  ");


								while($r_row = $select_img->fetch_assoc()) {


									if ( $r_row['image']  === 'unknown' || $r_row['type'] === 'tag') {
										
										$s_img = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
									    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 6 3 A 1.0001 1.0001 0 1 0 6 5 L 24 5 A 1.0001 1.0001 0 1 0 24 3 L 6 3 z M 6 7 C 4.9069372 7 4 7.9069372 4 9 L 4 15 L 6 15 L 6 9 L 24 9 L 24 15 L 26 15 L 26 9 C 26 7.9069372 25.093063 7 24 7 L 6 7 z M 12 11 L 9 15 L 15 15 L 12 11 z M 20 11 A 1 1 0 0 0 19 12 A 1 1 0 0 0 20 13 A 1 1 0 0 0 21 12 A 1 1 0 0 0 20 11 z M 16.75 12 L 15.5 13.667969 L 15.599609 13.800781 L 16.5 15 L 19 15 L 16.75 12 z M 3 17 L 3 24 C 3 25.657 4.343 27 6 27 L 24 27 C 25.657 27 27 25.657 27 24 L 27 17 L 3 17 z M 13 19 L 17 19 C 17.552 19 18 19.448 18 20 C 18 20.552 17.552 21 17 21 L 13 21 C 12.448 21 12 20.552 12 20 C 12 19.448 12.448 19 13 19 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
									</svg>';

									}else{
										$s_img = '<img src="'.parseVideos( $r_row['image'] ).'" >';
									}

								

								}

						

				echo '<button data-set="'.$row['url'].'" onclick="add_to_series(this)" >'.$s_img.ucfirst($row['title']).' </button>';

				// <small>'.$select_img->num_rows.'</small>
			}

	}

	if(	isset($_GET['follow_list']) ){

		$refid_post = $_GET['user_on'];

		if ($_GET['follow_list'] === 'series') {

			// echo stories_get($refid_post);

			$sql_arrange = "SELECT posts.id, posts.rank, posts.url,posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.creator ='$refid_post' AND title != '' AND visible='4' ORDER BY posts.created_at DESC LIMIT 10 ";

			echo '<div  class="posts_bundle">'.echo_post_data($sql_arrange,'out','').'</div>'; 

		}else if ($_GET['follow_list'] === 'Stories') {

			echo stories_get($refid_post);

		}else{

		if ($_GET['follow_list'] === 'Following') {
			$pintch = 'sender';
			$pintch2 = 'receiver';
		}else{
			$pintch2 = 'sender';
			$pintch = 'receiver';
		}

		$check_ref= "SELECT users.id, users.pen_name, users.profile, users.name  FROM users INNER JOIN notifications ON users.id = notifications.".$pintch2." WHERE notifications.".$pintch." = '$refid_post' AND notifications.type='follow' AND notifications.liked='true'  ";

		$user_search_list = get_userlist($check_ref,'link' );

		echo '<div class="auto_mesage" id="auto_mesage">'.$user_search_list.'</div>';

	}

	}

	if(	isset($_GET['reference_chat']) ){


					$refid_post = $_GET['reference_chat'];

					$check_ref= "SELECT posts.id, posts.rank, posts.title, posts.content, posts.region , posts.visible, posts.created_at, posts.likes, posts.ref, posts.creator,users.profile , users.name, users.pen_name ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.url='$refid_post'  ";

					$check = $conn->query($check_ref);



					 
					while($row = $check->fetch_assoc()) {

						$refid_post = $row['id'];

						$get_count = "SELECT id FROM response  WHERE post_id='$refid_post' GROUP BY sender ";

						$check_get_count = $conn->query($get_count);

						$check_get_count = $check_get_count->num_rows;

						echo $row['title']."<small>".$row['name']." . @".$row['pen_name']." . ".$check_get_count." people talking</small>" ;
					}




	}




				if( isset( $_GET['user'] ) ){


					$user_return = echo_userdata( $_GET['user'] );
					echo $user_return;


				}





	if(	isset( $_GET['search_sr'] ) ){

			$return_dat = echo_search ( $_GET['search_sr'] );

			echo $return_dat;

		}


		if ( isset($_GET['story']) ) {


			$ps_id = $_GET['story'];

			if ( $_GET['story_t'] === 'write_story' ) {

				$ec = $conn->query("SELECT title from posts WHERE url='$ps_id' ");

				while ($row = $ec->fetch_assoc() ) {
					
					echo $row['title'];
				}

			}else{
				echo echo_story( $ps_id );
			}

					

		}


		if(	isset( $_GET['trending_sr'] ) ){

			$return_dat = echo_trend ( $_GET['trending_sr'] );

			echo $return_dat;

	}



	if(isset($_POST['read_id'])){

		$postid = $_POST['read_id'];
		$userid = $Users_name_id;
		//$receiver = $_POST['post_owner'];

		$comment_rece = $conn->query("SELECT * FROM posts WHERE url='$postid' ");

		while($rec= $comment_rece->fetch_assoc()) {
			$receiver = $rec['creator'];
			$received_content = $rec['content'];
			$postid = $rec['id'];
		}

		echo strip_tags( $received_content,'<p><br><b><i><a><img><iframe>' );

		$check_occur = $conn->query("SELECT * FROM notifications WHERE post_id='$postid' AND sender='$userid' AND type='reading' ");

		if ($check_occur->num_rows === 0) {

				$upload_comment = $conn->query("INSERT INTO notifications (receiver,post_id,sender,type) VALUES ('$receiver', '$postid', '$userid','reading'); ");

				if($upload_comment){

						

				}else{
					// echo "NOT";
					// echo "Error: " . $sql . "<br>" . $conn->error;
				}


		}

	}




		




?>