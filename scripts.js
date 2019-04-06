
var safeColors = ['linear-gradient(15deg,rgb(70, 91, 124), rgb(188, 230, 195))','linear-gradient(15deg,rgb(245, 180, 134), rgb(204, 120, 113))','linear-gradient(15deg,rgb(124, 70, 70), rgb(230, 188, 188))','linear-gradient(15deg,rgb(103, 70, 124), rgb(230, 188, 219))']
var rand = function() {
    return Math.floor(Math.random()*4)
}
var randomColor = function() {

    var r = safeColors[rand()]

    return r
}



// var textarea = document.querySelector('#write_two_lines');

// textarea.addEventListener('keydown', autosize);
             
// function autosize(){
//   var el = this;
//   setTimeout(function(){
//     el.style.cssText = 'height:auto; padding:0';
//     // for box-sizing other than "content-box" use:
//     // el.style.cssText = '-moz-box-sizing:content-box';
//     el.style.cssText = 'height:' + el.scrollHeight + 'px';
//   },0);
// }

if ( _('write_two_lines') ) {

	var textarea = document.getElementById("write_two_lines");
	var heightLimit = 200; /* Maximum height: 200px */

	textarea.oninput = function() {
	  textarea.style.height = ""; /* Reset the height*/
	  textarea.style.height = Math.min(textarea.scrollHeight, heightLimit) + "px";
	};


}


// $(document).ready(function() {
   
//         $('#pinned_posts .post').each(function() {

//             $(this).css('background', randomColor() )

//         })
    
// })


document.onreadystatechange = function () {

	if(_('write_title') ){


document.querySelector('#write_text').addEventListener('paste', (e) => {
  console.log(e.target)
  window.setTimeout(() => {
    san_conedit()
  })
})

document.querySelector('#write_title').addEventListener('paste', (e) => {
  console.log(e.target)
  window.setTimeout(() => {
    san_conedit()
  })
})


	}



// 	$('iframe').load( function() {

// 		var cssLink = document.createElement("link")
// 		cssLink.href = "main.css" 
// 		cssLink.rel = "stylesheet" 
// 		cssLink.type = "text/css" 

//     this.appendChild(cssLink)

//     console.log( this.text() )

// })



}


	function _(id){
		return document.getElementById(id)
	}

var oDoc = document.getElementById("write_text")



function setEndOfContenteditable(contentEditableElement)
{
    var range,selection
    if(document.createRange)//Firefox, Chrome, Opera, Safari, IE 9+
    {
        range = document.createRange()//Create a range (a range is a like the selection but invisible)
        range.selectNodeContents(contentEditableElement)//Select the entire contents of the element with the range
        range.collapse(false)//collapse the range to the end point. false means collapse to end rather than the start
        selection = window.getSelection()//get the selection object (allows you to change selection)
        selection.removeAllRanges()//remove any selections already made
        selection.addRange(range)//make the range you have just created the visible selection
    }
    else if(document.selection)//IE 8 and lower
    { 
        range = document.body.createTextRange()//Create a range (a range is a like the selection but invisible)
        range.moveToElementText(contentEditableElement)//Select the entire contents of the element with the range
        range.collapse(false)//collapse the range to the end point. false means collapse to end rather than the start
        range.select()//Select the range (make it the visible selection
    }
}


	function get_link(box) {

	 	clear_more()

		// var sLnk = prompt('Write the URL here','http:\/\/')

		var sLnk = _('add_extra_input').value

		// console.log( box.getAttribute("type") )

		// if(sLnk&&sLnk!=''&&sLnk!='http://'){formatDoc('createlink',sLnk)

		if ( box.getAttribute("type") == 'insertImage') {

			oDoc.innerHTML = oDoc.innerHTML+"<img src='"+sLnk+"' >"

			
		}else{
			oDoc.innerHTML = oDoc.innerHTML+"<a href='"+sLnk+"' >"+sLnk+"</a>"
		}

		

			// oDoc.focus()



 setEndOfContenteditable(oDoc)

		// editor.composer.commands

		 // document.execCommand( box.getAttribute("type") , false, sLnk )

		 


	}







function san_conedit() {



	console.log("gogogo")

	var con = _('write_text').innerHTML
	var don = _('write_title').innerHTML

	_('write_text').innerHTML = con.replace(/style="[^"]*"/gi, "")
	_('write_title').innerHTML = don.replace(/style="[^"]*"/gi, "")

}




