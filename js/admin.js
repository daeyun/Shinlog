 $(function() {
	$('#datecheckbox').click(function(){
		if($("#date").attr("disabled") == "disabled") {
			$("#date").removeAttr("disabled");
		}else{
			$("#date").attr("disabled","disabled");
		}
	});
	$('#permalinkcheckbox').click(function(){
		if($("#permalink").attr("disabled") == "disabled") {
			$("#permalink").removeAttr("disabled");
		}else{
			$("#permalink").attr("disabled","disabled");
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
	
	$('#toggle-advanced-options').click(function(){
		$('#advanced-options').slideToggle();
		if($(this).find("span").html()=="[+]"){
			$(this).find("span").html("[-]");
		}else{
			$(this).find("span").html("[+]");
		}
	});
 });