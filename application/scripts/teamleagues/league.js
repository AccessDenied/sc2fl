$(function(){
	$(".anchor_roster").click(function(e){
		e.preventDefault();
		var toggle = ($(this).next().css("display") != "block");
		$(".roster").slideUp();
		if (toggle) $(this).next().slideToggle();
	});
});