function format_star(box, sValue) {

	  	var attribute_type = box.getAttribute("type")

	  	console.log( attribute_type )

	    document.execCommand( attribute_type, false, sValue )

	    if(document.queryCommandState( attribute_type ) == false){

	    	   box.classList.remove( "down" )

	    }else{

	    	 box.classList.add( "down" )

	    }

	    oDoc.focus()

}



	function highlight_focus(box){
		box.style.borderBottom = "1px solid #555"

	}

	function likepost(box){

		// like function starts here


		var postid = $(box).closest('.post_container').attr('data-id')

		var likeq = box.querySelector(".post_likes")

		// var rect = box.getBoundingClientRect()
		// console.log(rect.top, rect.right, rect.bottom, rect.left)

		// var width = box.offsetWidth
		// var height = box.offsetHeight

		// var burst = new mojs.Burst({
  // 			left: rect.left+8 +width/2, top: rect.top+height/2,
  // 			//radius:       15,
  // 			radiusX:      65,
  // 			angle:    0,
  // 			count: 12,
		// 	  children: {
		// 	    shape:        'circle',
		// 	   // radius:       10,
		// 	   // scale:        1,
		// 	    fill:       '#ffdc40',
		// 	    //strokeDasharray: '100%',
		// 	   // strokeDashoffset: { '-100%' : '100%' },
		// 	    duration:     600,
		// 	   // easing:       'quad.out',
		// 	  }
		// 	})

		qu_lik = likeq.innerHTML

		
		

    		if( box.id == "elevate_buttton" ){
  				box.id = "elevated_buttton"
  				likeq.innerHTML = Number(qu_lik) + 1 
  				// burst.replay()
    		}else{
    			box.id = "elevate_buttton"
    			likeq.innerHTML = Number(qu_lik) - 1 
    		}

						var hr = new XMLHttpRequest()
					    // Create some variables we need to send to our PHP file
					    var url = "script_bundle.php"
					    var vars = "likeid="+postid
					    hr.open("POST", url, true)
					    // Set content type header information for sending url encoded variables in the request
					    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					    // Access the onreadystatechange event for the XMLHttpRequest object
					    hr.onreadystatechange = function() {
						    if(hr.readyState == 4 && hr.status == 200) {
							    var return_data = hr.responseText

							    if (return_data == "done") {

							    	    if( box.id == "elevated_buttton" ){
							  			//	box.id = "elevated_buttton"
							  			//	likeq.innerHTML = Number(qu_lik) + 1 
							    		}else{
							    		//	box.id = "elevate_buttton"
							    		//	likeq.innerHTML = Number(qu_lik) - 1 
							    		}
							    
							    }else{
							    		console.log(return_data)
							    		// if user is not logged in or an error

							    	    if( box.id == "elevate_buttton" ){
							  				box.id = "elevated_buttton"
							  				likeq.innerHTML = Number(qu_lik)

							  				// qu_lik is a fixed varivble which doesn's refreshes so you just need to initialize the actual value of qu_link 

							    		}else{
							    			box.id = "elevate_buttton"
							    			likeq.innerHTML = Number(qu_lik)
							    		}
							    }
								
						    }
					    }
					    // Send the data to PHP now... and wait for response to update the status div
					    hr.send(vars) // Actually execute the request
					  //  document.getElementById("status").innerHTML = "Logging In..."

	}

	function follow(ids,box){

		// like function starts here
		var folow_inden = box.id

    		if( folow_inden.toLowerCase() == "follow" ){
  				box.id = "following"
  				box.innerHTML = "Following"

    		}else{
    			box.id = "follow"
    			box.innerHTML = "Follow"
    		}

						var hr = new XMLHttpRequest()
					    // Create some variables we need to send to our PHP file
					    var url = "script_bundle.php"
					    var vars = "followid="+ids
					    hr.open("POST", url, true)
					    // Set content type header information for sending url encoded variables in the request
					    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					    // Access the onreadystatechange event for the XMLHttpRequest object
					    hr.onreadystatechange = function() {
						    if(hr.readyState == 4 && hr.status == 200) {
							    var return_data = hr.responseText

							    if (return_data == "done") {

							    	   // if( box.id == "elevated_buttton" ){
							  			//	box.id = "elevated_buttton"
							  			//	likeq.innerHTML = Number(qu_lik) + 1 
							    		//}else{
							    		//	box.id = "elevate_buttton"
							    		//	likeq.innerHTML = Number(qu_lik) - 1 
							    		//}
							    
							    }else{
							    		console.log(return_data)

							    		folow_inden = box.id
							    		// if user is not logged in or an error

							    	    if( folow_inden.toLowerCase() == "follow" ){
							  				box.id = "Following"
						

							  				// qu_lik is a fixed varivble which doesn's refreshes so you just need to initialize the actual value of qu_link 

							    		}else{
							    			box.id = "Follow"
							    
							    		}
							    }
								
						    }
					    }
					    // Send the data to PHP now... and wait for response to update the status div
					    hr.send(vars) // Actually execute the request
					  //  document.getElementById("status").innerHTML = "Logging In..."



	}


    // $('#home_pop').on('scroll', function () {
    //     alert('scrolling')
    // })



	function arrange_boxes() {
		// var post_boxes = document.getElementsByClassName('post')

		// var offset_arr = 0

		// for (var i = 1 i <= post_boxes.length i++) {

		// 	if(i%3 !== 0){

		// 		if (offset_arr == 0) {
				
		// 			var img_inbox = post_boxes[i].getElementsByClassName("post_image")
		// 			// change layout

		// 			post_boxes[i].style.width = '62%'
		// 			post_boxes[i].style.height = '11.5vw'
		// 			post_boxes[i].style.display = 'block'
		// 			post_boxes[i].style.float = 'left'

		// 			img_inbox[0].style.width = '38%'
		// 			img_inbox[0].style.marginBottom = '0'
		// 			img_inbox[0].style.float = 'left'
		// 			img_inbox[0].style.marginRight = '1vw'

		// 		}


		// 	}else{

		// 		if (offset_arr == 0) {
		// 			offset_arr = 1
		// 		}else{
		// 			offset_arr = 0
		// 		}

		// 	}
			
		// }
	}

 var $container



							    	


	var offset_mul = -1

	function get_notif(search) {


	    $.get("script_bundle.php?notif_limit="+search, function(data){


	    	if (data != '') {
	    		console.log(data)

	    		_('mentions_notif').innerHTML = ' Discussions '
	    		_('Notifications_notif').innerHTML = ' Notification'

		  	var chat_data = JSON.parse(data)

							    	for (var key in chat_data) {

							    		var value = chat_data[key]

							    		// console.log(value,key)



							    		if (key == 'message' && value != '') {

							    			_('mentions_notif').innerHTML = value+' Discussions '

							    			_('nav_inbox').style.display = "block"
							    			_('nav_inbox').innerHTML = value

							    			// console.log(value,key,'m')

							    		}else if(key == 'message' && value == ''){
							    			_('nav_inbox').style.display = "none"
							    		}

							    		if (key == 'notifications' && value != '') {

							    			_('Notifications_notif').innerHTML = value+' Notification'
							    			
							    		}

							    			if ( _('nav_notif') ) {

									    if (key == 'notifications' && value != '') {

									 
									    			
									    			_('nav_notif').innerHTML = value
									    			_('nav_notif').style.display = "block"

									    			
									    		}else if(key == 'notifications' && value == ''){

									    			_('nav_notif').style.display = "none"
									    		}


							    		}





							    	}


	    	}

		// _('auto_mesage').innerHTML =  data

		

		})

	}



		function get_trending(data) {

			// $.get("script_bundle.php?trending_sr="+data, function(return_data){	


			// 		if ( _('nav_notif') ) {

			// 			_('hash_tag').innerHTML  = return_data
						
			// 		}

			// })

			// hash tag on hame page
		}






		function on_searchbar(box,enterkey) {

			// console.log(box.value)
			

			if (enterkey.keyCode == '13' && box.value != '' ) {

				_('post_sr').innerHTML = '<img alt="load more" id="loading_img" src="images/loading.svg">'

				history.pushState({state:1}, "State 1", "?q="+ box.value )

				to_search( box.value )

				// get_search(box.value)
			}

		}


		var feed_type = 'main'


		function get_feedtype(){


			  	$('#feed_pannel button').each( function() {
				    $(this).attr('data-state', 'false' );
				})

    			if ( localStorage.getItem("feed_type") == null ) {
    				feed_type = 'main'
    			}else{
    				feed_type = localStorage.getItem("feed_type")
    			}
  

    			$( "#"+feed_type+"_button"  ).attr( 'data-state' , 'true' )

    			console.log(feed_type);

		}

	function download_content(type){

    			// get_notif(15)

    		

    			if (offset_mul == -1) {

    			// $.get("script_bundle.php?featured_length="+4, function(data){
    			//    	_('featured_tag').innerHTML = data;
    			//    })
    		
    				
    			}


  



				if( _('load_more').getAttribute('phase') == 'loading' || !_("load_more") || _("load_more").innerHTML == "You have seen everything!" ){

					console.log(offset_mul,'NotLoading')

				}else{

				//check if ajax request is working

					
						_('load_more').setAttribute('phase','loading')

						offset_mul += 1

						console.log(offset_mul,'Loading....')

						// _("load_more").innerHTML = "<center><img id='loading_img' src='images/loading.svg'></center>"

				        $.get("script_bundle.php?content_offset="+offset_mul+"&content_type="+feed_type, function(data){

				        	_('load_more').setAttribute('phase','Loaded')

							    if(data == ''){

							    	console.log(offset_mul,'no data')

							    	offset_mul = -1
							    	download_content()

							    	console.log(offset_mul,'reset feed data')
							    	// _("load_more").innerHTML = "You have seen everything!"

							    }else{

							    	var url = new URL( window.location.href )
							    	var st = url.searchParams.get("story")

							    	

							    	if (st) {

							    		$( "#posts_story" ).append( data )
							    		// console.log(st)

							    	}else{

							    		$( "#posts" ).append( data )
							    	}

							    	

							    	_("load_more").innerHTML = "<center><img alt='load more' id='loading_img' src='images/loading.svg'></center>"
									  
								}


								arrange_stories()

				        })


					  	


					  }
					  

				 
	}



	function isScrolledIntoView(elem){
	    var $elem = $(elem)
	    var $window = $(window)

	    var docViewTop = $window.scrollTop()
	    var docViewBottom = docViewTop + $window.height()

	    var elemTop = $elem.offset().top
	    var elemBottom = elemTop + $elem.height()

	    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop))
	}

	var home_pod = _('home_pop')
	var page_pod = _('story_pop')
	var user_pod = _('user_pop')
	var search_pod = _('search_pop')

	function playnpause(){

			 	$('video').each(function(){

			console.log('video')

		    if ($(this).is(":in-viewport")) {
		        $(this)[0].play()
		    } else {
		        $(this)[0].pause()
		    }

		    
		})


		$('iframe').each(function(){

			



		   if( isScrolledIntoView($(this))  && $(this).is(":visible") == true ){

		   		console.log('play frame')

		   		// if ( ) {

		   			// var player = $f($(this))

  					// player.api("pause")

		   			$(this)[0].contentWindow.postMessage('{"event":"command","func":"' + 'playVideo' + '","args":""}', '*')

		   		// }

		   		

		    }else {

		    		// var player = $f($(this))

  					// player.api("pause")

		    	console.log('pause frame')

		        $(this)[0].contentWindow.postMessage('{"event":"command","func":"' + 'pauseVideo' + '","args":""}', '*')

		    }

		    
		})

	}

	 function check_scroll () {





	 	playnpause()

	
		// console.log(home_pod.scrollTop ,( (home_pod.scrollHeight - home_pod.offsetHeight)*60/100 ) ) 


		if( home_pod.scrollTop  > ( (home_pod.scrollHeight - home_pod.offsetHeight)*80/100) ||  page_pod.scrollTop  > ( (page_pod.scrollHeight - page_pod.offsetHeight)*80/100)) {

			download_content()
			
	 	}


}


