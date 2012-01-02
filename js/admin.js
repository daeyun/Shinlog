 $(function() {
	$('#datecheckbox').click(function(){
		if($("#date").attr("disabled") == "disabled") {
			$("#date").removeAttr("disabled");
		}else{
			$("#date").attr("disabled","disabled");
		}
	});
	$('#add_tag').click(function(){
		if($("#tags").val()==""){
			$("#tags").val($("#tagList").val());
		}else{
			$("#tags").val($("#tags").val()+", "+$("#tagList").val());
		}
	});
	$('#add_category').click(function(){
		if($("#categories").val()==""){
			$("#categories").val($("#categoryList").val());
		}else{
			$("#categories").val($("#categories").val()+", "+$("#categoryList").val());
		}
	});

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	var advanced_options=readCookie("advanced_options");
	if(advanced_options != null && advanced_options == "on"){
		$('#advanced-options').show();
		$('#toggle-advanced-options span').html("[-]");
	}

	$('#toggle-advanced-options').click(function(){
		$('#advanced-options').slideToggle();
		if($(this).find("span").html()=="[+]"){
			$(this).find("span").html("[-]");
			document.cookie = "advanced_options=on; path=/";
		}else{
			$(this).find("span").html("[+]");
			document.cookie = "advanced_options=off; path=/";
		}
	});
	$(".header .tagline").append('<div class="ajaxMsg">Saved</div>');
	$("#postform").submit(function(event){
		event.preventDefault();
		$.post($("#postform").attr("action"), $("#postform").serialize()+"&ajax=true", function(data) {
			if(data=="successful"){
				 $(".header .tagline .ajaxMsg").stop().fadeTo(70,1).delay(200).fadeTo(500,0); 
			}
		});
	});
	$(document).bind('keydown', 'f7', function(ent){ window.location.href = "admin/new"; });	
	$(document).bind('keydown', 'f8', function(ent){
		if($('.post-edit-link').length != 0){
			window.location.href = $(".post-edit-link").attr("href");
		}
	});	
	$("html, #body, input").bind('keydown', 'f9', function(ent){
		if($('#admin_post_submit').length != 0){
			$("#admin_post_submit").submit();
		}
	});	
	$("html, #body, input").bind('keydown', 'f10', function(ent){
		if($('#admin_post_view').length != 0){
			window.location.href = $("#admin_post_view").attr("href");
		}
	});
	if($('#admin_post_view').length == 0){
		$("input.title").focus();
	}else{
		$("textarea#body").focus();
		var v= $("textarea#body").html();
		$("textarea#body").html('');
		$("textarea#body").html(v);
	}

 });
