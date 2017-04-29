$(document).ready(function(){
	
	//remove blocking from friend request
	$(".unblock").click(function(event){
		event.preventDefault();
		event.stopPropagation();
		
		var select = $(this);
		var id = select.attr('id');
		var ar = id.split('-');
		
		$.get('unnlockfriendrequest.php',{blocked:ar[0],notificationid:ar[1]},function(success){
			if($.trim(success) =='1'){
				$(select).parent().fadeOut('fast');
			}
		});
		
	});
	
	
	var CookieSet1 = Cookies.get('userid');
	var CookieSet2 = Cookies.get('visitor');
		// check if user is already a friend or has sent a request on page load
		if (CookieSet1 != null && CookieSet2 != null && (CookieSet1 != CookieSet2)) {
				$.post('friendchecker.php',{user_id:CookieSet1,visitor:CookieSet2},
				function(success){
					if($.trim(success)==='true'){
					$("#friendresponse").val('Requested');
					$('#friendresponse').prop('disabled', true);
					}
					if($.trim(success)==='friends'){
					$("#friendresponse").val('Accepted');
					$('#friendresponse').prop('disabled', true);
					}
					
				});	
		}
			
			//acceptingfriend
			$("#friendAcceptLink").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var select = $(this);
				var id = select.attr('href');
				var ar = id.split('-');
				
				// 0= them, the requester, 1= me the requested friend, 2= request notification row id
				$.post('friendaccept.php',
				{userid:ar[1],friendID:ar[0],id:ar[2]},
				function(success){
					if($.trim(success)==='done'){
						
						var d = $(select).parentsUntil('div');
						d.parent().fadeOut();
					}
				});
			});
			
			//deleteing a friend request
			$("#friendDeleteLink").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var select = $(this);
				var id = select.attr('href');
				var ar = id.split('-');
				
				// 0= them, the requester, 1= me the requested friend, 2= request notification row id
				$.post('friendrequestdelete.php',
				{userid:ar[0],id:ar[1]},
				function(success){
					if($.trim(success)==='done'){
						
						var d = $(select).parentsUntil('div');
						d.parent().fadeOut();
					}
				});
			});
			
			//blocking a friend request
			$("#friendBlockLink").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var select = $(this);
				var id = select.attr('href');
				var ar = id.split('-');
				
				// 0= them, the requester, 1= me the requested friend, 2= request notification row id
				$.post('friendrequestblock.php',
				{userid:ar[0],id:ar[1]},
				function(success){
					if($.trim(success)==='done'){
						
						var d = $(select).parentsUntil('div');
						d.parent().fadeOut();
					}
				});
			});
			
			//unfriend
			$(".unfriend").click(function(event){
			event.preventDefault();
			event.stopPropagation();
			var select = $(this);
			var id = select.attr('href');
			$.get('unfriend.php',{id:id},function(success){
				if($.trim(success) == '1'){
					$(select).parent().fadeOut();
				}else{
					alert('Please try again');
				}
				});
			});

			//block notification
			$(".blocknotification").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var select = $(this);
				var id = select.attr('id');
				$.get('blocknotification.php',{id:id},function(success){
					if($.trim(success) == '1'){
					$(select).parent().fadeOut();
				}else{
					alert('Please try again');
				}

				});
			});
			
			//js function for updating work history form and sending messages
			$("#Form").submit(function(event){
			event.preventDefault();
			var est,frm,to,cur;
			est = $("#est").val();
			frm = $("#frm").val();
			to = $("#to").val();
			cur = $("#cur").val();
			
			$.post($(this).attr("action"),
			$(this).serializeArray(),
			function(info){ 
			
			if($.trim(info) == 'Saved' || $.trim(info)=='Sent'){
				
				$("#to").val('');
				$("#title").val('');
				$("#message").val('');
				
				$("#main").load('editProfileSuccess.php',{reply:info});
				
			}else{
				$("#est").val(est);
				$("#frm").val(frm);
				$("#to").val(to);
				$("#cur").val(cur);
				$("#output").html(info);
				
			}
				
			
			});
			
		});

			// friend request send to notification table
		$("#friendrequest").submit(function(event){
			event.preventDefault();
			event.stopPropagation();
			$.post($(this).attr("action"),
			$(this).serializeArray(),
			function(info){ 
			$("#friendresponse").val('requested');
			$('#friendresponse').prop('disabled', true);
			});
		});
		
		
	//remove work history from user table
	$(".cancel_icon").click(function(event){
		
		var select = $(this);
		var id = select.attr('id');
		var ar = id.split('-');

		$.post(ar[1],{wh:ar[0],user_id:ar[2]}, function(success){
			if($.trim(success) === 'Error'){
				alert('Sorry an error occurred');
			}else{
			$(select).parent().fadeOut();
			}
		});		
	});

