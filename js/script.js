$(document).ready(function(){
	 
	if ($(window).width() < 960) {
		$(".content").width(520);
		$(".sidebar1").width(220);
		$(".container").width(790);
	}
	$(".xoxo ul").each(function(){$(this).find("li:first").css("border-top", "1px solid #f0f0f0")});
	
	//$(".widget_recent_entries ul li:even").css("background-color", "#f2f2f2");
});
window.onload = function() {
document.getElementById('s').onfocus = function() { if (this.value == 'Search') this.value=''; };
document.getElementById('s').onblur = function() { if (this.value == '') this.value = 'Search'; };
}