function check__chat_scroll(){



	if ( _('chat_data').scrollTop < ( (_('chat_data').scrollHeight - _('chat_data').offsetHeight)*10/100) ) {
		query_pre_chat()
	}else{
		console.log( _('chat_data').scrollTop )
	}

}


	home_pod.onscroll = function (){
		check_scroll()
	}

	user_pod.onscroll = function (){
		check_scroll()
	}

	search_pod.onscroll = function (){
		check_scroll()
	}


	if (	_('chat_data') ) {

	

	_('chat_data').onscroll = function (){
		check__chat_scroll()
	}

}


	page_pod.onscroll = function (){
		check_scroll()
	}






		function to_search(data){

				clear_story()

				if (data != 'null') {

					_('search_pop_box').value = data.replace(/_/g, " ")
					
				}

				set_size( _('search_pop') )

				_('search_pop_box').focus()

				get_search(data)
				
		}


		function get_search(data) {

			_('post_sr').innerHTML  = '<img alt="load more" id="loading_img" src="images/loading.svg">'

			$.get("script_bundle.php?search_sr="+data, function(return_data){

				// _('search_pop').style.display = "block"

				// set_size( _('search_pop') )
				
				_('post_sr').innerHTML  = return_data

			})
		}



				function get_trend_home() {

				_('set_feed_type').style.display = "none"

				$.get("script_bundle.php?trending_sr=null", function(return_data){

					// _('search_pop').style.display = "block"

					// set_size( _('search_pop') )

					_('set_feed_type').style.display = "block"
					
					_('top_pannel').innerHTML  = return_data

				})
		}


	function display_options(type){


		send_notice('<center><a type="setup" onclick="pages_guider(this)" >Setup</a>	<a  href="signout.php">Log out</a><a  data-id="feedback" type="chat" onclick="pages_guider(this)" >Feedback</a></center>',type)

		// _("pannel_bottom").style.display = "block"

	}

	function destroy_notice(){
		go_back()
		destroy_error()
	}



	function to_home() {

		clear_story()


	  	get_trending(null)
  		download_content()

  		set_size( _('home_pop') )

  		// .style.display = "block"

	}

	function to_setup() {

		clear_story()

  		_('setup_pop').style.display = "block"
  		set_size( _('setup_pop') )

  		_('setup_pop').innerHTML  = '<img alt="load more" id="loading_img" src="images/loading.svg">'
  		
  				$.get("script_bundle.php?setup=true", function(data){
					_('setup_pop').innerHTML =  data
			
				})


	}

	function clean_notice(){
		_('success').style.display = 'none';
		_('cover_notice').style.display = 'none';
	}


	function to_list(btn_type) {

		if (mobile_true() == 'true') {
			clear_story()
		}else{
			clean_notice()
		}

		_('list_pop').style.display = "block"
		_('cover').style.display = "block"

		show_notification()

	}

	function to_notif(btn_type) {

		// _('conversation_box').style.display = "none"

		if (mobile_true() == 'true') {
			clear_story()
		}else{
			clean_notice()
		}
		

				_('msg_form').style['display'] = 'none'
				_('notif_form').style['display'] = 'none'

		if (btn_type == 2) {
			_('notif_form').style['display'] = 'block'
			$('#notif_form').prepend( '<img alt="load more" id="loading_img" src="images/loading.svg">' )

		}else{
			_('msg_form').style['display'] = 'block'
			$('#msg_form').prepend( '<img alt="load more" id="loading_img" src="images/loading.svg">' )

		}
							    	

		

							   

		
		// make_cover()

		_('notif_pop').style.display = "block"
		_('cover').style.display = "block"

		set_size( _('notif_pop') )

			if(btn_type == 2){

				_('Notifications_notif').style.background = "#fff"
				_('Notifications_notif').style.color = "#000"

				_('mentions_notif').style.backgroundColor = "transparent"
				_('mentions_notif').style.color = "#fff"

			}else{


				_('Notifications_notif').style.background = "transparent"
				_('Notifications_notif').style.color = "#fff"

				_('mentions_notif').style.backgroundColor = "#fff"
				_('mentions_notif').style.color = "#000"

			}

			$.get("script_bundle.php?notification_type="+btn_type, function(data){



				if (btn_type == 2) {

					
					_('notif_form').innerHTML =  data
					

				}else{

					_('msg_form').innerHTML =  data
				}

			

		})



	}


	function go_back() {

		window.history.back()

		console.log('ok')
	}


	window.onpopstate = function() {

		  start_op()


	}		

	function pages_guider(box) {

		var btn_type = box.getAttribute("type")

 		if (btn_type == 'write_page' || btn_type == 'write_message' || btn_type == 'write_story') {


			history.pushState({state:1}, "State 1", "?write="+btn_type)


		}else if (btn_type == 'chat' || btn_type == 'write_back') {

		
			if (box.hasAttribute("data-id") == true) {
			   var data_var = box.getAttribute("data-id")
			}else{
				var data_var = $(box).closest('.post_container').attr('data-id')
			}


			history.pushState({state:1}, "State 1", "?"+btn_type+"="+data_var)


		}else if (btn_type == 'options') {

			display_options('clickable')

		}else{

			var data_var = box.getAttribute("data-set")

			if (!data_var || data_var== '') {
				data_var = 'true'
			}

			if (box.hasAttribute("data-type") == true) {
				data_var += '&type='+box.getAttribute("data-type")

				channel_parentstory = $(box).closest('.post_container')
			}

			history.pushState({state:1}, "State 1", "?"+btn_type+"="+data_var )

		}

		start_op()
		
	}

	function copy_to_clip(str){

	  var el = document.createElement('textarea')
	  el.value = str
	  document.body.appendChild(el)
	  el.select()
	  document.execCommand('copy')
	  document.body.removeChild(el)

	}





	function to_write(data,data2) {


		clear_story()

		var url = new URL( window.location.href )

		var refer = url.searchParams.get("refer")


		if (refer) {

			// _('write_ref_story').innerHTML = 'Loading...'
			// _('write_ref_lines').innerHTML = 'Loading...';
			_('write_ref_story').style['display'] = 'none'

			$.get("script_bundle.php?story="+refer+"&story_t="+data, function(return_data){

				 if (data == 'write_message') {

					_('write_ref_lines').innerHTML = return_data;

				}else if (data == 'write_story') {

					

					_('write_ref_story').innerHTML = "Question: "+return_data;
				
					_('write_ref_story').style['display'] = 'block'
				}


			})

		}else{
			_('write_ref_story').style['display'] = 'none'
		}

		if (data == 'write_page') {

			write_something()
		

		}else if (data == 'write_message') {

			console.log( data2 )

			write_short(data2)

			_('write_ref_lines').innerHTML = '';
		

		}else if (data == 'write_story') {

			write_story()

			_('write_ref_story').innerHTML = '';
		

		}

	
	}

	function to_story(btn_type) {

		clear_story()
		_('story_pop').style.display = "block"

		set_size( _('story_pop') )
		download_content()

	}


			function get_story(data_var) {

				

				if( $('#story_box .post_container').attr('data-id') != data_var ){

					console.log( $('#story_box .post_container').attr('data-id') , data_var)
		
						_('story_box').innerHTML  = '<img alt="load more" id="loading_img" src="images/loading.svg">'

						$.get("script_bundle.php?story="+data_var+"&story_t=none", function(data){

							_('story_box').innerHTML =  data

						})

					}

		}


	function start_op() {

		
		get_trend_home()


		var url = new URL( window.location.href )

		var c = url.searchParams.get("q")
		var nf = url.searchParams.get("notif")
		var ls = url.searchParams.get("list")
		var wr = url.searchParams.get("write")
		var wb = url.searchParams.get("write_back")
		var ch = url.searchParams.get("chat")
		var st = url.searchParams.get("story")
		var fr = url.searchParams.get("form")
		var pf = url.searchParams.get("user")
		var op = url.searchParams.get("options")
		var setup = url.searchParams.get("setup")
		var msg = url.searchParams.get("msg")
		var share = url.searchParams.get("share")
		var feed_opt = url.searchParams.get("feed_opt")
		var series_pannel = url.searchParams.get("series-pannel")

		if (msg) {
			send_notice(msg,'nohistory')
		}

		if(op){

			display_options('nohistory')

		}else if (c) {

			to_search(c)

		}else if(nf){

			to_notif(nf)

		}else if(ls){

			to_list(ls)

		}else if(wr){

			to_write(wr)

		}else if(wb){

			to_response(wb,'write_back')

		}else if(ch){

			to_response(ch,'chat')

		}else if(st){

			to_story(st)

			get_story(st)
						

		}else if(fr && _('contain_form') ){

			to_form()

		}else if(setup){

			to_setup()



		}else if(pf){

			to_profile(pf)



			
				
				get_profile(pf)
			

		}else if(share){
			to_share()
		}else if(feed_opt){
			to_feedopt()
		}else if(series_pannel){
			to_series_pannel(series_pannel, url.searchParams.get("type") )
		}else{
			to_home()
		}


	}

	


	function expand_image(box){

		// box.style['width'] = '100%'


		box.setAttribute('class','expanded')
		box.setAttribute('onclick','')
		history.pushState( {state:1}, "State 1", "?story="+box.querySelector("h4").getAttribute('data-set') )

	// 	if ( mobile_true() == 'true') {

	// 	box.querySelector("img").style['width'] = '90%'
	// }else{

	// 	box.querySelector("img").style['width'] = '62%'
	// 	}

		
	// 	box.querySelector("button").style['display'] = 'block'
	// 	// box.scrollIntoView();
	}


	function to_series_pannel(storyid,type){
		_('success').style['display'] = 'block'
		_('cover_notice').style.display = 'block'

		if (type === 'image') {
			_('success').innerHTML  = '<img id="series_img" src='+storyid+'><img id="series_img_cover" src='+storyid+'>'
		}else{
			_('success').innerHTML  = '<img id="series_img_cover" src='+user_cover+'>'
		}

	_('success').innerHTML += '<div id="series_pannel"> <input autocomplete="off" id="create_series_input" type="text" placeholder="Create new Album"><button data-set="null" onclick="add_to_series(this)" >+</button> <div id="create_list"></div> </div>'

				_('create_list').innerHTML = '<h3> Loading.. </h3>'

				$.get("script_bundle.php?series_list="+storyid, function(data){

				
						_('create_list').innerHTML = data
				


				})

	}





	function add_to_series(box){
		
		var url = new URL( window.location.href )
		var series_pannel = url.searchParams.get("series-pannel")
		var series_type = url.searchParams.get("type");

		

		if ( _('create_series_input').value.trim() != '' ) {

			var create_se = _('create_series_input').value;

		}else{
			var create_se = 'null';
		}

			_('success').innerHTML = 'Adding...'
			
			var line_say = "script_bundle.php?addto_series="+box.getAttribute("data-set")+"&storyid_series="+series_pannel+'&type_series='+series_type+'&create_series='+create_se
			console.log(line_say);

			$.get(line_say, function(data){

					
				_('success').innerHTML = data
				


			})

	}

	function switch_feed(box){

		$('#feed_pannel button').each( function() {

            $(this).attr('data-state', 'false' );

        })



        box.setAttribute('data-state','true');

        _('posts').innerHTML = '';

        offset_mul = -1;



        localStorage.setItem( "feed_type" , box.getAttribute('data-type') )

       

        download_content()

	}


	function show_notification(){

		// if (	_('notification_section').style.display == 'none' ) {

		// 	_('profile_section').style.display = 'none'
		// 	_('notification_section').style.display = 'block'

		_('notification_section').innerHTML = '<img alt="load more" id="loading_img" src="images/loading.svg">';

			$.get("script_bundle.php?notification_type=2", function(data){

					_('notification_section').innerHTML =  data

		})


		// }else{
		// 	_('notification_section').style.display = 'none'
		// 	_('profile_section').style.display = 'block'			
		// }

	}



	function to_share(){

		var url = new URL( window.location.href )

		url_data = url.searchParams.get('share')


		_('success').innerHTML = "<button  onclick='copy_embedlink( \""+url_data+"\" )'> Embed</button> <a href='https://www.facebook.com/sharer/sharer.php?u=http://fleeke.com/?story="+url_data+"' target='_blank'>Share on Facebook</a> <a target='_blank' href='https://twitter.com/intent/tweet?text=http://fleeke.com/?story="+url_data+"'> Share on twitter </a> <a data-set='"+url_data+"' type='story' onclick='pages_guider(this)' > Go to page</a>"
		

		if (url.searchParams.get('type') == 'true') {
			_('success').innerHTML += "<button  onclick='edit_story(this)'>Edit</button> <button  onclick='delete_story(this)'>Delete</button>"
		}else{
			_('success').innerHTML += "<button  onclick='report_story(this)'>Report</button>"
		}

		_('success').style['display'] = 'block'
		_('cover_notice').style.display = 'block'



	}

	function to_feedopt(){

		_('success').innerHTML = '<div id="feed_pannel"> <button id="main_button" data-type="main" data-state="true" onclick="switch_feed(this)">All</button><button id="story_button" data-type="story" onclick="switch_feed(this)">Stories</button><button id="chat_button" data-type="chat" onclick="switch_feed(this)">Discussion</button><button id="photo_button" data-type="photo" onclick="switch_feed(this)">Experiences</button></a></div>'
		
		_('success').style['display'] = 'block'
		_('cover_notice').style.display = 'block'

		get_feedtype();
	}

	function get_follow(type,user){




				$('#stuff_list center').html('<center><img alt="load more" id="loading_img" src="images/loading.svg"></center>')

				$.get("script_bundle.php?follow_list="+type+"&user_on="+user, function(data){

						$('#stuff_list center').html(data)


				})

	}

	function delete_me(box){
		// box.style['display'] = 'none'
		box.parentNode.removeChild(box)
	}

	function arrange_stories(){

		console.log( 'changing background' )

		$('#posts .post_container').each( function() {

			console.log( $(this).css('height') )

            // $(this).css('background', randomColor() )

        })



	}

	var updated_profile = ''


	function get_profile(pf){

		if(  _('user_pop').getAttribute('data-set') != pf ){

			_('user_pop').innerHTML  = '<img alt="load more" id="loading_img" src="images/loading.svg">'

			updated_profile = ''

		}else{

			if( updated_profile != '' ) {

				_('user_pop').innerHTML = updated_profile

			}

		}


		// update profile later


				$.get("script_bundle.php?user="+pf, function(data){

				
					if(  _('user_pop').getAttribute('data-set') == pf ){

						updated_profile = data

					}else{

						_('user_pop').innerHTML =  data

						_('user_pop').setAttribute('data-set',pf)

					}




				})





	}


	function to_profile(data){

		clear_story()
		_('user_pop').style.display = "block"
		set_size( _('user_pop') )
	}



	function read_more(box) {

		arrange_boxes()

		box.setAttribute('onclick','')

		var data =  box.getAttribute("data-id") 
		var box_type =  box.getAttribute("type") 

		if (box_type == 'series') {

			_('story_box').innerHTML = "<div class='post_container series' data-id="+data+" > "+box.innerHTML+"</div>"
			box.style.display = 'none'

			history.pushState({state:1}, "State 1", "?story="+data )
			start_op();

		}else{
		    

		var content_image =  box.querySelector(".post_image")

		if ( content_image && content_image.getAttribute('data-type') == 'video') {

			box.querySelector("#post_title").style['display'] = 'none'
			box.querySelector("#image_con").style['display'] = 'none'
			box.querySelector("#video_con").style['display'] = 'block'
			// content_image.querySelector(".img").style['width'] = '100vw'
			// box.querySelector("#video_con").playVideo()
			
			// content_image.innerHTML = "<iframe src='"+getId ( content_image.getAttribute('data-set') ) +"?&autoplay=1' >"
			playnpause()
		}

		



	

		// var read_more_b = box.querySelector("#see_more")
		// read_more_b.style.display = 'none'

		var post_text_box = box.querySelector(".text")

		// if (post_text_box) {

		var response_box =  box.querySelector("#post_bottom")

		post_text_box.style['max-height'] = '700vw'

		var post_main_box = box.querySelector("#main_post")
		post_main_box.style['max-height'] = '700vw'


		post_text_box.innerHTML += "<br><b id='loading_text'>Loading...</b>"

		var post_content_box =  box.querySelector("#post_content")
		post_content_box.style["cursor"] = "unset"

		response_box.style["display"] = "block"



		var post_media_box = box.querySelector("#media_section")


		// story_parts

		var pa_article = $(box).closest('article')

		console.log( pa_article[0] );


		 box.style['cursor'] = "unset"



    					var hr = new XMLHttpRequest()

					    var url = "script_bundle.php"
					    var vars = "read_id="+data
					    hr.open("POST", url, true)

					    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")


					    var selected_box = $(box).closest('.post_container')
					
					    _('story_box').innerHTML = "<div class='post_container post' data-id="+data+" > "+selected_box.html()+"</div>"
					    selected_box.css('display','none')

					    history.pushState({state:1}, "State 1", "?story="+data )
						start_op();

					    hr.onreadystatechange = function() {
						    if(hr.readyState == 4 && hr.status == 200) {
							    var return_data = hr.responseText


							    	post_text_box.innerHTML = return_data

									_('story_box').querySelector(".text").innerHTML = return_data
									

		
											   			
						    }
					    }

					    hr.send(vars)

					}

					   

	}


	function make_cover() {

		clear_story()

		_('cover').style.display = "block"

	}

	var last_post_id = 0
	var chat_check



	function get_post_comment(data){
		console.log("Lets gogogo",data)
	}



