<?php

require_once 'mysqlconnect.php';



if( isset($_POST['post_title']) ){

}else{
	$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}



function limit_words($string, $word_limit)
{
    $words = explode(" ",$string);
    return implode(" ",array_splice($words,0,$word_limit));
}

	function getYoutubeid($url){

		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);

		return "https://img.youtube.com/vi/".$match[1]."/0.jpg";

	}

    function getVimeoVideoIdFromUrl($url) {
        $regs = array();
    
        $id = '';
    
        if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
            $id = $regs[3];
        }
    
        return $id;
    }



function parseVideos( $src ) {


	if (stripos($src,'vimeo.com') !== false){

		$imgid = getVimeoVideoIdFromUrl($src);

		$image = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));

		return $image[0]['thumbnail_large'];

	}else if (stripos($src,'youtu') !== false){

		$imgid = getYoutubeid($src);
		return $imgid;
	}else{
		return $src;
	}





}

	function get_meta($value){
				$comment_text = html_entity_decode($value, ENT_QUOTES);

				$prg = "/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

				if( preg_match( '~https?://\S+\.(?:jpe?g|gif|png)(?:\?\S*)?(?=\s|$|\pP)~i' , $comment_text, $url) )

					{
					$comment_text = preg_replace( '~https?://\S+\.(?:jpe?g|gif|png)(?:\?\S*)?(?=\s|$|\pP)~i' , "<img   class='photo' src=$url[0]>", $comment_text );
				}else if( preg_match($prg, $comment_text, $url) ){
					$comment_text = preg_replace( $prg, "<a target='_blank' href=http://$url[0]>{$url[0]}</a>", $comment_text );
				}

				$comment_text = FilterMentionHash($comment_text);

				return $comment_text;
	}
	
function get_records( $n){

							// return $n;
						
							if ($n < 1000000) {

								if($n > 999){
									return round($n /1000). 'K';
								}else{
									return $n;
								}
							     
							}else if ($n < 1000000000) {
							    // Anything less than a billion
							    return round($n / 1000000) . 'M';
							}else {
							    // At least a billion
							    return round($n / 1000000000) . 'B';
							}

						}

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


		function get_pfimage($profile_image)
		{
				if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){

						return '<img id="image" src="images/default.svg">';
							
				}else{

						return  '<img id="image" src='.$profile_image.'>';

				}
		}




if( isset($_COOKIE['lluda_token']) ){

		$token_login = $_COOKIE['lluda_token'];

		$check_cookie = $conn->query("SELECT * FROM users WHERE token='$token_login' ");

		while ($row = $check_cookie->fetch_assoc() ) {
				
				$Users_name = $row['name'];
				$usr_seen = $row["last_seen"];
				$Users_name_id = $row['id'];
				$Usr_pen_name =  $row['pen_name'] ;
				$Usr_pen_email = $row["address"];
				$Usr_pen_pass = $row["password"];
				$Usr_pen_bio =  $row["bio"];
				$Usr_pen_pro =  $row["profile"];
				$profile_image =  get_pfimage($Usr_pen_pro);

		}

		$creator_pen_name = $Usr_pen_name;

}else{
	$Users_name_id = "";
}



		function echo_trend($data){

		global $conn;

		if ($data === 'null') {

			$upload_occ = $conn->query("SELECT * FROM trending ORDER BY count DESC LIMIT 12 " );

		}else{

			$search_string = $data ;

			$upload_occ = $conn->query("SELECT * FROM trending WHERE term != '$search_string'  AND term LIKE '%{$search_string}%'  ORDER BY count DESC LIMIT 6 " );

			// echo($search_string);
		}

			

			
$trend_dat = '<div id="trend_sugg">';

						while($srow = $upload_occ->fetch_assoc()) {



								$food = $srow['term'] ;

								if (strpos($food, '_') === false) {


									$food =  trim( ucfirst($food) );

									$title = "#";
									


								}else{

									$food = ucwords(str_replace('_', ' ', $food ));

									$title = "";
								}

								
								

								$trend_dat .= "<a data-set=".$srow['term']." type='q' onclick='pages_guider(this);' >".$title."".$food."</a>";
							}


							return $trend_dat."</div>";


		}



			function get_userlist($data,$type){

				global $conn;

				$sql_arrange = $conn->query($data);
				$sql_res = '';

			// $sql_arrange = $conn->query("SELECT * FROM users WHERE pen_name LIKE '%{$search_string}%' OR name LIKE '%{$search_string}%' LIMIT 10 ");



				while ($row = $sql_arrange->fetch_assoc() ) {


							$profile_image =  $row["profile"];

							if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){

									$profile_image = '<img src="images/default.svg">';
										
							}else{

									$profile_image = '<img src='.$profile_image.'>';

							}

							if ($type === 'function') {
								$type = 'add_sugg(this)';
							}else{
								$type = 'pages_guider(this)';
							}

						$sql_res .= "<button onclick='".$type."' type='user' data-set='".$row['pen_name']."' >".$profile_image."<medium>".$row['name']." <small>@".$row['pen_name']."</small><medium></button>";
				}

				return $sql_res;

	}









