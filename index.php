<?php 

require_once 'function_collection.php';	

	  if(isset($_COOKIE['user_token'])) {


			if (isset($_POST['logout'])) {

	        	unset($_COOKIE['user_token']);
	        	setcookie('user_token', '', time() - 3600, '/');
	        

	  		}

	  		
		}
			include_once("pannel.php");
		




?>

<!DOCTYPE html>
<html>

<body onload="start_op();">









		<?php 





			

			if( isset($_COOKIE['lluda_token']) ){
				echo '<div id="content" autofocus ><center>';
			}else{
				echo '<style> #cover{left:0; width:100%; height:100%;} </style><div id="prime_con" autofocus ><center>';
			}



				$feed_frame = '<div id="posts" class="posts_bundle" > </div>

							<button phase="Loaded" id="load_more" onclick="download_content()"> <center><img alt="load more" id="loading_img" src="images/loading.svg"></center> </button>';



				if ( isset($_GET['story']) ) {

					$query_box = echo_story( $_GET['story'] );

				}else{

					$query_box = '';

				}

				
				echo "<div id='story_pop'  class = 'parent_container'> <article id='story_box' >".$query_box."</article> <div id='posts_story' class='posts_bundle' ></div> </div>";





				if( isset( $_GET['user'] ) ){


					$user_return = echo_userdata( $_GET['user'] );
					$user_dataset = $_GET['user'];

				}else{
					$user_return = '';
					$user_dataset = '';
				}

				echo '<div id="user_pop"  class = "parent_container" data-set="'.$user_dataset.'"> '.$user_return.' </div>';


					echo '<div id="cover"  onclick="go_back()"> </div>

					<div id="search_pop" class = "parent_container">

					<input autocomplete="off" onkeyup="on_searchbar(this,event)" id="search_pop_box" type="text" name="q" placeholder="Search">
					
					<center><div id="post_sr">
					</div><center>

					</div>';

					echo 	'	

					

			<div id="write_pop"  class = "parent_container">

			<h1>Create</h1>
			
			<a type="write_message"  onclick="pages_guider(this)">

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" version="1.1">
								<g id="surface1">
								<path d="M 37 39 L 11 39 L 5 45 L 5 11 C 5 7.699219 7.699219 5 11 5 L 37 5 C 40.300781 5 43 7.699219 43 11 L 43 33 C 43 36.300781 40.300781 39 37 39 Z "></path>
								</g>
								</svg>

			Discussion</a>



			
			<a type="write_story"  onclick="pages_guider(this)">

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1">
<g id="surface1">
<path style=" " d="M 16 5 C 13.242188 5 11 7.242188 11 10 L 11 22 L 15 23 L 11 24 L 11 34 L 28 34 C 29.652344 34 31 35.347656 31 37 L 31 40 C 31 41.9375 32 43 34 43 C 36 43 37 42 37 40 L 37 35 L 32 34 L 37 33 L 37 23 L 35 22 L 37 21 L 37 20 L 33 19 L 37 18 L 37 11 C 37 7.644531 38.433594 5.726563 41.25 5.1875 C 40.851563 5.085938 40.429688 5 40 5 Z M 43 7 C 40.121094 7 39 8.121094 39 11 L 39 14 L 44 14 C 44.554688 14 45 13.550781 45 13 L 45 10 C 45 7.648438 43 7 43 7 Z M 19 16 L 29 16 C 29.554688 16 30 16.449219 30 17 C 30 17.550781 29.554688 18 29 18 L 19 18 C 18.449219 18 18 17.550781 18 17 C 18 16.449219 18.449219 16 19 16 Z M 19 20 L 25 20 C 25.550781 20 26 20.449219 26 21 C 26 21.550781 25.550781 22 25 22 L 19 22 C 18.449219 22 18 21.550781 18 21 C 18 20.449219 18.449219 20 19 20 Z M 19 24 L 29 24 C 29.554688 24 30 24.449219 30 25 C 30 25.550781 29.554688 26 29 26 L 19 26 C 18.449219 26 18 25.550781 18 25 C 18 24.449219 18.449219 24 19 24 Z M 19 28 L 25 28 C 25.550781 28 26 28.445313 26 29 C 26 29.554688 25.550781 30 25 30 L 19 30 C 18.449219 30 18 29.554688 18 29 C 18 28.445313 18.449219 28 19 28 Z M 6 36 C 5.449219 36 5 36.445313 5 37 L 5 40 C 5 42.757813 7.242188 45 10 45 L 33 45 C 31.347656 45 29 43 29 40 L 29 37 C 29 36.445313 28.554688 36 28 36 Z "></path>
</g>
</svg>
			Story</a>


<form method="POST" enctype="multipart/form-data">
							<label for="post_exp">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" version="1.1">
