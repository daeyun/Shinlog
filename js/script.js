$(function() {
	if ($(window).width() < 960 && $(window).width() > 10) {
		$(".content").width(520);
		$(".sidebar1").width(220);
		$(".container").width(790);
	}
	$(".sidebar_list ul").each(function(){$(this).find("li:first a").css("border-top", "1px solid #f0f0f0")});
	if(!($(".sidebar1").length)){
		$(".content").css({"width":"auto","padding-right":"20px"});
	}
	$("#searchform").submit(function(){
		$("#searchform").attr("action", "/search/"+encodeURIComponent($("#s").val()));
	});
	$("#s").focus( function() { if (this.value == 'Search') this.value=''; $("#s").stop().animate({width:200},600); });
	$("#s").blur( function() { if (this.value == ''){ this.value = 'Search'; $("#s").stop().animate({width:55},600);} });
	$("code, pre").addClass("prettyprint");
	prettyPrint();
});