Object.size = function(obj) {
    var size = 0, key
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++
    }
    return size
}


	function query_chat(data) {

			$.get("script_bundle.php?comment-no="+data+"&last_post="+last_post_id, function(return_data){

								console.log(data+" "+last_post_id+" "+return_data)

	


							    if(return_data == ''){



							    }else{


							 

							    	
							    	var chat_data = JSON.parse(return_data)

							    	for ( var key in chat_data ) {

							    			var valueid = key

							    			console.log(valueid)

							    			var against_p = _('chat_button_var').getAttribute('data-id')

							    				for ( var key in chat_data[key] ) {

							    					var value = chat_data[valueid][key]['value']


							    					if( key == 'lastpost' && Number(value) == 0 && against_p == valueid ){

							    						_('load_previous').style['display'] = 'none'
							    						console.log( Object.keys(chat_data[valueid]).length ,'display', Number(value),return_data)

							    						if (Object.keys(chat_data[valueid]).length <= 1) {

							    							_('no_conversation').style['display'] = 'block'

							    						}else{

							    							_('no_conversation').style['display'] = 'none'

							    						}



							    					}else{

							    						_('no_conversation').style['display'] = 'none'


										    			if(value != '' && Number(key) > last_post_id && against_p == valueid){


										    				var chat_type = chat_data[valueid][key]['user']

							    							console.log( value , chat_data[valueid][key]['user'] )


										    				var value_content = "<div data-id='"+key+"' class='comment_parent' > <div id='"+chat_type+"'> "+value+"</div></div>"

										    			

										    						$("#chat_data").append(value_content)
											    					last_post_id = Number(key)

										    				_('chat_data').scrollTop = _('chat_data').scrollHeight


											    			
											    		}else{
											    			// console.log(against_p+" "+valueid+" "+last_post_id+' '+value)
											    		}

										    		}
							    				}

								    		

								    		



									    
									}

							    	
							    }




							     

			})


	}



		function query_pre_chat() {

			_('load_previous').style['display'] = 'block'

			var current_start = $( ".comment_parent" ).first().attr('data-id')
			console.log(current_start, _('load_previous').getAttribute('status') )

			if ( _('load_previous').getAttribute('status') != 'loading' ) {

			_('load_previous').setAttribute('status','loading')

			$.get("script_bundle.php?comment-no="+_('chat_button_var').getAttribute('data-id')+"&start_post="+current_start, function(return_data){

					_('load_previous').style['display'] = 'none'
					_('load_previous').setAttribute('status','Loaded')

					console.log(return_data,'return')

							    if( Number(return_data.length) <= 1 ){

							    	_('load_previous').style['display'] = 'none'

							    }else{

							    	var chat_data = JSON.parse(return_data)

							    	for ( var key in chat_data ) {

							    			var valueid = key

							    			var pre_data = ''

							    				for ( var key in chat_data[key] ) {


							    					var value = chat_data[valueid][key]['value']





							    					var against_p = _('chat_button_var').getAttribute('data-id')

									    			if(value != '' && Number(key) < current_start && against_p == valueid){


									    			var chat_type = chat_data[valueid][key]['user']

							    					console.log( value , chat_data[valueid][key]['user'] )

									    				// _('chat_data').innerHTML = value+_('chat_data').innerHTML

									    				// var btn = document.createElement("DIV")

									    			var value_content = "<div data-id='"+key+"' class='comment_parent' > <div id='"+chat_type+"'> "+value+"</div></div>"
									    				// btn.appendChild(value)

									    				pre_data += value_content
										    			
										    			
										    		}else{
										    			// console.log(against_p+" "+valueid+" "+last_post_id+' '+value)
										    		}


							    				}

								    		
							    				$("#chat_data").prepend(pre_data)
								    		



									    
									}

							    	
							    }




							     

			})

		}


	}

	function get_post_comments(data){
		
	

			// console.log(last_post_id,'O')


			clearInterval(chat_check)
		

				// last_post_id = 0
				_('no_conversation').style['display'] = 'none'
				_('load_previous').style['display'] = 'block'
				_('chat_data').innerHTML = ''

			chat_check = setInterval( function(){

				// console.log(data)
				query_chat(data)

			} , 3000 )



		
	}

	function get_post_ref(ref_id){

		_('box_words').innerHTML = "<center><h4><img alt='load more' id='loading_img' src='images/loading.svg'></h4></center>"

			$.get("script_bundle.php?reference="+ref_id, function(data){

					if(data == ''){
						
						_("box_words").innerHTML = "<h4>Nothing!</h4>"

					}else{

						_('box_words').innerHTML = data
						
									  
					}

			})

	}


	var data_postid = ""


	function mobile_true(){
		var windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth

		if (windowWidth < 500) {
			return 'true'
		}else{
			return 'false'
		}
	}


	function to_response(uni_story,btn_type){


		data_postid = uni_story

		// make_cover()
		clear_story()
		// body...

		_('chat_button_var').setAttribute("data-id", data_postid)

		_('writeback_button_var').setAttribute("data-id", data_postid)
		_('data_conv').setAttribute("data-set", data_postid)

		_('conversation_box').style.display = "block"

		

		if(btn_type == "chat"){

			_('chat_button_var').style.background = "#fff"
			_('writeback_button_var').style.background = "whitesmoke"


			get_post_comments(data_postid)
			get_post_ref(data_postid)


			if (mobile_true() == 'true') {

				_('box_chat').style.display = "block"
				_('box_words').style.display = "none"

			}else{

				_('box_words').style.display = "block"
				_('box_chat').style.display = "block"

			}

		}else{

			_('chat_button_var').style.background = "whitesmoke"
			_('writeback_button_var').style.background = "#fff"
			

			get_post_comments(data_postid)
			get_post_ref(data_postid)

			if (mobile_true() == 'true') {

				_('box_chat').style.display = "none"
				_('box_words').style.display = "block"

			}else{
				_('box_words').style.display = "block"
				_('box_chat').style.display = "block"
			}
		
		}
		

		_('data_conv').innerHTML = "Loading.."

		$.get("script_bundle.php?reference_chat="+data_postid, function(data){

			_('data_conv').innerHTML =  data

			console.log(data)

		})


	}

	// function comment_open(box) {

			

	// 	data_postid = box.getAttribute("data-id") 


	// 	_('chat_button_var').setAttribute("data-id", data_postid)

	// 	_('writeback_button_var').setAttribute("data-id", data_postid)

	// 	var btn_type = box.getAttribute("data-type") 

	// 	_('conversation_box').style.display = "block"

	// 	if(btn_type == "chat"){

	// 		_('chat_button_var').style.background = "whitesmoke"
	// 		_('writeback_button_var').style.background = "#fff"

	// 		last_post_id = 0

	// 		_('chat_data').innerHTML = ""

	// 		get_post_comments(data_postid)



	// 		_('box_chat').style.display = "block"
	// 		_('box_words').style.display = "none"
	// 	}else{

	// 		_('chat_button_var').style.background = "#fff"
	// 		_('writeback_button_var').style.background = "whitesmoke"

	// 		get_post_ref(data_postid)

	// 		_('box_chat').style.display = "none"
	// 		_('box_words').style.display = "block"
	// 	}
		



	// 	_('data_conv').innerHTML = "Loading.."


	// 	$.get("script_bundle.php?reference_chat="+data_postid, function(data){

	// 		_('data_conv').innerHTML =  data


	// 							    // 	for (var key in chat_data) {

	// 						    	// 	var value = chat_data[key]
	// 						    	// }

	// 	})


	// 	// _('data_conv').innerHTML = post_meta(data_postid,type)

	// }




	function post_meta(data_postid,type) {





	
		// if(type == 'story'){

		// 	var title_chat = $("#post_"+data_postid).find('#post_title').find('a:first').text()
		// 	var title_owner = $("#post_"+data_postid).find('#contain_title').find('small').text()

		// }else{
			
		// 	var title_chat = $("#post_"+data_postid).find('h1').text()
		// 	var title_owner = $("#post_"+data_postid).find('small').text()

			
		// }

		// if(title_chat.length > 70){

		// 	title_chat = title_chat.substring(0, 70)+".."
		// }




	}

	function write_refer(box) {

		post_type_value = box.getAttribute("data-type")

				var text = ""
				var title = _('write_two_lines_ref').value

			if (title == ""  ) {

				_("sign_btn_ref").innerHTML = "Write something"
				_('sign_btn_ref').style.display = "block"

				
			}else{

					_('sign_btn_ref').innerHTML = "Publishing.."
					_('sign_btn_ref').style.display = "block"

					var vars = "post_title="+title+"&post_text="+text+"&visible="+post_type_value+"&image_tempo="+tmp+"&refer="+data_postid+"&post_id=null"

					$.post('script_bundle.php',vars, function(data){

						console.log(data)

						_('sign_btn_ref').innerHTML = ""
						_('write_two_lines_ref').value = ""
						_('sign_btn_ref').style.display = "none"

					$('#line_reference').prepend( data )

				 })


			}
	


	}

	function message_frame(info,unique_key){

		info = info.trim()

		_('no_conversation').style['display'] = 'none'

		console.log(info.length);

		

		var data =  data_postid 
	

		_('comment').value = ""


						var hr = new XMLHttpRequest()
					    // Create some variables we need to send to our PHP file
					    var url = "script_bundle.php"
					    var vars = "commentid="+data+"&post_content="+info+"&refid="+unique_key
					    hr.open("POST", url, true)
					    // Set content type header information for sending url encoded variables in the request
					    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					    // Access the onreadystatechange event for the XMLHttpRequest object
					    hr.onreadystatechange = function() {
					    	console.log(vars)

					    	

						    if(hr.readyState == 4 && hr.status == 200) {

						    	

							    var return_data = hr.responseText

							    // if(return_data == 'done'){

							    	console.log( return_data,'sent' )	

							    	var box_data = JSON.parse(return_data)

							    	for (var key in box_data) {

							    		var value = box_data[key][0]
							    		var value2 = box_data[key][1]

							    		last_post_id = Number(value2)

							    		
							    		console.log(value,'atleast1',last_post_id,value2 )

							    		

							    		_(key+'sent').innerHTML = value+"<span> <img class='tick' style='display:block' src='images/tick.svg'> </span>"

							    	}
								
						    }
					    }
					    // Send the data to PHP now... and wait for response to update the status div
					    hr.send(vars) // Actually execute the request
		

	}



	function comment_fun(box,enterkey) {


		

		var box_len =  box.getAttribute("id")

		console.log( box_len , _('comment').value )

		var info = $("#comment").val().replace(/\n/g, "")

		if ( info != '' ){

			if ( enterkey.keyCode == '13' || box_len == null  ) {

					var unique_key = Math.random()


					if (info.trim().length > 0) {

						$("#chat_data").append( "<div id='local_sent' class='comment_parent'> <div id='two_comment'>  <span id='"+unique_key+"sent' > "+info+" <span > <img class='tick' style='display:none' src='images/tick.svg'> </div> </div>" )
						message_frame(info,unique_key)

					}

					 _('chat_data').scrollTop = _('chat_data').scrollHeight

			}

		}

	}


	function send_chat_img(box){

		// _("profile_setup_text").innerHTML = "uploading...."
			// var image = box.files['0']		
			var unique_key = Math.random()
				console.log(image)
			$("#chat_data").append( "<div class='comment_parent'> <div id='two_comment'>  <span id='"+unique_key+"sent' > Loading...  <span > <img class='tick' style='display:none' src='images/tick.svg'> </div> </div>" )
			 _('chat_data').scrollTop = _('chat_data').scrollHeight

			// var fd = new FormData()
			// fd.append('post_image',image)


			// 			var hr = new XMLHttpRequest()
			// 		    var url = "script_bundle.php"
			// 		    hr.open("POST", url)
			// 		    hr.send(fd)


			// 		    hr.onreadystatechange = function() {
			// 			    if(hr.readyState == 4 && hr.status == 200) {
			// 				    var return_data = hr.responseText
							
			// 				    if(return_data == "too large" || return_data == "Incorrect file type" || return_data == "Upload error" || return_data == '' ){

			// 				    	send_notice(return_data)

			// 				    }else{
							 
			// 				    	message_frame(return_data,unique_key)
				
			// 				    }

							    
			// 			    }
			// 		    }


					    //setup
			
		upload_control (box,message_frame,unique_key)


	}

	function call(fun){
		return fun
	}


	function upload_control (box,callback,oth){


			var image = box.files['0']		
			// var unique_key = Math.random()
			console.log(image)

			// $("#chat_data").append( "<div class='comment_parent'> <div id='two_comment'>  <span id='"+unique_key+"sent' > Loading...  <span > <img class='tick' style='display:none' src='images/tick.svg'> </div> </div>" )
			 // _('chat_data').scrollTop = _('chat_data').scrollHeight

			var fd = new FormData()
			fd.append('post_image',image)


						var hr = new XMLHttpRequest()
					    var url = "script_bundle.php"
					    hr.open("POST", url)
					    hr.send(fd)


					    hr.onreadystatechange = function() {
						    if(hr.readyState == 4 && hr.status == 200) {
							    var return_data = hr.responseText
							
							    if(return_data == "too large" || return_data == "Incorrect file type" || return_data == "Upload error" || return_data == '' ){

							    	send_notice(return_data)

							    }else{

							    	console.log('callback callback callbackcallback callback callback')
							    	console.log(callback,return_data,oth)
							 
							    	callback(return_data,oth)
				
							    }

							    
						    }
					    }




	}

	function speak(box){

		var data =  box.getAttribute("data-id") 

		var playing = window.speechSynthesis.speaking
		var paused = window.speechSynthesis.paused

		// reply = document.getElementById("text_"+data)

		var reply = $("#post_"+data+" .text").text()

		// console.log(reply)

		startSpeech = new SpeechSynthesisUtterance(reply)


	//	console.log("speaking: "+amISpeaking)
	//	console.log("paused: "+amIpaused)

		if(playing == true)
		{
			box.style.backgroundImage = 'url("images/play.svg")'
			box.style.backgroundPosition = "70% 50%"
			window.speechSynthesis.cancel()

		}	
		else
		{
          readit(data)
			box.style.backgroundImage = 'url("images/pause.svg")'
			box.style.backgroundPosition = "50% 50%"


			window.speechSynthesis.speak(startSpeech)	

		
		}

		startSpeech.onend = function() { 
			box.style.backgroundImage = 'url("images/play.svg")'
			box.style.backgroundPosition = "70% 50%"
		}	
	}





	var tmp


	function un_upload_img(){
		// _('insert_media').style.display = "inline"

		_("uploaded_image").style.display = "none"

		_("main_source").innerHTML = ""

		_('post_image').value = ""
		tmp = ""
	}

	// Image upload

	function file_uploaded(return_data){

		_("uploaded_image").style.display = "none";
		tmp = return_data
		video_or_img()
		_('post_image').value = ""

	}

	function send_image(box){

			upload_control (box,file_uploaded,'file_upload')
			_("uploaded_image").style.display = "block"
			_("img_name_up").innerHTML = "uploading...."


	}



	function exp_up(return_data){

			// to_series_pannel(return_data,'image')
			history.pushState({state:1}, "State 1", "?series-pannel="+return_data+"&type=image" )

			start_op()

	}

	function send_exp(box){

			upload_control (box,exp_up,'exp_up')
			send_notice('Uploading..','nohistory');

	}

	function profile_up(return_data){
			
			document.querySelector("#setup_form #image ").setAttribute("src", return_data )
							    	
			_('setup_img').value = return_data

			_("profile_setup_text").innerHTML = "Uploaded"


	}

	function send_profile_img(box){

		_("profile_setup_text").innerHTML = "uploading...."

		upload_control (box,profile_up,'profile_upload')


	}