function echo_search($data){

		global $conn;


		$ties = mysqli_real_escape_string ($conn , htmlspecialchars( $data ) );

		$food = str_replace('_', ' ', $ties);

		$title =  trim( ucfirst($food) );

		$search_id = str_replace(" ", '_', strtolower( preg_replace('/\s+/', ' ', str_replace("#", '', $title ) ) ) );

		if ($search_id !== "") {

			$upload_occ = $conn->query("SELECT * FROM trending WHERE term='$search_id'");

			if ($upload_occ->num_rows === 0) {
				$upload = $conn->query("INSERT INTO trending (term) VALUES ('$search_id'); ");
			}else{
				$upload = $conn->query("UPDATE trending SET count = count + 1 WHERE term = '$search_id' " );
			}

		}


			$search_string = str_replace("_", ' ', trim( strtolower($food) ) );
						
			$sql_arrange = "SELECT posts.id, posts.url ,posts.rank, posts.title, posts.content, posts.region , posts.visible, posts.ref, posts.likes, posts.creator, posts.created_at,users.name,users.pen_name, users.profile ,posts.image  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.title LIKE '%{$search_string}%' OR posts.content LIKE '%{$search_string}%' OR users.name LIKE '%{$search_string}%'  LIMIT 10 ";

			$user_search_list = get_userlist("SELECT * FROM users WHERE pen_name LIKE '%{$search_string}%' OR name LIKE '%{$search_string}%' OR address LIKE '%{$search_string}%'  LIMIT 4  ",'link' );


				
				 $query_box = echo_post_data($sql_arrange,'out',''); 

				 $trend_re = echo_trend($data);

				 if($query_box === "" && $trend_re === "" && $user_search_list  == ''){
				 	return "<h3>No result found<h3>";
				 }else{
				 	return $trend_re.'<center><div class="auto_mesage"> '.$user_search_list.'</div><div class="posts_bundle" >'.$query_box."</div></center>";
				 }


		}



		function echo_mini($sql_arrange,$limit){

			global $conn;
			$return_mini = "";


			$check = $conn->query($sql_arrange);

			// if ($check->num_rows > 2 || $limit === '2' ) {
				
				while($row = $check->fetch_assoc()) {

					$posted_id = $row['id'];
					$content_data = limit_words( strip_tags( $row['content'],'<i>' ) ,15 )."..";
					$content_title = strip_tags( html_entity_decode($row['title']) ,'<i>');



						$image_oI = $row['image'];
						$img_o = '';
						$img_t = 'media_section';
						$img_ti = 'text';

						

						if($image_oI === NULL || $image_oI === '' || $image_oI === 'undefined'){

							$img_ti = 'text';

							$img_o = "<div data-type='".$img_ti."' data-set='' class='post_image'  > 

							<img class='coverlayer' src='".$row['profile']."'>

							</div>";

						}else{

							$img_array = explode('.', $image_oI);
							$img_ext = strtolower(end($img_array));

							$data_set = $row['image'];

							$allowed_type = array('png','gif','jpeg','jpg');


							$image_oI =  parseVideos($image_oI);

							if(in_array($img_ext,$allowed_type )){

								$img_ti = 'image';
					

							} else{
								
								$img_ti = 'video';

								

							   
							}

							 $img_o = "<div data-type='".$img_ti."' data-set='".$data_set."' class='post_image'  > 

							 <img  src='".$image_oI."' >  <img class='overlay_post_image' src='".$image_oI."' > 
 </div>

							";
							


						}


						//href='index.php?story=".$row['url']."' 


			if( $row['visible'] === '1' || $row['title'] === '' ){

			}else{

					$return_mini .= "<a data-set='".$row['url']."' type='story' onclick='pages_guider(this);' class='post' >


							<div data-type='".$img_ti."' id='".$img_t."'>

							

							".$img_o."

							

								<div id='post_title'> <img src='images/play.svg'> 

								<span data-set='".$row['url']."' type='story' onclick='pages_guider(this);' >  ".$content_title ." <small>@".$row['pen_name']." </small></span>
								</div>


							</div>




					</a>";

				}	



				}
			// }

	return $return_mini;
}



						function echo_story($data)
							{

								global $conn;
							
							$url_id = $data;

							$sql_arrange = "SELECT posts.id, posts.rank, posts.title, posts.url, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref , posts.creator, users.name, users.pen_name ,posts.image,users.profile  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.url ='$url_id' ORDER BY posts.created_at DESC LIMIT 10";

					
							return echo_post_data($sql_arrange,'out','full'); 

							}




				function stories_get($profile_id){

					global $conn;

					$sql_arrange = "SELECT posts.id, posts.rank, posts.url,posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.creator ='$profile_id' AND title != '' ORDER BY posts.created_at DESC LIMIT 10 ";

					$sql_pins = "SELECT posts.id,posts.image, posts.rank, posts.url,posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name,users.profile, users.pen_name  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.creator ='$profile_id' AND posts.visible = '0' AND posts.title != '' ORDER BY posts.created_at DESC LIMIT 3 ";


					// $sql_pins_c = $conn->query("SELECT id FROM posts  WHERE creator ='$profile_id' AND visible = '0' ORDER BY created_at DESC LIMIT 3 "); 

					// if ($sql_pins_c->num_rows >= 3) {
						
					// 	$query_pin = echo_mini($sql_pins,'3'); 
					// }else{
					// 	$query_pin = '';
					// }

					

					$query_box = echo_post_data($sql_arrange,'out',''); 

						
					// <div id="pinned_posts">

				 // 		 '.$query_pin.'

				 // 		  </div>

						return '

				 		 <div  class="posts_bundle">

				 		 '.$query_box.'

				 		 	</div>';

				}


				function echo_userdata($value)
				{

					global $conn;
					global $Users_name_id;
					
									$page_id = $value;

				$pf_check = $conn->query("SELECT * FROM users WHERE pen_name='$page_id' ");

					while($pf = $pf_check->fetch_assoc()) {

					 $profile_name = $pf["name"];
					 $profile_pen_name = $pf["pen_name"];
					 $profile_pen_bio = $pf["bio"];
					 $profile_id = $pf["id"];
					 $profile_image = $pf["profile"];

				}

				$check_occur = $conn->query("SELECT * FROM notifications WHERE receiver='$profile_id' AND sender='$Users_name_id' AND type='follow' ");

					if ($check_occur->num_rows === 0) {
						$follow_status = 'follow';
					}else{

					while($row = $check_occur->fetch_assoc()) {

				 		$bool_follow = $row["liked"];

					 		if($bool_follow === 'true'){
					 			$follow_status = 'Following';
					 		}else{
					 			$follow_status = 'Follow';
					 		}

				 		}
					}

						// echo($Usr_pen_name);
						// echo($page_id);


							

					if ($Users_name_id === $profile_id) {

							$follow_fl = '';
							$data_more = '';
							$data_more = '<a id="more_opt_pf" type="options" onclick="pages_guider(this);">

							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path d="M 9.6679688 2 L 9.1757812 4.5234375 C 8.3550224 4.8338012 7.5961042 5.2674041 6.9296875 5.8144531 L 4.5058594 4.9785156 L 2.1738281 9.0214844 L 4.1132812 10.707031 C 4.0445153 11.128986 4 11.558619 4 12 C 4 12.441381 4.0445153 12.871014 4.1132812 13.292969 L 2.1738281 14.978516 L 4.5058594 19.021484 L 6.9296875 18.185547 C 7.5961042 18.732596 8.3550224 19.166199 9.1757812 19.476562 L 9.6679688 22 L 14.332031 22 L 14.824219 19.476562 C 15.644978 19.166199 16.403896 18.732596 17.070312 18.185547 L 19.494141 19.021484 L 21.826172 14.978516 L 19.886719 13.292969 C 19.955485 12.871014 20 12.441381 20 12 C 20 11.558619 19.955485 11.128986 19.886719 10.707031 L 21.826172 9.0214844 L 19.494141 4.9785156 L 17.070312 5.8144531 C 16.403896 5.2674041 15.644978 4.8338012 14.824219 4.5234375 L 14.332031 2 L 9.6679688 2 z M 12 8 C 14.209 8 16 9.791 16 12 C 16 14.209 14.209 16 12 16 C 9.791 16 8 14.209 8 12 C 8 9.791 9.791 8 12 8 z"></path>
</svg>
				 		
				 		</a>


				 			';
							

						}else{

							$data_more = '';
							$follow_fl = '<button class="button_userpage" onclick=" follow(\''.$profile_pen_name.'\',this) " id="'.$follow_status.'">'.$follow_status.'</button>';
							$follow_fl .= '<button class="button_userpage" type="write_message" onclick="pages_guider(this)" data-set="'.$profile_pen_name.'" id="message" > Discuss </button>';

			
						}


							$image_pic = get_pfimage($profile_image); 


							$follow_q = $conn->query("SELECT * FROM notifications WHERE receiver='$profile_id' AND type='follow' AND liked='true' ");
							$follow_count = $follow_q->num_rows;

							$following_q = $conn->query("SELECT * FROM notifications WHERE sender='$profile_id' AND type='follow' AND liked='true' ");
							$following_count = $following_q->num_rows;

							//	Get the followers
							$read_q = $conn->query("SELECT * FROM posts WHERE creator='$profile_id' AND visible='4' ");
							$read_count = $read_q->num_rows;

							$write_q = $conn->query("SELECT * FROM posts WHERE creator='$profile_id' AND title != '' ");
							$write_count = $write_q->num_rows;




// AND image!= '' AND image!= 'undefined'

						$whole_st = stories_get($profile_id);

				 		return ' <div id="data_box"> 

				 		<div id="user_data_box">



				 		<img class="coverlayer" src="'.$profile_image.'">

				 		<div id="profile_section">

				 		'.$image_pic.'

				 		<div id="main">

				 		<div id="main_bar">

				 		<large id="users_name_pf"> <span>'.ucfirst($profile_name) ." @".$profile_pen_name.' <medium>'.$profile_pen_bio.'</medium></span>  </large> 

				 			'.$follow_fl.'

				 			'.$data_more.'

				 			</div>




					 		<div id="data_user">

					 			<span onclick="get_follow(\'Stories\',\''.$profile_id.'\')" > <b>'.$write_count.'</b> Creates</span>

					 			<span onclick="get_follow(\'series\',\''.$profile_id.'\')"> <b>'.$read_count.'</b>Albums</span>

					 			<span onclick="get_follow(\'Followers\',\''.$profile_id.'\')" > <b>'.$follow_count.'</b> Followers</span>

					 			<span onclick="get_follow(\'Following\',\''.$profile_id.'\')" > <b>'.$following_count.'</b> Following</span>

					 			
					 			
					 		</div>

					 		</div>

					 		</div>



				 		 </div>



				 		 </div>


				 		<div id="stuff_list">

				 		<center>

				 			'.$whole_st.'

				 		

				 		</center>

				 		</div>

				 		 ';


				 		 //profile

				}


				function FilterMentionHash($tweet){

					$tweet = html_entity_decode($tweet, ENT_QUOTES);

					$tweet = preg_replace("/#([A-Za-z0-9\/\.]*)/", "<a onclick='pages_guider(this);' type='search' data-set=\"$1\">#$1</a>", $tweet);
					$tweet = preg_replace("/@([A-Za-z0-9\/\.]*)/", "<a onclick='pages_guider(this);' type='user' data-set=\"$1\">@$1</a>", $tweet);
					return $tweet;
				}
				