<g id="surface1">
<path style=" " d="M 9.5 3 C 8.789063 3 8.320313 3.289063 8.09375 3.6875 L 6.8125 6 L 4.9375 6 C 1.996094 6 0 8.058594 0 11 L 0 19.125 C 0 21.816406 2.183594 24 4.875 24 L 21.125 24 C 23.816406 24 26 21.816406 26 19.125 L 26 10.875 C 26 8.183594 23.816406 6 21.125 6 L 19.1875 6 L 17.90625 3.6875 C 17.679688 3.289063 17.179688 3 16.5 3 Z M 4 7.875 C 4.628906 7.875 5.125 8.371094 5.125 9 C 5.125 9.628906 4.628906 10.125 4 10.125 C 3.371094 10.125 2.875 9.628906 2.875 9 C 2.875 8.371094 3.371094 7.875 4 7.875 Z M 13 7.9375 C 16.898438 7.9375 20.0625 11.101563 20.0625 15 C 20.0625 18.898438 16.898438 22.0625 13 22.0625 C 9.101563 22.0625 5.9375 18.902344 5.9375 15 C 5.9375 11.097656 9.101563 7.9375 13 7.9375 Z M 13 10.1875 C 10.34375 10.1875 8.1875 12.34375 8.1875 15 C 8.1875 17.65625 10.34375 19.8125 13 19.8125 C 15.65625 19.8125 17.8125 17.65625 17.8125 15 C 17.8125 12.34375 15.65625 10.1875 13 10.1875 Z "></path>
</g>
</svg>
                                Album</label>
	  						<input id="post_exp" accept="image/*" onchange="send_exp(this);" type="file" name="post_image" style="display: none;">
	  					</form>



		

			</div>';


// <div id="featured_tag"></div> 

		$home_con = '	<div id="top_pannel" ></div>

						<span id="set_feed_type" data-type="false" type="feed_opt" onclick="pages_guider(this);">

								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
								    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 3 7 A 1.0001 1.0001 0 1 0 3 9 L 27 9 A 1.0001 1.0001 0 1 0 27 7 L 3 7 z M 3 14 A 1.0001 1.0001 0 1 0 3 16 L 27 16 A 1.0001 1.0001 0 1 0 27 14 L 3 14 z M 3 21 A 1.0001 1.0001 0 1 0 3 23 L 27 23 A 1.0001 1.0001 0 1 0 27 21 L 3 21 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
								</svg>

						</span>		


		

		
							' ;


						


					echo'<div id="home_pop"  class = "parent_container" >

								'.$home_con.' '.$feed_frame.'

								</div>';

					$layer_img = '<img class="coverlayer" src="'.$prifile_link.'">';



					echo  "<div id='setup_pop'  class = 'parent_container' > </div>";

						$btn5 = '<button data-set="1" id="mentions_notif" type="notif" onclick="pages_guider(this);" > Discussions</button> 

						<button data-set="2" id="Notifications_notif" type="notif" onclick="pages_guider(this);" > Notifications </button>';

						

						echo "<div class='parent_container side_pop' id='notif_pop'> 

						".$layer_img."

						<h1 id='notification_type'> ".$btn5." </h1> 

						<div id='msg_form'> </div>
						<div id='notif_form'> </div>
						
						 </div>";

				

						echo "<div class='parent_container side_pop'  id='list_pop'> 

								".$layer_img." 

							<div id='notification_section' >



					 		</div>
						
						 </div>";


	if( isset($_COOKIE['lluda_token']) ){

		 echo '<div id="popup_tl">
				<center>

				<div id="popup_two_line">

				<center>
				<div id="me">'.$profile_image.'</div>

				<div id="post_btns">

				<button id="anonymous_btn" data-set="null" alt ="anonymous" data-type="2" onclick="Create_post(this)">Public</button>

				<button id="anonymous_btn" data-set="null" alt ="anonymous" data-type="1" onclick="Create_post(this)">Private</button>



				</div>

				<div id="update_btns">

					<button id="anonymous_btn" data-set="null" class="post_toggle anony_save" data-type="2" onclick="Create_post(this)">Save</button>

					</div>

				<div id="parent_two_lines">

				<textarea row="1" id="write_two_lines" spellcheck="false" contenteditable="true" onkeyup="two_lines_cal(this)"  type="text" placeholder="Write here.."></textarea>

					<reference id="write_ref_lines">

					</reference>

				</div>

				<span  class="signal_twolines" id="sign_btn" ></span>

				</center>

				</div>

				<div class="auto_mesage" id="auto_mesage"></div>

				</center>

				</div>';
}


			// $search_box = '

			// 	 <div id="search_pop" > <center>
			// <form action="search.php" method="GET" id="search_box"><input id="search_pop_box" type="text" name="q" placeholder="Search"></form>
			// </center>
			// </div>';

			// 		echo "<div id='div_head'> <img id='logo' src='images/white_logo.png'> <large>lluda</large> 

			// 		<a id='nav_search' onclick='search_story()''><img id='home_img' src='images/filter.svg'></a>

					
			// 		</div>";



					//feeds


			

	 ?>




	
</center></div>

<div tabindex="0" id="success" style="display: none;"></div>
<div id="cover_notice" onclick="go_back()"></div>

</body>




</html>

<!-- <script src="query.js"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

	var user_cover = "<?php echo $prifile_link;  ?>"

</script>

<script src="scripts.js"></script>

<!-- <script src="https://gist.github.com/jyr/1420508.js"></script> -->