//**************************************************************
//code REFERENCE1 BEGIN
// Clark, S. (2013) Ajax file upload with jQuery and XHR2Sean Clark http://square-bracket.Com. 
//Available at: https://gist.github.com/optikalefx/4504947 (Accessed: 19 December 2016).

$.fn.upload = function(remote, data, successFn, progressFn) {
	// if we dont have post data, move it along
	if (typeof data != "object") {
		progressFn = successFn;
		successFn = data;
	}

	var formData = new FormData();

	var numFiles = 0;
	this.each(function() {
		var i, length = this.files.length;
		numFiles += length;
		for (i = 0; i < length; i++) {
			formData.append(this.name, this.files[i]);
		}
	});

	// if we have post data too
	if (typeof data == "object") {
		for (var i in data) {
			formData.append(i, data[i]);
		}
	}

	var def = new $.Deferred();
	if (numFiles > 0) {
		// do the ajax request
		$.ajax({
			url: remote,
			type: "POST",
			xhr: function() {
				myXhr = $.ajaxSettings.xhr();
				if(myXhr.upload && progressFn){
					myXhr.upload.addEventListener("progress", function(prog) {
						var value = ~~((prog.loaded / prog.total) * 100);

						// if we passed a progress function
						if (typeof progressFn === "function") {
							progressFn(prog, value);

						// if we passed a progress element
						} else if (progressFn) {
							$(progressFn).val(value);
						}
					}, false);
				}
				return myXhr;
			},
			data: formData,
			dataType: "json",
			cache: false,
			contentType: false,
			processData: false,
			complete: function(res) {
				var json;
				try {
					json = JSON.parse(res.responseText);
				} catch(e) {
					json = res.responseText;
				}
				if (typeof successFn === "function") successFn(json);
				def.resolve(json);
			}
		});
	} else {
		def.reject();
	}

	return def.promise();
};
	 //************************************************************
	//code REFERENCE1 END.
	 
	 //wiget call profile pic
	$("#imgForm").submit(function(event){
		
		var id = $("#userid").attr("value");
	
		$(":file").upload("save_file.php",{user:id},function(success){
			$(":file").val('');
						
			if( $.trim(success.substr(0,6)) == 'data'){
					$("#profileavatar_profile_page").attr("src",success);
					$("#imgReply").html('');
			}else{
					$("#imgReply").html(success);
			}
			
		}, null);
		
		event.preventDefault();
	event.stopPropagation();
		
	});
		
	//script call for star rating
	$(".rating").jRating({
						decimalLength:1,
						rateMax: 5,
						
					});
					
	$(".rating").on('click',function(){
		
		$(this).jRating({phpPath:'rating.php'});
		
	});	
	
	
	
	//script call for resource comments
	$("#resourceCommentForm").submit(function(event){
		
			event.stopPropagation();
			event.preventDefault();

		$.post($(this).attr("action"),
		$(this).serializeArray(),
		function(info){
			//$("#output").html(info);
			if($.trim(info)==='error'){
				alert('An error occurred please try again');
			}else{
				var result = JSON.parse(info);
				
				$(".viewComments").load('refreshComments.php',{user_id:result.user_id,column:result.column,id:result.id});
				$.post('sendnotifications.php',{sender_id:result.user_id,source:result.column,id:result.id},function(info){});
			}
		});
	});
	
		//on enter submit form for discussions
		$('#resourcetextarea').keypress(function (e) {
	  if (e.which == 13) {
		$('#resourceCommentForm').submit();
		return false;    //<---- Add this line
	  }
	});
	
	//deleteing comments or replying
	$(".commentManagementform").submit(function(event){
		
		event.stopPropagation();
			event.preventDefault();

		$.post($(this).attr("action"),
		$(this).serializeArray(),
		function(info){
			
			var result = JSON.parse(info);
			
			$(".viewComments").load('refreshComments.php',{user_id:result.user_id,column:result.column,id:result.id});
		});
	});
	
	//commentreplies toggle
	$(".showreplies").click(function(event){
		var select = $(this);
		var id = select.attr('value');
		$('#'+id).toggle();
	});
		
	//password checker
	$("#ckpw").keyup(function(){
		var pw = $("#pw").val();
		var ckpw = $("#ckpw").val();
		
		$.post("PWchecker.php",
		{pw:pw,check:ckpw},
		function(info){
			$("#checker").val(info);
			
			if($.trim(info) === '1'){
				
				$(".confirmPw").attr("src","images/tick.png");
					}else{
						$("#checker").val('-1');
				$(".confirmPw").attr("src","images/cross.png");
			}
		});
	});
	
	
			
	//resource ascending descending selection
	$(".sortArrow").click(function(event){
		event.stopPropagation();
			event.preventDefault();
			var val = $("#asc").val();
			if (val === ''){ 
			$(".sortArrow").attr("src","images/dwn.png");
			$("#asc").val('1');
			}else{
				$("#asc").val('');
				$(".sortArrow").attr("src","images/raise.png");
			}
	});
		
	//report input
	$("#reportinput").submit(function(event){
		event.stopPropagation();
			event.preventDefault();
			$.post($(this).attr("action"),
		$(this).serializeArray(),
		function(info){
			var result = JSON.parse(info);
			if($.trim(result.result) === '1'){
				//if submitted ok
				$(".reportResultsdiv").load('reportreload.php',{reportid:result.reportid});
			}
				
			if($.trim(result.result) === '2'){
					//if submisson went wrong
					alert('form submission error, please try again');
			}
			if($.trim(result.result) === '3'){
				// unaccepted charaters
					alert('Do not use £ ¬ ` $ characters');
			}
		});
	});
	
	
	
	$("#Rid").keyup(function(){
		var name = $(this).val();
		var searchtype, title;
		if($('#topic').is(':checked') || $('#backinTopic').is(':checked')){
			searchtype = 'forum_topics';
			title = 'topic_title';
		}else{
			searchtype = 'document_resources';
			title = 'title';
		}
		$.post('findresourcename.php',{search:name,typeofsearch:searchtype,title:title},function(found){
			var i = 0;
			if($.trim(found) == 'NONE'){
				
			}else{
				var show = JSON.parse(found);
				
				$("#liveresourceSearch").empty();
				
				while(i < show.length){
					var list =  '<li class="picked" id="'+show[i].id+'" >'+show[i].title+' <br>'+show[i].date+'</li> \
						<script>$("#'+show[i].id+'").click(function(){$("#Rid").val(\''+show[i].title+'\'); $("#liveresourceSearch").html(\'\'); $("#RidID").val(\''+show[i].id+'\'); $("#confirmblock").val(\'1\'); });</script>';
						$("#liveresourceSearch").append(list);
									
					i++;
				}
			}
			
		});
		
		
	});
	
	//find user to block
	$("#blockuser").keyup(function(){
		var UserBoBeblocked = $("#blockuser").val();
		var currentadmin = $("#currentadmin").val();
		$.post('findusertoblock.php',
		{user:UserBoBeblocked, current:currentadmin},
		function(success){
			if($.trim(success)=='NF' || $.trim(success)=='Self'){
				if($.trim(success)=='NF'){
					$("#userid").html('Not Found');
					
				}else{
					$("#userid").html('Cannot block your self');
					
				}
				$("#confirmuser").val('0');
				$("#username").html('');
				$("#getblockuserid").val('');
			}else{
				var result = JSON.parse(success);
				$("#userid").html(result.user_id);
				$("#username").html(result.username);
				$("#confirmuser").val('1');
				$("#getblockuserid").val(result.user_id);
			}
		});
	});
	
	//live search for a username
	$("#searchName").keyup(function(){
		var name = $('#searchName').val();
		var i = 0;
		
		$.get('searchName.php',
		{findName:name},
		function(found){
			
			if($.trim(found) == ''){
				
			}else{
				var rtn = JSON.parse(found);
				$("#livesearch").empty();
				while(i < rtn.length){
					var list = '<li class="picked" id="'+rtn[i].user_id+'" ><img class="searchprofilepic" src="'+rtn[i].img+'" alt="profile picture" /> \
					<br>'+rtn[i].firstname+' '+rtn[i].surname+'<br>'+rtn[i].school+'</li> \
					<script>$("#'+rtn[i].user_id+'").click(function(){$("#searchName").val(\''+rtn[i].firstname+' '+rtn[i].surname+'\'); $("#livesearch").html(\'\'); $("#searchID").val(\''+rtn[i].user_id+'\'); $("#confirmuser").val(\'1\'); });</script>';
					i++;
				}
				
				$("#livesearch").append(list);
			}
		});
	});
	
	$("#specialist_areaSelect").on('click',function(){
		var name = $("#specialist_areaSelect option:selected").text();
		$("#selectedOption").val(name);
	});
	
	
	
	$(".messageiconbin").click(function(){
		var select = $(this);
		var id = select.attr('id');
		var ar = id.split('-');
	
		
		$.get('delete_message.php',{user_id:ar[0],inboxitem:ar[1]},function(success){
			if($.trim(success) =='1'){
				$(select).parent().fadeOut();
			}else{
				alert('An error occurred, please try again')
			}
		});
		
	});
	
	$(".inboxreplybtn").click(function(){
		$(".inboxreply").toggle("fast");
	});
	
	$(".notificationManage").click(function(event){
		event.stopPropagation();
			event.preventDefault();
		var select = $(this);
		var id = select.attr('href');
		var ar = id.split('-');

			$.get('notificationmanage.php',{notificationid:ar[0],type:ar[2]},function(success){
				if($.trim(success)=='1'){
					$(select).parent().fadeOut();
				}else{
					alert('Please try again');
				}
			});
	});
	
	//download counter input to table
	$(".downloadCounter").click(function(){
		var select = $(this);
		var id = select.attr('id');
		var ar = id.split('-');
		$.get('downloaderv3.php',{resourceid:ar[0], user_id:ar[1]});

	});