function youtube_e(url) {
    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/
    var match = url.match(regExp)

    if (match && match[2].length == 11) {
        return match[2]
    } else {
        return 'error'
    }
}



function parseVideo (url) {
    // - Supported YouTube URL formats:
    //   - http://www.youtube.com/watch?v=My2FRPA3Gf8
    //   - http://youtu.be/My2FRPA3Gf8
    //   - https://youtube.googleapis.com/v/My2FRPA3Gf8
    // - Supported Vimeo URL formats:
    //   - http://vimeo.com/25451551
    //   - http://player.vimeo.com/video/25451551
    // - Also supports relative URLs:
    //   - //player.vimeo.com/video/25451551

    url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/)

    if (RegExp.$3.indexOf('youtu') > -1) {
        var type = 'youtube'
    } else if (RegExp.$3.indexOf('vimeo') > -1) {
        var type = 'vimeo'
    }

    return {
        type: type,
        id: RegExp.$6
    }
}


function getId (url) {
    // Returns an iframe of the video with the specified URL.
    var videoObj = parseVideo(url)

    

    if (videoObj.type == 'youtube'){

        $iframe = '//www.youtube.com/embed/' + videoObj.id+"?enablejsapi=1&version=3&playerapiid=ytplayer"

    }else if (videoObj.type == 'vimeo') {
        $iframe = '//player.vimeo.com/video/' + videoObj.id

    }else{
    	$iframe = url
    }

    return $iframe
}


