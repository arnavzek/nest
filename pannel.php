<?php

		if ( isset($_GET['story']) ) {

			$meta_story = $_GET['story'];

			$check_metastory = $conn->query("SELECT * FROM posts WHERE url='$meta_story' ");

				while ($row = $check_metastory->fetch_assoc() ) {
						
						$title = $row['title'];
						$img_url =  $row["image"];
						$discr = limit_words( strip_tags( $row['content'],'<i>' ) ,15 );

			}



		}else if ( isset($_GET['user']) ) {

				$meta_user = $_GET['user'];

				$check_metauser = $conn->query("SELECT * FROM users WHERE pen_name='$meta_user' ");

				while ($row = $check_metauser->fetch_assoc() ) {
						
						$title = $row['name'];
						$discr =  $row['pen_name'] ;
						$img_url =  $row["profile"];
					

				}


		}else{
			$title = '';
			$discr = '';
			$img_url = '';
		} 




		$write_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 17.90625 1.0039062 C 17.808828 1.013125 17.710938 1.0376719 17.617188 1.0761719 C 17.243187 1.2311719 17 1.596 17 2 L 17 4 L 4 4 C 2.9069372 4 2 4.9069372 2 6 L 2 11 A 1.0001 1.0001 0 1 0 4 11 L 4 6 L 17 6 L 17 8 C 17 8.404 17.243188 8.7688281 17.617188 8.9238281 C 17.741187 8.9748281 17.871 9 18 9 C 18.26 9 18.516031 8.8980312 18.707031 8.7070312 L 21.707031 5.7070312 C 22.098031 5.3160312 22.098031 4.6839687 21.707031 4.2929688 L 18.707031 1.2929688 C 18.492531 1.0784687 18.198516 0.97625 17.90625 1.0039062 z M 20.984375 11.986328 A 1.0001 1.0001 0 0 0 20 13 L 20 18 L 7 18 L 7 16 C 7 15.596 6.7568125 15.231172 6.3828125 15.076172 C 6.2588125 15.025172 6.129 15 6 15 C 5.74 15 5.4839687 15.101969 5.2929688 15.292969 L 2.2929688 18.292969 C 1.9019687 18.683969 1.9019687 19.317031 2.2929688 19.707031 L 5.2929688 22.707031 C 5.5789687 22.993031 6.0078125 23.077828 6.3828125 22.923828 C 6.7568125 22.768828 7 22.405 7 22 L 7 20 L 20 20 C 21.093063 20 22 19.093063 22 18 L 22 13 A 1.0001 1.0001 0 0 0 20.984375 11.986328 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
</svg>';


						$chat_svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" version="1.1">
								<g id="surface1">
								<path d="M 37 39 L 11 39 L 5 45 L 5 11 C 5 7.699219 7.699219 5 11 5 L 37 5 C 40.300781 5 43 7.699219 43 11 L 43 33 C 43 36.300781 40.300781 39 37 39 Z "></path>
								</g>
								</svg>';



?>



<head>

		<meta name="mobile-web-app-capable" content="yes">

		<link rel="manifest" href="manifest.json">

		<link href="https://fonts.googleapis.com/css?family=Passion+One" rel="stylesheet">
		
		<link href="https://fonts.googleapis.com/css?family=Roboto:400,900" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="main.css">

		

	  <meta name="apple-mobile-web-app-capable" content="yes">
	  <meta name="mobile-web-app-capable" content="yes">
	  <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >
	  <meta charset="UTF-8">
	      
	  <meta name="description" content="A social world for those who keep running finding the unconventional">
	  <meta name="theme-color" content="#000" data-keep="true">
	   
	  <meta property="og:image:type" content="images/image/png" />

	  <meta property="og:image" content="<?php echo $img_url ?>" />
	  <meta property="og:title" content="<?php echo $title ?>" />
	  <meta property="og:description" content="<?php echo $discr ?>" />

	  <meta name="author" content="Arnav Singh">
	  <link rel="icon" href="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke_logo.png" sizes="512*512" type="image/png">

	
	
	<!-- <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script> -->






	<title>nest</title>
	
</head>

<?php 