//work history toggle check to box
	$("#cur").click(function(){
		var select = $(this);
		var id = select.attr('value');
		if($.trim(id) !=''){
			$("#to").val('1970-12-01');
			$("#to").toggle();
		}else{
			$("#to").val('');
			$("#to").toggle();
		}
	});

	//user delete resource
	$(".resourceDelete").click(function(){
		var confirm = window.confirm("Are you sure?"); //confirmation box
		var select = $(this); //html element that called the script
		var id = select.attr('value'); //the value used to get the id
		if(confirm == true){ 
			//if user selects yes call a script and send the id, 
			$.get('resourcedelete.php',{resourceid:id},function(success){
				if($.trim(success)=='1'){
					$(select).parent().fadeOut(); //if successfull, fade out the html element
				}

			});
		}
	});

	//email recommendation
	$(".emailRecommendation").submit(function(event){
		event.stopPropagation();
			event.preventDefault();
			$.get($(this).attr("action"),$(this).serializeArray(),function(info){
				$(".emailRecommendation").parent().toggle();
				//$(".ta").innerHTML = "empty";
			});
	});

	//toggle recommender
	$(".toggleRecommender").click(function(){
		
		$(".emailRecommendation").parent().toggle();
	});

	$(".resend").click(function(event){
		event.stopPropagation();
			event.preventDefault();
			var select = $(this);
			var email = select.attr('href');
			
			$.get("ResendConfirmation.php",{email:email},function(info){
				if($.trim(info)=='sent'){
					alert("Sent");
				}
			});
	});
//*****************************************************
//end of document loader		
});