function return_dat (data){
	 console.log(data,'re')
	 return data
}

function getVideoThumbnail (url) {
    // Obtains the video's thumbnail and passed it back to a callback function.
    var videoObj = parseVideo(url)


    if (videoObj.type == 'youtube') {

        return_dat('//img.youtube.com/vi/' + videoObj.id + '/maxresdefault.jpg') 

    } else if (videoObj.type == 'vimeo') {

        $.get('http://vimeo.com/api/v2/video/' + videoObj.id + '.json', function(returndata) {

          return_dat(returndata[0].thumbnail_medium)

       
        })
    }

    
}


function checkURL(url) {
    return(url.match(/\.(jpeg|jpg|gif|png)$/) != null)
}


		function send_video(){

		var vLnk = _('add_extra_input').value

		

			_("uploaded_image").style.display = "none"

			tmp = vLnk

			video_or_img()
			clear_more()



	}

	// chooses to add  video or image 
	function video_or_img(){

			if (tmp != '') {

				var videoId = getId(tmp)

				if ( checkURL(tmp) == true ) {

					_('main_source').innerHTML = '<img id="img_src" src="'+videoId+'" >'

				}else{
					_('main_source').innerHTML = '<iframe id="video_src" width="560" height="315" src="'+videoId+'" frameborder="0" allowfullscreen></iframe>'
				}

			}



	}

		function clean(name) {
		    name.value = ""

		}

		function write_story(){
			// initDoc()


				 _('update_story').style['display'] = 'none'
				 _('send_story').style['display'] = 'block'

				var popup = _('popup_story')
				popup.style.display = "block"	

				set_size(  _('popup_story') )

		}


		 var selectionSt
		 var caretPos


		 function ReturnWord(s, pos) {

		 	var preText = s.substring(0, pos)
		 	selectionSt = preText.lastIndexOf(" ")

		 	    console.log(selectionSt, caretPos)
	        

	        if (preText.indexOf(" ") > 0 || preText.indexOf("\n") > 0) {

	            var words = preText.split(" ")
	            words = words[words.length - 1].split("\n")
	            return words[words.length - 1] //return last word
	        }
	        else {
	            return preText
	        }
	    }

	    function pasteHtmlAtCaret(html) {

	    var sel, range
	    if (window.getSelection) {
	        // IE9 and non-IE
	        sel = window.getSelection()
	        if (sel.getRangeAt && sel.rangeCount) {
	            range = sel.getRangeAt(0)
	            range.deleteContents()

	            // Range.createContextualFragment() would be useful here but is
	            // only relatively recently standardized and is not supported in
	            // some browsers (IE9, for one)
	            var el = document.createElement("div")
	            el.innerHTML = html
	            var frag = document.createDocumentFragment(), node, lastNode

	            while ( (node = el.firstChild) ) {
	                lastNode = frag.appendChild(node)
	            }
	            
	            range.insertNode(frag)

	            // Preserve the selection
	            if (lastNode) {
	                range = range.cloneRange()
	                range.setStartAfter(lastNode)
	                range.collapse(true)
	                sel.removeAllRanges()
	                sel.addRange(range)
	            }
	        }
	    }


	}



	    function add_sugg(box) {


	    	text = "@"+box.getAttribute("data-set")

	    	_('write_two_lines').focus()
	    	// pasteHtmlAtCaret(text)

	    	var content =  _('write_two_lines').value

	    	var preText = content.substring(0, selectionSt)+" "+text+" "
	    	var proText = content.substring(caretPos,content.length)
	   		var textdat_n = preText+proText


	    	_('write_two_lines').value = textdat_n

	    	var caret = (textdat_n.length)-proText.length 

	    	_('write_two_lines').selectionStart = caret
	    	_('write_two_lines').selectionEnd = caret


	    	//set cursor position for contenteditable

	  //   	node = _('write_two_lines')
   //    		var node = document.querySelector("#write_two_lines")
			// node.focus()
			// var textNode = node.firstChild

			// console.log(textdat_n.length,proText.length)

			// var caret = (textdat_n.length-5)-proText.length 
			// var range = document.createRange()
			// range.setStart(textNode, caret )
			// range.setEnd(textNode, caret )
			// var sel = window.getSelection()
			// sel.removeAllRanges()
			// sel.addRange(range)



			_('auto_mesage').innerHTML = ''
	    	// pasteHtmlAtCaret(text)


	    }


	    function get_sugg(search) {


	    $.get("script_bundle.php?sr_ref="+search, function(data){

		_('auto_mesage').innerHTML =  data



		})



	    	

	    	console.log(search)


	    }

	    	    function find_sugg(search) {


	    $.get("script_bundle.php?men_ref="+search, function(data){

		_('auto_mesage').innerHTML =  data



		})

		

	    	

	    	console.log(search)


	    }



	    function get_cur(text) {


	    	caretPos = text.selectionStart

	    	// text.getSelection().getStartElement()

		 	// caretPos = window.getSelection().getRangeAt(0).cloneRange()
	        // caretPos = caretPos.endOffset

	        console.log(caretPos)
	    }
	   

		 function PrevWord(text) {

		 	get_cur(text)

	        word = text.value

	        word = word.replace(/&nbsp/gi,' ')

	        var word = ReturnWord(word, caretPos)

	        console.log(word)

  			// 

	        if (word != null && word.length > 0 && word != '&nbsp' ) {

	        	bool = word.indexOf("@") >= 0

	        	if ( bool == true ) {

	        		 word = word.replace(/@/gi,'')
	        		 get_sugg(word) 
	        	
	        	}

	        }else{

	        	_('auto_mesage').innerHTML = ''
	        }
	    }

		function two_lines_cal(box){

			PrevWord(box)
			var max_string = 130

			var input_text = box.value

			var margin = max_string - ( input_text.length)

			if(box.id == "write_two_lines_ref"){
				var sign = "sign_btn_ref"
			}else{
				var sign = "sign_btn"
			}

	 		if(input_text.length == 0){

	 			// send_notice('write Something')

	 		// 		_(sign).innerHTML = ""
			// 	_(sign).style.display = "block"

	 		}else if( margin < 0 && sign == 'sign_btn_ref' ){

	 			send_notice("Be creative "+margin)

			// 	_(sign).innerHTML = "Be creative "+margin
			// 	_(sign).style.display = "block"
			// 	// _('anonymous_btn').disabled = true
			// 	// _('anonymous_btn').style.opacity = "0.7"
			// 	// _('anonymous_btn').style.cursor = "no-drop"

			}else{

			// 	_(sign).innerHTML = ""
			// 	_(sign).style.display = "none"
			// 	// _('anonymous_btn').disabled = false
			// 	// _('anonymous_btn').style.opacity = "1"
			// 	// _('anonymous_btn').style.cursor = "pointer"
			
			}




		}







		function write_short(data){


		
				_('post_btns').style['display'] = "block"
				_('update_btns').style['display'] = "none"


				find_sugg()


				set_size( _('popup_tl') )

				_('write_two_lines').focus()

				

				if(data == null || data == '' ){

				}else{

					_('write_two_lines').value = " @"+data+" "
				}

				

		}

		function reset_size(box){
			// box.style['height'] = '0'
			// box.style['width'] = '0'
			// box.style['left'] = "50%"
  	// 		box.style['top'] = "50%"
			// box.style['transition']=  'none'
			box.style['display'] = "none"
		}


		function set_size(box){
			box.style['display'] = "block"

		// box.style['height'] = "100%"
	  // 		box.style['width'] = "100%"
	  // 		box.style['left'] = "0"
	  // 		box.style['top'] = "0"
	  // 		box.style['transition'] =  '0.2s ease-in-out'
		}

		function pausevideo(){

			console.log('video1')

			$('iframe').each(function(){

				console.log( $(this).attr( 'src' ) )

			    // $(this).attr( 'src', $(this).attr('src').replace(/&autoplay=1/gi, "")  )

			    console.log( $(this).attr( 'src' ) )

			    $(this)[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*')

			    
			})


		}


// console.log('video')
		

	


	function clear_story(){


		$('.expanded').each( function() {

            $(this).attr('class', '' )
             $(this).attr('onclick', 'expand_image(this)' )

        })

		console.log('video')
		

		pausevideo()


		$('video').each(function(){

			console.log('video')


		        $(this)[0].pause()
		    

		    
		})


			  		// _('posts').innerHTML = ''
  		_('posts_story').innerHTML = ''
	  

			get_notif(11)

			clearInterval(chat_check)

				last_post_id = 0


				

				var title = _('cover')


				var popup = _('popup_story')
				
				title.style.display = "none"

		

				if(popup){

				

				var url = new URL( window.location.href )

				var msg = url.searchParams.get("msg")
				var op = url.searchParams.get("options")

				if (msg || op) {
					// send_notice(msg)
					// _("success").style.display = "none"
				}else{
					_("success").style.display = "none"
					_('cover_notice').style.display = 'none'
				}

				

				_("pannel_bottom").style.display = "none"

				reset_size( _("write_pop") )
				reset_size( _("search_pop") )
				reset_size( _("home_pop") )
				reset_size( _("story_pop") )
				reset_size( _("user_pop") )
				reset_size( _("setup_pop") )
				reset_size( _("notif_pop") )
				reset_size( _("list_pop") )
				reset_size(  _('popup_story') )
				reset_size(  _('popup_tl') )
	 			_('conversation_box').style.display = "none"

	 			if ( _('other_list') ) {

	 				_('other_list').style['display'] = 'none'

	 			}
	 			
				
		

				}

				if(_('contain_form')){

					_('contain_form').style.display = "none"
					
					_("write_pop").style.display = "none"

		 			reset_size( _("search_pop") )

		 			reset_size( _("home_pop") )
		 			
		 			reset_size( _("user_pop") )

		 				reset_size( _("story_pop") )

				}


		}




	function write_something(){
		clear_story()
			// make_cover()
		_("write_pop").style.display = "block"

		set_size( _('write_pop') )

	}
	
	function login() {

		var e = _('username').value
		var p = _('password').value

		if (e == "" || p == "") {
			_('discribe').innerHTML = "Fill up everything!"
		}else{
						var hr = new XMLHttpRequest()
					    // Create some variables we need to send to our PHP file
					    var url = "script_bundle.php"
					    var vars = "email="+e+"&password="+p
					    //alert(vars)
					    hr.open("POST", url, true)
					    // Set content type header information for sending url encoded variables in the request
					    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
					    // Access the onreadystatechange event for the XMLHttpRequest object
					    hr.onreadystatechange = function() {
						    if(hr.readyState == 4 && hr.status == 200) {
							    var return_data = hr.responseText

							    if (return_data == "Welcome!") {


							    	// location.reload()

							    	window.location.href = window.location.href+"?login=true"

							    }else{
							    	_("discribe").innerHTML = return_data	
							    }
						    }
					    }
					    // Send the data to PHP now... and wait for response to update the status div
					    hr.send(vars) // Actually execute the request
					    _("discribe").innerHTML = "Logging In..."
			}

		}



		var post_type_value

		function add_more() {

			_("add_extra").style.display = "block"

			_("add_extra_input").value = ""

			_("add_extra_input").focus()

	
		}

		function clear_more() {

			_("add_extra").style.display = "none"
		}

		function destroy_error(box){

			_('cover_notice').style.display = 'none'

			console.log('failure!')

			if (box) {
				box.style.display = 'none'
			}else{
				_('success').style.display = "none"
			}

		}

		function copy_postlink(box){

			copy_to_clip("http://fleeke.com/?story="+box)
			send_notice( 'Copied to clipboard <br><br> '+"http://fleeke.com/?story="+box,'nohistory')

		}

		function copy_embedlink(box){

			copy_to_clip("<iframe src='http://fleeke.com/?story="+box+"' > </iframe>")
			send_notice('Copied to clipboard <br><br> '+"http://fleeke.com/?story="+box,'nohistory')
		}


		var channel_parentstory

		function delete_story(box){

			var parent = channel_parentstory.attr('data-id')

			send_notice('Deleting..','nohistory')

				var vars = "delete_post="+parent

				$.post('script_bundle.php',vars, function(data){

				if (data == 'true') {

					channel_parentstory.css('display','none')

					send_notice('Deleted!','nohistory')
				}else{
					send_notice('Opps!')
				}



			})
		}

		function report_story(box){

			var parent = channel_parentstory.attr('data-id')

			send_notice('Reporting..','nohistory')

				var vars = "report_post="+parent

				$.post('script_bundle.php',vars, function(data){

				if (data == 'true') {

					send_notice('Reported!','nohistory')
				}else{
					send_notice('Opps!')
				}

			})

		}

		function ref_write (box){

			clear_story()

			history.pushState({state:1}, "State 1", "?write="+box.getAttribute('data-type')+"&refer="+data_postid )

			start_op();

		}

		function edit_story(){

			var parent = channel_parentstory
			clear_story()

			 if ( parent.attr('class').includes("two_lines") == true ) {

			 	
	
			 	var popup = _('popup_tl')

				popup.style.display = "block"	

				
				set_size( _('popup_tl') )


				history.pushState({state:1}, "State 1", "?write=write_message&edit="+parent.attr('data-id') )

				_('post_btns').style['display'] = "none"
				_('update_btns').style['display'] = "block"

				document.querySelector(".anony_save").setAttribute("data-set", parent.attr('data-id') )

				_('write_two_lines').value =  parent.find("h1").text().trim()
				console.log(parent.find("h1").text().trim())
				_('write_two_lines').focus()
			 	
	
			}else{

			// parent = $(box).closest('#story_parts')

			_('write_text').innerHTML =  parent.find(".text").html() 
			_('write_title').innerHTML = parent.find("#post_title span large").html().trim() 

			var content_image =  parent.find(".overlay_post_image")

			if ( content_image.length != 0 ) {

				tmp = content_image.attr('src') 

				video_or_img()

			}

				history.pushState({state:1}, "State 1", "?write=write_story&edit="+parent.attr('data-id') )

				var popup = _('popup_story')
				popup.style.display = "block"

				set_size( _('popup_story') )

				_('update_story').setAttribute("data-set", parent.attr('data-id') )
				
				 _('update_story').style['display'] = 'block'
				 _('send_story').style['display'] = 'none'
				 
			}

		}

		function Create_post(box) {

			post_type_value = box.getAttribute("data-type")

			san_conedit()

			var title
			var textz

			if(post_type_value == "2" || post_type_value == "1" ){
				textz = ""
				title = _('write_two_lines').value
			}else{
				title = _('write_title').innerHTML
				textz = _('write_text').innerHTML
			}

			
			var visiblity_check = post_type_value


			var text =  textz.replace(/&nbsp/gi, " ") 
			var word_Q = text.split(" ")
			var title_Q = title.split(" ")

			if (title == ""  ) {

					if(post_type_value == "2" || post_type_value == "1"){
						_('sign_btn').innerHTML = "Write something"
					}else{
						send_notice("Title really helps")
					}
		

			}else if(text == "" && post_type_value !== "2"&& post_type_value !== "1"){

				send_notice("Nothing written")

			}else if(word_Q.length <= 20 && post_type_value !== "2"&& post_type_value !== "1"){

					send_notice("Story too short")

			}else if(title_Q.length >= 240 && post_type_value !== "2" && post_type_value !== "1"){

						send_notice("title too long")

			}else{
							var hr = new XMLHttpRequest()
						    // Create some variables we need to send to our PHP file
							   var url = "script_bundle.php"

						    var urled = new URL( window.location.href )

							var msg_ref = urled.searchParams.get("refer")

						    if (msg_ref) {
						    	ref_data_postid = msg_ref
						    	update_id = 'null'
						    }else{
						    	ref_data_postid = 'null'
						    	update_id = box.getAttribute("data-set")
						    }


						    // var vars = "post_title="+title+"&post_text="+text+"&visible="+visiblity_check+"&image_tempo="+tmp+"&refer="+ref_data_postid+"&post_id=null"

						    var vars = "post_title="+encodeURIComponent(title)+"&post_text="+encodeURIComponent(text)+"&visible="+visiblity_check+"&refer="+ref_data_postid+"&image_tempo="+tmp+"&post_id="+update_id

						    console.log(vars)
						    hr.open("POST", url, true)
						    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
						    hr.onreadystatechange = function() {
							    if(hr.readyState == 4 && hr.status == 200) {

							    

								    var return_data = hr.responseText

								    if ( return_data.toLowerCase().includes("opps!") == true ) {

								    	send_notice(return_data)

								    }else{

								    	posting_success(return_data)
								    }
									
							    }
						    }

						    hr.send(vars)


								
							send_notice("Yeah! Publishing...",'nohistory')
								
								
				}

		}

		function send_notice(data,type){

			console.log('go down')

			_('cover_notice').style.display = 'block'
			_("success").innerHTML = data
			_('success').style.display = "block"
			_('success').focus()

			if(type == 'clickable'){
				history.pushState({state:1}, "State 1", "?options=true")
			}else if(type == 'nohistory'){
			
			}else{
				history.pushState({state:1}, "State 1", "?msg="+data)
			}


		
		}

		function posting_success(data){


					history.pushState({state:1}, "State 1", "?story="+data)

					tmp = ""
					un_upload_img()

					_('sign_btn').style.display = "none"
					_('sign_btn').innerHTML = ""
					_('success').style.display = "none"

					start_op();

					_('write_title').innerHTML = ''
					_('write_text').innerHTML = ''
					_('write_two_lines').value = ''
		}



		if( _('password') ){

		_('password').addEventListener('keypress', function (e) {
		    var key = e.which || e.keyCode
		    if (key === 13) { // 13 is enter
		      login()
		    }
		})

		}



		if(_('username')){
			
			_('username').addEventListener('keypress', function (e) {
			    var key = e.which || e.keyCode
			    if (key === 13) { // 13 is enter
			      login()
			    }
			})

		}

		function to_form(){

				make_cover()
		
			  	_('contain_form').style.display = "block"	

		}



			function set_up() {

			var fullname = _('fullname').value
			var penname_id = _('penname_id').value
			var email = _('email').value
			var password = _('password').value
			var bio = _('bio').value


							var hr = new XMLHttpRequest()
						    // Create some variables we need to send to our PHP file
						    var url = "script_bundle.php"
						    var vars = "fullname_st="+fullname+"&penname_id_st="+penname_id+"&email_st="+email+"&password_st="+password+"&bio_st="+bio+"&profile_img="+_('setup_img').value

						    console.log(vars)

						    hr.open("POST", url, true)
						    // Set content type header information for sending url encoded variables in the request
						    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
						    // Access the onreadystatechange event for the XMLHttpRequest object
						    hr.onreadystatechange = function() {
							    if(hr.readyState == 4 && hr.status == 200) {
								    var return_data = hr.responseText

								    if (return_data == "done") {
						    			// _('signupButton').style.color = "#000"
								    	 _('signupButton').value = "done"

								    	 	history.pushState({state:1}, "State 1", "?home=true")
								    	  window.location="index.php?msg=Your account has been successfully setup"
								    }else{
								    	_("signupButton").value = return_data
								    	_('signupButton').style.color = "tomato"	
								    }
									
							    }
						    }
						    // Send the data to PHP now... and wait for response to update the status div
						    hr.send(vars)

						    _('signupButton').value = "Processing...."		
				

		}