require_once 'mysqlconnect.php';

	if( isset($_COOKIE['lluda_token']) ){


			
		$token_login = $_COOKIE['lluda_token'];



		$check_cookie = $conn->query("SELECT * FROM users WHERE token='$token_login' ");

		if($check_cookie->num_rows === 0) {

			//In case of cookie reset

			unset($_COOKIE['lluda_token']);

			setcookie('lluda_token', '', time() - 3600, '/');

			header("location:index.php");

		}

		while ($row = $check_cookie->fetch_assoc() ) {

			if ($row['type'] === '0') {
				
				header("location:verify.php");
			}
				
				$Users_name = $row['name'];

				$Users_name_id = $row['id'];
				$Usr_pen_name =  $row['pen_name'] ;
				$usr_seen = $row["last_seen"];
				$Usr_pen_email = $row["address"];
				$Usr_pen_bio =  $row["bio"];
				$Usr_name_bio =  $row["name"];
				$profile_image =  $row["profile"];


				if($profile_image === '' || $profile_image === 'undefined' || $profile_image === NULL){

						$profile_image = '<img src="images/default.svg">';
						$prifile_link = "images/default.svg";
							
				}else{
						$prifile_link = $profile_image;
						$profile_image = '<img src='.$profile_image.'>';

				}

				
		}

			echo '<img class="backlayer" src="'.$prifile_link.'">';

				

			$new_user_meta = "";

	$chat_svg_p = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 48 48" version="1.1">
								<g id="surface1">
								<path d="M 37 39 L 11 39 L 5 45 L 5 11 C 5 7.699219 7.699219 5 11 5 L 37 5 C 40.300781 5 43 7.699219 43 11 L 43 33 C 43 36.300781 40.300781 39 37 39 Z "></path>
								</g>
								</svg>';


	$home_svg_p = '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 238.48 238.48">

	<path class="cls-2" d="M197.68,189.45H141.07l-0.46-62.21c-5.36-12.17-35.33-11.89-40.18.45l-0.69,61.76H40.8c-3.35,0-6.06-2.24-6.06-5V106.2A4.51,4.51,0,0,1,36.13,103l78.44-78.17a6.92,6.92,0,0,1,9.18-.14h0l0.15,0.14L202.34,103a4.51,4.51,0,0,1,1.4,3.19v78.22A5.62,5.62,0,0,1,197.68,189.45Z"/></svg>';

	$write_svg_p = '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.1 16.1"><defs><style>.cls-1,.cls-2{fill:none;}.cls-1{stroke:inherit;stroke-miterlimit:10;stroke-width:0.7px;}</style></defs><title>create</title><path class="cls-1" d="M475.42,284l-0.4-4.53a0.46,0.46,0,0,1,.13-0.36l4-4a2.76,2.76,0,0,1,2-.81h0.44a3.83,3.83,0,0,1,3.77,3.16h0a2.76,2.76,0,0,1-.64,2.3l-1,1.16-2.85,3.26a0.46,0.46,0,0,1-.36.16l-4.95-.21" transform="translate(-470.82 -272.69)"></path><line class="cls-1" x1="8.05" y1="8.05" x2="12.82" y2="8.21"></line><line class="cls-1" x1="2.58" y1="13.37" x2="10.99" y2="5.03"></line></svg>';

	$search_svg_p = '<svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 410 410">

	<path class="cls-2" d="M356.73,349.9l-76.1-76.1a133,133,0,0,0,32.77-87.56c0-73.67-59.92-133.53-133.53-133.53S46.35,112.63,46.35,186.24s59.92,133.53,133.53,133.53A133,133,0,0,0,267.43,287l76.1,76.1a9.43,9.43,0,0,0,6.6,2.78,9.15,9.15,0,0,0,6.6-2.78A9.39,9.39,0,0,0,356.73,349.9ZM65,186.24a114.78,114.78,0,1,1,229.56,0c0,63.26-51.45,114.85-114.78,114.85S65,249.56,65,186.24Z" transform="translate(-13 -20.5)"/></svg>';

	$user_svg_p = '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">

	<circle class="cls-2" cx="16" cy="10.12" r="6.25"/><path class="cls-2" d="M7.94,26C7.94,21,11.55,17,16,17S24.06,21,24.06,26" transform="translate(0 -0.33)"/></svg>';


		

	echo '<div id="pannel">




				<div id="popup_story">

				<div id="add_extra">

				<input placeholder="Paste the link" id="add_extra_input" type="url">

				<button type="insertImage" onclick="send_video()" >Embed video</button>

				<button type="createLink" onclick="get_link(this)" >Link</button>

				<button type="insertImage" onclick="get_link(this)" >Image</button>

				

				</div>
					<div id="write_head">

						<button onclick="go_back()">
						<img src="images/close.svg">
						</button>



						<button id="js_format">

							<form method="POST" enctype="multipart/form-data">
								<label class="image_upload" id="add_media" for="post_image">

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
    <path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 11 1 C 8.8026661 1 7 2.8026661 7 5 L 7 17.5 C 7 20.525577 9.4744232 23 12.5 23 C 15.525577 23 18 20.525577 18 17.5 L 18 6 L 16 6 L 16 17.5 C 16 19.444423 14.444423 21 12.5 21 C 10.555577 21 9 19.444423 9 17.5 L 9 5 C 9 3.8833339 9.8833339 3 11 3 C 12.116666 3 13 3.8833339 13 5 L 13 15.5 C 13 15.786937 12.786937 16 12.5 16 C 12.213063 16 12 15.786937 12 15.5 L 12 6 L 10 6 L 10 15.5 C 10 16.869063 11.130937 18 12.5 18 C 13.869063 18 15 16.869063 15 15.5 L 15 5 C 15 2.8026661 13.197334 1 11 1 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"></path>
</svg>

								Upload Image</label>


								
		  						<input id="post_image" accept="image/*" onchange="send_image(this);" type="file" name="post_image" style="display: none;">
		  					</form>
							
						</button>

						<button onclick="format_star(this)" type="bold" id="js_format">
							<img src="images/bold.svg">
						</button>


						<button  onclick="add_more()" >
							<img src="images/add.svg">
						</button>

						<button id="send_story" data-set="null" class="post_toggle" data-type="0" onclick="Create_post(this)">

						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
	    <path d="M 6 3 A 2 2 0 0 0 4 5 L 4 11 A 2 2 0 0 0 5.3398438 12.884766 A 2 2 0 0 0 6 13 A 2 2 0 0 0 6.0214844 13 L 18 15 L 6.0214844 17.001953 A 2 2 0 0 0 6 17 A 2 2 0 0 0 5.3378906 17.115234 A 2 2 0 0 0 4 19 L 4 25 A 2 2 0 0 0 6 27 A 2 2 0 0 0 6.9921875 26.734375 L 6.9941406 26.734375 L 27.390625 15.921875 L 27.392578 15.917969 A 1 1 0 0 0 28 15 A 1 1 0 0 0 27.390625 14.078125 L 6.9941406 3.265625 A 2 2 0 0 0 6 3 z"></path>
	</svg>

						</button>

						<button id="update_story" data-set="null" class="post_toggle" data-type="0" onclick="Create_post(this)">Save</button>
					
					</div>

					<div id="input_area" onclick="clear_more" >

					<center>

					<div id="main_source">

					</div>
					
						<div id="insert_media">
						

						<form  method="POST" enctype="multipart/form-data">
							<label class="image_upload" id="add_media" for="post_image">Upload Image</label>
	  						<input id="post_image" accept="image/*" onchange="send_image(this);" type="file" name="post_image" style="display: none;">
	  					</form>


	  					<form method="POST" enctype="multipart/form-data">
							<label class="video_upload" id="add_media" onclick="add_more();" for="post_video">Embed video</label>
	  					</form>

						</div>
						
						<div id="uploaded_image">
							<div id="img_name_up"></div>
							<div onclick="un_upload_img()" id="delete_upload">&times</div>
						</div>

						<span id="write_ref_story"></span>

						<textBox  id="write_title" contenteditable="true" type="text" placeholder="Title" ></textBox>

						<textBox spellcheck="false" onfocus="get_cur(this)" id="write_text" contenteditable="true" type="text" placeholder="Write the story"></textBox>

						</center>

						</div>

				</div>

			

			
			<center>

	<a href="index.php" id="welcome">
		<img src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">

		<h1 id="welcome_login">nest</h1>
					
					</a>

			

			<div id="box_nav">

			<center>

				<a class="nav" type="home" onclick="pages_guider(this);" > '.$home_svg_p.' </a>

				<a class="nav"	data-set="1" type="notif" onclick="pages_guider(this);" > <div id="nav_inbox" class="notif"></div> 

				'.$chat_svg_p.' </a>	

				<a class="nav_write nav" type="write_page" onclick="pages_guider(this);" > 

					<img src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">

				</a>

				<a class="nav"  type="list" onclick="pages_guider(this);" >'.$user_svg_p.' <div id="nav_notif" class="notif" style="display: none;"></div></a>




				<a class="nav" data-set="null" type="q" onclick="pages_guider(this);" >'.$search_svg_p.'</a>		

			</center>

			</div>



			

			<div id="pannel_bottom">




			</div>



			</div> <div id="head_meta">'.$new_user_meta.'</div>

			</center>' ;




				$image_upbtn = '<label for="chat_setup_image"> <img src="images/add.svg">  </label>
	  						
							 <input id="chat_setup_image" accept="image/*" onchange="send_chat_img(this);" type="file" name="post_image" style="display: none;">';



			$refresh_svg =  '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" version="1.1">
<g id="surface1">
<path style=" " d="M 25 5 C 14.351563 5 5.632813 13.378906 5.054688 23.890625 C 5.007813 24.609375 5.347656 25.296875 5.949219 25.695313 C 6.550781 26.089844 7.320313 26.132813 7.960938 25.804688 C 8.601563 25.476563 9.019531 24.828125 9.046875 24.109375 C 9.511719 15.675781 16.441406 9 25 9 C 29.585938 9 33.699219 10.925781 36.609375 14 L 34 14 C 33.277344 13.988281 32.609375 14.367188 32.246094 14.992188 C 31.878906 15.613281 31.878906 16.386719 32.246094 17.007813 C 32.609375 17.632813 33.277344 18.011719 34 18 L 40.261719 18 C 40.488281 18.039063 40.71875 18.039063 40.949219 18 L 44 18 L 44 8 C 44.007813 7.460938 43.796875 6.941406 43.414063 6.558594 C 43.03125 6.175781 42.511719 5.964844 41.96875 5.972656 C 40.867188 5.988281 39.984375 6.894531 40 8 L 40 11.777344 C 36.332031 7.621094 30.964844 5 25 5 Z M 43.03125 23.972656 C 41.925781 23.925781 40.996094 24.785156 40.953125 25.890625 C 40.488281 34.324219 33.558594 41 25 41 C 20.414063 41 16.304688 39.074219 13.390625 36 L 16 36 C 16.722656 36.011719 17.390625 35.632813 17.753906 35.007813 C 18.121094 34.386719 18.121094 33.613281 17.753906 32.992188 C 17.390625 32.367188 16.722656 31.988281 16 32 L 9.71875 32 C 9.507813 31.96875 9.296875 31.96875 9.085938 32 L 6 32 L 6 42 C 5.988281 42.722656 6.367188 43.390625 6.992188 43.753906 C 7.613281 44.121094 8.386719 44.121094 9.007813 43.753906 C 9.632813 43.390625 10.011719 42.722656 10 42 L 10 38.222656 C 13.667969 42.378906 19.035156 45 25 45 C 35.648438 45 44.367188 36.621094 44.945313 26.109375 C 44.984375 25.570313 44.800781 25.039063 44.441406 24.636719 C 44.078125 24.234375 43.570313 23.996094 43.03125 23.972656 Z "></path>
</g>
</svg>';

		echo "




		<center> <div id='conversation_box' >

		

			<div id='conv_title'  >

			<button id='back_button' onclick='go_back()'><img src='images/back.svg'></button>

			<h1 id='data_conv' data-set='' type='story' onclick='pages_guider(this);' > </h1> 

			<button onclick='go_back()' >

			<svg viewBox='0 0 24 24' >
    <path d='M 4.9902344 3.9902344 A 1.0001 1.0001 0 0 0 4.2929688 5.7070312 L 10.585938 12 L 4.2929688 18.292969 A 1.0001 1.0001 0 1 0 5.7070312 19.707031 L 12 13.414062 L 18.292969 19.707031 A 1.0001 1.0001 0 1 0 19.707031 18.292969 L 13.414062 12 L 19.707031 5.7070312 A 1.0001 1.0001 0 0 0 18.980469 3.9902344 A 1.0001 1.0001 0 0 0 18.292969 4.2929688 L 12 10.585938 L 5.7070312 4.2929688 A 1.0001 1.0001 0 0 0 4.9902344 3.9902344 z'></path>
</svg>

			</button>

			<button id='chat_button_var' type='chat' onclick='pages_guider(this)' > ".$chat_svg." </button>

			<button id='writeback_button_var' type='write_back'  onclick='pages_guider(this)' > ".$write_svg."  </button>
			
			</div>

			<div id='box_chat'>

			<button data-set='' id='load_previous' onclick='query_pre_chat()' >


			
			<img alt='load more' id='loading_img' src='images/loading.svg'>

			</button>

			<h1  id='no_conversation'> Start Discussing</h1>

			<div id='chat_data'></div>

			<div id='chat_base'>

				<textarea type='text' data-id='' onkeyup='comment_fun(this,event)'  id='comment' placeholder='Your words...'></textarea>
			

				".$image_upbtn."
				

		
			</div>


			</div>

			<div id='box_words'>
		
			

			</div>

			
		</div> </center>";



  //  echo $_COOKIE['user_token']; <small>Freely share your little, big everyday stories without letting people know your name.</small>
}else{

	require_once 'redirect_fb.php';

	require_once 'redirect_gl.php';

	$Users_name = "";
	$Usr_pen_name = "";
	$prifile_link = "";
	$profile_image = "";


		$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl( $redirect_fb_link , $permissions);

	$authUrl = $gClient->createAuthUrl();
	$output = '<a class="login_link" id="login_with_google" href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'"><img src="https://www.google.com/favicon.ico" alt=""/>Login with Google</a> 


			<a class="login_link" id="login_with_facebook" href="' . htmlspecialchars($loginUrl) . '">

<svg class="svgIcon-use" width="25" height="25" viewBox="0 0 25 25"><path d="M20.292 4H4.709A.709.709 0 0 0 4 4.708v15.584c0 .391.317.708.709.708h8.323v-6.375h-2.125v-2.656h2.125V9.844c0-2.196 1.39-3.276 3.348-3.276.938 0 1.745.07 1.98.1v2.295h-1.358c-1.066 0-1.314.507-1.314 1.25v1.756h2.656l-.531 2.656h-2.125L15.73 21h4.562a.708.708 0 0 0 .708-.708V4.708A.708.708 0 0 0 20.292 4" fill-rule="evenodd"></path></svg>


			Login with facebook</a>

	';

	// echo '<img class="backlayer" src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">';




		echo ' 

		<div id="cover" onclick="go_back()"> </div> <div id="container"><div id="discribe">

		<div id="icon">
		<img src="https://s3.us-east-2.amazonaws.com/lluda-main/manual/fleeke.svg">
		</div>

		<div id="logo_typo" >
		nest
		</div>
		<br>
		<div id="discription_typo">
		A social way to be creative
		</div>

		</div> 
					<div id="signup_form">

					<center>

					<a type="form" onclick="pages_guider(this);"  id="login_with_username" class="login_link">Login</a>




					

					


					<div id="login_data_agree">By signing up you indicate that you have read and agree to the Terms of Service and Privacy Policy.</div>

					</center>

					</div></div>';


		echo '<div id="contain_form">


		 		<div id="extnal_login">
 	
 			'.$output .'



		</div>




 		<div id="login">

				<center>
				<h1>Login</h1>
				<form action="login.php" method="post">
		        <input type="text" name="email" placeholder="Email or Penname" maxlength="50"><br><br>
		        <input type="password" name="password" placeholder="Password" maxlength="15"><br><br><br>
		        <input class="signupButton" type="submit" name="submit" value="Login"><br><br><br>
		    </form>
			</center>
			
		</div>
 		

		<div id="signup">

				<center>
				<h1>Sign Up</h1>
				<form autocomplete="off" action="signup.php" method="post">

		        <input readonly="" onfocus="this.removeAttribute(\'readonly\');" type="text" name="fullname" placeholder="Full Name" maxlength="30">
            <br><br>
		        <input readonly="" onfocus="this.removeAttribute(\'readonly\');" type="text" name="email" placeholder="Email" maxlength="50"><br><br>

		        <input readonly="" onfocus="this.removeAttribute(\'readonly\');" type="password" name="password" placeholder="Password" maxlength="15">
            <br><br><br>
		        <input class="signupButton" type="submit" name="submit" value="Join nest">

		    </form>
			</center>
			
		</div>



	</div>';


}

	 ?>
	




<!-- <script src="http://cdn.jsdelivr.net/mojs/latest/mo.min.js"></script> -->