function echo_post_data($sql_arrange,$ref_par,$ref_size){

			global $conn;
			
			global $Usr_pen_name;
			global $Users_name_id;
			$return_var = "";



			$check = $conn->query($sql_arrange);

			if ($check->num_rows != 0) {

				while($row = $check->fetch_assoc()) {

						$posted_id = $row['id'];

						$posted_age = $row['created_at'];
						$phpdate = strtotime( $posted_age );
						$credit = date( 'd M', $phpdate );

						$check_occur = $conn->query("SELECT * FROM notifications WHERE post_id='$posted_id' AND sender='$Users_name_id' AND type='like' ");
						
						if ($check_occur->num_rows === 0) {

							$button_id = "elevate_buttton";
						}else{
							
							while($pop = $check_occur->fetch_assoc()) {

						 		$liked = $pop["liked"];

						 		if ($liked === 'true') {
						 			$button_id = "elevated_buttton";
						 		}else{
						 			$button_id = "elevate_buttton";
						 		}
						 	}
						}



						$n = $row['likes'];
						$n_format = get_records( $n );

						$refer_id = $row['ref'];

						$image_oI = $row['image'];
						$img_o = '';
						$img_t = 'media_section';
						$img_ti = '';

						$post_identity = $row['id'];
						$post_url = $row['url'];

						$view_q = $conn->query("SELECT * FROM notifications WHERE post_id='$post_identity' AND type='reading' ");

						$view_count = $view_q->num_rows;

						$min_read = round( (str_word_count( $row['content'] )/4 )/60,0);

				
						$content_title = strip_tags( html_entity_decode($row['title']) ,'<i>');

						$article_meta = " <small> ".$view_count." views . ".$min_read." min read </small> ";

						if($image_oI === NULL || $image_oI === '' || $image_oI === 'undefined'){

							$img_ti = 'text';

							$img_o = "<div data-type='".$img_ti."' data-set='' class='post_image'  > 

							<img class='coverlayer' src='".$row['profile']."'>

							</div>";

						}else{

							$img_array = explode('.', $image_oI);
							$img_ext = strtolower(end($img_array));

							$data_set = $row['image'];

							$allowed_type = array('png','gif','jpeg','jpg');

						

							 $image_oI =  parseVideos($image_oI);

							if(in_array($img_ext,$allowed_type )){

								$img_ti = 'image';
							   $article_meta = " <small> ".$min_read." min read </small> ";

							   $image_oIv = '';

							} else{
								
								$img_ti = 'video';

								 $article_meta = " <small> ".$view_count." views </small> ";





							if (substr_count($data_set, 'youtube') > 0) {

									$step1=explode('v=', $data_set);
									$step2 =explode('&',$step1[1]);
									$data_set = $step2[0];

								$image_oIv =" <iframe id='video_con' src='http://www.youtube.com/embed/".$data_set."?enablejsapi=1' ></iframe>";	

							}else if(substr_count($data_set, 'vimeo') > 0) {

								$data_set = (int) substr(parse_url($data_set, PHP_URL_PATH), 1);

								$image_oIv =" <iframe id='video_con' src='http://player.vimeo.com/video/".$data_set."?api=1' ></iframe>";
																
							}


							   
							}


							 $img_o = "<div data-type='".$img_ti."'  class='post_image'  > 


									 <div id='image_con' >

									 <img  src='".$image_oI."' > 
									 <img class='overlay_post_image' src='".$image_oI."' > 

									</div>


									".$image_oIv."
							
							
				

							 </div>";
							
							
						}


						$check_comment = $conn->query("SELECT id FROM response WHERE post_id='$posted_id' AND type='comment' " );

						$quantity_chat = get_records($check_comment->num_rows);

						$check_writes = $conn->query("SELECT id  FROM posts WHERE ref= '$posted_id' ");

						$quantity_write = get_records($check_writes->num_rows);

						//echo $row['content'];

						//assigining the button # to a variable for later use


						$chat_svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" version="1.1">
								<g id="surface1">
								<path d="M 37 39 L 11 39 L 5 45 L 5 11 C 5 7.699219 7.699219 5 11 5 L 37 5 C 40.300781 5 43 7.699219 43 11 L 43 33 C 43 36.300781 40.300781 39 37 39 Z "></path>
								</g>
								</svg>';


						$heart_svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 510.51 510.51" style="enable-background:new 0 0 510.51 510.51;" xml:space="preserve">
<g>
	<g>
		<path d="M510.51,167.399c0,14.742-2.09,29.286-6.273,43.629c-4.186,14.344-9.362,27.492-15.538,39.445    c-6.179,11.953-14.844,24.802-25.998,38.548c-11.158,13.746-21.816,25.801-31.978,36.158    c-10.161,10.359-23.208,22.512-39.146,36.457c-15.939,13.947-29.984,25.799-42.136,35.563    c-12.151,9.762-27.593,22.111-46.317,37.055c-18.726,14.943-34.265,27.393-46.617,37.354    c-13.547-12.352-31.676-27.689-54.387-46.02c-22.711-18.328-42.533-34.264-59.467-47.813    c-16.934-13.545-35.062-29.482-54.387-47.811c-19.325-18.328-35.162-35.461-47.514-51.398C28.4,262.631,18.34,244.9,10.57,225.377    C2.8,205.853-0.686,186.528,0.111,167.403c0-35.46,12.55-65.743,37.652-90.844s55.383-37.652,90.844-37.652    c13.148,0,26.597,3.781,40.343,11.352s25.302,15.936,34.665,25.1c9.363,9.164,18.627,19.722,27.791,31.676    s15.141,20.321,17.93,25.102c2.789,4.781,4.98,8.566,6.574,11.355l6.571-10.758c3.984-7.172,10.16-15.838,18.527-25.998    c8.367-10.16,17.631-20.42,27.791-30.779c10.16-10.359,22.113-19.125,35.859-26.297c13.747-7.172,27.194-10.758,40.343-10.758    c35.461,0,65.246,12.451,89.35,37.354C498.457,101.159,510.51,131.54,510.51,167.399z"/>
	</g>
</g>


</svg>';


$share_svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" version="1.1">
<g id="surface1">
<path style=" " d="M 9.5 3 C 8.789063 3 8.320313 3.289063 8.09375 3.6875 L 6.8125 6 L 4.9375 6 C 1.996094 6 0 8.058594 0 11 L 0 19.125 C 0 21.816406 2.183594 24 4.875 24 L 21.125 24 C 23.816406 24 26 21.816406 26 19.125 L 26 10.875 C 26 8.183594 23.816406 6 21.125 6 L 19.1875 6 L 17.90625 3.6875 C 17.679688 3.289063 17.179688 3 16.5 3 Z M 4 7.875 C 4.628906 7.875 5.125 8.371094 5.125 9 C 5.125 9.628906 4.628906 10.125 4 10.125 C 3.371094 10.125 2.875 9.628906 2.875 9 C 2.875 8.371094 3.371094 7.875 4 7.875 Z M 13 7.9375 C 16.898438 7.9375 20.0625 11.101563 20.0625 15 C 20.0625 18.898438 16.898438 22.0625 13 22.0625 C 9.101563 22.0625 5.9375 18.902344 5.9375 15 C 5.9375 11.097656 9.101563 7.9375 13 7.9375 Z M 13 10.1875 C 10.34375 10.1875 8.1875 12.34375 8.1875 15 C 8.1875 17.65625 10.34375 19.8125 13 19.8125 C 15.65625 19.8125 17.8125 17.65625 17.8125 15 C 17.8125 12.34375 15.65625 10.1875 13 10.1875 Z "></path>
</g>
</svg>';

						$write_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 17.90625 1.0039062 C 17.808828 1.013125 17.710938 1.0376719 17.617188 1.0761719 C 17.243187 1.2311719 17 1.596 17 2 L 17 4 L 4 4 C 2.9069372 4 2 4.9069372 2 6 L 2 11 A 1.0001 1.0001 0 1 0 4 11 L 4 6 L 17 6 L 17 8 C 17 8.404 17.243188 8.7688281 17.617188 8.9238281 C 17.741187 8.9748281 17.871 9 18 9 C 18.26 9 18.516031 8.8980312 18.707031 8.7070312 L 21.707031 5.7070312 C 22.098031 5.3160312 22.098031 4.6839687 21.707031 4.2929688 L 18.707031 1.2929688 C 18.492531 1.0784687 18.198516 0.97625 17.90625 1.0039062 z M 20.984375 11.986328 A 1.0001 1.0001 0 0 0 20 13 L 20 18 L 7 18 L 7 16 C 7 15.596 6.7568125 15.231172 6.3828125 15.076172 C 6.2588125 15.025172 6.129 15 6 15 C 5.74 15 5.4839687 15.101969 5.2929688 15.292969 L 2.2929688 18.292969 C 1.9019687 18.683969 1.9019687 19.317031 2.2929688 19.707031 L 5.2929688 22.707031 C 5.5789687 22.993031 6.0078125 23.077828 6.3828125 22.923828 C 6.7568125 22.768828 7 22.405 7 22 L 7 20 L 20 20 C 21.093063 20 22 19.093063 22 18 L 22 13 A 1.0001 1.0001 0 0 0 20.984375 11.986328 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
</svg>';



						if ($row['visible'] == 0) {

							$story_type = "story";

						}if ($row['visible'] == 4) {

							$story_type = "series";

						}else{

							$story_type = "two_lines";

						}


															if ($row['creator'] === $Users_name_id) {

										$edit_allow = 'true';

								
									
									}else{

										$edit_allow = 'false';

										
									}

						

						$chat_svges = "<button  class='button_res' onclick='likepost(this)' id='".$button_id."'> 
										<center>
									
										".$heart_svg."
										<span class='post_likes' >".$n_format."</span>
									
										</center>
										</button>	

										";


												$all_buttons = "<button class='button_res' id='discuss_button'  type='chat' onclick='pages_guider(this)' >
												<center>

												<div>
												
												".$chat_svg."
												<span class='post_likes' > ".$quantity_chat."</span>
												
												</center>
												</button>";


												$write_svges = "<button class='button_res' id='discuss_button' type='write_back' onclick='pages_guider(this)'>
												<center>

											
												".$write_svg."
												<span class='post_likes'> ".$quantity_write."</span>
												

												</center>
												</button>";


												$option_svges = "<button class='button_res' id='more' data-type='".$edit_allow."' data-set='".$post_url."' type='share' onclick='pages_guider(this);'>

													<center>

<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' version='1.1'>
<g id='surface1'>
<path  d='M 25 2 C 12.316406 2 2 12.316406 2 25 C 2 37.683594 12.316406 48 25 48 C 37.683594 48 48 37.683594 48 25 C 48 12.316406 37.683594 2 25 2 Z M 13 28 C 11.34375 28 10 26.65625 10 25 C 10 23.34375 11.34375 22 13 22 C 14.65625 22 16 23.34375 16 25 C 16 26.65625 14.65625 28 13 28 Z M 25 28 C 23.34375 28 22 26.65625 22 25 C 22 23.34375 23.34375 22 25 22 C 26.65625 22 28 23.34375 28 25 C 28 26.65625 26.65625 28 25 28 Z M 37 28 C 35.34375 28 34 26.65625 34 25 C 34 23.34375 35.34375 22 37 22 C 38.65625 22 40 23.34375 40 25 C 40 26.65625 38.65625 28 37 28 Z '></path>
</g>
</svg>

	</center>
													</button>";


					

						// $credit =   date( 'Y-m-d', strtotime($date1));

					$image_pic = get_pfimage($row['profile']);


					$private_note = '';

						if ( $row['visible'] === '0' || $row['visible'] === '2' || $row['visible'] === '4' ) {

							// 0 -> story, 1 -> twolines private , 2 two lines public, 3 -> annoyymus,4 & 5 is empty

							$all_buttons = $chat_svges.$write_svges.$all_buttons.$option_svges;


						}else if($row['visible'] === '3'){
							
							$entry_type = "<div id='text_about'> <span id='visible_type'>Annonymous</span>  <small>  ".$credit."</small> </div>";

		
					
						}else if($row['visible'] === '1'){


							$is_men_q = $conn->query("SELECT id FROM response  WHERE receiver='$Users_name_id' AND post_id ='$post_identity' AND type='mention' ");

								$is_men = $is_men_q->num_rows;

								// makes private post invisible to the public
								if ($row['creator'] === $Users_name_id || $is_men != 0 ) {
									
									$is_okay = "YES";
								}else{
									$is_okay = "NOT";
								}


							// $entry_type = "<div id='text_about'> <span id='visible_type'>".$row['name']." </span>  <small>  ".$row['pen_name']." . ".$credit."</small>   </div>";

							$private_note = "<span id='private_note'>Private</span> | ";
					
						}
							
						


						$entry_type = "<div id='text_about'> <span id='visible_type'>".$private_note.$row['pen_name']." . ".$credit." </span>  <small>

						".$view_count." views

						</small> 

						</div>";





						$bottom_visible = "	<div  id='post_bottom'>

												<div id='post_c'>
												".$all_buttons."
												<br></div>


											</div>";


						$post_note = "<a data-set='".$row['pen_name']."' type='user' onclick='pages_guider(this);'  id='post_note'> <div id='inline_credit'> ".$image_pic.$entry_type." </div>  </a>";

						// $credit = date("t F Y", mktime( $row['created_at'] ) );

						// $credit = timeAgo( $row['created_at'] );

						 //<a href='post.php?id="$row"'></a>



						




							$check_occur2 = $conn->query("SELECT created_at FROM response  WHERE receiver='$Users_name_id' AND sender!='$Users_name_id' AND seen='n' AND post_id ='$post_identity' ORDER BY created_at DESC");

									if($check_occur2->num_rows !== 0 ){

										while($rrow = $check_occur2->fetch_assoc()) {
												$time_cre = $rrow['created_at'];
												break;
										}

											
											$un_type = " <large>".$check_occur2->num_rows ."</large> Unread discussion ".timeAgo($time_cre);
											




										$meta = "<span id='meta' type='chat' onclick='pages_guider(this)' >".$un_type ." <button>Chat</button> </span>";

									}else{
										$meta = '';
									}






					if($row['visible'] === '1' && $is_okay === 'NOT' || $row['title'] === '' ){


								// blocking people from viewing private stories

								// $return_var .= "<div class='two_lines'><br><h1>Private</h1></div>";

					}else{






						if($row['visible'] === '0' || $row['visible'] === '3'){



								$ec = $conn->query( " SELECT url, title FROM posts WHERE id ='$refer_id' " );

						while ($rower = $ec->fetch_assoc() ) {
					
							$meta.= "<span id='meta' data-id='".$rower['url']."'' type='chat' onclick='pages_guider(this)' >".$rower['title']."</span>";

						}


						$read_more = " onclick='read_more(this)'";

						if ($ref_size === 'full') {

							$content_data = $row['content'];

							$meta_for = $meta;

							$meta = '';

							$read_more = "";

						}else{

							$meta_for = '';
							$content_data = limit_words(strip_tags( $row['content'],'<i>' ) ,30)."..";

						}




									// 				<div id='button_collect'> 

									
									// 	<a data-set='".$post_url."' type='series-pannel' data-type='post' onclick='pages_guider(this);'>

									// 		<button class='button_res'>
									// 			<center>

									// 			<div id='res'>

									// 			".$share_svg."
											
												
									// 			</div>

									// 			</center>
									// 			</button>

									// 	</a>

									// </div>




							$return_var .= $meta_for."<div data-id='".$post_url."' data-type='".$img_ti."'  class='post_container post'>

							 <div id='pannel_two_lines'>

							



									

							</div>

							".$meta." 
							

							<div data-id='".$post_url."' id='story_parts' ".$read_more .">

							

							<div data-type='".$img_ti."' id='".$img_t."'>

							".$post_note." 

							

							".$img_o."

							

								<div id='post_title'>

								 <img src='images/play.svg'> 

								<span>  <large>".$content_title."</large>".$article_meta."</span>
								</div>


							</div>

								<div id='main_post'>
								<div id='contain_title'>

								<small>@".$row['pen_name']." . ".timeAgo($row['created_at'])." </small>

								

								<button id='more' data-type='".$edit_allow."' data-set='".$post_url."' type='share' onclick='pages_guider(this);' >...</button>


							

								 </div>
								 
								<div id='post_content'  >

								<div class='text' >".$content_data." </div>

								

								</div>

								
								

									</div>

									".$bottom_visible."

								</div>

								</div>";

						}else if($row['visible'] === '4'){


							$s_img = '';

								if ($ref_size === 'full') {
								
										$select_img = $conn->query(" SELECT series.image,series.type,series.post_id,posts.url,posts.title FROM posts INNER JOIN series  ON posts.id = series.category_id  WHERE series.category_id='$posted_id' ORDER BY series.created_at DESC LIMIT 40 ");
								
								}else{
								
										$select_img = $conn->query(" SELECT * FROM series WHERE category_id='$posted_id' ORDER BY created_at DESC LIMIT 3 ");
															
								}



							if($select_img->num_rows > 0){

								
								// $array = [];

								while($r_row = $select_img->fetch_assoc() ) {


									// 		$s_inert = '<svg class="collage_part"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
									//     <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 6 3 A 1.0001 1.0001 0 1 0 6 5 L 24 5 A 1.0001 1.0001 0 1 0 24 3 L 6 3 z M 6 7 C 4.9069372 7 4 7.9069372 4 9 L 4 15 L 6 15 L 6 9 L 24 9 L 24 15 L 26 15 L 26 9 C 26 7.9069372 25.093063 7 24 7 L 6 7 z M 12 11 L 9 15 L 15 15 L 12 11 z M 20 11 A 1 1 0 0 0 19 12 A 1 1 0 0 0 20 13 A 1 1 0 0 0 21 12 A 1 1 0 0 0 20 11 z M 16.75 12 L 15.5 13.667969 L 15.599609 13.800781 L 16.5 15 L 19 15 L 16.75 12 z M 3 17 L 3 24 C 3 25.657 4.343 27 6 27 L 24 27 C 25.657 27 27 25.657 27 24 L 27 17 L 3 17 z M 13 19 L 17 19 C 17.552 19 18 19.448 18 20 C 18 20.552 17.552 21 17 21 L 13 21 C 12.448 21 12 20.552 12 20 C 12 19.448 12.448 19 13 19 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
									// </svg>';

										if ($r_row['type'] === 'image') {

											$s_inert = ' <img class="collage_part" src="'.parseVideos( $r_row['image'] ).'" > ';

											// $array = $r_row['image'];
											
										}else if ($r_row['type'] === 'tag') {

											$pos_id = $r_row['post_id'];

											$selp_img = $conn->query(" SELECT image FROM posts WHERE id='$pos_id' ");

											while($s_row = $selp_img->fetch_assoc() ) {

												if ($s_row['image'] != 'undefined') {
													# code...

													$s_inert = ' <img class="collage_part" src="'.parseVideos( $s_row['image'] ).'" > ';

													// $array = $s_row['image'];


												}else if( $ref_size === 'full' ){

														$sql_pins = "SELECT posts.id,posts.image, posts.rank, posts.url,posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name,users.profile, users.pen_name  FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.id ='$pos_id' AND posts.visible = '0' AND posts.title != '' ORDER BY posts.created_at DESC LIMIT 3 "; 

														$s_inert = echo_mini($sql_pins,'3'); 

												}

												
											}

										}


											if ($ref_size === 'full') {

												$s_img .= '<div  id="seires_image" onclick="expand_image(this)" >'.$s_inert.'

												<h4 data-set="'.$r_row['url'].'" type="story" onclick="pages_guider(this)" > 

												<large>'.$r_row['title'].'</large>

												<button onclick="go_back()" > 

												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" version="1.1">
												
												<g id="surface1">
												<path style=" " d="M 8.71875 7.28125 L 7.28125 8.71875 L 14.5625 16 L 7.28125 23.28125 L 8.71875 24.71875 L 16 17.4375 L 23.28125 24.71875 L 24.71875 23.28125 L 17.4375 16 L 24.71875 8.71875 L 23.28125 7.28125 L 16 14.5625 Z "></path>
												</g>
												</svg>

												 </button>

												</h4> 

												 </div>';

											}else{
												$s_img .= $s_inert;
											}

										

								}

								// if ($array && $array != '') {

								// 	$s_img .= '<img class="coverlayer" src="'.parseVideos( $array ).'">';
								// }

								

								

							if ($ref_size === 'full') {

										$s_link = '';

							}else{

								// for ($x = 1; $x <= 3-$select_img->num_rows; $x++) {

								

								// 	$s_img .= '<svg class="collage_part"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
								// 	    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 6 3 A 1.0001 1.0001 0 1 0 6 5 L 24 5 A 1.0001 1.0001 0 1 0 24 3 L 6 3 z M 6 7 C 4.9069372 7 4 7.9069372 4 9 L 4 15 L 6 15 L 6 9 L 24 9 L 24 15 L 26 15 L 26 9 C 26 7.9069372 25.093063 7 24 7 L 6 7 z M 12 11 L 9 15 L 15 15 L 12 11 z M 20 11 A 1 1 0 0 0 19 12 A 1 1 0 0 0 20 13 A 1 1 0 0 0 21 12 A 1 1 0 0 0 20 11 z M 16.75 12 L 15.5 13.667969 L 15.599609 13.800781 L 16.5 15 L 19 15 L 16.75 12 z M 3 17 L 3 24 C 3 25.657 4.343 27 6 27 L 24 27 C 25.657 27 27 25.657 27 24 L 27 17 L 3 17 z M 13 19 L 17 19 C 17.552 19 18 19.448 18 20 C 18 20.552 17.552 21 17 21 L 13 21 C 12.448 21 12 20.552 12 20 C 12 19.448 12.448 19 13 19 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
								// 	</svg>';

							

		
				 			
								// } 



								$s_link = "data-set='".$post_url."' type='story' onclick='pages_guider(this)' ";

								}

							

							}else{

								$s_img = '';
								$s_link = '';

							}

			


							$return_var .= "<div data-id='".$post_url."' type='series' onclick='read_more(this)'
							 
							 class='post_container series'>

								
								<div id='pannel_two_lines'>

									".$post_note."

												<div id='contain_title'>					
												

												<button id='more' data-type='".$edit_allow."' data-set='".$post_url."' type='share' onclick='pages_guider(this);' >
												...
												</button>

											

												</div>




								</div>


								<div id='store'>

								<center>

									".$meta."

									

									<h1>
									".$row['title']." <small> ".$conn->query(" SELECT id FROM series WHERE category_id='$posted_id' ")->num_rows." Pieces</small></h1> <div> ".$s_img."	 </div>
										</center>
									</div>

								

							</div>";

							

						}else{

								
								$pst_id = $row['id'];

								if($ref_par === 'out' ){

									$sql_heart = "SELECT posts.id, posts.url,posts.rank, posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.id ='$refer_id' ORDER BY posts.created_at ASC LIMIT 3 ";

									$query_box_child = echo_post_data($sql_heart,'out',''); 

								}else if($ref_par === 'in' ){

									$sql_heart = "SELECT posts.id, posts.url, posts.rank, posts.title, posts.content, posts.region , posts.visible,posts.created_at, posts.likes, posts.ref, posts.creator, users.name, users.pen_name ,posts.image,users.profile FROM posts INNER JOIN users ON posts.creator = users.id WHERE posts.ref ='$pst_id' ORDER BY posts.created_at ASC LIMIT 3 ";

									$query_box_child = echo_post_data($sql_heart,'in',''); 

								}else{

									$query_box_child  = "";
								}


							$tweet = substr($row['title'] ,0,130);

							$tweet = FilterMentionHash($tweet);



									// 							<div id='button_collect'> 

									// ".$all_buttons ."

									// </div>


							$return_var .= "<div data-id='".$post_url."' class='post_container two_lines'>

								

								<div id='pannel_two_lines'>

									".$image_pic."

												<div id='contain_title'>

												<div id='button_collect'> ".$chat_svges ."

													<button class='button_res' id='more' data-type='".$edit_allow."' data-set='".$post_url."' type='share' onclick='pages_guider(this);'>

													<center>

<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 50 50' version='1.1'>
<g id='surface1'>
<path  d='M 25 2 C 12.316406 2 2 12.316406 2 25 C 2 37.683594 12.316406 48 25 48 C 37.683594 48 48 37.683594 48 25 C 48 12.316406 37.683594 2 25 2 Z M 13 28 C 11.34375 28 10 26.65625 10 25 C 10 23.34375 11.34375 22 13 22 C 14.65625 22 16 23.34375 16 25 C 16 26.65625 14.65625 28 13 28 Z M 25 28 C 23.34375 28 22 26.65625 22 25 C 22 23.34375 23.34375 22 25 22 C 26.65625 22 28 23.34375 28 25 C 28 26.65625 26.65625 28 25 28 Z M 37 28 C 35.34375 28 34 26.65625 34 25 C 34 23.34375 35.34375 22 37 22 C 38.65625 22 40 23.34375 40 25 C 40 26.65625 38.65625 28 37 28 Z '></path>
</g>
</svg>

	</center>
													</button>


												</div>

											

												

												

												</div>



								</div>

									<div id='store'>

									".$meta."

									<h1 type='chat' onclick='pages_guider(this)' > ".$entry_type ." <medium>".$tweet."  </medium> </h1>
												
									<reference>".$query_box_child."</reference>

									</div>

								

							</div>";


						

					}

				}

						

				}

			}

			

				return $return_var;
			


			

}

?>